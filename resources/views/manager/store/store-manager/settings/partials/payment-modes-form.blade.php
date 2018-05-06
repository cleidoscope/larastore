<!-- Add New Payment Mode Modal -->
<div class="ui xsmall modal" id="addPaymentModeModal">
  	<div class="header">Add New Payment Mode</div>
  	<div class="content">
	  	<form method="POST" action="{{ route('manager.payment-mode.store', $store->id) }}" class="ui form paymentModeForm has-loader">
		    {{ csrf_field() }}
		    <div class="field">
		    	<label class="required">Payment Method</label>
		    	<input type="text" name="title" spellcheck="false">
		    </div>
		    <div class="field">
		    	<label>Details</label>
		    	<textarea name="description" rows="3"></textarea>
		    </div>
		    <div class="text-right">
			    <div class="ui default small circular button" id="closePaymentMode">Cancel</div>
			    <button type="submit" class="ui primary small circular button has-loader-button">Create</button>
		    </div>
	  	</form>
  	</div>
</div>



<!-- Edit Payment Method Modal -->
<div class="ui xsmall modal" id="editPaymentModeModal">
  	<div class="header">Edit Payment Mode <em></em></div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form paymentModeForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field">
		    	<label class="required">Title</label>
		    	<input type="text" name="title" spellcheck="false">
		    </div>
		    <div class="field">
		    	<label>Description</label>
		    	<textarea name="description" rows="3"></textarea>
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeEditPaymentMode">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Update</button>
		    </div>
		</form>
  	</div>
</div>



<!-- Delete Payment Mode Modal -->
<div class="ui xsmall modal" id="deletePaymentModeModal">
  	<div class="header">
  		Delete Payment Mode
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete the payment mode <strong></strong>?<br />
		    <div class="text-right margin-top">
			    <div class="ui default small circular button" id="dclosePaymentMode">Cancel</div>
			    <button type="submit" class="ui red small circular button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>


@section('scripts')
<script>
$('.paymentModeForm')
.form({
fields: {
	title : 'empty',
}
});

$('#addPaymentModeModal').modal('attach events', '#addPaymentMode', 'show').modal('attach events', '#closePaymentMode', 'hide');
$('#editPaymentModeModal').modal('attach events', '.editPaymentMode', 'show').modal('attach events', '#closeEditPaymentMode', 'hide');
$('#deletePaymentModeModal').modal('attach events', '.deletePaymentMode', 'show').modal('attach events', '#dclosePaymentMode', 'hide').modal('setting', { autofocus: false });

$('.editPaymentMode').click(function(){
	var modal = $('#editPaymentModeModal');
	var title = $(this).data('title');
	var description = $(this).data('description');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(title);
	modal.find('input[name=title]').val(title);
	modal.find('textarea[name=description]').val(description);
});

$('.deletePaymentMode').click(function(){
	var modal = $('#deletePaymentModeModal');
	var title = $(this).data('title');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('form strong').text(title);
});
</script>
@stop