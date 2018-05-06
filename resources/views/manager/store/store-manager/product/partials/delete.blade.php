<div class="ui xsmall modal" id="deleteProductModal">
  <div class="header">
    Delete <em>{{$product['title']}}</em>
  </div>
  <div class="content">
    <div class="description">
      Are you sure you want to delete this product?
    </div>
  </div>
  <form class="actions has-loader" method="POST" action="{{ route('manager.product.destroy', ['store_id' => $store->id, 'product_id' => $product['id']]) }}">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <div class="ui default circular small button" id="closeDeleteCategory">Cancel</div>
    <button type="submit" class="ui red circular small button has-loader-button">Delete Product</button>
  </form>
</div>