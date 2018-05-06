<!-- Approve Review Modal -->
<div class="ui xsmall modal" id="approveReviewModal">
  	<div class="header">
  		Approve product review
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    Approved product reviews will be visible in the product page and the average product ratings will  be recalculated.
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeApproveReview">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Approve</button>
		    </div>
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		</form>
  	</div>
</div>

<!-- Delete Review Modal -->
<div class="ui xsmall modal" id="deleteReviewModal">
  	<div class="header">
  		Delete product review <em></em>
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete this product review?<br />
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeDeleteReview">Cancel</div>
			    <button type="submit" class="ui red circular small button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>





@section('scripts')
<script>
$(document).ready(function(){
	$('#approveReviewModal').modal('attach events', '.approveReview', 'show').modal('attach events', '#closeApproveReview', 'hide').modal('setting', { autofocus: false });
	$('#deleteReviewModal').modal('attach events', '.deleteReview', 'show').modal('attach events', '#closeDeleteReview', 'hide').modal('setting', { autofocus: false });

	$('.approveReview').click(function(){
		var action = $(this).data('action');
		$('#approveReviewModal form').attr('action', action);
	});

	
	$('.deleteReview').click(function(){
		var action = $(this).data('action');
		$('#deleteReviewModal form').attr('action', action);
	});
});
</script>
@stop