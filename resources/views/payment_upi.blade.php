<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complete Payment — Dr.SOS Online</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --primary: #10b981;
      --primary-dark: #059669;
      --accent: #6366f1;
      --dark: #0f172a;
      --card-bg: #1e293b;
      --border: rgba(255,255,255,0.08);
      --text: #e2e8f0;
      --muted: #94a3b8;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--dark);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      background-image: radial-gradient(ellipse at top, #1e3a5f 0%, var(--dark) 60%);
    }
    .pay-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 1.5rem;
      padding: 2.5rem;
      max-width: 480px;
      width: 100%;
      text-align: center;
      box-shadow: 0 25px 60px rgba(0,0,0,0.4);
      animation: slideUp 0.5s ease;
    }
    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to   { transform: translateY(0);   opacity: 1; }
    }
    .pay-logo {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 1.5rem;
    }
    .pay-logo i { font-size: 1.5rem; }
    .pay-badge {
      display: inline-block;
      background: linear-gradient(135deg, var(--primary), #34d399);
      color: #fff;
      border-radius: 2rem;
      padding: 0.25rem 1rem;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 1.5rem;
    }
    .pay-amount {
      font-size: 3.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, #10b981, #6366f1);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1;
      margin-bottom: 0.25rem;
    }
    .pay-amount-label {
      color: var(--muted);
      font-size: 0.85rem;
      margin-bottom: 1.5rem;
    }
    .pay-info {
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--border);
      border-radius: 1rem;
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
      text-align: left;
    }
    .pay-info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.4rem 0;
      font-size: 0.9rem;
    }
    .pay-info-row:not(:last-child) { border-bottom: 1px solid var(--border); }
    .pay-info-row span:first-child { color: var(--muted); }
    .pay-info-row span:last-child  { font-weight: 600; color: var(--text); }
    .pay-divider {
      color: var(--muted);
      font-size: 0.82rem;
      margin: 1.25rem 0;
      position: relative;
    }
    .pay-divider::before, .pay-divider::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 38%;
      height: 1px;
      background: var(--border);
    }
    .pay-divider::before { left: 0; }
    .pay-divider::after  { right: 0; }
    .btn-pay {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.65rem;
      width: 100%;
      padding: 1rem 1.5rem;
      border-radius: 0.875rem;
      font-size: 1rem;
      font-weight: 700;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.25s ease;
      margin-bottom: 0.75rem;
    }
    .btn-pay-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #fff;
      box-shadow: 0 4px 20px rgba(16,185,129,0.35);
    }
    .btn-pay-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(16,185,129,0.5);
    }
    .btn-pay-secondary {
      background: rgba(255,255,255,0.06);
      color: var(--text);
      border: 1px solid var(--border);
    }
    .btn-pay-secondary:hover {
      background: rgba(255,255,255,0.1);
    }
    .upi-id-box {
      background: rgba(99,102,241,0.12);
      border: 1px solid rgba(99,102,241,0.3);
      border-radius: 0.75rem;
      padding: 0.85rem 1.25rem;
      font-family: monospace;
      font-size: 1.05rem;
      font-weight: 700;
      color: #a5b4fc;
      letter-spacing: 1px;
      cursor: pointer;
      position: relative;
      margin-bottom: 0.5rem;
      transition: background 0.2s;
    }
    .upi-id-box:hover { background: rgba(99,102,241,0.2); }
    .upi-copy-hint {
      font-size: 0.78rem;
      color: var(--muted);
      margin-bottom: 1.25rem;
    }
    .app-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0.65rem;
      margin-bottom: 1.5rem;
    }
    .app-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.3rem;
      padding: 0.75rem 0.5rem;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--border);
      border-radius: 0.75rem;
      text-decoration: none;
      color: var(--text);
      font-size: 0.75rem;
      font-weight: 500;
      transition: all 0.2s;
    }
    .app-btn:hover {
      background: rgba(255,255,255,0.1);
      transform: translateY(-2px);
    }
    .app-btn img { width: 32px; height: 32px; border-radius: 8px; object-fit: contain; }
    .pay-note {
      font-size: 0.8rem;
      color: var(--muted);
      line-height: 1.5;
      margin-top: 1rem;
    }
    .pay-note i { color: var(--primary); margin-right: 0.3rem; }
    .done-btn {
      margin-top: 1.5rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--muted);
      font-size: 0.88rem;
      text-decoration: none;
      transition: color 0.2s;
    }
    .done-btn:hover { color: var(--primary); }
    .toast {
      position: fixed;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%) translateY(100px);
      background: var(--primary);
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 2rem;
      font-size: 0.9rem;
      font-weight: 600;
      opacity: 0;
      transition: all 0.3s;
      z-index: 999;
      white-space: nowrap;
    }
    .toast.show {
      transform: translateX(-50%) translateY(0);
      opacity: 1;
    }
  </style>
