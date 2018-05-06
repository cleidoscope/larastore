<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\ProductCategory;
use Auth;
use Validator;

class ProductCategoryController extends Controller
{

	public function index($store_id, Request $request)
	{
		$store = Store::findOrFail($store_id);

        if( Auth::user()->can('manageStore', $store) ) :
            return view('manager.store.store-manager.category.index', compact('store'));
        else :
            return abort('403');
        endif;
	}





	public function store($store_id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;
        
        $store = Store::findOrFail($store_id);
        
        if( Auth::user()->can('manageStore', $store) ) :
    		ProductCategory::create([
    			'category' 	=> 	$request->category,
    			'slug' 	   	=> 	$this->slugify($request->category),
    			'store_id'	=>	$store->id,
    		]);
    		return redirect()->back()->with('_notifyMessage', 'Category successfully created.');
        else :
            return abort('403');
        endif;	
	}





	public function update($store_id, $id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;

		$store = Store::findOrFail($store_id);
		$productCategory = ProductCategory::findOrFail($id);
        
        if( Auth::user()->can('manageProductCategory', $productCategory) &&
            $productCategory->store_id == $store->id
        ) :
            $productCategory->category = $request->category;
            $productCategory->slug = $this->slugify($request->category, $id);
            $productCategory->save();
            return redirect()->back()->with('_notifyMessage', 'Category successfully updated.');
        else :
            return abort('403');
        endif;	
	}




	public function destroy($store_id, $id, Request $request)
	{
		$store = Store::findOrFail($store_id);
		$productCategory = ProductCategory::findOrFail($id);
        if( Auth::user()->can('manageProductCategory', $productCategory) &&
            $productCategory->store_id == $store->id
        ) :
    		$productCategory->products()->update([
    			'product_category_id' => NULL,
    		]);
    		$productCategory->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Category successfully deleted.');
        else :
            return abort('403');
        endif;  
	}



    public function validator($data)
    {
        return Validator::make($data, [
            'category' => 'required|string',
        ]);
    }




    public function slugify($category, $id = FALSE)
    {
        $string = str_replace(' ', '-', $category);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = preg_replace('/-+/', '-', $string);
        $string = $slug = strtolower($string);

        $i = $c = 0;

        while( $i == 0 ) :
            if( $id ) :
                $exists = ProductCategory::where('id', '<>', $id)->where('slug', $slug)->first();
            else :
                $exists = ProductCategory::where('slug', $slug)->first();
            endif;

            if(! $exists ) break;
            $c++;
            $slug = $string . '-' . $c;
        endwhile;

        return $slug;
    }


}