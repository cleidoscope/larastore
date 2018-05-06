<!-- Add New Voucher Modal -->
<div class="ui xsmall modal" id="addVoucherModal">
  	<div class="header">Add New Voucher</div>
  	<div class="content">
	  	<form method="POST" action="{{ route('manager.voucher.store', $store->id) }}" class="ui form voucherForm has-loader">
		    {{ csrf_field() }}
		    <div class="field @if($errors->has('_addVoucherError')) error @endif">
		    	<label class="required">Voucher Code</label>
		    	<input type="text" name="code" value="{{ old('code') }}" spellcheck="false">
		    </div>
		    <div class="field">
		    	<label class="required">Discount</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">{{ config('app.currency') }}</div>
					<input type="number" step="0.01" min="1" name="discount" value="{{ old('discount') }}">
				</div>
		    </div>
		    <div class="field">
		    	<label class="required">Valid until</label>
		    	<input type="date" name="valid_until" value="{{ old('valid_until') }}">
		    </div>
			@if($errors->has('_addVoucherError'))
			<div class="ui negative message small inline no-margin-top">
			{{ $errors->first('_addVoucherError') }}
			</div>
			@endif
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeAddVoucher">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Create</button>
		    </div>
	  	</form>
  	</div>
</div>




<!-- Edit Voucher Modal -->
<div class="ui xsmall modal" id="editVoucherModal">
  	<div class="header">Edit Voucher <em></em></div>
  	<div class="content">
	  	<form method="POST" action="@if($errors->has('_editVoucherError')) {{ $errors->first('oldAction') }} @endif" class="ui form voucherForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field @if($errors->has('_editVoucherError')) error @endif">
		    	<label class="required">Voucher Code</label>
		    	<input type="text" name="code" value="{{ old('code') }}" spellcheck="false" @if($errors->has('_editVoucherError'))autofocus @endif>
		    </div>
		    <div class="field">
		    	<label class="required">Discount</label>
				<div class="ui labeled input fluid">
					<div class="ui basic label">{{ config('app.currency') }}</div>
					<input type="number" step="0.01" min="1" name="discount" value="{{ old('discount') }}">
				</div>
		    </div>
		    <div class="field">
		    	<label class="required">Valid until</label>
		    	<input type="date" name="valid_until" value="{{ old('valid_until') }}">
		    </div>
			@if($errors->has('_editVoucherError'))
			<div class="ui negative message small inline no-margin-top">
			{{ $errors->first('_editVoucherError') }}
			</div>
			@endif
		    <div class="text-right">
			    <div class="ui default small circular button" id="closeEditVoucher">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Update</button>
		    </div>
		</form>
  	</div>
</div>





<!-- Delete Voucher Modal -->
<div class="ui xsmall modal" id="deleteVoucherModal">
  	<div class="header">
  		Delete Voucher <em></em>
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete this voucher?<br />
		    <div class="text-right margin-top">
			    <div class="ui default small circular button" id="closeDeleteVoucher">Cancel</div>
			    <button type="submit" class="ui red small circular button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>


@section('scripts')
<script>
$('.voucherForm')
.form({
fields: {
	code : 'empty',
	discount : ['empty', 'number'],
	valid_until : 'empty',
}
});

$('#addVoucherModal').modal('attach events', '#addVoucher', 'show').modal('attach events', '#closeAddVoucher', 'hide');
$('#editVoucherModal').modal('attach events', '.editVoucher', 'show').modal('attach events', '#closeEditVoucher', 'hide');
$('#deleteVoucherModal').modal('attach events', '.deleteVoucher', 'show').modal('attach events', '#closeDeleteVoucher', 'hide').modal('setting', { autofocus: false });

$('.editVoucher').click(function(){
	var modal = $('#editVoucherModal');
	var code = $(this).data('code');
	var discount = $(this).data('discount');
	var valid_until = $(this).data('valid-until');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(code);
	modal.find('input[name=code]').val(code);
	modal.find('input[name=discount]').val(discount);
	modal.find('input[name=valid_until]').val(valid_until);
});

$('.deleteVoucher').click(function(){
	var modal = $('#deleteVoucherModal');
	var code = $(this).data('code');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(code);
});


@if($errors->has('_addVoucherError'))
$('#addVoucherModal').modal('show');
@endif

@if($errors->has('_editVoucherError'))
$('#editVoucherModal').modal('show');
@endif
</script>
@stop