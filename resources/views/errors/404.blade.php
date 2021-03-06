<!doctype html>
<html lang="en">
<head>
<title>Page not found &rsaquo; {{ config('app.name')}}</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=1.0.0" />
<link rel="stylesheet" href="{{ asset('semantic/dist/semantic.min.css') }}">
<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/manager.css') }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div class="error-page-container text-center">
	<h2 class="no-margin-bottom text-grey">404</h2>
	<p>Sorry, but the page you are looking for does not exist</p>
	<a class="ui button primary" href="{{ url('') }}">Return to homepage</a>
</div>

</body>
</html>
