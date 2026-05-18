<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>@yield('title', 'ABS')</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #f0f0f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-box {
            width: 100%;
            max-width: 340px;
            background: #fff;
            border: 3px solid #1a1a1a;
            border-radius: 12px;
            box-shadow: 4px 4px 0 #1a1a1a;
            padding: 24px;
        }
        .auth-box.register { max-width: 480px; }
         .logo {
             width: 36px;
             height: 36px;
             background: #4f46e5;
             border: 2px solid #1a1a1a;
             border-radius: 8px;
             display: flex;
             align-items: center;
             justify-content: center;
             margin: 0 auto 12px;
         }
        h1 { font-size: 18px; font-weight: 700; color: #1a1a1a; text-align: center; margin-bottom: 4px; }
        p { font-size: 11px; color: #666; text-align: center; margin-bottom: 16px; }
        label { display: block; font-size: 10px; font-weight: 700; color: #1a1a1a; margin-bottom: 2px; }
        input, select {
            width: 100%;
            padding: 6px 8px;
            border: 2px solid #1a1a1a;
            border-radius: 6px;
            font-size: 11px;
            font-family: inherit;
            margin-bottom: 8px;
        }
        input:focus, select:focus { outline: none; box-shadow: 2px 2px 0 #1a1a1a; }
         .btn {
             width: 100%;
             padding: 8px;
             background: #4f46e5;
             border: 2px solid #1a1a1a;
             border-radius: 6px;
             font-size: 11px;
             font-weight: 700;
             cursor: pointer;
             box-shadow: 2px 2px 0 #1a1a1a;
         }
        .btn:hover { transform: translate(-1px, -1px); box-shadow: 3px 3px 0 #1a1a1a; }
        .btn:active { transform: translate(1px, 1px); box-shadow: 1px 1px 0 #1a1a1a; }
        .checkbox { width: auto; margin-bottom: 0; margin-right: 4px; }
        .flex { display: flex; align-items: center; justify-content: space-between; }
        .flex label { margin-bottom: 0; }
        .flex a { font-size: 10px; font-weight: 700; color: #1a1a1a; }
        .footer { border-top: 1px solid #ddd; padding-top: 12px; margin-top: 12px; }
        .footer p { margin-bottom: 0; font-size: 10px; }
        .footer a { font-weight: 700; }
        .error { font-size: 9px; color: #f00; margin-top: -6px; margin-bottom: 6px; }
        .status { font-size: 10px; background: #d4edda; border: 1px solid #c3e6cb; padding: 4px; border-radius: 4px; margin-bottom: 8px; color: #155724; }
    </style>
</head>
<body>
    <div class="auth-box {{ Request::routeIs('register') ? 'register' : '' }}">
        <div class="logo"><i class="fas fa-fingerprint" style="font-size:14px;"></i></div>
        <h1>{{ config('app.name', 'ABS') }}</h1>
        <p>@yield('subtitle', 'Welcome')</p>

        @yield('content')

        @hasSection('footer')
        <div class="footer">@yield('footer')</div>
        @endif

        <p style="margin-top:12px;margin-bottom:0;">© {{ date('Y') }} {{ config('app.name', 'ABS') }}</p>
    </div>
</body>
</html>