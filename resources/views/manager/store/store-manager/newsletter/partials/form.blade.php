<!-- Add New Newsletter Modal -->
<div class="ui small modal" id="addNewsletterModal">
  	<div class="header">Add New Newsletter</div>
  	<div class="content">
	  	<form method="POST" action="{{ route('manager.newsletter.store', $store->id) }}" class="ui form newsletterForm has-loader">
		    {{ csrf_field() }}
		    <div class="field">
		    	<label class="required">Subject</label>
		    	<input type="text" name="subject" value="" spellcheck="false">
		    </div>
		    <div class="field">
		    	<label class="required">Message</label>
		    	<textarea name="message"></textarea>
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeAddNewsletter">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Create</button>
		    </div>
	  	</form>
  	</div>
</div>




<!-- Edit Newsletter Modal -->
<div class="ui small modal" id="editNewsletterModal">
  	<div class="header">Edit Newsletter <em></em></div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form newsletterForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field">
		    	<label class="required">Subject</label>
		    	<input type="text" name="subject" value="" spellcheck="false">
		    </div>
		    <div class="field">
		    	<label class="required">Message</label>
		    	<textarea name="message"></textarea>
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeEditNewsletter">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Save</button>
		    </div>
		</form>
  	</div>
</div>





<!-- Delete Newsletter Modal -->
<div class="ui xsmall modal" id="deleteNewsletterModal">
  	<div class="header">
  		Delete Newsletter <em></em>
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete this newsletter?<br />
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeDeleteNewsletter">Cancel</div>
			    <button type="submit" class="ui red circular small button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>




<!-- Send Newsletter Modal -->
<div class="ui small modal" id="sendNewsletterModal">
  	<div class="header">
  		Send Newsletter <em></em>
  	</div>
  	<div class="content">
  		<div class="ui grid stackable margin-bottom">

			<div class="eight wide tablet eight wide computer column">
			  	<form method="POST" action="" class="ui form has-loader">
			  		{{ csrf_field() }}
			  		<input type="hidden" name="recipient" value="subscribers">
			  		<p>Send this newsletter to your subscribers.</p>
					<button class="ui primary circular small button has-loader-button">Send to subscribers</button>
			  	</form>
			</div>

			<div class="eight wide tablet eight wide computer column">
			  	<form method="POST" action="" class="ui form has-loader" id="newsletter_to_email">
				    {{ csrf_field() }}
				    <input type="hidden" name="recipient" value="email">
			  		<p>Or to a specific email (suited for testing).</p>
			  		<div class="inline field">
			  			<div class="ui action input">
						 	<input type="email" name="email">
						  	<button class="ui primary small button has-loader-button">Send</button>
						</div>
			  		</div>
				</form>
			</div>
		</div>
	    <div class="text-right margin-top">
		    <div class="ui default circular small button" id="closeSendNewsletter">Cancel</div>
	    </div>
  	</div>
</div>

@section('scripts')
<script>
$('.newsletterForm')
.form({
fields: {
	subject : 'empty',
	message : 'empty',
}
});
$('#newsletter_to_email')
.form({
fields: {
	email : ['email', 'empty'],
}
});


$('#addNewsletterModal').modal('attach events', '#addNewsletter', 'show').modal('attach events', '#closeAddNewsletter', 'hide');
$('#editNewsletterModal').modal('attach events', '.editNewsletter', 'show').modal('attach events', '#closeEditNewsletter', 'hide');
$('#deleteNewsletterModal').modal('attach events', '.deleteNewsletter', 'show').modal('attach events', '#closeDeleteNewsletter', 'hide').modal('setting', { autofocus: false });
$('#sendNewsletterModal').modal('attach events', '.sendNewsletter', 'show').modal('attach events', '#closeSendNewsletter', 'hide').modal('setting', {autofocus: false
});

$('.editNewsletter').click(function(){
	var modal = $('#editNewsletterModal');
	var subject = $(this).data('subject');
	var message = $(this).data('message');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(subject);
	modal.find('input[name=subject]').val(subject);
	modal.find('textarea[name=message]').val(message);
});

$('.deleteNewsletter').click(function(){
	var modal = $('#deleteNewsletterModal');
	var subject = $(this).data('subject');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(subject);
});

$('.sendNewsletter').click(function(){
	var modal = $('#sendNewsletterModal');
	var subject = $(this).data('subject');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(subject);
});

</script>
@stop