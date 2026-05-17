<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ABS') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Space Grotesk', sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .neo { background: #fff; border: 3px solid #1a1a1a; border-radius: 16px; box-shadow: 6px 6px 0 #1a1a1a; }
        .btn { display: inline-block; border: 3px solid #1a1a1a; border-radius: 10px; padding: 14px 28px; font-weight: 700; text-decoration: none; box-shadow: 4px 4px 0 #1a1a1a; transition: all 0.1s; }
        .btn:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0 #1a1a1a; }
        .btn-yellow { background: #ffde59; color: #1a1a1a; }
        .btn-black { background: #1a1a1a; color: #fff; }
        .btn-blue { background: #7aa2f7; color: #1a1a1a; }
        .btn-pink { background: #ff8ba7; color: #1a1a1a; }
        .btn-green { background: #98ff98; color: #1a1a1a; }
        .logo { width: 48px; height: 48px; background: #ffde59; border: 3px solid #1a1a1a; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 3px 3px 0 #1a1a1a; }
    </style>
</head>
<body>
    <!-- Marquee Top -->
    <div style="background:#1a1a1a;border-bottom:3px solid #1a1a1a;overflow:hidden;padding:14px 0;">
        <div style="display:flex;animation:scroll 15s linear infinite;white-space:nowrap;">
            <span style="color:#ffde59;font-size:15px;font-weight:700;margin-right:60px;">✨ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
            <span style="color:#ffde59;font-size:15px;font-weight:700;margin-right:60px;">✨ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
            <span style="color:#ffde59;font-size:15px;font-weight:700;margin-right:60px;">✨ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
            <span style="color:#ffde59;font-size:15px;font-weight:700;margin-right:60px;">✨ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
        </div>
    </div>
    <style>@keyframes scroll{0%{transform:translateX(0)}100%{transform:translateX(-25%)}}</style>

    <!-- Header -->
    <header style="background:#fff;border-bottom:3px solid #1a1a1a;padding:20px 0;">
        <div class="container">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;">
                    <div class="logo"><i class="fas fa-fingerprint" style="font-size:20px;"></i></div>
                    <span style="font-size:22px;font-weight:800;color:#1a1a1a;">{{ config('app.name', 'ABS') }}</span>
                </a>
                <div style="display:flex;gap:16px;align-items:center;">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-black" style="padding:10px 20px;font-size:14px;">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="font-size:15px;font-weight:700;color:#1a1a1a;text-decoration:none;">Sign In</a>
                        @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-yellow" style="padding:10px 20px;font-size:14px;">Get Started</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main style="padding:60px 0;">
        <div class="container">
            <!-- Hero -->
            <div style="text-align:center;margin-bottom:50px;">
                <div style="display:inline-block;background:#ffde59;border:2px solid #1a1a1a;border-radius:25px;padding:10px 20px;font-size:13px;font-weight:700;margin-bottom:24px;">
                    ✨ Laravel 13 • GPS Tracking • Leaflet Maps
                </div>
                <h1 style="font-size:56px;font-weight:800;color:#1a1a1a;margin-bottom:20px;line-height:1.05;">
                    Attendance &<br>
                    <span style="background:linear-gradient(90deg,#ff8ba7,#bb9af7,#7aa2f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Employee Management</span>
                </h1>
                <p style="font-size:18px;color:#666;max-width:550px;margin:0 auto 35px;line-height:1.6;">
                    Complete system for managing employee attendance, leaves, payroll, and reimbursements with GPS tracking via Leaflet maps.
                </p>
                <div style="display:flex;justify-content:center;gap:20px;margin-bottom:60px;">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-yellow" style="font-size:15px;">Start Free Trial</a>
                        <a href="{{ route('login') }}" class="btn btn-black" style="font-size:15px;">Sign In</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn btn-blue" style="font-size:15px;">Go to Dashboard</a>
                    @endguest
                </div>
            </div>

            <!-- Marquee Tilted -->
            <div style="margin-bottom:50px;transform:rotate(-2deg);">
                <div style="background:#7aa2f7;border:3px solid #1a1a1a;overflow:hidden;padding:16px 0;box-shadow:6px 6px 0 #1a1a1a;">
                    <div style="display:flex;animation:scroll 12s linear infinite;white-space:nowrap;">
                        <span style="color:#1a1a1a;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                        <span style="color:#1a1a1a;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                        <span style="color:#1a1a1a;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                        <span style="color:#1a1a1a;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:50px;">
                <div class="neo" style="padding:24px;">
                    <div style="width:48px;height:48px;background:#7aa2f7;border:2px solid #1a1a1a;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:3px 3px 0 #1a1a1a;">
                        <i class="fas fa-user" style="font-size:20px;"></i>
                    </div>
                    <h3 style="font-size:18px;font-weight:800;margin-bottom:10px;">Employee Panel</h3>
                    <ul style="list-style:none;font-size:13px;color:#666;line-height:2;">
                        <li>✓ Smart Attendance with GPS</li>
                        <li>✓ Leave Management</li>
                        <li>✓ Reimbursements</li>
                        <li>✓ Payroll View</li>
                        <li>✓ Announcements</li>
                    </ul>
                </div>
                <div class="neo" style="padding:24px;">
                    <div style="width:48px;height:48px;background:#ff8ba7;border:2px solid #1a1a1a;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:3px 3px 0 #1a1a1a;">
                        <i class="fas fa-users" style="font-size:20px;"></i>
                    </div>
                    <h3 style="font-size:18px;font-weight:800;margin-bottom:10px;">HR Panel</h3>
                    <ul style="list-style:none;font-size:13px;color:#666;line-height:2;">
                        <li>✓ Attendance Monitoring</li>
                        <li>✓ Leave Approval</li>
                        <li>✓ Reimbursement Approval</li>
                        <li>✓ Payroll Management</li>
                    </ul>
                </div>
                <div class="neo" style="padding:24px;">
                    <div style="width:48px;height:48px;background:#98ff98;border:2px solid #1a1a1a;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:3px 3px 0 #1a1a1a;">
                        <i class="fas fa-cogs" style="font-size:20px;"></i>
                    </div>
                    <h3 style="font-size:18px;font-weight:800;margin-bottom:10px;">Admin Panel</h3>
                    <ul style="list-style:none;font-size:13px;color:#666;line-height:2;">
                        <li>✓ User Management</li>
                        <li>✓ Department & Roles</li>
                        <li>✓ Shift Management</li>
                        <li>✓ Location Management</li>
                        <li>✓ Dashboard Analytics</li>
                    </ul>
                </div>
            </div>

            <!-- Tech Stack -->
            <div class="neo" style="padding:28px;background:#ffde59;margin-bottom:50px;text-align:center;">
                <div style="font-size:16px;font-weight:800;margin-bottom:12px;">🛠️ TECHNOLOGY STACK</div>
                <div style="font-size:14px;font-weight:600;color:#1a1a1a;">
                    Laravel 13 • PHP 8.3 • Tailwind CSS • Alpine.js • Leaflet Maps • MySQL • Font Awesome
                </div>
            </div>

            <!-- CTA -->
            <div class="neo" style="padding:40px;background:#1a1a1a;text-align:center;margin-bottom:50px;">
                <h3 style="font-size:28px;font-weight:800;color:#fff;margin-bottom:12px;">Ready to get started?</h3>
                <p style="color:#ccc;margin-bottom:24px;font-size:15px;">Join 500+ companies managing their workforce with ABS</p>
                @guest
                <a href="{{ route('register') }}" class="btn btn-yellow" style="margin-right:12px;">Start Free Trial</a>
                <a href="{{ route('login') }}" class="btn" style="background:#fff;color:#1a1a1a;">Sign In</a>
                @else
                <a href="{{ url('/dashboard') }}" class="btn btn-yellow">Go to Dashboard</a>
                @endguest
            </div>

            <!-- Stats -->
            <div style="display:flex;justify-content:center;gap:50px;">
                <div><span style="font-size:32px;font-weight:800;">500+</span><br><span style="font-size:13px;color:#666;">Active Users</span></div>
                <div><span style="font-size:32px;font-weight:800;">50+</span><br><span style="font-size:13px;color:#666;">Companies</span></div>
                <div><span style="font-size:32px;font-weight:800;">99.9%</span><br><span style="font-size:13px;color:#666;">Uptime</span></div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer style="background:#fff;border-top:3px solid #1a1a1a;padding:24px 0;text-align:center;">
        <div class="container">
            <p style="font-size:13px;font-weight:600;">© {{ date('Y') }} {{ config('app.name', 'ABS') }} • Privacy • Terms • Support</p>
        </div>
    </footer>
</body>
</html>