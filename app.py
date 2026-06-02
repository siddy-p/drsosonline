from dotenv import load_dotenv; load_dotenv()  # loads .env file on ServerbYT
from flask import Flask, Blueprint, render_template, redirect, url_for, flash, request, session
from flask_login import LoginManager, login_user, logout_user, login_required, current_user
from flask_bcrypt import Bcrypt
from flask_mail import Mail, Message
from models import db, User, Profile, Application, Booking, ContactMessage, Doctor, Appointment
import os

app = Flask(__name__)
app.config['SECRET_KEY'] = os.environ.get('SECRET_KEY', 'drsos-dev-secret-2024-change-in-prod')
db_url = os.environ.get('DATABASE_URL', 'sqlite:///drsos.db')
if db_url.startswith('postgres://'):
    db_url = db_url.replace('postgres://', 'postgresql://', 1)
app.config['SQLALCHEMY_DATABASE_URI'] = db_url
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

# ── Flask-Mail (configure via environment variables on cPanel) ──
app.config['MAIL_SERVER']   = os.environ.get('MAIL_SERVER', 'smtp.drsosonline.com')
app.config['MAIL_PORT']     = int(os.environ.get('MAIL_PORT', 587))
app.config['MAIL_USE_TLS']  = os.environ.get('MAIL_USE_TLS', 'true').lower() == 'true'
app.config['MAIL_USERNAME'] = os.environ.get('MAIL_USERNAME', '')   # e.g. noreply@drsosonline.com
app.config['MAIL_PASSWORD'] = os.environ.get('MAIL_PASSWORD', '')   # cPanel email password
app.config['MAIL_DEFAULT_SENDER'] = os.environ.get('MAIL_USERNAME', 'noreply@drsosonline.com')
# Admin email that receives booking notifications
ADMIN_EMAIL = os.environ.get('ADMIN_EMAIL', 'admin@drsosonline.com')
# UPI ID for payments
UPI_ID = '7025361771@ptsbi'
UPI_NAME = 'Dr SOS Online'

db.init_app(app)
bcrypt = Bcrypt(app)
mail = Mail(app)
login_manager = LoginManager(app)
login_manager.login_view = 'login'
login_manager.login_message = 'Please log in to access this page.'
login_manager.login_message_category = 'warning'


@login_manager.user_loader
def load_user(user_id):
    return User.query.get(int(user_id))


def send_notification(subject, body):
    """Send an email notification to the admin. Silently fails if mail is not configured."""
    try:
        if app.config.get('MAIL_USERNAME'):
            msg = Message(subject=subject, recipients=[ADMIN_EMAIL], body=body)
            mail.send(msg)
    except Exception as e:
        app.logger.warning(f'Mail send failed: {e}')


def send_booking_confirmation(recipient_email, recipient_name, subject, body):
    """Send confirmation email to the patient."""
    try:
        if app.config.get('MAIL_USERNAME'):
            msg = Message(subject=subject, recipients=[recipient_email], body=body)
            mail.send(msg)
    except Exception as e:
        app.logger.warning(f'Confirmation mail failed: {e}')


# ─────────────────────────── BLUEPRINTS ───────────────────────────

edu_bp = Blueprint('edu', __name__, url_prefix='/edu')
online_bp = Blueprint('online', __name__, url_prefix='/online')


# ═══════════════════════════════════════════════════════
#  EduConsult Blueprint  (/edu/...)
# ═══════════════════════════════════════════════════════

@edu_bp.route('/')
def home():
    return render_template('edu/home.html')


@edu_bp.route('/education')
def education():
    return render_template('edu/education.html')


