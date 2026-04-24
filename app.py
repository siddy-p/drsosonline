from flask import Flask, render_template, redirect, url_for, flash, request, session
from flask_login import LoginManager, login_user, logout_user, login_required, current_user
from flask_bcrypt import Bcrypt
from models import db, User, Profile, Application, Booking, ContactMessage
import os

app = Flask(__name__)
app.config['SECRET_KEY'] = os.environ.get('SECRET_KEY', 'drsos-dev-secret-2024-change-in-prod')
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///drsos.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db.init_app(app)
bcrypt = Bcrypt(app)
login_manager = LoginManager(app)
login_manager.login_view = 'login'
login_manager.login_message = 'Please log in to access this page.'
login_manager.login_message_category = 'warning'


@login_manager.user_loader
def load_user(user_id):
    return User.query.get(int(user_id))


with app.app_context():
    db.create_all()


# ─────────────────────────── PUBLIC PAGES ───────────────────────────

@app.route('/')
def home():
    return render_template('home.html')


@app.route('/education')
def education():
    return render_template('education.html')


@app.route('/palliative-care')
def palliative_care():
    return render_template('palliative_care.html')


@app.route('/doctors')
def doctors():
    return render_template('doctors.html')


@app.route('/air-ambulance')
def air_ambulance():
    return render_template('air_ambulance.html')


@app.route('/contact', methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        msg = ContactMessage(
            name=request.form.get('name'),
            email=request.form.get('email'),
            phone=request.form.get('phone'),
            subject=request.form.get('subject'),
            message=request.form.get('message')
        )
        db.session.add(msg)
        db.session.commit()
        flash('Your message has been sent! We\'ll be in touch shortly.', 'success')
        return redirect(url_for('contact'))
    return render_template('contact.html')


@app.route('/book', methods=['GET', 'POST'])
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
        flash('Appointment request submitted! We will confirm shortly.', 'success')
        return redirect(url_for('book'))
    return render_template('book.html')


# ─────────────────────────── AUTH ROUTES ───────────────────────────

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
        p.first_name = request.form.get('first_name')
        p.last_name = request.form.get('last_name')
        p.date_of_birth = request.form.get('date_of_birth')
        p.gender = request.form.get('gender')
        p.nationality = request.form.get('nationality')
        p.phone = request.form.get('phone')
        p.street_address = request.form.get('street_address')
        p.city = request.form.get('city')
        p.county_state = request.form.get('county_state')
        p.country = request.form.get('country')
        p.postcode = request.form.get('postcode')
        p.passport_number = request.form.get('passport_number')
        p.passport_expiry = request.form.get('passport_expiry')
        p.passport_country = request.form.get('passport_country')
        db.session.commit()
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
        p.highest_qualification = request.form.get('highest_qualification')
        p.institution_name = request.form.get('institution_name')
        p.graduation_year = request.form.get('graduation_year')
        p.grade_achieved = request.form.get('grade_achieved')
        p.field_of_study = request.form.get('field_of_study')
        p.english_test = request.form.get('english_test')
        p.english_score = request.form.get('english_score')
        p.preferred_country = request.form.get('preferred_country')
        p.preferred_course = request.form.get('preferred_course')
        p.intake_year = request.form.get('intake_year')
        p.intake_month = request.form.get('intake_month')
        p.budget_range = request.form.get('budget_range')
        p.additional_notes = request.form.get('additional_notes')
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
    return redirect(url_for('home'))


# ─────────────────────────── DASHBOARD ───────────────────────────

@app.route('/dashboard')
@login_required
def dashboard():
    apps = Application.query.filter_by(user_id=current_user.id).order_by(Application.created_at.desc()).limit(5).all()
    bookings = Booking.query.filter_by(user_id=current_user.id).order_by(Booking.created_at.desc()).limit(3).all()
    return render_template('dashboard.html', applications=apps, bookings=bookings)


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
        return redirect(url_for('home'))
    users = User.query.order_by(User.created_at.desc()).all()
    apps = Application.query.order_by(Application.created_at.desc()).all()
    bookings = Booking.query.order_by(Booking.created_at.desc()).all()
    messages = ContactMessage.query.order_by(ContactMessage.created_at.desc()).all()
    return render_template('admin.html', users=users, applications=apps, bookings=bookings, messages=messages)


if __name__ == '__main__':
    app.run(debug=True)