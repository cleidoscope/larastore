<?php

namespace App\Providers;

use App\Store;
use App\Product;
use App\Invoice;
use App\ProductCategory;
use App\Order;
use App\OrderItem;
use App\Voucher;
use App\Newsletter;
use App\StoreSubscriber;
use App\Carousel;
use App\ShippingMethod;
use App\ShippingRate;
use App\PaymentMode;
use App\Policies\StorePolicy;
use App\Policies\ProductPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\ProductCategoryPolicy;
use App\Policies\OrderPolicy;
use App\Policies\OrderItemPolicy;
use App\Policies\VoucherPolicy;
use App\Policies\NewsletterPolicy;
use App\Policies\StoreSubscriberPolicy;
use App\Policies\CarouselPolicy;
use App\Policies\ShippingMethodPolicy;
use App\Policies\ShippingRatePolicy;
use App\Policies\PaymentModePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Store::class                =>  StorePolicy::class,
        Product::class              =>  ProductPolicy::class,
        Invoice::class              =>  InvoicePolicy::class,
        ProductCategory::class      =>  ProductCategoryPolicy::class,
        Order::class                =>  OrderPolicy::class,
        OrderItem::class            =>  OrderItemPolicy::class,
        Voucher::class              =>  VoucherPolicy::class,
        Newsletter::class           =>  NewsletterPolicy::class,
        StoreSubscriber::class      =>  StoreSubscriberPolicy::class,
        Carousel::class             =>  CarouselPolicy::class,
        ShippingMethod::class       =>  ShippingMethodPolicy::class,
        ShippingRate::class         =>  ShippingRatePolicy::class,
        PaymentMode::class          =>  PaymentModePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
