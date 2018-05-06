<a class="ui labeled icon small circular button margin-bottom" href="{{ route('manager.product.index', $store->id) }}">
	<i class="left chevron icon"></i>
	All Products
</a>



@if( Route::currentRouteName() == 'manager.product.edit' )
@include('manager.store.store-manager.product.partials.delete')
<form method="POST" action="{{ route('manager.product.update', ['store_id' => $store->id, 'product_id' => $product['id']]) }}" id="productCreateForm" class="ui form has-loader" enctype="multipart/form-data">
{{ method_field('PUT') }}
@else
<form method="POST" action="{{ route('manager.product.store', $store->id) }}" id="productCreateForm" class="ui form has-loader" enctype="multipart/form-data">
@endif
	{{ csrf_field() }}
	<div class="ui grid">
		<div class="sixteen wide mobile ten wide tablet eleven wide computer column">
			<div class="ui segment">
				@if(Route::currentRouteName() == 'manager.product.edit')
				<h3 class="no-margin-bottom">Edit <em>{{ $product['title'] }}</em></h3>
				<div class="margin-bottom"><em>{{ $product['slug'] }}</em></div>
				@else
				<h3 class="margin-bottom">Add Product</h3>
				@endif
	        	<div class="field">
					<label class="required">Name</label>
					<input type="text" name="title" placeholder="Name" value="{{ $product['title'] }}">
				</div>
	        	<div class="field">
					<label class="required">Description</label>
					<textarea name="description" placeholder="Description" spellcheck="false" rows="12">{{ $product['description'] }}</textarea>
				</div>
				<div class="field">
					<label>Images</label>
					<div class="product-images-container">
						<div class="product-image-preview new">
							<button type="button" class="circular ui icon button small primary add-product-image-button"><i class="icon plus"></i></button>
							<button type="button" class="circular ui icon button small negative delete-product-image-button"><i class="icon remove"></i></button>
							<input type="file" accept="image/*" name="product_images[]">
						</div>

						@foreach( $product['product_images'] as $product_image )
						<div class="product-image-preview image-deletable" id="{{ $product_image->id }}" style="background-image: url({{ Helpers::getImage($product_image->image) }})">
							<button type="button" style="opacity: 1;" class="circular ui icon button small negative delete-product-image-button delete-product-image-stored-button" data-id="{{ $product_image->id }}"><i class="icon remove"></i></button>
						</div>
						@endforeach

						@if( Route::currentRouteName() == 'manager.product.edit' )
						<div id="images-to-delete-container"></div>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="sixteen wide mobile six wide tablet five wide computer column">
			<div class="ui segment">
				<div class="field">
					<label class="pull-right" id="discount-percent">{!! Helpers::getDiscountHTML($product['price'], $product['old_price']) !!}</label>
					<label class="required">Price</label>
					<div class="ui labeled input fluid">
						<div class="ui basic label">{{ config('app.currency') }}</div>
						<input type="text" name="price" placeholder="Price" autocomplete="off" value="{{ number_format($product['price'], 2) }}" class="format-number">
					</div>
				</div>
				<div class="field">
					<label>Old Price</label>
					<div class="ui labeled input fluid">
						<div class="ui basic label">{{ config('app.currency') }}</div>
						<input type="text" name="old_price" autocomplete="off" placeholder="Old Price" @if( $product['old_price'] ) value="{{  number_format($product['old_price'], 2) }}" @endif class="format-number optional">
					</div>
				</div>
				<div class="field">
					<label class="required">Weight</label>
					<div class="ui labeled input fluid">
						<div class="ui basic label">kg</div>
						<input type="text" name="weight" placeholder="Weight" autocomplete="off" class="format-number" value="{{  number_format($product['weight'], 2) }}">
					</div>
					<div class="font-light font-small margin-top half">Used to calculate shipping rates at checkout.</div>
				</div>
				<div class="field">
					<label>Category</label>
					<select name="product_category_id" class="ui fluid dropdown">
						<option @if(!$product['product_category_id']) selected @endif value="uncategorized">Uncategorized</option>
						@foreach( App\ProductCategory::orderBy('created_at', 'desc')->get() as $productCategory )
						<option value="{{$productCategory->id}}" data-category="{{ $productCategory->category }}" @if($product['product_category_id'] == $productCategory->id) selected @endif>{{ $productCategory->category }}</option>
						@endforeach
					</select>
				</div>
        		<div class="field">
        			<div class="ui checkbox">
						<input type="checkbox" value="in_stock" @if($product['in_stock']) checked @endif name="in_stock" tabindex="0" class="hidden"> 
						<label>In Stock</label>
					</div>
				</div>
        		<div class="field">
        			<div class="ui checkbox">
						<input type="checkbox" value="unlimited" id="is_featured" @if($product['is_featured']) checked @endif name="is_featured" tabindex="0" class="hidden"> 
						<label for="is_featured">Featured Product</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="image_order" id="image_order">

	<div class="bottom-submit">
		<button type="submit" class="ui primary small circular button has-loader-button">Save</button>
		@if( Route::currentRouteName() == 'manager.product.edit' )
		<button type="button" class="ui small icon red circular button" id="deleteProduct"><i class="icon trash"></i></button>
		@endif
	</div>
