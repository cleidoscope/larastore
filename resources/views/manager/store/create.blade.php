@extends('manager.layout')

@section('title')
<title>Create Store &rsaquo; {{ config('app.name') }}</title>
@stop

@section('content')
<h3 class="text-center font-thin font-massive">Create New Store</h3>
<div class="ui container">
	<div class="ui stackable grid margin-top">
		<div class="sixteen wide mobile two wide tablet two wide computer column"></div>
		<div class="sixteen wide mobile six wide tablet seven wide computer column">
			<form id="storeCreateForm" class="ui form" method="POST" action="{{ route('manager.store.store') }}">
				{{ csrf_field() }}
				<!-- Step 1 -->
				<div class="content-step show" id="content-step1">
					<div class="field">
						<label class="font-light required"">Store name</label>
						<input type="text" name="name" value="{{ old('name') }}" autocomplete="off" maxlength="50">
					</div>
					<div class="field @if( $errors->has('subdomain_exists') ) error @endif">
						<label class="font-light required">Your custom store domain</label>
						<div class="ui right labeled input fluid @if($errors->has('subdomain_exists')) error @endif">
						  	<input type="text" name="subdomain" class="lowercase" value="{{ old('subdomain') }}" id="subdomain" autocomplete="off" maxlength="50">
						  	<div class="ui basic label">
						    .cloudstore.ph
						  	</div>
						</div>
						<div class="subdomain-availability"></div>
					</div>
					<div class="field">
						<label class="font-light required">What are you selling?</label>
						<select name="store_category_id" class="ui fluid dropdown">
							<option disabled selected value=""></option>
							@foreach( App\StoreCategory::orderBy('category', 'desc')->get() as $storeCategory )
							<option value="{{$storeCategory->id}}" data-category="{{ $storeCategory->category }}" @if(old('store_category_id') == $storeCategory->id) selected @endif>{{ $storeCategory->category }}</option>
							@endforeach
						</select>
					</div>

					<button type="button" id="buttonCreateStore" class="ui right labeled icon primary large circular button right floated next-button">Create store <i class="chevron right icon"></i></button>
					<div class="clearfix"></div>
				</div>		
			</form>

			@if ( $errors->any() )
			<div class="ui negative message">
				<div class="header">Oops! There were errors:</div>
			  	<ul>
	                @foreach( $errors->all() as $error )
	                <li>{!! $error !!}</li>
	                @endforeach
			  	</ul>
			</div>
	        @endif
		</div>
		<div class="sixteen wide mobile six wide tablet six wide computer column">
			<p>
				Enjoy all the <a href="{{ route('manager.pricing') }}" target="_blank">Plus Plan</a> benefits <strong>FREE</strong> for the first month. After your trial has ended, you will then have the option to pick a plan that best suit your store's needs.
				<br />
				Start your free trial now and watch your online store grow!
			</p>
		</div>
	</div>
</div>
<div class="margin-bottom">&nbsp;</div>
@stop

@section('scripts')
<script>
var subdomains = {!! json_encode( App\Store::all()->pluck('subdomain')->toArray() ) !!};
function is_valid_domain_name(subdomain)
{
	var charsCheck = /^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i;
	var lengthCheck = /^.{1,253}$/;
	var labelLengthCheck = /^[^\.]{1,63}(\.[^\.]{1,63})*$/;
	return (charsCheck.exec(subdomain) != null && lengthCheck.test(subdomain) != null && labelLengthCheck.test(subdomain));
}


$(document).ready(function(){
	$('#subdomain').on('textInput input', function(){
		$('.subdomain-availability').html('<div class="ui active inline loader mini"></div>');
		var subdomain = $(this).val();
		subdomain = subdomain.toLowerCase();
		window.setTimeout(function () {
			if( $.inArray(subdomain, subdomains) === -1 && is_valid_domain_name(subdomain) ){
				$('#subdomain').closest('.field').removeClass('error');
				$('.subdomain-availability').html('<span class="positive"><i class="fa fa-check"></i> Available</span>');
			} 
			else if( !is_valid_domain_name(subdomain) ){
				$('#subdomain').closest('.field').addClass('error');
				$('.subdomain-availability').html('<span class="negative"><i class="fa fa-warning"></i> Invalid subdomain</span>');
			}
			else {
				$('#subdomain').closest('.field').addClass('error');
				$('.subdomain-availability').html('<span class="negative"><i class="fa fa-warning"></i> Not Available</span>');
			}
		}, 300);
	});

	var storeCreateForm = $('#storeCreateForm');


	function step1Validation(){	
		var fields = {
			name : 'empty',
		  	subdomain : 'empty',
		  	store_category_id : 'empty',
		};
		storeCreateForm.form({ fields: fields});
	}

	function step1Event(fields){
		var subdomain = storeCreateForm.find('input[name=subdomain]').val();
		storeCreateForm.form('validate form');
		if ( storeCreateForm.form('is valid') && $.inArray(subdomain, subdomains) === -1 && is_valid_domain_name(subdomain) ) {
			$('html, body').animate({scrollTop: '0px'}, 0);
			$('#subdomain').closest('.field').removeClass('error');
			return true;
		}
		else if( !is_valid_domain_name(subdomain) ){
			$('#subdomain').closest('.field').addClass('error');
			$('.subdomain-availability').html('<span class="negative"><i class="fa fa-warning"></i> Invalid subdomain</span>');
		}
		else if( $.inArray(subdomain, subdomains) !== -1 ){
			$('#subdomain').closest('.field').addClass('error');
			$('.subdomain-availability').html('<span class="negative"><i class="fa fa-warning"></i> Not Available</span>');
		}
		return false;
	}
	step1Validation();




	$('#buttonCreateStore').click(function(){
		storeCreateForm.submit();
	});

	storeCreateForm.on('submit', function(e){
		storeCreateForm.form('validate form');
		var success = step1Event();
		if( !success ) {
			e.preventDefault();
			return false;
		}
	});







	


});

</script>
@stop