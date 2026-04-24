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

    def __repr__(self):
        return f'<User {self.email}>'


class Profile(db.Model):
    __tablename__ = 'profiles'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False, unique=True)

    # Personal
    first_name = db.Column(db.String(100))
    last_name = db.Column(db.String(100))
    date_of_birth = db.Column(db.String(20))
    gender = db.Column(db.String(20))
    nationality = db.Column(db.String(100))
    phone = db.Column(db.String(30))

    # Address
    street_address = db.Column(db.String(200))
    city = db.Column(db.String(100))
    county_state = db.Column(db.String(100))
    country = db.Column(db.String(100))
    postcode = db.Column(db.String(20))

    # Passport / ID
    passport_number = db.Column(db.String(50))
    passport_expiry = db.Column(db.String(20))
    passport_country = db.Column(db.String(100))

    # Education
    highest_qualification = db.Column(db.String(100))
    institution_name = db.Column(db.String(200))
    graduation_year = db.Column(db.String(10))
    grade_achieved = db.Column(db.String(50))
    field_of_study = db.Column(db.String(150))
    english_test = db.Column(db.String(20))
    english_score = db.Column(db.String(20))

    # Preferences
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
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
