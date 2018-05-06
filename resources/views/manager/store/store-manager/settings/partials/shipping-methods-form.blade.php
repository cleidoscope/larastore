<!-- Add New Shipping Method Modal -->
<div class="ui xsmall modal" id="addShippingMethodModal">
  	<div class="header">New shipping method</div>
  	<div class="content">
	  	<form method="POST" action="{{ route('manager.shipping-method.store', $store->id) }}" class="ui form ShippingMethodForm has-loader">
		    {{ csrf_field() }}
		    <div class="field">
		    	<label class="required">Shipping method</label>
		    	<input type="text" name="title" spellcheck="false">
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeAddShippingMethod">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Save</button>
		    </div>
	  	</form>
  	</div>
</div>



<!-- Edit Shipping Method Modal -->
<div class="ui xsmall modal" id="editShippingMethodModal">
  	<div class="header">Edit Shipping Method <em></em></div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form ShippingMethodForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field">
		    	<label class="required">Shipping method</label>
		    	<input type="text" name="title" spellcheck="false">
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeEditShippingMethod">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Save</button>
		    </div>
		</form>
  	</div>
</div>




<!-- Delete Shipping Method Modal -->
<div class="ui xsmall modal" id="deleteShippingMethodModal">
  	<div class="header">
  		Delete shipping method
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete the shipping method <strong></strong>?<br />
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeDeleteShippingMethod">Cancel</div>
			    <button type="submit" class="ui red circular small button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>




<!-- Add New Shipping Rate Modal -->
<div class="ui xsmall modal" id="addShippingRateModal">
  	<div class="header">Add shipping rate to <em></em></div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form ShippingRateForm has-loader">
		    {{ csrf_field() }}
		    <div class="field">
				<label class="required">Minimum weight</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">kg</div>
					<input type="text" name="min" autocomplete="off" placeholder="Minimum weight" class="format-number" value="0.00">
				</div>
			</div>
		    <div class="field">
				<label class="required">Maximum weight</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">kg</div>
					<input type="text" name="max" autocomplete="off" placeholder="Maximum weight" class="format-number" value="0.00">
				</div>
			</div>
			<div class="field">
				<label class="required">Rate amount</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">{{ config('app.currency') }}</div>
					<input type="text" name="rate" autocomplete="off" placeholder="Rate" class="format-number" value="0.00">
				</div>
			</div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeAddShippingRate">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Save</button>
		    </div>
	  	</form>
  	</div>
</div>


<!-- Edit New Shipping Rate Modal -->
<div class="ui xsmall modal" id="editShippingRateModal">
  	<div class="header">Edit shipping rate</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form ShippingRateForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field">
				<label class="required">Minimum weight</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">kg</div>
					<input type="text" name="min" autocomplete="off" placeholder="Minimum weight" class="format-number" value="0.00">
				</div>
			</div>
		    <div class="field">
				<label class="required">Maximum weight</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">kg</div>
					<input type="text" name="max" autocomplete="off" placeholder="Maximum weight" class="format-number" value="0.00">
				</div>
			</div>
			<div class="field">
				<label class="required">Rate amount</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">{{ config('app.currency') }}</div>
					<input type="text" name="rate" autocomplete="off" placeholder="Rate" class="format-number" value="0.00">
				</div>
			</div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeEditShippingRate">Cancel</div>
			    <button type="submit" class="ui primary small circular button has-loader-button">Save</button>
		    </div>
	  	</form>
  	</div>
</div>


<!-- Delete Shipping Rate Modal -->
<div class="ui xsmall modal" id="deleteShippingRateModal">
  	<div class="header">
  		Delete shipping rate
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete this shipping rate?<br />
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeDeleteShippingRate">Cancel</div>
			    <button type="submit" class="ui red circular small button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>

@section('scripts')
<script>
$('.ShippingMethodForm')
.form({
fields: {
	title : 'empty',
}
});


$('#addShippingMethodModal').modal('attach events', '#addShippingMethod', 'show').modal('attach events', '#closeAddShippingMethod', 'hide');
$('#editShippingMethodModal').modal('attach events', '.editShippingMethod', 'show').modal('attach events', '#closeEditShippingMethod', 'hide');
$('#deleteShippingMethodModal').modal('attach events', '.deleteShippingMethod', 'show').modal('attach events', '#closeDeleteShippingMethod', 'hide').modal('setting', { autofocus: false });

$('.editShippingMethod').click(function(){
	var modal = $('#editShippingMethodModal');
	var title = $(this).data('title');
	var description = $(this).data('description');
	var surcharge = $(this).data('surcharge');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(title);
	modal.find('input[name=title]').val(title);
	modal.find('textarea[name=description]').val(description);
	modal.find('input[name=surcharge]').val(surcharge);
});

$('.deleteShippingMethod').click(function(){
	var modal = $('#deleteShippingMethodModal');
	var title = $(this).data('title');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('form strong').text(title);
});



$('.ShippingRateForm')
.form({
fields: {
	min : 'empty',
	max : 'empty',
	rate : 'empty',
}
});
$('#addShippingRateModal').modal('attach events', '.addShippingRate', 'show').modal('attach events', '#closeAddShippingRate', 'hide');
$('#editShippingRateModal').modal('attach events', '.editShippingRate', 'show').modal('attach events', '#closeEditShippingRate', 'hide');
$('#deleteShippingRateModal').modal('attach events', '.deleteShippingRate', 'show').modal('attach events', '#closeDeleteShippingRate', 'hide').modal('setting', { autofocus: false });
$('.addShippingRate').click(function(){
	var modal = $('#addShippingRateModal');
	var method = $(this).data('method');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(method);
});
$('.editShippingRate').click(function(){
	var modal = $('#editShippingRateModal');
	var min = $(this).data('min');
	var max = $(this).data('max');
	var rate = $(this).data('rate');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('input[name=min]').val(min);
	modal.find('input[name=max]').val(max);
	modal.find('input[name=rate]').val(rate);
});
$('.deleteShippingRate').click(function(){
	var modal = $('#deleteShippingRateModal');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
});


</script>
@stop