<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="{{ asset('soft/build') }}/assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="{{ asset('soft/build') }}/assets/img/favicon.png" />
    <title>@yield('title', 'ABS - Authentication')</title>
    <!--     Fonts and icons     -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
      src="https://kit.fontawesome.com/42d5adcbca.js"
      crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('soft/build') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('soft/build') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Main Styling -->
    <link
      href="{{ asset('soft/build') }}/assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5"
      rel="stylesheet" />
  </head>

  <body
    class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    
    <main class="ease-soft-in-out min-h-screen flex items-center justify-center">
      <div class="w-full max-w-md px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
          <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h4 class="font-bold text-center text-slate-700">@yield('header', 'Welcome')</h4>
          </div>
          <div class="flex-auto p-6">
            @yield('content')
          </div>
        </div>
      </div>
    </main>

    <!--   Core JS Files   -->
    <script src="{{ asset('soft/build') }}/assets/js/plugins/perfect-scrollbar.min.js" async></script>
    <!-- github button -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- main script file  -->
    <script
      src="{{ asset('soft/build') }}/assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5"
      async></script>
  </body>
</html>
