@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>About Us &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<div class="ui container">
	<div class="ui grid stackable  margin-top">
		<div class="three wide computer column"></div>
		<div class="ten wide computer column">
			<h2 class="font-medium font-extra-massive mobile-shrink text-center">Get to know us</h2>
			<br />
			<h3 class="font-big margin-top">We are aimed to make ecommerce easier and better for every Filipino entrepreneur.</h3>
			<p class="font-size-extra-normal margin-bottom">
				Our purpose at Cloudstore is to bring power to Filipino online sellers because we recognize the difficulties of starting an online store business here in the Philippines.
				Merchants have resorted to creating online business groups on social media sites like Facebook. In fact, there has been an increase in the number of Philippine Facebook business groups in the recent years. This only shows that people have realized the power of selling products and services online. Facebook business groups, however, are simply not reliable enough. These people needed a platform that will serve as a backbone for their businesses. A platform built specifically for Filipinos. But not just any platform; they needed one that is equipped with all the necessary tools allowing them to easily sell products, drive engagement, and track important website metrics. This realization has become the cornerstone of our company. Thus, Cloudstore was born.
			</p>
		</div>
	</div>

	<div class="ui grid stackable margin-top">
		<div class="three wide computer column"></div>
		<div class="ten wide computer column">
			<h3 class="font-big margin-top no-margin-bottom">The Platform</h3>
			<p class="font-size-extra-normal margin-top margin-bottom">
				Our team of developers are working hard every day to provide a competent solution to your problems. We have designed and developed a commerce platform with the sole purpose of serving each and every Filipino entrepreneur. Cloudstore aims to ease the troubles of setting up a profitable online business by providing an affordable, intuitive, and reliable tool that works on all devices. 
				<br /><br />
				We know that not everyone has the technical know-how needed to make an effective and secure commerce website from scratch. Creating a stunning and responsive online store should never be difficult! Our platform is integrated with a centralized system that harnesses the power of Google Analytics and Facebook Pixel. Not only will you easily own a beautiful web store, you will also have a comprehensive way of tracking your business performance. Get detailed reports about what your customers want while also understanding the actions that people take on your online store. Moreover, you will receive a text message every time a customer places an order so you never miss a chance to close a sale.
				<br /><br />
				Do you have a great business idea? Let's start selling today!
			</p>
		</div>
	</div>
</div>
@stop