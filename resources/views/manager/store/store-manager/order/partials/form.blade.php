<!-- Edit Order Modal -->
<div class="ui modal small" id="editOrderModal">
  <div class="header">
      Edit <em>Order #{{ $order->id }}</em>
  </div>
  <div class="content">
    <form class="ui form has-loader" method="POST" action="{{ route('manager.store-order.update', ['store_id' => $store->id, 'id' => $order->id]) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <h3 class="no-margin-top no-margin-bottom">Status</h3>
        <div class="field inline">
          <select name="status" class="ui dropdown">
            <option value="pending" @if( $order->status == 'pending' ) selected @endif>Pending</option>
            <option value="processing" @if( $order->status == 'processing' ) selected @endif>Processing</option>
            <option value="completed" @if( $order->status == 'completed' ) selected @endif>Completed</option>
            <option value="cancelled" @if( $order->status == 'cancelled' ) selected @endif>Cancelled</option>
            <option value="failed" @if( $order->status == 'failed' ) selected @endif>Failed</option>
          </select>
        </div>

        <h3 class="no-margin-top">Shipping Address</h3>
        <div class="two fields">
          <div class="field">
            <label class="required">First Name</label>
            <input type="text" name="first_name" placeholder="First Name" value="{{ $order->shipping_address->first_name }}">
          </div>
          <div class="field">
            <label class="required">Last Name</label>
            <input type="text" name="last_name" placeholder="Last Name" value="{{ $order->shipping_address->last_name }}">
          </div>
        </div>
        <div class="field">
          <label class="required">Street</label>
          <input type="text" name="street" placeholder="Street" value="{{ $order->shipping_address->street }}">
        </div>
        <div class="two fields">
          <div class="field">
            <label class="required">City</label>
            <input type="text" name="city" placeholder="City" value="{{ $order->shipping_address->city }}">
          </div>
          <div class="field">
            <label class="required">Province</label>
            <input type="text" name="province" placeholder="Province" value="{{ $order->shipping_address->province }}">
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label class="required">ZIP</label>
            <input type="text" name="zip" placeholder="ZIP" value="{{ $order->shipping_address->zip }}">
          </div>
          <div class="field">
            <label class="required">Mobile Number</label>
            <input type="text" name="phone" placeholder="Mobile Number" value="{{ $order->shipping_address->phone }}">
          </div>
        </div>

        <hr />
        
        <div class="ui two column grid margin-bottom">
          <div class="row">
            <div class="column">
              <h3 class="no-margin-tsop">Shipping Method</h3>
              @foreach( $store->shipping_methods as $shipping_method )
              <div class="field margin-top">
                <div class="ui radio checkbox">
                  <input type="radio" name="shipping_method" value="{{ $shipping_method->id }}" @if( $shipping_method->id == $order->shipping_method->id ) checked @endif tabindex="0" class="hidden">
                  <label>
                    <strong>{{ $shipping_method->title }}</strong>
                  </label>
                </div>
              </div>
              @endforeach
            </div>
            <div class="column">
              <h3 class="no-margin-tsop">Payment Mode</h3>
              @foreach( $store->payment_modes as $payment_mode )
              <div class="field margin-top">
                <div class="ui radio checkbox">
                  <input type="radio" name="payment_mode" value="{{ $payment_mode->id }}" @if( $payment_mode->id == $order->payment_mode->id ) checked @endif tabindex="0" class="hidden">
                  <label>
                    <strong>{{ $payment_mode->title }}</strong>
                  </label>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="text-right margin-top">
          <div class="ui default circular small button" id="closeEditOrderModal">Cancel</div>
          <button type="submit" class="ui primary circular small button has-loader-button">Save</button>
        </div>
    </form>
  </div>
</div>



