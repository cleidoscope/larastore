<div class="ui xsmall modal" id="feedbackFormModal">
  	<div class="content">
	    <form method="POST" action="{{ route('review') }}" class="ui form has-loader">
			<h4 class="font-regular font-big text-center">Write a review</h4>
			<div class="field text-center">
				<label>Rating</label>
				<div class="ui massive star red rating" id="feedback_rating" style="color: red !important;"></div>
				<input type="hidden" name="rating">
			</div>
			<br />
			<div class="field">
				<label>Comment</label>
				<textarea name="comment" placeholder="Your comment" rows="4"></textarea>
				<div class="font-small margin-top half">Note that you can only submit one (1) review per product.</div>
			</div>
	    	<button type="button" class="ui button default small" id="closeFeedbackForm" tabindex="1">Cancel</button>
			<button type="submit" class="ui primary button small right floated has-loader-button" tabindex="0">Submit review</button>
			{{ csrf_field() }}
	    	<input type="hidden" name="product_id" value="{{ $product->id }}">
		</form>
    </div>
</div>