<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Controllers\Controller;
use App\Store;
use App\Order;
use App\ShippingMethod;
use App\PaymentMode;
use Auth;
use Validator;

class StoreOrderController extends Controller
{

	public function index($store_id, Request $request)
	{
		$store = Store::findOrFail($store_id);

        if( Auth::user()->can('manageStore', $store) ) :
            return view('manager.store.store-manager.order.index', compact('store'));
        else :
            return abort('403');
        endif;
	}





    public function show($store_id, $id, Request $request)
    {
        $store = Store::findOrFail($store_id);
        $order = Order::findOrFail($id);

        if( Auth::user()->can('manageOrder', $order) &&
            $order->store_id == $store->id
        ) :
            return view('manager.store.store-manager.order.show', compact('store', 'order'));
        else :
            return abort('403');
        endif;
    }





    public function update($store_id, $id, OrderCreateRequest $request)
    {
        $store = Store::findOrFail($store_id);
        $order = Order::findOrFail($id);

        if( Auth::user()->can('manageOrder', $order) &&
            $order->store_id == $store->id
        ) :
            $status_validator = Validator::make($request->all(), [
                'status' => 'in:pending,failed,processing,completed,cancelled',
            ]);

            if( $status_validator->fails() ) return redirect()->back()->withInput()->withErrors($status_validator);

            $shipping_address = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'street' => $request->street,
                'city' => $request->city,
                'province' => $request->province,
                'zip' => $request->zip,
                'phone' => $request->phone,
            ];
            $shipping_method = ShippingMethod::select('id', 'title')->where('id', $request->shipping_method)->where('store_id', $store->id)->firstOrFail();
            $shipping_method->rates = $shipping_method->rates;
            $payment_mode = PaymentMode::select('id', 'title', 'description')->where('id', $request->payment_mode)->where('store_id', $store->id)->firstOrFail();

            $order->status = $request->status;
            $order->shipping_address = json_encode($shipping_address);
            $order->shipping_method = json_encode($shipping_method);
            $order->payment_mode = json_encode($payment_mode);
            //if( $voucher ) $order->voucher = json_encode($voucher);
            $order->save();

            return redirect(route('manager.store-order.show', ['store_id' => $store->id, 'id' => $order->id]))
            ->with('_notifyMessage', 'Order successfully updated.');
        else :
            return abort('403');
        endif;
    }






    public function destroy($store_id, $id, Request $request)
    {
        $store = Store::findOrFail($store_id);
        $order = Order::findOrFail($id);

        if( Auth::user()->can('manageOrder', $order) &&
            $order->store_id == $store->id
        ) :
            $order->forceDelete();
            return redirect(route('manager.store-order.index', ['store_id' => $store->id]));
        else :
            return abort('403');
        endif;
    }


}