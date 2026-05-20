#!/bin/bash
# keep_alive.sh — run via cron every 5 minutes to keep gunicorn alive
# Cron line (add via ServerbYT → Scheduled Tasks):
# */5 * * * * /bin/bash /home/sites/11a/2/29388bae9f/public_html/keep_alive.sh

APP_DIR="/home/sites/11a/2/29388bae9f/public_html"
VENV_DIR="$APP_DIR/venv"
PIDFILE="$APP_DIR/gunicorn.pid"
PORT=8080
LOG="$APP_DIR/gunicorn.log"

# Check if gunicorn is running
if [ -f "$PIDFILE" ]; then
    PID=$(cat "$PIDFILE")
    if kill -0 "$PID" 2>/dev/null; then
        exit 0   # already running, nothing to do
    fi
fi

# Start gunicorn
cd "$APP_DIR"
source "$VENV_DIR/bin/activate"
nohup gunicorn app:app \
    --bind 127.0.0.1:$PORT \
    --workers 2 \
    --timeout 120 \
    --pid "$PIDFILE" \
    --log-file "$LOG" \
    --daemon
echo "Gunicorn started at $(date)" >> "$LOG"
