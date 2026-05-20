<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ABS') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-mono bg-neo-bg min-h-screen">
    <div style="background:#000;border-bottom:3px solid #000;overflow:hidden;padding:14px 0;">
        <div style="display:flex;animation:scroll 15s linear infinite;white-space:nowrap;">
            <span style="color:#fee440;font-size:15px;font-weight:700;margin-right:60px;">⚡ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
            <span style="color:#fee440;font-size:15px;font-weight:700;margin-right:60px;">⚡ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
            <span style="color:#fee440;font-size:15px;font-weight:700;margin-right:60px;">⚡ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
            <span style="color:#fee440;font-size:15px;font-weight:700;margin-right:60px;">⚡ ATTENDANCE • GPS TRACKING • LEAVE MANAGEMENT • PAYROLL • REIMBURSEMENTS • EMPLOYEES • HR PANEL • ADMIN • ANALYTICS • SHIFTS • DEPARTMENTS • ROLES • LEAFLET MAPS • LARAVEL 13 •</span>
        </div>
    </div>
    <style>@keyframes scroll{0%{transform:translateX(0)}100%{transform:translateX(-25%)}}</style>

    <header style="background:#fff;border-bottom:3px solid #000;padding:20px 0;">
        <div class="neo-container">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;">
                    <div style="width:48px;height:48px;background:#fee440;border:3px solid #000;border-radius:0;display:flex;align-items:center;justify-content:center;box-shadow:3px 3px 0 #000;">
                        <i class="fas fa-fingerprint" style="font-size:20px;color:#000;"></i>
                    </div>
                    <span style="font-size:22px;font-weight:800;color:#000;">{{ config('app.name', 'ABS') }}</span>
                </a>
                <div style="display:flex;gap:16px;align-items:center;">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="neo-btn-primary neo-btn-sm">DASHBOARD</a>
                    @else
                        <a href="{{ route('login') }}" class="neo-btn-secondary neo-btn-sm">SIGN IN</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="neo-btn-primary neo-btn-sm">GET STARTED</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main style="padding:60px 0;">
        <div class="neo-container">
            <div style="text-align:center;margin-bottom:50px;">
                <div style="display:inline-block;background:#fee440;border:2px solid #000;padding:10px 20px;font-size:13px;font-weight:700;margin-bottom:24px;">
                    ⚡ LARAVEL 13 • GPS TRACKING • LEAFLET MAPS
                </div>
                <h1 style="font-size:56px;font-weight:800;color:#000;margin-bottom:20px;line-height:1.05;">
                    Attendance &<br>
                    <span style="background:linear-gradient(90deg,#f15bb5,#9b5de5,#00bbf9);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Employee Management</span>
                </h1>
                <p style="font-size:18px;color:#666;max-width:550px;margin:0 auto 35px;line-height:1.6;font-weight:700;">
                    Complete system for managing employee attendance, leaves, payroll, and reimbursements with GPS tracking via Leaflet maps.
                </p>
                <div style="display:flex;justify-content:center;gap:20px;margin-bottom:60px;">
                    @guest
                        <a href="{{ route('register') }}" class="neo-btn-primary" style="font-size:15px;">START FREE TRIAL</a>
                        <a href="{{ route('login') }}" class="neo-btn-secondary" style="font-size:15px;">SIGN IN</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="neo-btn-green" style="font-size:15px;">GO TO DASHBOARD</a>
                    @endguest
                </div>
            </div>

            <div style="margin-bottom:50px;transform:rotate(-2deg);">
                <div style="background:#00bbf9;border:3px solid #000;overflow:hidden;padding:16px 0;box-shadow:6px 6px 0 #000;">
                    <div style="display:flex;animation:scroll 12s linear infinite;white-space:nowrap;">
                        <span style="color:#000;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                        <span style="color:#000;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                        <span style="color:#000;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                        <span style="color:#000;font-size:16px;font-weight:800;margin-right:60px;">🚀 SMART ATTENDANCE • 📍 GPS LOCATION • 📅 LEAVE MANAGEMENT • 💰 PAYROLL • 💳 REIMBURSEMENTS • 👥 EMPLOYEES • 📊 HR PANEL • ⚙️ ADMIN •</span>
                    </div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:50px;">
                <div class="neo-card" style="padding:24px;">
                    <div style="width:48px;height:48px;background:#00bbf9;border:2px solid #000;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:3px 3px 0 #000;">
                        <i class="fas fa-user" style="font-size:20px;color:#000;"></i>
                    </div>
                    <h3 style="font-size:18px;font-weight:800;margin-bottom:10px;">EMPLOYEE PANEL</h3>
                    <ul style="list-style:none;font-size:13px;color:#666;line-height:2;font-weight:700;">
                        <li>✓ Smart Attendance with GPS</li>
                        <li>✓ Leave Management</li>
                        <li>✓ Reimbursements</li>
                        <li>✓ Payroll View</li>
                        <li>✓ Announcements</li>
                    </ul>
                </div>
                <div class="neo-card" style="padding:24px;">
                    <div style="width:48px;height:48px;background:#f15bb5;border:2px solid #000;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:3px 3px 0 #000;">
                        <i class="fas fa-users" style="font-size:20px;color:#000;"></i>
                    </div>
                    <h3 style="font-size:18px;font-weight:800;margin-bottom:10px;">HR PANEL</h3>
                    <ul style="list-style:none;font-size:13px;color:#666;line-height:2;font-weight:700;">
                        <li>✓ Attendance Monitoring</li>
                        <li>✓ Leave Approval</li>
                        <li>✓ Reimbursement Approval</li>
                        <li>✓ Payroll Management</li>
                    </ul>
                </div>
                <div class="neo-card" style="padding:24px;">
                    <div style="width:48px;height:48px;background:#00f5d4;border:2px solid #000;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:3px 3px 0 #000;">
                        <i class="fas fa-cogs" style="font-size:20px;color:#000;"></i>
                    </div>
                    <h3 style="font-size:18px;font-weight:800;margin-bottom:10px;">ADMIN PANEL</h3>
                    <ul style="list-style:none;font-size:13px;color:#666;line-height:2;font-weight:700;">
                        <li>✓ User Management</li>
                        <li>✓ Department & Roles</li>
                        <li>✓ Shift Management</li>
                        <li>✓ Location Management</li>
                        <li>✓ Dashboard Analytics</li>
                    </ul>
                </div>
            </div>

            <div class="neo-card-yellow" style="padding:28px;margin-bottom:50px;text-align:center;">
                <div style="font-size:16px;font-weight:800;margin-bottom:12px;">🛠️ TECHNOLOGY STACK</div>
                <div style="font-size:14px;font-weight:600;color:#000;">
                    Laravel 13 • PHP 8.3 • Tailwind CSS • Alpine.js • Leaflet Maps • MySQL • Font Awesome
                </div>
            </div>

            <div style="background:#000;border:3px solid #000;padding:40px;text-align:center;margin-bottom:50px;box-shadow:8px 8px 0 #000;">
                <h3 style="font-size:28px;font-weight:800;color:#fff;margin-bottom:12px;">READY TO GET STARTED?</h3>
                <p style="color:#ccc;margin-bottom:24px;font-size:15px;font-weight:700;">Join 500+ companies managing their workforce with ABS</p>
                @guest
                <a href="{{ route('register') }}" class="neo-btn-primary" style="margin-right:12px;">START FREE TRIAL</a>
                <a href="{{ route('login') }}" class="neo-btn-secondary">SIGN IN</a>
                @else
                <a href="{{ url('/dashboard') }}" class="neo-btn-primary">GO TO DASHBOARD</a>
                @endguest
            </div>

            <div style="display:flex;justify-content:center;gap:50px;">
                <div style="text-align:center;"><span style="font-size:32px;font-weight:800;">500+</span><br><span style="font-size:13px;color:#666;font-weight:700;">Active Users</span></div>
                <div style="text-align:center;"><span style="font-size:32px;font-weight:800;">50+</span><br><span style="font-size:13px;color:#666;font-weight:700;">Companies</span></div>
                <div style="text-align:center;"><span style="font-size:32px;font-weight:800;">99.9%</span><br><span style="font-size:13px;color:#666;font-weight:700;">Uptime</span></div>
            </div>
        </div>
    </main>

    <footer style="background:#fff;border-top:3px solid #000;padding:24px 0;text-align:center;">
        <div class="neo-container">
            <p style="font-size:13px;font-weight:700;">© {{ date('Y') }} {{ config('app.name', 'ABS') }} • Privacy • Terms • Support</p>
        </div>
    </footer>
</body>
</html>