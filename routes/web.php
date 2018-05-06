<?php

$manager = 'www.cloudstore.loc';
$admin = 'admin.cloudstore.loc';

/*
$manager = 'www.cloudstore.ph';
$admin = 'admin.cloudstore.ph';*/








/* 
* Manager Routes
*
*
*/
Route::group([
    'domain'  => $manager,
], function () {

	Route::group([
	    'namespace' => 'Manager',
	], function () {
		Route::get('/', 'PageController@homepage')->name('manager.homepage');
        Route::get('/pricing', 'PageController@pricing')->name('manager.pricing');
        Route::get('/support', 'PageController@support')->name('manager.support');
        Route::get('/contact', 'PageController@contact')->name('manager.contact');
        Route::get('/subscribed', 'PageController@subscribed')->name('manager.subscribed');
        Route::get('/privacy-policy', 'PageController@privacy_policy')->name('manager.privacy_policy');
        Route::get('/about', 'PageController@about')->name('manager.about');

        Route::post('/paypal_ipn', 'PageController@paypal_ipn')->name('manager.paypal_ipn'); // PayPal IPN listener
        Route::post('/subscribe', 'SubscriberController@store')->name('manager.subscribe'); // Subscribe

	

		Route::group([
		    'middleware' => 'manager',
            'prefix'     => 'my-account'
		], function () {

             Route::get('/', 'UserController@show')->name('manager.user.show');
             Route::post('update/personal', 'UserController@updatePersonal')->name('manager.user.update.personal');
             Route::post('update/security', 'UserController@updateSecurity')->name('manager.user.update.security');
             Route::post('update/contact', 'UserController@updateContact')->name('manager.user.update.contact');
             Route::post('update/email_notifications', 'UserController@updateEmailNotifications')->name('manager.user.update.email_notifications');

			// Store Route
        	Route::resource('store', 'StoreController', [
            'except' => ['show', 'edit', 'update', 'destroy'],
            'names' => [
            	'index' => 'manager.store.index',
                'create' => 'manager.store.create',
                'store' => 'manager.store.store',
            ]
	        ]);


            // Store Manager group route
            Route::group([
                'middleware' => 'validateStore',
                'prefix' => 'store/{store_id}',
            ], function () {
                Route::get('/', 'StoreController@show')->name('manager.store.show');

                // Product Route
                Route::resource('product', 'ProductController', [
                'except' => ['show'],
                'names' => [
                    'index' => 'manager.product.index',
                    'create' => 'manager.product.create',
                    'store' => 'manager.product.store',
                    'edit' => 'manager.product.edit',
                    'update' => 'manager.product.update',
                    'destroy' => 'manager.product.destroy',
                ]
                ]);


                // Category Route
                Route::resource('category', 'ProductCategoryController', [
                'except' => ['show', 'create', 'edit'],
                'names' => [
                    'index' => 'manager.category.index',
                    'store' => 'manager.category.store',
                    'update' => 'manager.category.update',
                    'destroy' => 'manager.category.destroy',
                ]
                ]);


                // Product Review Route
                Route::resource('review', 'ProductReviewController', [
                'except' => ['show', 'create', 'edit', 'store'],
                'names' => [
                    'index' => 'manager.review.index',
                    'update' => 'manager.review.update',
                    'destroy' => 'manager.review.destroy',
                ]
                ]);



                // Store Order Route
                Route::resource('order', 'StoreOrderController', [
                'except' => ['create', 'edit'],
                'names' => [
                    'index' => 'manager.store-order.index',
                    'show' => 'manager.store-order.show',
                    'store' => 'manager.store-order.store',
                    'update' => 'manager.store-order.update',
                    'destroy' => 'manager.store-order.destroy',
                ]
                ]);



                // Order Item Route
                Route::resource('order/{order_id}/order_item', 'OrderItemController', [
                'only' => ['store', 'destroy'],
                'names' => [
                    'store' => 'manager.order-item.store',
                    'destroy' => 'manager.order-item.destroy',
                ]
                ]);


                // Voucher Route
                Route::resource('voucher', 'VoucherController', [
                'except' => ['show', 'create', 'edit'],
                'names' => [
                    'index' => 'manager.voucher.index',
                    'store' => 'manager.voucher.store',
                    'update' => 'manager.voucher.update',
                    'destroy' => 'manager.voucher.destroy',
                ]
                ]);


                // Newsletter Route
                Route::resource('newsletter', 'NewsletterController', [
                'except' => ['show', 'create', 'edit'],
                'names' => [
                    'index' => 'manager.newsletter.index',
                    'store' => 'manager.newsletter.store',
                    'update' => 'manager.newsletter.update',
                    'destroy' => 'manager.newsletter.destroy',
                ]
                ]);
                Route::post('newsletter/send', 'NewsletterController@send')->name('manager.newsletter.send');



                // Store Subscriber Route
                Route::resource('subscriber', 'StoreSubscriberController', [
                'except' => ['show', 'create', 'edit'],
                'names' => [
                    'index' => 'manager.store-subscriber.index',
                    'store' => 'manager.store-subscriber.store',
                    'update' => 'manager.store-subscriber.update',
                    'destroy' => 'manager.store-subscriber.destroy',
                ]
                ]);



                // Carousel Route
                Route::resource('carousel', 'CarouselController', [
                'except' => ['show', 'create', 'edit', 'index'],
                'names' => [
                    'store' => 'manager.carousel.store',
                    'update' => 'manager.carousel.update',
                    'destroy' => 'manager.carousel.destroy',
                ]
                ]);



                // Shipping Method Route
                Route::resource('shipping-method', 'ShippingMethodController', [
                'except' => ['index', 'show', 'create', 'edit'],
                'names' => [
                    'store' => 'manager.shipping-method.store',
                    'update' => 'manager.shipping-method.update',
                    'destroy' => 'manager.shipping-method.destroy',
                ]
                ]);


                // Shipping Rate Route
                Route::resource('shipping-method/{method_id}/shipping-rate', 'ShippingRateController', [
                'except' => ['index', 'show', 'create', 'edit'],
                'names' => [
                    'store' => 'manager.shipping-rate.store',
                    'update' => 'manager.shipping-rate.update',
                    'destroy' => 'manager.shipping-rate.destroy',
                ]
                ]);


                // Payment method Route
                Route::resource('payment-mode', 'PaymentModeController', [
                'except' => ['index', 'show', 'create', 'edit'],
                'names' => [
                    'store' => 'manager.payment-mode.store',
                    'update' => 'manager.payment-mode.update',
                    'destroy' => 'manager.payment-mode.destroy',
                ]
                ]);


                // Store Manager
                Route::get('appearance/themes', 'StoreController@appearance')->name('manager.store.appearance.themes');
                Route::get('appearance/logo', 'StoreController@appearance')->name('manager.store.appearance.logo');
                Route::get('appearance/carousel', 'StoreController@appearance')->name('manager.store.appearance.carousel');
                Route::get('settings/general', 'StoreController@settings')->name('manager.store.settings.general');
                Route::get('settings/shipping-method', 'StoreController@settings')->name('manager.store.settings.shipping-method');
                Route::get('settings/payment-mode', 'StoreController@settings')->name('manager.store.settings.payment-mode');

                Route::post('update/appearance/theme', 'StoreController@updateTheme')->name('manager.store.appearance.update.theme');
                Route::post('update/appearance/logo', 'StoreController@updateLogo')->name('manager.store.appearance.update.logo');
                Route::post('update/general', 'StoreController@updateGeneral')->name('manager.store.settings.update.general');


                Route::post('facebookPixelFires', 'StoreController@facebookPixelFires')->name('manager.store.facebookPixelFires'); // Google Analytics Sessions AJAX
                Route::post('googleAnalyticsReport', 'StoreController@googleAnalyticsReport')->name('manager.store.googleAnalyticsReport'); // Google Analytics Sessions AJAX
                Route::post('socialMediaReport', 'StoreController@getSocialMediaReport')->name('manager.store.socialMediaReport'); // Social Media report AJAX

            });








            // Order Route
            Route::resource('order', 'OrderController', [
            'only' => ['index', 'show', 'update'],
            'names' => [
                'index' => 'manager.order.index',
                'show' => 'manager.order.show',
                'update' => 'manager.order.update',
            ]
            ]);


            // Invoice Route
            Route::resource('invoice', 'InvoiceController', [
            'except' => ['create', 'edit', 'update', 'destroy'],
            'names' => [
                'index' => 'manager.invoice.index',
                'show' => 'manager.invoice.show',
                'store' => 'manager.invoice.store',
            ]
            ]);
            Route::post('invoice/{id}/download', 'InvoiceController@download')->name('manager.invoice.download');







		});
	});





    /* 
    * Authentication Routes
    *
    *
    */
    Route::group([
        'namespace' => 'Auth',
    ], function () {
        Route::group([
            'middleware' => 'guest',
        ], function () {
            Route::get('/login', 'AuthController@login')->name('auth.login.form');
            Route::get('/signup', 'AuthController@signup')->name('auth.signup.form');
            Route::post('/signup', 'AuthController@create')->name('auth.signup.store');
            Route::get('/recover', 'AuthController@recover')->name('auth.recover');
            Route::post('/recover/send', 'AuthController@recoverSend')->name('auth.recover.send');
            Route::get('/recover/reset/{token}', 'AuthController@recoverReset')->name('auth.recover.reset');
            Route::post('/recover/reset/{token}/update', 'AuthController@recoverUpdate')->name('auth.recover.update');
        });
    });
});







