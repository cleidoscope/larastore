<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductReview;
use App\Store;
use Auth;
use Validator;



class ProductReviewController extends Controller
{


    public function index($store_id, Request $request)
    {
        $store = Store::findOrFail($store_id);

        $reviews = ProductReview::whereIn('product_id', $store->products->pluck('id')->toArray())->orderBy('created_at', 'desc')->paginate(25);

        if( Auth::user()->can('manageStore', $store) ) :
            return view('manager.store.store-manager.product-review.index', compact('store', 'reviews'));
        else :
            return abort('403');
        endif;
    }





	public function update($store_id, $id, Request $request)
	{
        $store = Store::findOrFail($store_id);
        $product_review = ProductReview::findOrFail($id);
        if( Auth::user()->can('manageStore', $store) && $product_review->product->store_id == $store->id ) :
            $product_review->is_approved = true;
            $product_review->save();
            return redirect()->back()->with('_notifyMessage', 'Product review successfully approved.');
        else :
            return abort('403');
        endif;
	}



    public function destroy($store_id, $id, Request $request)
    {
        $store = Store::findOrFail($store_id);
        $product_review = ProductReview::findOrFail($id);
        if( Auth::user()->can('manageStore', $store) && $product_review->product->store_id == $store->id ) :
            $product_review->forceDelete();
            return redirect()->back()->with('_notifyMessage', 'Product review successfully deleted.');
        else :
            return abort('403');
        endif;
    }




}