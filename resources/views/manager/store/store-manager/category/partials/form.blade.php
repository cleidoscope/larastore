<!-- Add New Category Modal -->
<div class="ui xsmall modal" id="addCategoryModal">
  	<div class="header">Add New Category</div>
  	<div class="content">
	  	<form method="POST" action="{{ route('manager.category.store', $store->id) }}" class="ui form categoryForm has-loader">
		    {{ csrf_field() }}
		    <div class="field">
		    	<label class="required">Category</label>
		    	<input type="text" name="category" value="{{ old('category') }}" spellcheck="false">
		    	<div class="extra margin-top">Note: The <strong>slug</strong> is auto-generated when creating a category. Spaces and special characters will be omitted if there's any. <a href="{{ route('manager.support') }}" target="_blank">What is a slug?</a></div>
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeAddCategory">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Create</button>
		    </div>
	  	</form>
  	</div>
</div>


<!-- Edit Category Modal -->
<div class="ui xsmall modal" id="editCategoryModal">
  	<div class="header">Edit Category <em></em></div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form categoryForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field">
		    	<label class="required">Category</label>
		    	<input type="text" name="category" value="{{ old('category') }}" spellcheck="false">
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeEditCategory">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Update</button>
		    </div>
		</form>
  	</div>
</div>


<!-- Delete Category Modal -->
<div class="ui xsmall modal" id="deleteCategoryModal">
  	<div class="header">
  		Delete Category <em></em>
	  	<div class="extra font-light">Note: Products in this category will be set to <strong>uncategorized</strong> after deleting.</div>
  	</div>
  	<div class="content">
	  	<form method="POST" action="" class="ui form has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure you want to delete this category?<br />
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeDeleteCategory">Cancel</div>
			    <button type="submit" class="ui red  circular small button has-loader-button">Delete</button>
		    </div>
		</form>
  	</div>
</div>


@section('scripts')
<script>
$('.categoryForm')
.form({
fields: {
	category : 'empty',
}
});

$('#addCategoryModal').modal('attach events', '#addCategory', 'show').modal('attach events', '#closeAddCategory', 'hide');
$('#editCategoryModal').modal('attach events', '.editCategory', 'show').modal('attach events', '#closeEditCategory', 'hide');
$('#deleteCategoryModal').modal('attach events', '.deleteCategory', 'show').modal('attach events', '#closeDeleteCategory', 'hide').modal('setting', { autofocus: false });

$('.editCategory').click(function(){
	var modal = $('#editCategoryModal');
	var category = $(this).data('category');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(category);
	modal.find('input[name=category]').val(category);
});

$('.deleteCategory').click(function(){
	var modal = $('#deleteCategoryModal');
	var category = $(this).data('category');
	var action = $(this).data('action');
	modal.find('form').attr('action', action);
	modal.find('.header em').text(category);
});
</script>
@stop