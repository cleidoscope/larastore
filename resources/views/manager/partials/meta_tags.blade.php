<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 maximum-scale=1.0, user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=1.0.0" />

<meta name="description" 			content="Fast and beautifully created ecommerce platform for your online store." />
<meta property="fb:app_id" 			content="1208410692601134" /> 
<meta property="og:type"   			content="website" /> 
<meta property="og:url"    			content="{{ Request::url() }}" /> 
<meta property="og:title"  			content="{{ config('app.name') }}" /> 
<meta property="og:description"  	content="Fast and beautifully created ecommerce platform for your online store." />
<meta name="og:site_name" 			content="{{ config('app.name') }}" />
<meta property='og:image' 			content="{{ asset('banner.jpg') }}" />

<meta name="twitter:card" 			content="summary_large_image" />
<meta name="twitter:title" 			content="{{ config('app.name') }}" />
<meta name="twitter:image" 			content="{{ asset('banner.jpg') }}" />