/* 
* Admin Routes
*
*
*/
Route::group([
    'domain'        =>  $admin,
    'namespace'     =>  'Admin',
    'middleware'    =>  'admin'
], function () {

    Route::get('/', function(){
        return redirect(route('admin.store.index'));
    });

    // Stores
    Route::resource('store', 'StoreController', [
        'except' => ['create', 'store', 'edit', 'destroy'],
        'names' => [
            'index' => 'admin.store.index',
            'show' => 'admin.store.show',
            'update' => 'admin.store.update',
        ]
    ]);


    // Users
    Route::resource('user', 'UserController', [
        'except' => ['create', 'store', 'edit', 'destroy'],
        'names' => [
            'index' => 'admin.user.index',
            'show' => 'admin.user.show',
            'update' => 'admin.user.update',
        ]
    ]);



});









/* 
* Store Routes
*
*
*/
Route::group([
    'middleware'    => 'activeStore',
    'namespace'     => 'Store',
], function () {
    Route::get('/', 'StoreController@homepage')->name('homepage');
    Route::get('/cart', 'StoreController@cart')->name('cart');
    Route::get('/checkout', 'StoreController@checkout')->name('checkout');
    Route::get('/{category}', 'StoreController@productsIndex')->name('products.index');
    Route::get('/{category}/{slug}', 'StoreController@product')->name('store.product.show');


    Route::post('/add_to_cart', 'StoreController@add_to_cart')->name('add_to_cart');
    Route::post('/subtract_from_cart', 'StoreController@subtract_from_cart')->name('subtract_from_cart');
    Route::post('/remove_from_cart', 'StoreController@remove_from_cart')->name('remove_from_cart');
    Route::post('/checkout/store', 'StoreController@checkout_store')->name('checkout_store');
    Route::post('/ajax_validate_voucher', 'StoreController@ajax_validate_voucher')->name('ajax_validate_voucher');
    Route::post('/subscribe', 'StoreController@subscribe')->name('subscribe');
	Route::post('/review', 'StoreController@review')->name('review');
});








/* 
* Authentication Routes
*
*
*/
Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth'
], function () {
    Route::group([
        'middleware' => 'guest',
        'prefix'     => 'auth'
    ], function () {
        Route::post('/login', 'AuthController@store')->name('auth.login.store');
        Route::post('/login/facebook', 'AuthController@facebookLogin')->name('auth.login.store.facebook');
    });

    Route::post('/logout', 'AuthController@logout')->name('auth.logout');
});








