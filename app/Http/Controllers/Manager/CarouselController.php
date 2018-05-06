<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\Carousel;
use Auth;
use Validator;
use Illuminate\Support\Str;
use Image;
use File;
use App\Http\Helpers;

class CarouselController extends Controller
{





	public function store($store_id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;

        $store = Store::findOrFail($store_id);
        
        if( Auth::user()->can('manageStore', $store) && !$store->is_basic) :
            $carousel = new Carousel();
            $carousel->store_id = $store->id;
            $carousel->url = $request->url;

            if ( $request->hasFile('image') && $request->file('image')->isValid() ) :
                $destinationPath = 'storage/carousel-images/';
                $extension = $request->image->extension();
                $fileName = Str::random(10) . '-' . time() . '.' . $extension;

                $img = Image::make($request->image);
                if( $img->width() > 1000 ) :
                    $img->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                endif;

                $img->save($destinationPath.$fileName);

                $carousel->image = '/'.$destinationPath.$fileName;
            endif;

            $carousel->save();
            return redirect()->back()->with('_notifyMessage', 'Item successfully created.');
        else :
            return abort('403');
        endif;	
	}





	public function update($store_id, $id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( empty($request->url()) ) :
            return redirect()->back()->withErrors(['URL is required.']);
        endif;

		$store = Store::findOrFail($store_id);
		$carousel = Carousel::findOrFail($id);
        
        if( Auth::user()->can('manageCarousel', $carousel) && $carousel->store_id == $store->id ) :
            $carousel->url = $request->url;

            if ( $request->hasFile('image') && $request->file('image')->isValid() ) :
                $image = substr($carousel->image, 1);
                if( File::exists($image) ) :
                    File::delete($image);
                endif;

                $destinationPath = 'storage/carousel-images/';
                $extension = $request->image->extension();
                $fileName = Str::random(10) . '-' . time() . '.' . $extension;

                $img = Image::make($request->image);
                if( $img->width() > 1000 ) :
                    $img->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                endif;

                $img->save($destinationPath.$fileName, 70);

                $carousel->image = '/'.$destinationPath.$fileName;
            endif;

            $carousel->save();
            return redirect()->back()->with('_notifyMessage', 'Item successfully updated.');
        else :
            return abort('403');
        endif;	
	}




	public function destroy($store_id, $id, Request $request)
	{
		$store = Store::findOrFail($store_id);
		$carousel = Carousel::findOrFail($id);
        
        if( Auth::user()->can('manageCarousel', $carousel) && $carousel->store_id == $store->id ) :
            $image = substr($carousel->image, 1);
            if( File::exists($image) ) :
                File::delete($image);
            endif;
    		$carousel->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Item successfully deleted.');
        else :
            return abort('403');
        endif;  
	}




    public function validator($data)
    {
        return Validator::make($data, [
            'url'   =>  'sometimes|nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'image' =>  'required|file',
        ]);
    }

}