<!-- Delete Order Modal -->
<div class="ui modal small" id="deleteOrderModal">
  <div class="header text-center">
      <h4 class="font-big no-margin-bottom text-red"><i class="fa fa-warning"></i></h4>
      Delete <em>Order #{{ $order->id }}</em>
  </div>
  <div class="content">
      <form method="POST" action="{{ route('manager.store-order.destroy', ['store_id' => $store->id, 'id' => $order->id]) }}" class="has-loader">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        Are you sure to delete this order? This cannot be undone.
        <div class="text-right margin-top">
          <div class="ui default circular small button" id="closeDeleteOrderModal">Cancel</div>
          <button type="submit" class="ui red circular small button has-loader-button">Delete</button>
        </div>
      </form>
  </div>
</div>



<!-- Add Order Item Modal -->
<div class="ui modal xsmall" id="addOrderItemModal">
  <div class="header">
      Add Order Item
  </div>
  <div class="content">
      <form method="POST" action="{{ route('manager.order-item.store', ['store_id' => $store->id, 'order_id' => $order->id]) }}" class="ui form has-loader">
        {{ csrf_field() }}
        <?php $order_item_ids = $order->order_items->pluck('product_id')->toArray(); ?>
        <div class="field">
          <label>Search for product</label>
          <select class="ui search dropdown" name="product_id">
            <option value="">Search for product</option>
            @foreach( $store->products->whereNotIn('id', $order_item_ids) as $product )
            <option value="{{ $product->id }}">{{ $product->title }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Quantity</label>
          <input type="number" min="1" name="quantity" placeholder="Quantity">
        </div>
        <div class="text-right margin-top">
          <div class="ui default circular small button" id="closeAddOrderItemModal">Cancel</div>
          <button type="submit" class="ui primary circular small button has-loader-button">Add Item</button>
        </div>
      </form>
  </div>
</div>



<!-- Remove Order Item Modal -->
<div class="ui modal xsmall" id="removeOrderItemModal">
  <div class="header">
      Remove order item
  </div>
  <div class="content">
      <form method="POST" action="" class="has-loader">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        Are you sure to remove the item <strong></strong>?
        <div class="text-right margin-top">
          <div class="ui default circular small button" id="closeRemoveOrderItemModal">Cancel</div>
          <button type="submit" class="ui red circular small button has-loader-button">Remove</button>
        </div>
      </form>
  </div>
</div>




@section('scripts')
<script>
$('#editOrderModal')
.modal('attach events', '#editOrder', 'show')
.modal('attach events', '#closeEditOrderModal', 'hide')
.modal('setting', {
  autofocus: false,
});


$('#deleteOrderModal')
.modal('attach events', '#deleteOrder', 'show')
.modal('attach events', '#closeDeleteOrderModal', 'hide').modal('setting', {
  autofocus: false,
});


$('#editOrderModal form')
.form({
fields: {
    status          : 'empty',
    first_name      : 'empty',
    last_name       : 'empty',
    street          : 'empty',
    city            : 'empty',
    province        : 'empty',
    phone           : ['empty', 'number'],
    zip             : ['empty', 'number'],
    shipping_method : ['checked', 'number'],
    payment_mode    : ['checked', 'number'],
}
});


$('#addOrderItemModal')
.modal('attach events', '#addItem', 'show')
.modal('attach events', '#closeAddOrderItemModal', 'hide')
.modal('setting', {
  autofocus: false,
});


$('#addOrderItemModal form')
.form({
fields: {
    product_id    : 'empty',
    quantity      : ['empty', 'integer[1..1000]'],
}
});


$('#removeOrderItemModal')
.modal('attach events', '.removeItem', 'show')
.modal('attach events', '#closeRemoveOrderItemModal', 'hide')
.modal('setting', { autofocus: false });

$('.removeItem').click(function(){
  var form = $('#removeOrderItemModal');
  var name = $(this).data('name');
  var action = $(this).data('action');

  form.find('form strong').text(name);
  form.find('form').attr('action', action);
});
</script>
@stop