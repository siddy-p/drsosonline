"""
passenger_wsgi.py — Phusion Passenger entry point.
Works on ServerbYT and any Passenger-enabled Apache/Nginx host.
"""
import sys
import os

# Add the app directory to the path
sys.path.insert(0, os.path.dirname(__file__))

from app import app as application
