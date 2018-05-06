@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Pricing and Features &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<h3 class="text-center font-regular font-massive">Plan Pricing</h3>

<div class="ui container">
	<div class="ui stackable grid">
		<div class="ui column mobile only pricing-toggle">
			<div class="ui buttons medium fluid no-padding-left">
			  	<a class="ui button basic font-medium" data-target=".planBasic">Basic</a>
			  	<a class="ui button basic font-medium background-blue" data-target=".planPlus">Plus</a>
			  	<a class="ui button basic font-medium" data-target=".planPro">Pro</a>
			</div>
		</div>

		<div class="one wide computer column computer only"></div>
		<div class="sixteen wide mobile sixteen wide tablet fourteen wide computer column">
			<table class="ui celled padded unstackable table no-margin-top margin-bottom half pricing-table">
				<thead>
					<tr class="font-medium font-size-medium center aligned">
						<th></th>
						<th class="top aligned">Basic</th>
						<th class="background-blue">Plus<div class="plan-popular">MOST POPULAR</div></th>
						<th class="top aligned">Pro</th>
					</tr>

					<tr class="font-medium font-size-medium center aligned middle aligned mobile-only planBasic">
						<th class="background-blue" colspan="4">Basic<div class="plan-popular">&nbsp;</div></th>
					</tr>
					<tr class="font-medium font-size-medium center aligned middle aligned mobile-only show planPlus">
						<th class="background-blue" colspan="4">Plus<div class="plan-popular">MOST POPULAR</div></th>
					</tr>
					<tr class="font-medium font-size-medium center aligned middle aligned mobile-only planPro">
						<th class="background-blue" colspan="4">Pro<div class="plan-popular">&nbsp;</div></th>
					</tr>

				</thead>
				<tbody>
					<tr>
						<td>Monthly price</td>
						<td class="center aligned hide-mobile planBasic planPrice"><div class="font-big font-medium margin-top margin-bottom">₱550</div></td>
						<td class="center aligned hide-mobile show planPlus planPrice"><div class="font-big font-medium margin-top margin-bottom">₱1000</div></td>
						<td class="center aligned hide-mobile planPro planPrice"><div class="font-big font-medium margin-top margin-bottom">₱2000</div></td>
					</tr>
					<tr class="background-blue font-medium">
						<td colspan="4" class="all-caps">FEATURES</td>
					</tr>
					<tr>
						<td>Number of products</td>
						<td class="center aligned hide-mobile planBasic">150</td>
						<td class="background-blue center aligned hide-mobile show planPlus">500</td>
						<td class="center aligned hide-mobile planPro">Unlimited</td>
					</tr>
					<tr>
						<td>Free themes</td>
						<td class="center aligned hide-mobile planBasic"><i class="large green checkmark icon"></i></td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Sales analytics</td>
						<td class="center aligned hide-mobile planBasic"><i class="large green checkmark icon"></i></td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Facebook Messenger integration</td>
						<td class="center aligned hide-mobile planBasic"><i class="large green checkmark icon"></i></td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Social media followers report *</td>
						<td class="center aligned hide-mobile planBasic"><i class="large green checkmark icon"></i></td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<!-- <tr>
						<td>Facebook Product Catalog integration</td>
						<td class="center aligned hide-mobile">-</td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile"><i class="large green checkmark icon"></i></td>
					</tr> -->
					<tr>
						<td>SMS notifications</td>
						<td class="center aligned hide-mobile planBasic">-</td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Facebook Pixel report</td>
						<td class="center aligned hide-mobile planBasic">-</td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Google Analytics report</td>
						<td class="center aligned hide-mobile planBasic">-</td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Newsletter and subscription</td>
						<td class="center aligned hide-mobile planBasic">-</td>
						<td class="background-blue center aligned hide-mobile show planPlus"><i class="large green checkmark icon"></i></td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Custom domain</td>
						<td class="center aligned hide-mobile planBasic">-</td>
						<td class="background-blue center aligned hide-mobile show planPlus">-</td>
						<td class="center aligned hide-mobile planPro"><i class="large green checkmark icon"></i></td>
					</tr>
					<tr>
						<td>Custom theme</td>
						<td class="center aligned hide-mobile planBasic">-</td>
						<td class="background-blue center aligned hide-mobile show planPlus">-</td>
						<td class="center aligned hide-mobile planPro">1</td>
					</tr>
				</tbody>
			</table>
			<small>* Facebook, Twitter, and Instagram</small>
		</div>
	</div>
</div>

<div class="margin-top">&nbsp;</div>
<div class="margin-top">&nbsp;</div>

<div class="ui container pricing-payment-methods margin-top text-center">
	<h3 class="text-center margin-top font-regular font-big no-margin-bottom">Payment Modes</h3>
	<p>We have a range of payment options so you can pay your invoices conveniently</p>
	<div class="margin-top">&nbsp;</div>
	<div class="ui container">
		<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_150x38.png" title="PayPal Logo" alt="PayPal Logo">
		<img src="http://www.lbcexpress.com/bundles/applicationsonatapage/img/lbc-logo-header.png?version=1.1.4" title="LBC" alt="LBC">
		<img src="http://www.mlhuillier.com/wp-content/themes/mlhuillier/images/mlhuillier-logo.jpg" title="MLhuillier" alt="MLhuillier">
		<img src="https://www.gcash.com/app/default/assets/addons/default/rapidustech/easter-theme/resources/img/staticlogo.png?v=1489999392g" alt="Globe GCash" alt="Globe GCash">
	</div>
</div>
<div class="margin-bottom">&nbsp;</div>
@stop