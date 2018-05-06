@extends('manager.store.store-manager.layout')
<?php $carousels = $store->carousels; ?>

@section('title')
<title>Appearance &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop

@if( count($carousels) > 0 )
@section('styles')
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
@stop
@endif


@section('content')
<div class="ui secondary menu">
  	<a class="item tab @if( Route::currentRouteName() == 'manager.store.appearance.themes' ) active @endif" @if( Route::currentRouteName() != 'manager.store.appearance.themes' ) href="{{ route('manager.store.appearance.themes', $store->id) }}" @endif>Themes</a>
	
  	<a class="item tab @if( Route::currentRouteName() == 'manager.store.appearance.logo' ) active @endif" @if( Route::currentRouteName() != 'manager.store.appearance.logo' ) href="{{ route('manager.store.appearance.logo', $store->id) }}" @endif>Logo</a>

  	<a class="item tab @if( Route::currentRouteName() == 'manager.store.appearance.carousel' ) active @endif" @if( Route::currentRouteName() != 'manager.store.appearance.carousel' ) href="{{ route('manager.store.appearance.carousel', $store->id) }}" @endif>Carousel</a>
</div>

<!-- Themes -->
@if( Route::currentRouteName() == 'manager.store.appearance.themes' )
<h3 class="no-margin-bottom no-margin-top">Themes</h3>
<div class="extra">Select your prefered theme for your store.</div>
<form method="POST" action="{{ route('manager.store.appearance.update.theme', $store->id) }}" class="has-loader">
	{{ csrf_field() }}
	<div class="ui doubling stackable cards margin-top half">
		<div class="ui blue card">
		    <div class="image">
		    	<img src="{{ $store->store_theme->theme->preview }}">
		    </div>
		    <div class="content">
					<div class="header">{{ $store->store_theme->theme->title }}</div>
					<div class="description">{{ $store->store_theme->theme->description }}</div>
		    </div>
		    <div class="content">
				Current theme
        		<input type="radio" name="theme_id" value="{{ $store->store_theme->id }}" class="hidden" checked> 
		    </div>
		</div>

		@foreach( $store->store_themes->where('id', '!=', $store->store_theme->id) as $store_theme )
		<div class="ui card">
		    <div class="image">
		    	<img src="{{ $store_theme->theme->preview }}">
		    </div>
		    <div class="content">
					<div class="header">{{ $store_theme->theme->title }}</div>
					<div class="description">{{ $store_theme->theme->description }}</div>
		    </div>
		    <div class="content">
        		<div class="field">
        			<div class="ui radio checkbox">
						<input type="radio" name="theme_id" value="{{ $store_theme->id }}" tabindex="0"> 
						<label>Select this theme</label>
					</div>
				</div>
		    </div>
		</div>
		@endforeach
	</div>

	<div class="bottom-submit">
		<button type="submit" class="ui primary small circular button has-loader-button">Save</button>
	</div>
</form>


<!-- Logo -->
@elseif( Route::currentRouteName() == 'manager.store.appearance.logo' )
<form method="POST" enctype="multipart/form-data" action="{{ route('manager.store.appearance.update.logo', $store->id) }}" class="has-loader">
	{{ csrf_field() }}
	<div class="ui two column grid stackable">
		<div class="row">
			<div class="column">
				<!-- Store logo -->
				<h3 class="no-margin-bottom">Store logo</h3>
				<div class="extra">Set your store logo that represents your brand and identity.</div>
				<div class="image-file store-logo-image">
					<div class="image-preview" style="background-image: url({{ Helpers::getImage($store->store_logo) }})">
						<div class="label"><span><div class="ui button mini white">Update</div></span></div>
					</div>
					<input type="file" accept="image/*" name="store_logo">
				</div>
			</div>

			<div class="column">
				<!-- Store icon -->
				<h3 class="no-margin-bottom">Store icon</h3>
				<div class="extra">Set your store icon to enhance your brand, usability, web presence, and SEO.</div>
				<div class="image-file store-icon-image">
					<div class="image-preview" style="background-image: url({{ Helpers::getImage($store->store_icon) }})">
						<div class="label"><span><div class="ui circular icon button mini white"><i class="icon plus"></i></div></span></div>
					</div>
					<input type="file" accept="image/*" name="store_icon">
				</div>
			</div>
		</div>
	</div>

	<div class="bottom-submit">
		<button type="submit" class="ui primary circular small button has-loader-button">Save</button>
	</div>
</form>


<!-- Carousel -->
@elseif( Route::currentRouteName() == 'manager.store.appearance.carousel' )
<button class="ui primary small circular button right floated" id="addItem">Add item</button>
<h3 class="no-margin-bottom no-margin-top">Carousel</h3>
<div class="extra margin-bottom half">
	Add carousel items to be displayed in the homepage slideshow. <br />
	<em>Recommended size: 1000 x 500px</em>
</div>