</head>
<body>
  <div class="pay-card">
    <div class="pay-logo">
      <i class="fas fa-heart-pulse"></i> Dr.SOS Online
    </div>
    <div class="pay-badge"><i class="fas fa-lock me-1"></i> Secure UPI Payment</div>

    <div class="pay-amount">₹{{ $amount }}</div>
    <div class="pay-amount-label">
      {{ $consult_type === 'video' ? 'Video Consultation' : 'Phone / WhatsApp Consultation' }}
    </div>

    <div class="pay-info">
      <div class="pay-info-row">
        <span>Patient</span>
        <span>{{ $patient_name }}</span>
      </div>
      <div class="pay-info-row">
        <span>Booking ID</span>
        <span>#{{ $apt_id }}</span>
      </div>
      <div class="pay-info-row">
        <span>Pay To</span>
        <span>Dr SOS Online</span>
      </div>
      <div class="pay-info-row">
        <span>UPI ID</span>
        <span>{{ $upi_id }}</span>
      </div>
    </div>

    <!-- Direct UPI deep-link button (opens any UPI app on mobile) -->
    <a href="{{ $upi_link }}" class="btn-pay btn-pay-primary" id="payNowBtn">
      <i class="fas fa-mobile-screen-button"></i>
      Pay ₹{{ $amount }} via UPI App
    </a>

    <div class="pay-divider">or choose an app</div>

    <!-- Individual app deep-links -->
    <div class="app-grid">
      <a href="gpay://upi/pay?pa={{ $upi_id }}&pn=Dr%20SOS%20Online&am={{ $amount }}&cu=INR&tn=DrSOS%20Consultation%20%23{{ $apt_id }}"
         class="app-btn" title="Google Pay">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Google_Pay_Logo.svg/512px-Google_Pay_Logo.svg.png" alt="GPay">
        Google Pay
      </a>
      <a href="phonepe://pay?pa={{ $upi_id }}&pn=Dr%20SOS%20Online&am={{ $amount }}&cu=INR&tn=DrSOS%20Consultation%20%23{{ $apt_id }}"
         class="app-btn" title="PhonePe">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/PhonePe_Logo.svg/512px-PhonePe_Logo.svg.png" alt="PhonePe">
        PhonePe
      </a>
      <a href="paytmmp://pay?pa={{ $upi_id }}&pn=Dr%20SOS%20Online&am={{ $amount }}&cu=INR&tn=DrSOS%20Consultation%20%23{{ $apt_id }}"
         class="app-btn" title="Paytm">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Paytm_Logo_%28standalone%29.svg/512px-Paytm_Logo_%28standalone%29.svg.png" alt="Paytm">
        Paytm
      </a>
    </div>

    <div class="pay-divider">or pay manually</div>

    <!-- Manual UPI ID copy -->
    <div class="upi-id-box" onclick="copyUPI()" title="Click to copy">
      <i class="fas fa-copy me-2" style="color:var(--muted)"></i>{{ $upi_id }}
    </div>
    <div class="upi-copy-hint">Tap to copy UPI ID and open your preferred app</div>

    <p class="pay-note">
      <i class="fas fa-circle-info"></i>
      After completing your payment, click the button below. Your appointment will be confirmed
      within 30 minutes via phone/WhatsApp.
    </p>

    <!-- "I've paid" button — marks appointment as paid in the DB -->
    <a href="{{ route('payment.success', ['apt_id' => $apt_id]) }}" class="btn-pay btn-pay-secondary" style="margin-top:1.25rem">
      <i class="fas fa-check-circle"></i>
      I've Completed My Payment
    </a>

    <a href="{{ route('online.home') }}" class="done-btn">
      <i class="fas fa-arrow-left"></i> Back to home
    </a>
  </div>

  <div class="toast" id="toast">✓ UPI ID copied to clipboard!</div>

  <script>
    function copyUPI() {
      navigator.clipboard.writeText('{{ $upi_id }}').then(() => {
        const t = document.getElementById('toast');
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2500);
      });
    }

    // On desktop, show a helpful notice since UPI deep-links are mobile-only
    const isMobile = /Android|iPhone|iPad/i.test(navigator.userAgent);
    if (!isMobile) {
      document.getElementById('payNowBtn').style.opacity = '0.5';
      document.getElementById('payNowBtn').style.cursor = 'default';
      document.getElementById('payNowBtn').onclick = function(e) {
        e.preventDefault();
        copyUPI();
        this.innerHTML = '<i class="fas fa-mobile-screen-button"></i> UPI link works on mobile — UPI ID copied!';
      };
    }
  </script>
</body>
</html>
