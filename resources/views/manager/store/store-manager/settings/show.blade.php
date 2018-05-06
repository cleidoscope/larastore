@extends('manager.store.store-manager.layout')

@section('title')
<title>Settings &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop


@section('content')
<div class="ui grid">
	<div class="column">
		@if ( $errors->any() )
		<div class="ui error small message">
		  <ul class="list">
            @foreach( $errors->all() as $error )
            <li>{!! $error !!}</li>
            @endforeach
		  </ul>
		</div>
        @endif
		<div class="ui secondary menu">
		  	<a class="item tab @if( Route::currentRouteName() == 'manager.store.settings.general' ) active @endif" @if( Route::currentRouteName() != 'manager.store.settings.general' ) href="{{ route('manager.store.settings.general', $store->id) }}" @endif>General</a>


		  	<a class="item tab @if( Route::currentRouteName() == 'manager.store.settings.shipping-method' ) active @endif" @if( Route::currentRouteName() != 'manager.store.settings.shipping-method' ) href="{{ route('manager.store.settings.shipping-method', $store->id) }}" @endif>Shipping</a>

		  	<a class="item tab @if( Route::currentRouteName() == 'manager.store.settings.payment-mode' ) active @endif" @if( Route::currentRouteName() != 'manager.store.settings.payment-mode' ) href="{{ route('manager.store.settings.payment-mode', $store->id) }}" @endif>Payment</a>

		</div>
			@if( Route::currentRouteName() == 'manager.store.settings.general' )
			<!-- General -->
			<div class="tab-content active">
				<form method="POST" class="ui form has-loader" id="storeGeneral" action="{{ route('manager.store.settings.update.general', $store->id) }}">
					{{ csrf_field() }}
					<div class="ui grid stackable">
						<!-- Store details -->
						<div class="sixteen wide mobile six wide tablet six wide computer column">
							<h4 class="font-size-medium margin-bottom half">Store details</h4>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam felis nibh, pellentesque non aliquam nec, laoreet in ante.
							</p>
						</div>
						<div class="sixteen wide mobile ten wide tablet ten wide computer column">
							<div class="ui segment">
								<div class="field">
									<label class="required">Store Name</label>
									<input type="text" name="name" value="{{ $store->name }}" autocomplete="off" maxlength="50">
								</div>

								<div class="field">
									<label>Tagline&nbsp;<a href="javascript:void(0)" tabindex="1" class="fa fa-question-circle" data-toggle="popup" data-content="In a few words, explain what your store is about." data-variation="inverted small" data-position="right center"></a></label>
									<input type="text" name="tagline" maxlength="100" value="{{ $store->tagline }}" spellcheck="false">
								</div>

								<div class="field">
									<label>Category</label>
									<select name="store_category_id" class="ui fluid dropdown required">
										<option disabled selected value=""></option>
										@foreach( App\StoreCategory::orderBy('created_at', 'desc')->get() as $storeCategory )
										<option value="{{$storeCategory->id}}" data-category="{{ $storeCategory->category }}" @if($store->store_category_id == $storeCategory->id) selected @endif>{{ $storeCategory->category }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>


						<hr />
						
						<!-- Social media -->
						<div class="sixteen wide mobile six wide tablet six wide computer column">
							<h4 class="font-size-medium margin-bottom half">Social media</h4>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam felis nibh, pellentesque non aliquam nec, laoreet in ante.
							</p>
						</div>
						<div class="sixteen wide mobile ten wide tablet ten wide computer column">
							<div class="ui segment">
								<div class="field">
									<label>Facebook page</label>
									<input type="text" name="facebook" placeholder="Facebook Page Username" value="{{ $store->facebook }}" autocomplete="off"">
								</div>

								<div class="field">
									<label>Twitter</label>
									<input type="text" name="twitter" placeholder="Twitter Username" value="{{ $store->twitter }}" autocomplete="off"">
								</div>

								<div class="field">
									<label>Instagram</label>
									<input type="text" name="instagram" placeholder="Instagram Username" value="{{ $store->instagram }}" autocomplete="off"">
								</div>
							</div>
						</div>

						<hr />

						<!-- Contact Info -->
						<div class="sixteen wide mobile six wide tablet six wide computer column">
							<h4 class="font-size-medium margin-bottom half">Contact info</h4>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam felis nibh, pellentesque non aliquam nec, laoreet in ante.
							</p>
						</div>
						<div class="sixteen wide mobile ten wide tablet ten wide computer column">
							<div class="ui segment">
								<div class="field">
									<label>Street</label>
									<input type="text" name="street" value="{{ $store->street }}" autocomplete="off"">
								</div>
								<div class="two fields">
									<div class="field">
										<label>City</label>
										<input type="text" name="city" value="{{ $store->city }}" autocomplete="off"">
									</div>
									<div class="field">
										<label>Province</label>
										<input type="text" name="province" value="{{ $store->province }}" autocomplete="off"">
									</div>
								</div>
								<div class="two fields">
									<div class="field">
										<label>ZIP code</label>
										<input type="text" name="zip_code" value="{{ $store->zip_code }}" autocomplete="off"">
									</div>
									<div class="field">
										<label>Phone</label>
										<input type="tel" name="phone" minlength="0" maxlength="11" value="{{ $store->phone }}" autocomplete="off"">
										<p class="font-small margin-top half">
											Example format: 09123456789
										</p>
									</div>
								</div>
								<small><em>For plans <strong>Plus</strong> and <strong>Pro</strong>, an SMS will be sent to your phone number for each placed order.</em></small>
							</div>
						</div>
					</div>
					<div class="bottom-submit">
						<button type="submit" class="ui primary small circular button has-loader-button">Save</button>
					</div>
				</form>
			</div>	



			@elseif( Route::currentRouteName() == 'manager.store.settings.shipping-method' )
			<!-- Shipping Methods -->
			<div class="tab-content active">
				<div class="ui grid stackable">
					<div class="sixteen wide mobile ten wide tablet ten wide computer column">
						<button class="ui primary small circular button right floated" id="addShippingMethod">Add shipping method</button>
						<h3 class="no-margin-top no-margin-bottom">Shipping methods</h3>
						<div class="extra margin-bottom">Setup methods on how you ship your products.</div>

						@if(count( $store->shipping_methods ) > 0) 
							@foreach( $store->shipping_methods as $shipping_method )
							<div class="ui segment">
								<div class="font-size-extra-normal font-medium">
									{{ $shipping_method->title }}
									<div class="pull-right">
										<button class="ui mini circular button addShippingRate" data-method="{{ $shipping_method->title }}" data-action="{{ route('manager.shipping-rate.store', ['store_id' => $store->id, 'method_id' => $shipping_method->id]) }}">Add rate</button>
									</div>
									<div class="font-small font-light">
										<a href="javascript:void(0)" class="editShippingMethod underline" data-title="{{ $shipping_method->title }}" data-action="{{ route('manager.shipping-method.update', ['store_id' => $store->id, 'id' => $shipping_method->id]) }}">Edit</a>
										<span class="v-divider"></span>
										<a href="javascript:void(0)" class="deleteShippingMethod underline" data-title="{{ $shipping_method->title }}" data-action="{{ route('manager.shipping-method.destroy', ['store_id' => $store->id, 'id' => $shipping_method->id]) }}">Delete</a>
									</div>
								</div>
								@if( $shipping_method->rates->count() > 0 )
								<div class="table-responsive borderless margin-top half">
									<table class="ui unstackable very basic compact table no-margin-bottom">
										<tbody> 
											@foreach( $shipping_method->rates as $rate )
											<tr>
												<td>{{ number_format($rate->min, 2) }} kg - {{ number_format($rate->max, 2) }} kg</td>
												<td><strong>{{ Helpers::currencyFormat($rate->rate) }}</strong></td>
												<td class="right aligned">
													<span class="font-small font-light">
														<a href="javascript:void(0)" class="editShippingRate underline" data-min="{{ number_format($rate->min, 2) }}" data-max="{{ number_format($rate->max, 2) }}" data-rate="{{ number_format($rate->rate, 2) }}" data-action="{{ route('manager.shipping-rate.update', ['store_id' => $store->id, 'method_id' => $shipping_method->id, 'id' => $rate->id]) }}">Edit</a>
														<span class="v-divider"></span>
														<a href="javascript:void(0)" class="deleteShippingRate underline" data-title="{{ $shipping_method->title }}"  data-action="{{ route('manager.shipping-rate.destroy', ['store_id' => $store->id, 'method_id' => $shipping_method->id, 'id' => $rate->id]) }}">Delete</a>
													</span>
												</td>
											@endforeach
										</tbody>
									</table>
								</div>
								@else
								<div class="extra">You need to add at least one rate to make this shipping method available upon checkout.</div>
								@endif
							</div>
							@endforeach
						@else
							<div class="ui segment text-center extra">No shipping methods</div>
						@endif
					</div>
					<div class="sixteen wide mobile six wide tablet six wide computer column">
					</div>
				</div>

				<div class="text-right margin-top"> 
				{!! $store->shipping_methods()->paginate(25)->links('pagination.default') !!}
				</div>
			</div>


			@elseif( Route::currentRouteName() == 'manager.store.settings.payment-mode' )
			<!-- Payment Modes -->
			<div class="tab-content active">
				<button class="ui primary small circular button right floated" id="addPaymentMode">Add payment mode</button>
				<h3 class="no-margin-top no-margin-bottom">Payment Modes</h3>
				<div class="extra margin-bottom">Setup modes on how you want to accept payments.</div>
				<div class="table-responsive margin-top">
					<table class="ui unstackable table no-margin-bottom">
						@if(count( $store->payment_modes ) > 0) 
						<thead>
							<tr>
								<th>Payment Mode</th>
								<th>Description</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach( $store->payment_modes()->paginate(25) as $payment_mode )
							<tr class="top aligned">
								<td>{{ $payment_mode->title }}</td>
								<td>{!! nl2br($payment_mode->description) !!}</td>
								<td class="right aligned">
									<span class="font-small font-light">
										<a href="javascript:void(0)" class="editPaymentMode underline" data-title="{{ $payment_mode->title }}" data-description="{{ $payment_mode->description }}" data-action="{{ route('manager.payment-mode.update', ['store_id' => $store->id, 'id' => $payment_mode->id]) }}">Edit</a>
										<span class="v-divider"></span>
										<a href="javascript:void(0)" class="deletePaymentMode underline" data-title="{{ $payment_mode->title }}" data-action="{{ route('manager.payment-mode.destroy', ['store_id' => $store->id, 'id' => $payment_mode->id]) }}">Delete</a>
									</span>
								</td>
							</tr>
							@endforeach
						</tbody>
						@else
						<tbody>
							<tr class="text-center text-muted">
								<td class="extra">No payment modes.</td>
							</tr>
						</tbody>
						@endif
					</table>
				</div>

				<div class="text-right margin-top"> 
				{!! $store->payment_modes()->paginate(25)->links('pagination.default') !!}
				</div>
			</div>

			@endif

	</div>
</div>



<!-- Modals -->
@if( Route::currentRouteName() == 'manager.store.settings.shipping-method' )
@include('manager.store.store-manager.settings.partials.shipping-methods-form')
@elseif( Route::currentRouteName() == 'manager.store.settings.payment-mode' )
@include('manager.store.store-manager.settings.partials.payment-modes-form')
@endif

@stop


@section('scripts')
<script>
$(document).ready(function(){
	@if( Route::currentRouteName() == 'manager.store.settings.general' )
	$('#storeGeneral').form({ 
		fields: {
			name : 'empty',
		  	store_category_id : 'empty',
			phone  : ['number', 'minLength[0]', 'maxLength[11]', 'regExp[/^$|^(09|){2}\\d{9}$/]'],
		} 
	});
	@endif
});
</script>
@stop
