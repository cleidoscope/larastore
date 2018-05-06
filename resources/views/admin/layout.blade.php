<!doctype html>
<html lang="en">
<head>
@yield('title')
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 maximum-scale=1.0, user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=1.0.0" />

@include('admin.partials.styles')

@yield('styles')

</head>
<body>

@if( !Auth::guest() )
@include('admin.partials.navbar')
@endif

@yield('content')

@include('admin.partials.scripts')
@yield('scripts')

@if(session('_notifyMessage'))
@include('shared.notification', ['section' => '_notifyMessage'])
@endif
</body>
</html>