<div class="ui segment">
	@if( count($carousels) > 0 )
	<div class="ui grid stackable">
		<div class="sixteen wide mobile eight wide tablet eight wide computer column">
			<div class="ui items divided">
				@foreach( $carousels as $carousel )
				<div class="item">
				    <div class="ui tiny image">
				      	<img src="{{ $carousel->image }}">
				    </div>
				    <div class="content">
				    	<div class="description no-margin-top">
			        		<span class="carousel-url">{{ $carousel->url }}</span>
			        	</div>

						<span class="font-small font-light">
							<a href="javascript:void(0)" class="editItem underline" data-url="{{ $carousel->url }}" data-image="{{ $carousel->image }}" data-action="{{ route('manager.carousel.update', ['store_id' => $store->id, 'id' => $carousel->id]) }}">Edit</a>
							<span class="v-divider"></span>
							<a href="javascript:void(0)" class="deleteItem underline" data-action="{{ route('manager.carousel.destroy', ['store_id' => $store->id, 'id' => $carousel->id]) }}">Delete</a>
						</span>
				    </div>
			    </div>
				@endforeach
			</div>
		</div>
		<div class="sixteen wide mobile eight wide tablet eight wide computer column">
			<h4 class="margin-bottom half">Preview</h4>
			<div id="carouselPreview" class="carousel slide margin-bottom half" data-ride="carousel">
			  	<ol class="carousel-indicators">
			  		<?php $first = true; $i = 0; ?>
			  		@foreach( $carousels as $carousel )
				    <li data-target="#carouselPreview" data-slide-to="{{ $i }}" @if( $first ) class="active" @endif></li>
				    <?php $first = false; $i++; ?>
				    @endforeach
			  	</ol>

			  	<div class="carousel-inner">
			  		<?php $first = true; ?>
			  		@foreach( $carousels as $carousel )
				    <div class="item @if( $first ) active @endif">
				      	<img src="{{ $carousel->image }}">
				    </div>
				    <?php $first = false; ?>
				    @endforeach
			 	 </div>

			  	<!-- Left and right controls -->
			  	<a class="left carousel-control" href="#carouselPreview" data-slide="prev">
				    <i class="carousel-control-left fa fa-chevron-left"></i>
			  	</a>
			  	<a class="right carousel-control" href="#carouselPreview" data-slide="next">
				    <i class="carousel-control-right fa fa-chevron-right"></i>
			  	</a>
			</div>
			<small>Note: Carousel style may vary depending on the theme.</small>
		</div>
	</div>
	@endif
</div>
@endif


@if( Route::currentRouteName() == 'manager.store.appearance.carousel' )
<!-- Add New Item Modal -->
<div class="ui xsmall modal" id="addItemModal">
  	<div class="header">Add carousel item</div>
  	<div class="content">
	  	<form method="POST" action="{{ route('manager.carousel.store', ['store_id' => $store->id]) }}" enctype="multipart/form-data" class="ui form subscriberForm has-loader">
		    {{ csrf_field() }}
		    <div class="field">
		    	<label class="required">Image</label>
		    	<div class="image-file">
					<div class="image-preview"></div>
					<input type="file" accept="image/*" name="image">
				</div>
		    </div>
		    <div class="field">
		    	<label>URL</label>
		    	<input type="url" name="url" spellcheck="false">
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeAddItem">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Add</button>
		    </div>
	  	</form>
  	</div>
</div>

@if( count($carousels) > 0 )
<!-- Edit Item Modal -->
<div class="ui xsmall modal" id="editItemModal">
  	<div class="header">Edit carousel item</div>
  	<div class="content">
	  	<form method="POST" enctype="multipart/form-data" class="ui form subscriberForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('PUT') }}
		    <div class="field">
		    	<label class="required">Image</label>
		    	<div class="image-file">
					<div class="image-preview"></div>
					<input type="file" accept="image/*" name="image">
				</div>
		    </div>
		    <div class="field">
		    	<label>URL</label>
		    	<input type="url" name="url" spellcheck="false">
		    </div>
		    <div class="text-right">
			    <div class="ui default circular small button" id="closeEditItem">Cancel</div>
			    <button type="submit" class="ui primary circular small button has-loader-button">Save</button>
		    </div>
	  	</form>
  	</div>
</div>


<!-- Delete Item Modal -->
<div class="ui xsmall modal" id="deleteItemModal">
  	<div class="header">Delete item</div>
  	<div class="content">
	  	<form method="POST" class="ui form subscriberForm has-loader">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		    Are you sure to delete this carousel item?
		    <div class="text-right margin-top">
			    <div class="ui default circular small button" id="closeDeleteItem">Cancel</div>
			    <button type="submit" class="ui red circular small button has-loader-button">Delete</button>
		    </div>
	  	</form>
  	</div>
</div>
@endif

@endif

@stop

@section('scripts')
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script>
$(document).ready(function(){
	$('#addItemModal form')
	.form({
	fields: {
		image : 'empty',
		name : {
			identifier : 'url',
	        optional   : true,
	        rules: [
	          {
	            type   : 'url'
	          }
	        ]
		}
	}
	});


	$('#editItemModal form')
	.form({
	fields: {
		name : {
			identifier : 'url',
	        optional   : true,
	        rules: [
	          {
	            type   : 'url'
	          }
	        ]
		}
	}
	});

	$('#addItemModal').modal('attach events', '#addItem', 'show').modal('attach events', '#closeAddItem', 'hide');
	$('#editItemModal').modal('attach events', '.editItem', 'show').modal('attach events', '#closeEditItem', 'hide');
	$('#deleteItemModal').modal('attach events', '.deleteItem', 'show').modal('attach events', '#closeDeleteItem', 'hide').modal('setting', { autofocus: false });

	$('.editItem').click(function(){
		var form = $('#editItemModal form');
		var action = $(this).data('action');
		var url = $(this).data('url');
		var image = $(this).data('image');

		form.attr('action', action);
		form.find('input[name=url]').val(url);
		form.find('.image-preview').css('background-image', 'url(' + image + ')');
	});


	$('.deleteItem').click(function(){
		var form = $('#deleteItemModal form');
		var action = $(this).data('action');

		form.attr('action', action);
	});
	
	$('.carousel').carousel({
        interval: 4000
    }).on('slide.bs.carousel', function (e)
    {
    	var parent = $(this).find('.active.item').parent();
    	parent.height(parent.height());
    }).on('slid.bs.carousel', function (e)
    {
        var nextH = $(e.relatedTarget).height();
        $(this).find('.active.item').parent().animate({ height: nextH }, 500);
    });

});
</script>
@stop




