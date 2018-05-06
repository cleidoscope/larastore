@if( !$store->is_active )
<?php $trialInDays = Helpers::trialIndays($store); ?>
<div class="text-center trial-message font-size-extra-normal">
  <p>
    You have 
    <span class="trial-day">{{ substr($trialInDays, 0, 1) }}</span> 
    @if( substr($trialInDays, 1, 1) != '' ) <span class="trial-day">{{ substr($trialInDays, 1, 1) }}</span>   @endif
    {{ ( $trialInDays > 1 ) ? 'days' : 'day' }} left in your trial
  </p>
</div>
@endif


@if( $store->shipping_methods->count() == 0 )
<div class="ui negative message small">
  <div class="content">
    <div class="header">No shipping methods</div>
    <p>Your customers can't proceed with their orders. Have at least one (1) shipping method for your store. Click <a href="{{ route('manager.store.settings.shipping-method', $store->id) }}">here</a> to create one.</p>
  </div>
</div>
@endif

@if( $store->payment_modes->count() == 0 )
<div class="ui negative message small">
  <div class="content">
    <div class="header">No payment modes</div>
    <p>Your customers can't proceed with their orders. Have at least one (1) payment mode for your store. Click <a href="{{ route('manager.store.settings.payment-mode', $store->id) }}">here</a> to create one.</p>
  </div>
</div>
@endif

@if( !$store->is_basic && !$store->phone )
<div class="ui warning message small">
  <div class="content">
    <p>Add a valid PH mobile number to receive SMS notifications for each placed order from your store. Click <a href="{{ route('manager.store.settings.general', $store->id) }}">here</a> to set.</p>
  </div>
</div>
@endif