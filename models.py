from flask_sqlalchemy import SQLAlchemy
from flask_login import UserMixin
from datetime import datetime

db = SQLAlchemy()


class User(db.Model, UserMixin):
    __tablename__ = 'users'
    id = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.String(150), unique=True, nullable=False)
    password_hash = db.Column(db.String(256), nullable=False)
    is_active = db.Column(db.Boolean, default=True)
    is_admin = db.Column(db.Boolean, default=False)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)

    profile = db.relationship('Profile', backref='user', uselist=False, cascade='all, delete-orphan')
    applications = db.relationship('Application', backref='user', lazy=True, cascade='all, delete-orphan')
    bookings = db.relationship('Booking', backref='user', lazy=True)
    appointments = db.relationship('Appointment', backref='user', lazy=True)

    def __repr__(self):
        return f'<User {self.email}>'


class Profile(db.Model):
    __tablename__ = 'profiles'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False, unique=True)

    first_name = db.Column(db.String(100))
    last_name = db.Column(db.String(100))
    date_of_birth = db.Column(db.String(20))
    gender = db.Column(db.String(20))
    nationality = db.Column(db.String(100))
    phone = db.Column(db.String(30))

    street_address = db.Column(db.String(200))
    city = db.Column(db.String(100))
    county_state = db.Column(db.String(100))
    country = db.Column(db.String(100))
    postcode = db.Column(db.String(20))

    passport_number = db.Column(db.String(50))
    passport_expiry = db.Column(db.String(20))
    passport_country = db.Column(db.String(100))

    highest_qualification = db.Column(db.String(100))
    institution_name = db.Column(db.String(200))
    graduation_year = db.Column(db.String(10))
    grade_achieved = db.Column(db.String(50))
    field_of_study = db.Column(db.String(150))
    english_test = db.Column(db.String(20))
    english_score = db.Column(db.String(20))

    preferred_country = db.Column(db.String(100))
    preferred_course = db.Column(db.String(200))
    intake_year = db.Column(db.String(10))
    intake_month = db.Column(db.String(20))
    budget_range = db.Column(db.String(50))
    additional_notes = db.Column(db.Text)

    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)

    @property
    def full_name(self):
        parts = [self.first_name, self.last_name]
        name = ' '.join(p for p in parts if p)
        return name if name else 'Not set'

    @property
    def completion_percentage(self):
        fields = [
            self.first_name, self.last_name, self.date_of_birth, self.gender,
            self.nationality, self.phone, self.street_address, self.city,
            self.country, self.postcode, self.passport_number, self.passport_expiry,
            self.highest_qualification, self.institution_name,
            self.preferred_country, self.preferred_course
        ]
        filled = sum(1 for f in fields if f)
        return int((filled / len(fields)) * 100)


class Application(db.Model):
    __tablename__ = 'applications'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False)
    service_type = db.Column(db.String(100), nullable=False)
    preferred_country = db.Column(db.String(100))
    preferred_course = db.Column(db.String(200))
    intake = db.Column(db.String(50))
    status = db.Column(db.String(30), default='Pending')
    notes = db.Column(db.Text)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)


class Booking(db.Model):
    __tablename__ = 'bookings'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=True)
    name = db.Column(db.String(150), nullable=False)
    email = db.Column(db.String(150), nullable=False)
    phone = db.Column(db.String(30))
    service = db.Column(db.String(100))
    preferred_date = db.Column(db.String(30))
    message = db.Column(db.Text)
    status = db.Column(db.String(30), default='Pending')
    created_at = db.Column(db.DateTime, default=datetime.utcnow)


class ContactMessage(db.Model):
    __tablename__ = 'contact_messages'
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(150))
    email = db.Column(db.String(150))
    phone = db.Column(db.String(30))
    subject = db.Column(db.String(200))
    message = db.Column(db.Text)
    portal = db.Column(db.String(20), default='edu')  # 'edu' or 'online'
    created_at = db.Column(db.DateTime, default=datetime.utcnow)


# ─── Online Consultation Models ───

class Doctor(db.Model):
    __tablename__ = 'doctors'
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    specialty = db.Column(db.String(100))
    qualification = db.Column(db.String(200))
    bio = db.Column(db.Text)
    languages = db.Column(db.String(200))   # comma-separated e.g. "English, Hindi, Tamil"
    photo_url = db.Column(db.String(300))
    years_experience = db.Column(db.Integer, default=0)
    available_days = db.Column(db.String(100), default='Mon,Tue,Wed,Thu,Fri')
    available_from = db.Column(db.String(8), default='09:00')
    available_to = db.Column(db.String(8), default='18:00')
    fee_phone = db.Column(db.Integer, default=99)    # ₹99 phone/WhatsApp
    fee_video = db.Column(db.Integer, default=199)   # ₹199 video
    rating = db.Column(db.Float, default=4.8)
    total_consultations = db.Column(db.Integer, default=0)
    is_active = db.Column(db.Boolean, default=True)
    appointments = db.relationship('Appointment', backref='doctor', lazy=True)

    @property
    def language_list(self):
        return [l.strip() for l in (self.languages or '').split(',') if l.strip()]

    @property
    def available_day_list(self):
        return [d.strip() for d in (self.available_days or '').split(',') if d.strip()]

    def __repr__(self):
        return f'<Doctor {self.name}>'


class Appointment(db.Model):
    __tablename__ = 'appointments'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=True)
    doctor_id = db.Column(db.Integer, db.ForeignKey('doctors.id'), nullable=True)

    # Patient info (for non-logged-in users)
    patient_name = db.Column(db.String(150), nullable=False)
    patient_email = db.Column(db.String(150), nullable=False)
    patient_phone = db.Column(db.String(20), nullable=False)
    patient_age = db.Column(db.String(10))
    patient_gender = db.Column(db.String(20))

    appointment_date = db.Column(db.String(20), nullable=False)
    appointment_time = db.Column(db.String(10), nullable=False)
    consult_type = db.Column(db.String(20), nullable=False)   # 'phone', 'whatsapp', 'video'
    reason = db.Column(db.Text)
    symptoms = db.Column(db.Text)

    fee = db.Column(db.Integer)                               # ₹99 or ₹199
    payment_status = db.Column(db.String(20), default='pending')  # pending, paid
    status = db.Column(db.String(20), default='pending')      # pending, confirmed, cancelled, completed

    doctor_notes = db.Column(db.Text)   # admin can add notes
    created_at = db.Column(db.DateTime, default=datetime.utcnow)

    def __repr__(self):
        return f'<Appointment #{self.id} {self.patient_name}>'
