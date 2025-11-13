<!-- @format -->

<!DOCTYPE html>
@php
    $forceArabicRtl = request()->is('dashboard*')
        || request()->is('login')
        || request()->is('register')
        || request()->is('password*')
        || request()->is('forgot-password')
        || request()->is('reset-password')
        || request()->is('verify-email')
        || request()->is('email*');
    $langAttr = $forceArabicRtl ? 'ar' : app()->getLocale();
    $dirAttr = $forceArabicRtl ? 'rtl' : (app()->getLocale() == 'ar' ? 'rtl' : 'ltr');
@endphp
<html lang="{{ $langAttr }}" dir="{{ $dirAttr }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>Medad</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/web/css/main.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/fontawesome-free/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web/css/bootstrap.min.css') }}" />
</head>

<body>
    {{-- Language Switcher - Hide on dashboard and auth routes only --}}
    @php
        $hideLangSwitcher = request()->is('dashboard*')
            || request()->is('login')
            || request()->is('register')
            || request()->is('password*')
            || request()->is('forgot-password')
            || request()->is('reset-password')
            || request()->is('verify-email')
            || request()->is('email*');
    @endphp
    @unless($hideLangSwitcher)
        @include('web.partials.language-switcher')
    @endunless
    {{-- <div class='container'> --}}
    @yield('content')
    {{-- </div> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        @if (session('success'))
            {{-- Swal.fire({ --}}
            {{--    title: '{{session('success')}}', --}}
            {{--    showCancelButton: true, --}}
            {{--    confirmButtonText: 'Confirm', --}}
            {{--    confirmButtonColor:'#dc3545' --}}
            {{-- }); --}}
            Swal.fire(
                '{{ session('success') }}',
                'success'
            )
        @endif
        @if (session('error'))

            Swal.fire(
                'error',
                '{{ session('error') }}',
                'error'
            );
        @endif
    </script>

    @yield('script')
</body>

</html>