</form>


@section('scripts')
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
<script>
$( function() {
	$( ".product-images-container" ).sortable({
		items: ".product-image-preview:not(.new)",
	  	containment: "parent",
	  	update: function (event, ui) {
	        var data = $(this).sortable('toArray');
	       $('#image_order').val(data);
	    }
	});
} );

@if( Route::currentRouteName() == 'manager.product.edit' )
$('#deleteProductModal').modal('attach events', '#deleteProduct', 'show').modal('attach events', '#closeDeleteCategory', 'hide').modal('setting', { autofocus: false });
$('.delete-product-image-stored-button').click(function(){
	var id = $(this).data('id');
	var images_to_delete_container = $('#images-to-delete-container');
	images_to_delete_container.append('<input type="hidden" name="images_to_delete[]" value="' + id + '">');
});
@endif
var form = $('#productCreateForm');

form.form({
    fields: {
    	title : 'empty',
      	description : 'empty',
      	price : 'empty',
      	weight : 'empty',
      	product_category_id : 'empty'
    }
});



$('input[name=price], input[name=old_price]').on('input', function(){
	updateDiscountedPrice();
});


function updateDiscountedPrice()
{
	var price = $('input[name=price]').val().trim();
	var old_price = $('input[name=old_price]').val().trim();
	old_price = (old_price == 0) ? '' : old_price;
	if( price && old_price ){
		price = price.replace(/,/g , '');
		old_price = old_price.replace(/,/g , '');
		var text;
		var discount = 100 - ((price/old_price) * 100);
		discount = Math.round(discount * 100) / 100;
		discount = discount.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
	    if( (discount) > 0 ){
	    	text = '<span class="discount-negative">(-' + discount + '%)</span>';
	    } else if( (discount) < 0 ){
	    	text = '<span class="discount-positive">(+' + discount * -1 + '%)</span>';
	    } else {
	    	text = '(' + discount * -1 + '%)';
	    }
	    if( discount == 0 ) {
			$('#discount-percent').empty();
	    } else {
			$('#discount-percent').html(text);
	    }
	} else {
		$('#discount-percent').empty();
	}
}

// Add product images
$(document).on('click', '.add-product-image-button', function(){
    $(this).parent().find('input[type="file"]').click();
});

$(document).on('change', '.product-image-preview input[type="file"]', function(event){
    var $this = $(this);
    $this.parent().removeClass('new');
    $this.parent().attr('id', 'new');
    var input = $(event.currentTarget);
    var file = input[0].files[0];
    if( file.type.match("image/jpeg") || file.type.match("image/png") ){
        var photosize = $this[0].files[0].size/1000000;
        if( photosize > 5 ){
            alert("Error: Image file too big. Please select image file less than 5MB.");
        }
        else{
            var oFReader = new FileReader();
            oFReader.readAsDataURL(this.files[0]);
            oFReader.onload = function (oFREvent) {
                var new_image_browser = '<div class="product-image-preview new"><button type="button" class="circular ui icon button small primary add-product-image-button"><i class="icon plus"></i></button><button type="button" class="circular ui icon button small negative delete-product-image-button"><i class="icon remove"></i></button><input type="file" accept="image/*" name="product_images[]"></div>';
                $this.closest('.product-images-container').prepend(new_image_browser);
                $this.parent().addClass('image-deletable');
                $this.parent().find('.add-product-image-button').remove();
                $this.parent().css('background-image', 'url('+oFREvent.target.result+')');
            }
        }
    }
    
    else{
        alert("Error: Invalid image file!");
        $this.val('');
    }
});

$(document).on('click', '.delete-product-image-button', function(){
    $(this).parent().fadeOut(100, function(){
        $(this).remove();
    });
});
</script>
@stop