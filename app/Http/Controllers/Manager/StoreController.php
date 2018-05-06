<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\GoogleAnalytics\Analytics;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreateRequest;
use App\Store;
use App\StoreCategory;
use App\Order;
use App\Plan;
use App\Invoice;
use App\Theme;
use App\StoreTheme;
use Auth;
use Carbon\Carbon;
use Validator;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Helpers;
use App\Http\FacebookPixel;
use File;
use Image;

class StoreController extends Controller
{
   
    protected $view_ID = '157549031'; // Cloudstore subdomains: 157549031 Wholeyearsummer: 137018861



    public function index()
    {
        return view('manager.store.index');
    }




    public function create()
    {
    	$plans = Plan::orderBy('price', 'asc')->get();
        return view('manager.store.create', compact('plans'));
    }




    public function store(StoreCreateRequest $request)
    {
        $subdomain = strtolower($request->subdomain);
        
    	$store = Store::where('subdomain', $subdomain)->first();
    	$storeCategory = StoreCategory::findOrFail($request->store_category_id);
    	if( $store ) :
    		return redirect()->back()->withErrors(['subdomain_exists' => 'The subdomain <strong>' . $subdomain .'</strong> is already taken.'])->withInput();
    	endif;
        
        // Validate Subdomain
        if(! $this->is_valid_domain_name($subdomain) ) :
            return redirect()->back()->withErrors(['subdomain_exists' => 'The subdomain <strong>' . $subdomain .'</strong> has an invalid format.'])->withInput();
        endif;

        // Create Store
        $store = new Store;
        $store->name  =  $request->name;
        $store->user_id = Auth::user()->id;
        $store->subdomain = $subdomain;
        $store->plan_id = 2;
        $store->store_category_id = $storeCategory->id;
        $store->save();

        $storeTheme = new StoreTheme;
        $storeTheme->store_id = $store->id;
        $storeTheme->theme_id = 1;
        $storeTheme->save();

        $store->theme_id = $storeTheme->id;
        $store->save();


        // Add all FREE themes, except for theme_id 1 (already added and set as default)
        $freeThemes = Theme::where('is_free', TRUE)->where('id', '<>', 1)->get();
        foreach( $freeThemes as $freeTheme ) :
            StoreTheme::create([
                'store_id' => $store->id,
                'theme_id' => $freeTheme->id
            ]);
        endforeach;
        

        return redirect(route('manager.store.show', $store->id));
    }




     public function show($id)
    {
        $store = Store::findOrFail($id);

        if( Auth::user()->can('manageStore', $store) ) :
            $now = Carbon::parse(date('M d Y'));
            $salesAnalyticsLabels = [
                "Today",
                $now->subDays(1)->format('M d'),
                $now->subDays(1)->format('M d'),
                $now->subDays(1)->format('M d'),
                $now->subDays(1)->format('M d'),
                $now->subDays(1)->format('M d'),
                $now->subDays(1)->format('M d'),
            ];


            $now = Carbon::parse(date('M d Y h:i:s'));
            $dates = [
                $now->format('Y-m-d'),
                $now->subDays(1)->format('Y-m-d'),
                $now->subDays(1)->format('Y-m-d'),
                $now->subDays(1)->format('Y-m-d'),
                $now->subDays(1)->format('Y-m-d'),
                $now->subDays(1)->format('Y-m-d'),
                $now->subDays(1)->format('Y-m-d'),
            ];
            $salesAnalytics = [];

            foreach( $dates as $date ) :
                $orders = Order::where('store_id', $store->id)->where('status', 'completed')->whereDate('created_at', $date)->get();
                $salesAnalytics[] = $orders->sum('total');
            endforeach;



            $salesAnalyticsLabels = json_encode(array_reverse($salesAnalyticsLabels));
            $salesAnalytics = json_encode(array_reverse($salesAnalytics));
            return view('manager.store.store-manager.dashboard', compact('store', 'salesAnalyticsLabels', 'salesAnalytics'));
        endif;
        
        return abort('403');
    }




    public function appearance($store_id, Request $request)
    {
        $store = Store::findOrFail($store_id);

        if( Auth::user()->can('manageStore', $store) ) :
            return view('manager.store.store-manager.appearance.show', compact('store'));
        else :
            return abort('403');
        endif;
    }




    public function settings($id, Request $request)
    {
        $store = Store::findOrFail($id);

        if( Auth::user()->can('manageStore', $store) ) :
            return view('manager.store.store-manager.settings.show', compact('store'));
        endif;
    }



    public function upgrade($id)
    {
        $store = Store::findOrFail($id);

        if( Auth::user()->can('manageStore', $store) ) :
            return view('manager.store.store-manager.upgrade', compact('store'));
        endif;
    }




    // Social Media validators
    public function validateFacebookPage($username)
    {
        return Helpers::curl('https://graph.facebook.com/'.$username.'?access_token=1208410692601134|Q-Ecl4J5fcGMu0aTmLixPCZMFqA&fields=fan_count');
    }




