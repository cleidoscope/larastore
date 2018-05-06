<!doctype html>
<html lang="en">
<head>
@yield('title')

@include('manager.partials.meta_tags')

@include('manager.partials.styles')

@include('manager.partials.google_tag_manager')

@include('shared.facebook-pixel')

@yield('styles')

</head>
<body class=@yield('body-class')>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5LL5BL5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

@include('manager.partials.navbar')

<main class="cs-main-content">
@yield('content')
</main>
@include('manager.partials.footer')
@include('manager.partials.scripts')
@yield('scripts')
@if(session('_notifyMessage'))
@include('shared.notification', ['section' => '_notifyMessage'])
@endif
@include('manager.partials.getsitecontrol')
</body>
</html>