@edu_bp.route('/contact', methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        msg = ContactMessage(
            name=request.form.get('name'),
            email=request.form.get('email'),
            phone=request.form.get('phone'),
            subject=request.form.get('subject'),
            message=request.form.get('message'),
            portal='edu'
        )
        db.session.add(msg)
        db.session.commit()
        flash("Your message has been sent! We'll be in touch shortly.", 'success')
        return redirect(url_for('edu.contact'))
    return render_template('edu/contact.html')


@edu_bp.route('/book', methods=['GET', 'POST'])
def book():
    if request.method == 'POST':
        booking = Booking(
            user_id=current_user.id if current_user.is_authenticated else None,
            name=request.form.get('name'),
            email=request.form.get('email'),
            phone=request.form.get('phone'),
            service=request.form.get('service'),
            preferred_date=request.form.get('preferred_date'),
            message=request.form.get('message')
        )
        db.session.add(booking)
        db.session.commit()
        # Notify admin
        send_notification(
            subject=f'[Dr.SOS EduConsult] New Booking – {booking.name}',
            body=(
                f'New education consultation booking received:\n\n'
                f'Name    : {booking.name}\n'
                f'Email   : {booking.email}\n'
                f'Phone   : {booking.phone}\n'
                f'Service : {booking.service}\n'
                f'Date    : {booking.preferred_date}\n'
                f'Message : {booking.message}\n'
            )
        )
        # Confirm to patient
        send_booking_confirmation(
            recipient_email=booking.email,
            recipient_name=booking.name,
            subject='Your EduConsult Booking is Received – Dr.SOS',
            body=(
                f'Dear {booking.name},\n\n'
                f'Thank you for booking an education consultation with Dr.SOS.\n'
                f'We will confirm your appointment within 24 hours.\n\n'
                f'Service : {booking.service}\n'
                f'Date    : {booking.preferred_date}\n\n'
                f'Regards,\nDr.SOS EduConsult Team'
            )
        )
        flash('Consultation request submitted! We will confirm shortly.', 'success')
        return redirect(url_for('edu.book'))
    return render_template('edu/book.html')


# ═══════════════════════════════════════════════════════
#  Online Consultation Blueprint  (/online/...)
# ═══════════════════════════════════════════════════════

@online_bp.route('/')
def home():
    doctors = Doctor.query.filter_by(is_active=True).limit(3).all()
    return render_template('online/home.html', doctors=doctors)


@online_bp.route('/doctors')
def doctors():
    specialty = request.args.get('specialty', '')
    if specialty:
        docs = Doctor.query.filter_by(is_active=True).filter(
            Doctor.specialty.ilike(f'%{specialty}%')).all()
    else:
        docs = Doctor.query.filter_by(is_active=True).all()
    specialties = db.session.query(Doctor.specialty).filter_by(is_active=True).distinct().all()
    specialties = [s[0] for s in specialties if s[0]]
    return render_template('online/doctors.html', doctors=docs, specialties=specialties, selected=specialty)


@online_bp.route('/doctors/<int:doctor_id>')
def doctor_detail(doctor_id):
    doctor = Doctor.query.get_or_404(doctor_id)
    return render_template('online/doctor_detail.html', doctor=doctor)


@online_bp.route('/consult', methods=['GET', 'POST'])
def consult():
    doctors = Doctor.query.filter_by(is_active=True).all()
    prefill_doctor = request.args.get('doctor_id', '')
    if request.method == 'POST':
        consult_type = request.form.get('consult_type')
        fee = 199 if consult_type == 'video' else 99
        apt = Appointment(
            user_id=current_user.id if current_user.is_authenticated else None,
            doctor_id=request.form.get('doctor_id') or None,
            patient_name=request.form.get('patient_name'),
            patient_email=request.form.get('patient_email'),
            patient_phone=request.form.get('patient_phone'),
            patient_age=request.form.get('patient_age'),
            patient_gender=request.form.get('patient_gender'),
            appointment_date=request.form.get('appointment_date'),
            appointment_time=request.form.get('appointment_time'),
            consult_type=consult_type,
            reason=request.form.get('reason'),
            symptoms=request.form.get('symptoms'),
            fee=fee,
            status='pending',
            payment_status='pending'
        )
        db.session.add(apt)
        db.session.commit()
        # Notify admin
        send_notification(
            subject=f'[Dr.SOS Online] New Appointment #{apt.id} – {apt.patient_name}',
            body=(
                f'New doctor appointment received:\n\n'
                f'ID          : #{apt.id}\n'
                f'Patient     : {apt.patient_name}\n'
                f'Email       : {apt.patient_email}\n'
                f'Phone       : {apt.patient_phone}\n'
                f'Type        : {apt.consult_type}\n'
                f'Fee         : ₹{apt.fee}\n'
                f'Date & Time : {apt.appointment_date} at {apt.appointment_time}\n'
                f'Reason      : {apt.reason}\n'
                f'Symptoms    : {apt.symptoms}\n'
            )
        )
        # Confirm to patient
        send_booking_confirmation(
            recipient_email=apt.patient_email,
            recipient_name=apt.patient_name,
            subject='Appointment Confirmed – Dr.SOS Online',
            body=(
                f'Dear {apt.patient_name},\n\n'
                f'Your consultation appointment (#{apt.id}) has been received.\n\n'
                f'Type  : {apt.consult_type.title()} Consultation\n'
                f'Date  : {apt.appointment_date} at {apt.appointment_time}\n'
                f'Fee   : ₹{apt.fee}\n\n'
                f'Please complete your payment via UPI to confirm your slot.\n'
                f'UPI ID: {UPI_ID}\n\n'
                f'We will confirm within 30 minutes after payment.\n\n'
                f'Regards,\nDr.SOS Online Team'
            )
        )
        # Redirect to UPI payment page
        return redirect(url_for('upi_payment',
                                apt_id=apt.id,
                                name=apt.patient_name,
                                amount=fee,
                                consult_type=consult_type))
    return render_template('online/consult.html', doctors=doctors, prefill_doctor=prefill_doctor)


@online_bp.route('/palliative-care')
def palliative_care():
    return render_template('online/palliative_care.html')


@online_bp.route('/air-ambulance')
def air_ambulance():
    return render_template('online/air_ambulance.html')


@online_bp.route('/contact', methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        msg = ContactMessage(
            name=request.form.get('name'),
            email=request.form.get('email'),
            phone=request.form.get('phone'),
            subject=request.form.get('subject'),
            message=request.form.get('message'),
            portal='online'
        )
        db.session.add(msg)
        db.session.commit()
        flash("Your message has been sent! We'll get back to you shortly.", 'success')
        return redirect(url_for('online.contact'))
    return render_template('online/contact.html')


# Register blueprints
app.register_blueprint(edu_bp)
app.register_blueprint(online_bp)


# ─────────────────────────── UPI PAYMENT ───────────────────────────

@app.route('/payment/upi')
def upi_payment():
    apt_id       = request.args.get('apt_id', '')
    patient_name = request.args.get('name', 'Patient')
    amount       = request.args.get('amount', '99')
    consult_type = request.args.get('consult_type', 'phone')
    # Build UPI deep-link (works with GPay, PhonePe, Paytm, BHIM)
    txn_note = f'DrSOS Consultation #{apt_id}'
    upi_link = (
        f"upi://pay?pa={UPI_ID}"
        f"&pn={UPI_NAME.replace(' ', '%20')}"
        f"&am={amount}"
        f"&cu=INR"
        f"&tn={txn_note.replace(' ', '%20')}"
    )
    return render_template(
        'payment_upi.html',
        upi_link=upi_link,
        upi_id=UPI_ID,
        amount=amount,
        apt_id=apt_id,
        patient_name=patient_name,
        consult_type=consult_type
    )


@app.route('/payment/success')
def payment_success():
    apt_id = request.args.get('apt_id', '')
    if apt_id:
        apt = Appointment.query.get(int(apt_id))
        if apt:
            apt.payment_status = 'paid'
            db.session.commit()
            # Notify admin of payment
            send_notification(
                subject=f'[Dr.SOS] Payment Received – Appointment #{apt_id}',
                body=f'Patient {apt.patient_name} has confirmed payment of ₹{apt.fee} for appointment #{apt_id}.'
            )
    flash('Payment confirmed! We will contact you within 30 minutes to confirm your appointment.', 'success')
    return redirect(url_for('online.home'))


# ─────────────────────────── HEALTH CHECK ───────────────────────────

@app.route('/health')
def health():
    from flask import jsonify
    return jsonify({'status': 'ok', 'service': 'drsosonline'}), 200


# ─────────────────────────── LANDING PAGE ───────────────────────────

@app.route('/')
def landing():
    return render_template('landing.html')


# ─────────────────────────── AUTH ROUTES (shared) ───────────────────────────

@app.route('/register', methods=['GET', 'POST'])
def register():
    if current_user.is_authenticated:
        return redirect(url_for('dashboard'))
    if request.method == 'POST':
        email = request.form.get('email', '').strip().lower()
        password = request.form.get('password', '')
        confirm = request.form.get('confirm_password', '')
        if password != confirm:
            flash('Passwords do not match.', 'danger')
            return redirect(url_for('register'))
        if len(password) < 8:
            flash('Password must be at least 8 characters.', 'danger')
            return redirect(url_for('register'))
        if User.query.filter_by(email=email).first():
            flash('An account with this email already exists.', 'warning')
            return redirect(url_for('login'))
        hashed = bcrypt.generate_password_hash(password).decode('utf-8')
        user = User(email=email, password_hash=hashed)
        db.session.add(user)
        db.session.flush()
        profile = Profile(user_id=user.id)
        db.session.add(profile)
        db.session.commit()
        session['reg_user_id'] = user.id
        flash('Account created! Now complete your profile.', 'success')
        return redirect(url_for('register_profile'))
    return render_template('register.html', step=1)


@app.route('/register/profile', methods=['GET', 'POST'])
def register_profile():
    user_id = session.get('reg_user_id')
    if not user_id:
        return redirect(url_for('register'))
    user = User.query.get(user_id)
    if not user:
        return redirect(url_for('register'))
    if request.method == 'POST':
        p = user.profile
        for field in ['first_name','last_name','date_of_birth','gender','nationality','phone',
                      'street_address','city','county_state','country','postcode',
                      'passport_number','passport_expiry','passport_country']:
            setattr(p, field, request.form.get(field))
        db.session.commit()
        
        action = request.form.get('action')
        if action == 'finish':
            session.pop('reg_user_id', None)
            login_user(user)
            name = p.first_name or 'there'
            flash(f'Welcome, {name}! Your account is set up for Medical Consultations.', 'success')
            return redirect(url_for('dashboard'))
            
        return redirect(url_for('register_education'))
    return render_template('register_profile.html', step=2)


@app.route('/register/education', methods=['GET', 'POST'])
def register_education():
    user_id = session.get('reg_user_id')
    if not user_id:
        return redirect(url_for('register'))
    user = User.query.get(user_id)
    if not user:
        return redirect(url_for('register'))
    if request.method == 'POST':
        p = user.profile
        for field in ['highest_qualification','institution_name','graduation_year','grade_achieved',
                      'field_of_study','english_test','english_score','preferred_country',
                      'preferred_course','intake_year','intake_month','budget_range','additional_notes']:
            setattr(p, field, request.form.get(field))
        db.session.commit()
        session.pop('reg_user_id', None)
        login_user(user)
        name = p.first_name or 'there'
        flash(f'Welcome, {name}! Your account is all set up.', 'success')
        return redirect(url_for('dashboard'))
    return render_template('register_education.html', step=3)


@app.route('/login', methods=['GET', 'POST'])
def login():
    if current_user.is_authenticated:
        return redirect(url_for('dashboard'))
    if request.method == 'POST':
        email = request.form.get('email', '').strip().lower()
        password = request.form.get('password', '')
        remember = request.form.get('remember') == 'on'
        user = User.query.filter_by(email=email).first()
        if user and bcrypt.check_password_hash(user.password_hash, password):
            login_user(user, remember=remember)
            next_page = request.args.get('next')
            flash('Welcome back!', 'success')
            return redirect(next_page or url_for('dashboard'))
        flash('Invalid email or password.', 'danger')
    return render_template('login.html')


@app.route('/logout')
@login_required
def logout():
    logout_user()
    flash('You have been logged out.', 'info')
    return redirect(url_for('landing'))


# ─────────────────────────── DASHBOARD (shared) ───────────────────────────

@app.route('/dashboard')
@login_required
def dashboard():
    apps = Application.query.filter_by(user_id=current_user.id).order_by(Application.created_at.desc()).limit(5).all()
    bookings = Booking.query.filter_by(user_id=current_user.id).order_by(Booking.created_at.desc()).limit(3).all()
    appointments = Appointment.query.filter_by(user_id=current_user.id).order_by(Appointment.created_at.desc()).limit(5).all()
    return render_template('dashboard.html', applications=apps, bookings=bookings, appointments=appointments)


@app.route('/profile', methods=['GET', 'POST'])
@login_required
def profile():
    p = current_user.profile
    if request.method == 'POST':
        fields = [
            'first_name','last_name','date_of_birth','gender','nationality','phone',
            'street_address','city','county_state','country','postcode',
            'passport_number','passport_expiry','passport_country',
            'highest_qualification','institution_name','graduation_year','grade_achieved',
            'field_of_study','english_test','english_score',
            'preferred_country','preferred_course','intake_year','intake_month',
            'budget_range','additional_notes'
        ]
        for field in fields:
            setattr(p, field, request.form.get(field))
        db.session.commit()
        flash('Profile updated successfully!', 'success')
        return redirect(url_for('profile'))
    return render_template('profile.html', profile=p)


@app.route('/dashboard/applications')
@login_required
def applications():
    apps = Application.query.filter_by(user_id=current_user.id).order_by(Application.created_at.desc()).all()
    return render_template('applications.html', applications=apps)


# ─────────────────────────── ADMIN ───────────────────────────

@app.route('/admin')
@login_required
def admin():
    if not current_user.is_admin:
        flash('Access denied.', 'danger')
        return redirect(url_for('landing'))
    users = User.query.order_by(User.created_at.desc()).all()
    apps = Application.query.order_by(Application.created_at.desc()).all()
    bookings = Booking.query.order_by(Booking.created_at.desc()).all()
    appointments = Appointment.query.order_by(Appointment.created_at.desc()).all()
    messages = ContactMessage.query.order_by(ContactMessage.created_at.desc()).all()
    doctors = Doctor.query.all()
    return render_template('admin.html', users=users, applications=apps,
                           bookings=bookings, appointments=appointments,
                           messages=messages, doctors=doctors)


# ─────────────────────────── DB INIT + SEED ───────────────────────────

def seed_doctors():
    """Add dummy doctors if none exist."""
    if Doctor.query.count() == 0:
        doctors = [
            Doctor(
                name='Dr. Priya Sharma',
                specialty='General Physician',
                qualification='MBBS, MD (Internal Medicine)',
                bio='Dr. Priya Sharma has over 10 years of experience in general medicine and primary care. She specialises in managing chronic conditions, lifestyle diseases, and preventive healthcare. Known for her patient-first approach and clear communication.',
                languages='English, Hindi, Tamil',
                photo_url='/static/images/dr_priya.png',
                years_experience=10,
                available_days='Mon,Tue,Wed,Thu,Fri',
                available_from='09:00',
                available_to='18:00',
                fee_phone=99,
                fee_video=199,
                rating=4.9,
                total_consultations=320,
                is_active=True
            ),
            Doctor(
                name='Dr. Rahul Mehta',
                specialty='Paediatrician',
                qualification='MBBS, DCH, MD (Paediatrics)',
                bio='Dr. Rahul Mehta is a dedicated paediatrician with 8 years of experience caring for infants, children, and adolescents. He has a special interest in childhood nutrition, developmental milestones, and respiratory conditions. Parents trust his calm and reassuring approach.',
                languages='English, Hindi, Gujarati',
                photo_url='/static/images/dr_rahul.png',
                years_experience=8,
                available_days='Mon,Wed,Thu,Fri,Sat',
                available_from='10:00',
                available_to='19:00',
                fee_phone=99,
                fee_video=199,
                rating=4.8,
                total_consultations=215,
                is_active=True
            ),
        ]
        db.session.add_all(doctors)
        db.session.commit()


with app.app_context():
    db.create_all()
    seed_doctors()


if __name__ == '__main__':
    app.run(debug=True)