    public function validateTwitter($username)
    {
        $connection = new TwitterOAuth('3elzatZWNwMFKGocyAsCDH95b', 'JLjPDAR5xHGNTCbhmv8SZ3dmH8zbNKFtgNuQj4atT5kUtHYzNT', '885076213575897089-x3sykr23bgOf5JA3yZls7VjCoGpeD9p', 'RWs3RE26gvt5p6x16SjAdmBwNSBhL8XPCeuTel1TKifqO');
        $connection->get('users/show/followers_count', ["screen_name" => "$username"]);
        return $connection;
    }


    public function validateInstagram($username)
    {
        return Helpers::curl('https://www.instagram.com/'.$username.'/?__a=1');
    }






    public function updateGeneral($id, Request $request)
    {
        $store = Store::findOrFail($id);
        if( Auth::user()->can('manageStore', $store) ) :
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:30',
                'store_category_id' => 'required',
            ]);
            if( $validator->fails() ) :
                return redirect()->back()->withErrors($validator);
            endif;

            $errors = [];

            // Validate Twitter
            if ( $request->facebook ) :
                $facebook = $this->validateFacebookPage($request->facebook);
                $facebook = json_decode($facebook);
                if ( isset($facebook->error) ) :
                    $errors[] = 'Invalid Facebook page username <strong>'.$request->facebook.'</strong>.';
                endif;
            endif;



            // Validate Twitter
            if ( $request->twitter ) :
                $connection = $this->validateTwitter($request->twitter);
                if ($connection->getLastHttpCode() != 200) :
                    $errors[] = 'Invalid Twitter username <strong>'.$request->twitter.'</strong>.';
                endif;
            endif;



            // Validate Instagram
            if ( $request->instagram ) :
                $instagram = $this->validateInstagram($request->instagram);
                if (!Helpers::isJson($instagram)) :
                    $errors[] = 'Invalid Instagram username <strong>'.$request->instagram.'</strong>.';
                endif;
            endif;

            if( count($errors) > 0 ) :
                return redirect()->back()->withErrors($errors);
            endif;

            $store->name = $request->name;
            $store->tagline = $request->tagline;
            $store->facebook = $request->facebook;
            $store->twitter = $request->twitter;
            $store->instagram = $request->instagram;

            $store->street      =   $request->street;
            $store->city        =   $request->city;
            $store->province    =   $request->province;
            $store->zip_code    =   $request->zip_code;

            if( Helpers::validPHNumber($request->phone) ) :
                $store->phone       =   $request->phone;
            endif;

            $store->save();
            return redirect()->back()->with('_notifyMessage', 'Store settings successfully updated.');
        else :
            return abort('403');
        endif;
    }






    public function updateAnalytics($id, Request $request)
    {
        $store = Store::findOrFail($id);
        if( Auth::user()->can('manageStore', $store) ) :
            $this->view_ID = $request->ga_view_id;
            if( empty($request->ga_view_id) ) :
                $store->ga_tracking_id = NULL;
            endif;
            $store->save();
            return redirect()->back()->with('_notifyMessage', 'Store successfully updated.');
        else :
            return abort('403');
        endif;
    }




    public function updateTheme($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme_id' => 'required',
        ]);
        if( $validator->fails() ) :
            return redirect()->back()->withErrors($validator);
        endif;


        $store = Store::findOrFail($id);
        $storeTheme = StoreTheme::where('id', $request->theme_id)->where('store_id', $store->id)->firstOrFail();


        if( Auth::user()->can('manageStore', $store) ) :
            $store->theme_id = $storeTheme->id;
            $store->save();
            return redirect()->back()->with('_notifyMessage', 'Theme successfully updated.');
        else :
            return abort('403');
        endif;
    }





    public function updateLogo($id, Request $request)
    {
        $store = Store::findOrFail($id);

        if( Auth::user()->can('manageStore', $store) ) :

            if ( $request->hasFile('store_logo') && $request->file('store_logo')->isValid() ) :
                $destinationPath = 'storage/store-logos/';
                $time = time();

                $image = substr($store->store_logo, 1);
                if( File::exists($image) ) File::delete($image);

                $old_name = pathinfo($image, PATHINFO_FILENAME);
                $old_extension = pathinfo($image, PATHINFO_EXTENSION);
                $old_image_sizes = [$old_name.'-35.'.$old_extension, $old_name.'-50.'.$old_extension];
                foreach( $old_image_sizes as $old_image_size ) :
                     if( File::exists($destinationPath.$old_image_size) ) File::delete($destinationPath.$old_image_size);
                endforeach;

                $extension = $request->store_logo->extension();
                $fileName = $time. '.' . $extension;
                $img = Image::make($request->store_logo);
                if( $img->width() > 150 ) :
                    $img->resize(150, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                endif;
                $img->save($destinationPath.$fileName);

                $new_image_sizes = [$time.'-35.'.$extension => 35, $time.'-50.'.$extension => 50];
                foreach( $new_image_sizes as $key => $value ) :
                    Image::make($request->store_logo)->resize($value, null, function($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($destinationPath.$key);
                endforeach;

                $store->store_logo = '/'.$destinationPath.$fileName;
            endif;

            
            if ( $request->hasFile('store_icon') && $request->file('store_icon')->isValid() ) :
                $image = substr($store->store_icon, 1);
                if( File::exists($image) ) :
                    File::delete($image);
                endif;

                $destinationPath = 'storage/store-icons/';
                $extension = $request->store_icon->extension();
                $fileName = time() . '.' . $extension;

                $img = Image::make($request->store_icon);
                if( $img->width() > 180 ) :
                    $img->resize(180, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                endif;

                $img->save($destinationPath.$fileName);
                $store->store_icon = '/'.$destinationPath.$fileName;
            endif;

            $store->save();
            return redirect()->back()->with('_notifyMessage', 'Logo successfully saved.');
        else :
            return abort('403');
        endif;
    }




    public function is_valid_domain_name($subdomain)
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $subdomain) //valid chars check
                && preg_match("/^.{1,253}$/", $subdomain) //overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $subdomain)   ); //length of each label
    }




    // AJAX functions
    public function facebookPixelFires($store_id, Request $request)
    {
        if( $request->ajax() ) :
            $store = Store::findOrFail($store_id);
            if( Auth::user()->can('manageStore', $store) && !$store->is_basic ) :
                $now = Carbon::parse(date('Y-m-d'));
                $store_domain = parse_url($store->url, PHP_URL_HOST);
                $facebookPixel = new FacebookPixel($store_domain);
                $pixel_fires = $facebookPixel->PixelFires($now->subDays(14)->format('Y-m-d'), $now->AddDays(15)->format('Y-m-d'));
                return json_encode([
                    'success' => true,
                    'pixel_fires' => $pixel_fires
                ]);
            endif;
        else :
            return response('Unauthorized.', 401);
        endif;
    }



    public function googleAnalyticsReport($store_id, Request $request)
    {
        if( $request->ajax() ) :
            $store = Store::findOrFail($store_id);
            if( Auth::user()->can('manageStore', $store) && !$store->is_basic ) :
                $store_domain = parse_url($store->url, PHP_URL_HOST);
                $analytics = Analytics::initializeAnalytics();

                try{
                    $response = Analytics::getReport($analytics, $this->view_ID, ["30daysAgo", "today"], $store_domain);
                    $results = Analytics::getResults($response);
                }
                catch(\Exception $e)
                {
                    //echo $e->getMessage();
                    return json_encode([
                        'error' => true,
                        'message' => 'There was a problem connecting to Google Analytics.'
                    ]);
                }
                return json_encode([
                    'success' => true,
                    'dataReport' => json_encode($results),
                ]);
            else :
                return abort('403');
            endif;     
        else :
            return response('Unauthorized.', 401);
        endif;
    }




    public function getSocialMediaReport($store_id, Request $request)
    {
        if( $request->ajax() ) :
            $store = Store::findOrFail($store_id);
            if( Auth::user()->can('manageStore', $store) ) :
                $response = [];

                // Facebook 
                if ( $store->facebook ) :
                    $facebook = $this->validateFacebookPage($store->facebook);
                    $facebook = json_decode($facebook);
                    if ( isset($facebook->error) ) :
                        $response['facebook'] = '<i class="font-small fa fa-warning text-red"></i>';
                    else :
                        $response['facebook'] = '<div class="font-size-medium font-medium">' . number_format($facebook->fan_count) . '</div>';
                    endif;
                else :
                    $response['facebook'] = '<em class="font-small extra">Not set</em>';
                endif;



                // Twitter
                if ( $store->twitter ) :
                    $connection = $this->validateTwitter($store->twitter);
                    if ($connection->getLastHttpCode() == 200) :
                        $lastBody = $connection->getLastBody();
                        $response['twitter'] = '<div class="font-size-medium font-medium">'.$lastBody->followers_count.'</div>';
                    else :
                        $response['twitter'] = '<i class="font-small fa fa-warning text-red"></i>';
                    endif;
                else :
                    $response['twitter'] = '<em class="font-small extra">Not set</em>';
                endif;


                // Instagram
                if ( $store->instagram ) :
                    $instagram = $this->validateInstagram($store->instagram);
                    if (Helpers::isJson($instagram)) :
                        $instagram = json_decode($instagram);
                        $response['instagram'] = '<div class="font-size-medium font-medium">' . number_format($instagram->user->followed_by->count) . '</div>';
                    else :
                        $response['instagram'] = '<i class="font-small fa fa-warning text-red"></i>';
                    endif;
                else :
                    $response['instagram'] = '<em class="font-small extra">Not set</em>';
                endif;


                return json_encode($response);

            else :
                return abort('403');
            endif;
            
        else :
            return response('Unauthorized.', 401);
        endif;
    }


}
