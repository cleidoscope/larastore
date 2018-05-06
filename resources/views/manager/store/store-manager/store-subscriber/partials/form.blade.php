<!-- Add New Subscriber Modal -->
<div class="ui xsmall modal" id="addSubscriberModal">
  	<div class="header">Add New Subscriber</div>
  	<div class="content">
	  	<form method="POST" action="{{ route('manager.store-subscriber.store', $store->id) }}" class="ui form subscriberForm has-loader">
		    {{ csrf_field() }}
		    <div class="field">
		    	<label class="required">Full Name</label>
		    	<input type="text" name="full_name" value="{{ old('full_name') }}" spellcheck="false">
		    </div>
		    <div class="field @if($errors->has('_addSubscriberError')) error @endif">
		    	<label class="required">Email</label>
		    	<input type="email" name="email" value="{{ old('email') }}" spellcheck="false">
		    </div>
			@if($errors->has('_addSubscriberError'))
			<div class="ui negative message small inline no-margin-top">
			{{ $errors->first('_addSubscriberError') }}
			</div>
			@endif
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeAddSubscriber">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Create</button>
		    </div>
	  	</form>
  	</div>
</div>


<!-- Edit Subscriber Modal -->
<div class="ui xsmall modal" id="editSubscriberModal">
  	<div class="header">Edit Subscriber <em></em></div>
  	<div class="content">
	  	<form method="POST" action="@if($errors->has('_editSubscriberError')) {{ $errors->first('oldAction') }} @endif" class="ui form subscriberForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field">
		    	<label class="required">Full Name</label>
		    	<input type="text" name="full_name" value="{{ old('full_name') }}" spellcheck="false">
		    </div>
		    <div class="field @if($errors->has('_editSubscriberError')) error @endif">
		    	<label class="required">Email</label>
		    	<input type="email" name="email" value="{{ old('email') }}" spellcheck="false" @if($errors->has('_editSubscriberError'))autofocus @endif>
		    </div>
			@if($errors->has('_editSubscriberError'))
			<div class="ui negative message small inline no-margin-top">
			{{ $errors->first('_editSubscriberError') }}
			</div>
			@endif
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeEditSubscriber">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Update</button>
		    </div>
		</form>
  	</div>
</div>




<!-- Delete Subscriber Modal -->
<div class="ui xsmall modal" id="deleteSubscriberModal">
  	<div class="header">
  		Delete Subscriber <em></em>
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete this subscriber?<br />
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeDeleteSubscriber">Cancel</div>
			    <button type="submit" class="ui red circular small button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>



@section('scripts')
<script>
$(document).ready(function(){
	$('.subscriberForm')
	.form({
	fields: {
		full_name : 'empty',
		email : ['empty', 'email'],
	}
	});

	$('#addSubscriberModal').modal('attach events', '#addSubscriber', 'show').modal('attach events', '#closeAddSubscriber', 'hide');
	$('#editSubscriberModal').modal('attach events', '.editSubscriber', 'show').modal('attach events', '#closeEditSubscriber', 'hide');
	$('#deleteSubscriberModal').modal('attach events', '.deleteSubscriber', 'show').modal('attach events', '#closeDeleteSubscriber', 'hide').modal('setting', { autofocus: false });

	$('.editSubscriber').click(function(){
		var modal = $('#editSubscriberModal');
		var full_name = $(this).data('fullname');
		var email = $(this).data('email');
		var action = $(this).data('action');
		modal.find('form').attr('action', action);
		modal.find('.header em').text(full_name);
		modal.find('input[name=full_name]').val(full_name);
		modal.find('input[name=email]').val(email);
	});

	$('.deleteSubscriber').click(function(){
		var modal = $('#deleteSubscriberModal');
		var full_name = $(this).data('fullname');
		var action = $(this).data('action');
		modal.find('form').attr('action', action);
		modal.find('.header em').text(full_name);
	});

	@if($errors->has('_addSubscriberError'))
	$('#addSubscriberModal').modal('show');
	@endif

	@if($errors->has('_editSubscriberError'))
	$('#editSubscriberModal').modal('show');
	@endif
});

</script>
@stop