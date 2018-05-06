<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Store;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use Auth;
use File;
use Validator;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{


    public function index($store_id, Request $request)
    {
        $store = Store::findOrFail($store_id);
        if( isset( $request->search ) && !empty( $request->search ) ) :
            $products = $store->products()->where('title', 'LIKE', '%'.$request->search.'%')->paginate(25);
        else :
            $products = $store->products()->paginate(25);
        endif;

        if( Auth::user()->can('manageStore', $store) ) :
            return view('manager.store.store-manager.product.index', compact('store', 'products'));
        else :
            return abort('403');
        endif;
    }







    public function create($store_id)
    {
        $store = Store::findOrFail($store_id);
        $product = [
            'title'                 =>  old('title'),
            'description'           =>  old('description'),
            'price'                 =>  old('price'),
            'old_price'             =>  old('old_price'),
            'weight'                =>  old('weight') ? old('weight') : '0.00',
            'in_stock'              =>  old('in_stock'),
            'product_category_id'   =>  old('product_category_id'),
            'product_images'        =>  [],
            'is_featured'           =>  old('is_featured'),
        ];
        
        if( Auth::user()->can('manageStore', $store) && ( $store->is_pro || $store->products->count() < $store->plan->max_products ) ) :
            return view('manager.store.store-manager.product.create', compact('store', 'product'));
        else :
            return abort('403');
        endif;
    }







    public function store($store_id, ProductCreateRequest $request)
    {
        if( $request->old_price ) :
            $validator = $this->price_validator($request->all());
            if( $validator->fails() ) :
                return redirect()->back()->withInput()->withErrors($validator);
            endif;
        endif;

        $store = Store::findOrFail($store_id);
        
        if( Auth::user()->can('manageStore', $store) && ($store->is_pro || $store->products->count() < $store->plan->max_products) ) :
            if( $request->product_category_id == 'uncategorized' ) :
                $productCategoryID = NULL;
            else :
                $productCategory = ProductCategory::findOrFail($request->product_category_id);
                if( $productCategory->store_id != $store->id ) :
                    return redirect()->back();
                endif;
                $productCategoryID = $productCategory->id;
            endif;

            $in_stock = $request->in_stock ? TRUE : FALSE;
            $is_featured = $request->is_featured ? 1 : 0;

            $price = preg_replace('/[^0-9.]+/', '', $request->price);
            $price = $price ? (float)$price : 0.00;

            $old_price = preg_replace('/[^0-9.]+/', '', $request->old_price);
            $old_price = $old_price ? (float)$old_price : 0.00;
            
            $weight = preg_replace('/[^0-9.]+/', '', $request->weight);
            $weight = $weight ? (float)$weight : 0.00;
            
            $product = new Product;
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $price;
            $product->old_price = $old_price;
            $product->weight = $weight;
            $product->store_id = $store->id;
            $product->in_stock = $in_stock;
            $product->product_category_id = $productCategoryID;
            $product->is_featured = $is_featured;
            $product->slug = $this->slugify($store, $request->title);
            $product->save();

            if ( $request->hasFile('product_images') ) :
                $destinationPath = 'storage/product-images/';
                foreach( $request->product_images as $product_image ) :
                    if( $product_image->isValid() ) :
                        $extension = $product_image->extension();
                        $img = Image::make($product_image);

                        if( $img->width() > 600 ) :
                            $img->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        endif;
                        
                        $fileName = Str::random(10) . '-' . time() . '.' . $extension;

                        $img->save($destinationPath.$fileName, 30);

                        $new_product_image = new ProductImage();
                        $new_product_image->product_id = $product->id;
                        $new_product_image->image = '/'.$destinationPath.$fileName;
                        $new_product_image->save();

                    endif;
                endforeach;
            endif;



            return redirect(route('manager.product.edit', ['store_id' => $store_id, 'id' => $product->id]))
            ->with('_notifyMessage', 'Product successfully created.');
        else :
            return abort('403');
        endif;
    }







    public function edit($store_id, $product_id)
    {
        $store = Store::findOrFail($store_id);
        $product = Product::findOrFail($product_id);
        
        if( Auth::user()->can('manageProduct', $product) &&
            $product->store_id == $store->id
        ) :
            return view('manager.store.store-manager.product.edit', compact('store', 'product'));
        else :
            return abort('403');
        endif;
    }







    public function update($store_id, $product_id, ProductCreateRequest $request)
    {

        if( $request->old_price ) :
            $validator = $this->price_validator($request->all());
            if( $validator->fails() ) :
                return redirect()->back()->withInput()->withErrors($validator);
            endif;
        endif;

        $store = Store::findOrFail($store_id);
        $product = Product::findOrFail($product_id);

        if( $request->product_category_id == 'uncategorized' ) :
            $productCategoryID = NULL;
        else :
            $productCategory = ProductCategory::findOrFail($request->product_category_id);
            if( $productCategory->store_id != $store->id ) :
                return redirect()->back();
            endif;
            $productCategoryID = $productCategory->id;
        endif;
        
        if( Auth::user()->can('manageProduct', $product) &&
            $product->store_id == $store->id
        ) :
            $new_product_images = [];
            if ( $request->hasFile('product_images') ) :
                $destinationPath = 'storage/product-images/';
                foreach( $request->product_images as $product_image ) :
                    if( $product_image->isValid() ) :
                        $extension = $product_image->extension();
                        $img = Image::make($product_image);

                        if( $img->width() > 600 ) :
                            $img->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        endif;
                        $fileName = Str::random(10) . '-' . time() . '.' . $extension;

                        $img->save($destinationPath.$fileName, 75);

                        $new_product_image = new ProductImage();
                        $new_product_image->product_id = $product->id;
                        $new_product_image->image = '/'.$destinationPath.$fileName;
                        $new_product_image->save();

                        $new_product_images[] = $new_product_image->id;
                    endif;
                endforeach;
            endif;

            // Order product images
            $image_order = $request->image_order ? explode(',', $request->image_order) : [];
            $image_order = array_filter($image_order);
            if( count($image_order) > 0 ) :
                $o = 1; $i = 0;
                foreach( $image_order as $image_id ) :
                    if( $image_id != "new" ) :
                        $product_image = ProductImage::find($image_id);
                        if( $product_image ) :
                            $product_image->order = $o;
                            $product_image->save();
                            $o++;
                        endif;
                    else :
                        $product_image = ProductImage::find($new_product_images[$i]);
                        if( $product_image ) :
                            $product_image->order = $o;
                            $product_image->save();
                            $o++;
                            $i++;
                        endif;
                    endif;
                endforeach;
            endif;

            if( $request->images_to_delete ) :
                foreach( $request->images_to_delete as $image_to_delete ) :
                    $product_image_to_delete = ProductImage::where('id', $image_to_delete)->first();
                    if( $product_image_to_delete ) :
                        $image = substr($product_image_to_delete->image, 1);
                        if( File::exists($image) ) :
                            File::delete($image);
                        endif;
                        $product_image_to_delete->forceDelete();
                    endif;
                endforeach;
            endif;

            $in_stock = $request->in_stock ? TRUE : FALSE;
            $is_featured = $request->is_featured ? TRUE : FALSE;

            $price = preg_replace('/[^0-9.]+/', '', $request->price);
            $price = $price ? (float)$price : 0.00;

            $old_price = preg_replace('/[^0-9.]+/', '', $request->old_price);
            $old_price = $old_price ? (float)$old_price : 0.00;

            $weight = preg_replace('/[^0-9.]+/', '', $request->weight);
            $weight = $weight ? (float)$weight : 0.00;

            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $price;
            $product->old_price = $old_price;
            $product->weight = $weight;
            $product->in_stock = $in_stock;
            $product->is_featured = $is_featured;
            $product->product_category_id = $productCategoryID;
            $product->slug = $this->slugify($store, $request->title, $product_id);
            $product->save();

            return redirect(route('manager.product.edit', ['store_id' => $store_id, 'product_id' => $product->id]))->with('_notifyMessage', 'Product successfully updated.');
        else :
            return abort('403');
        endif;
    }





    public function destroy($store_id, $product_id, Request $request)
    {
        $store = Store::findOrFail($store_id);
        $product = Product::findOrFail($product_id);
        
        if( Auth::user()->can('manageProduct', $product) &&
            $product->store_id == $store->id
        ) :
            foreach( $product->product_images as $product_image ) :
                $image = substr($product_image->image, 1);
                if( File::exists($image) ) :
                    File::delete($image);
                endif;
            endforeach;
            $product->forceDelete();
            return redirect(route('manager.product.index', $store_id));
        else :
            return abort('403');
        endif;
    }





    public function slugify($store, $product, $id = FALSE)
    {
        $string = str_replace(' ', '-', $product);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = preg_replace('/-+/', '-', $string);
        $string = $slug = strtolower($string);

        $i = $c = 0;

        while( $i == 0 ) :
            if( $id ) :
                $exists = Product::where('store_id', $store->id)->where('id', '<>', $id)->where('slug', $slug)->first();
            else :
                $exists = Product::where('store_id', $store->id)->where('slug', $slug)->first();
            endif;

            if(! $exists ) break;
            $c++;
            $slug = $string . '-' . $c;
        endwhile;

        return $slug;
    }





    public function price_validator($data)
    {
        return Validator::make($data, [
            'old_price' => 'required',
        ]);
    }


}
