@extends('manager.store.store-manager.layout')

@section('title')
<title>Dashboard &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop


@section('content')
<div class="ui grid">
	<div class="eight wide mobile eight wide tablet four wide computer column">
		<div class="ui segment">
		  	<div class="cs-stat">
				<i class="fa fa-cubes statistic-icon"></i>
			    <div class="label">Total Products</div>
			    @if( $store->is_pro )
			    <div class="value font-medium">{{ $store->products->count() }}</div>
			    @else
			    <div class="value font-medium">{{ $store->products->count() }}/{{ $store->plan->max_products }}</div>
			    @endif
		  	</div>
		    <hr />
		    <div class="extra">
		        @if( $store->is_pro || $store->products->count() < $store->plan->max_products )
				<a href="{{ route('manager.product.create', $store->id) }}"><i class="fa fa-plus"></i> Add product</a>
				@else
				<span class="extra"><i class="fa fa-plus"></i> Add product</span>
				@endif
		    </div>
		</div>
	</div>

	<div class="eight wide mobile eight wide tablet four wide computer column">
		<div class="ui segment">
		  	<div class="cs-stat">
				<i class="fa fa-line-chart statistic-icon"></i>
			    <div class="label">Total Revenue</div>
			    <?php $orders = $store->orders->where('status', 'completed'); ?>
			    <div class="value font-medium">{{ Helpers::currencyFormat($orders->sum('total')) }}</div>
		  	</div>
		    <hr />
		    <div class="extra">
		    	<i class="fa fa-refresh"></i> Updated now
		    </div>
		</div>
	</div>

	<div class="eight wide mobile eight wide tablet four wide computer column">
		<div class="ui segment">
		  	<div class="cs-stat">
				<i class="fa fa-shopping-basket statistic-icon"></i>
			    <div class="label">Pending Orders</div>
			    <div class="value font-medium">{{ count($store->orders->where('status', 'pending')) }}</div>
		  	</div>
		    <hr />
		    <div class="extra">
		    	<a href="{{ route('manager.store-order.index', $store->id) }}"><i class="fa fa-tasks"></i> Manage Orders</a>
		    </div>
		</div>
	</div>

	<div class="eight wide mobile eight wide tablet four wide computer column">
		<div class="ui segment @if( $store->is_basic ) disabled @endif">
		  	<div class="cs-stat">
				<i class="fa fa-users statistic-icon"></i>
			    <div class="label">Subscribers</div>
			    <div class="value font-medium">{{ $store->store_subscribers->count() }}</div>
		  	</div>
		    <hr />
		    <div class="extra">
		    	<i class="fa fa-refresh"></i> Updated now
		    </div>
		</div>
	</div>
</div>


<div class="ui grid">
	<div class="sixteen wide mobile six wide tablet six wide computer column">
		<div class="ui segment">
			<div class="header"><h3>Orders Report</h3></div>
			<canvas id="ordersChart" class="margin-top"></canvas>
		</div>
	</div>

	<div class="sixteen wide mobile ten wide tablet ten wide computer column">
		<div class="ui segment">
			<div class="header"><h3>Sales Analytics</h3></div>
			<canvas id="salesChart" class="margin-top"></canvas>
		</div>
	</div>
</div>


@if( !$store->is_basic )
<div class="ui grid">
	<div class="sixteen wide column">
		<div class="ui segment">
			<div class="header"><h3>Google Analytics Report</h3></div>

			<div class="ui grid stackable">
				<div class="nine wide column">
					<div class="extra">Sessions from the last 7 days</div>
					<div class="loader-container">
						<div class="ui active small loader text" id="analytics-sessions-loader">Loading</div>
						<canvas id="analyticsChart" class="margin-top"></canvas>
					</div>
				</div>

				<div class="seven wide column">
					<div class="extra">Sessions from the last 30 days</div>

					<div class="ui secondary pointing tabular menu no-margin-top">
					  	<a class="item tab active no-padding-left" data-tab="tab-cities">Top Cities</a>
					  	<a class="item tab no-padding-left" data-tab="tab-pages">Most Viewed Pages</a>
					</div>

					<div class="ui tab active" data-tab="tab-cities">
						<div id="ga-cities-error-text" class="text-center ga-error-text"><div class="text-center"><i class="fa fa-warning"></i></div><span></span></div>
						<div class="content loader-container" id="topCitiesContainer">
							<div class="ui active small loader text" id="analytics-cities-loader">Loading</div>
							<table class="ui single line compact very basic small table"></table>
						</div>
					</div>
					<div class="ui tab" data-tab="tab-pages">
						<div id="ga-pages-error-text" class="text-center ga-error-text"><div class="text-center"><i class="fa fa-warning"></i></div><span></span></div>
						<div class="content loader-container" id="topPagesContainer">
							<div class="ui active small loader text" id="analytics-pages-loader">Loading</div>
							<table class="ui single line compact very basic small fixed table"></table>
						</div>
					</div>
				</div>
			</div>
			<div id="ga-sessions-error-text" class="ga-error-text text-center"><div class="text-center"><i class="fa fa-warning"></i></div><span></span></div>
		</div>
	</div>
</div>


<div class="ui grid">
	<div class="sixteen wide column">
		<div class="ui segment">
			<div class="header"><h3>Facebook Pixel Report</h3></div>
			
			<div class="ui grid stackable">
				<div class="column">
					<div class="extra">Pixel fires from the last 14 days</div>
					<div class="loader-container">
						<div class="ui active small loader text" id="facebook-pixels-loader">Loading</div>
						<div id="total-fires" class="text-blue font-medium margin-top half">&nbsp;</div>
						<canvas id="pixelsChart" class="margin-top"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif


<div class="ui grid">
	<div class="sixteen wide mobile nine wide tablet nine wide computer column">
		<div class="ui segment">
			<div class="header margin-bottom">
				<h3>
					<a class="ui icon mini circular button right floated" href="{{ route('manager.store.settings.general', $store->id) }}"><i class="wrench icon"></i></a>
					Social Media
				</h3>
			</div>
			<table class="social-media text-center">
				<tr>
					<td data-toggle="popup" data-content="Facebook Page Likes" data-position="bottom center" data-variation="small inverted">
						<i class="fa fa-facebook social-media-icon"></i>
						<div class="extra">Fans count</div>
						<div id="facebook-count">
							@if ( $store->facebook )
							<div class="ui active inline loader mini"></div>
							@else
							<em class="font-small extra">Not set</em>
							@endif
						</div>
					</td>
					<td data-toggle="popup" data-content="Twitter Followers" data-position="bottom center" data-variation="small inverted">
						<i class="fa fa-twitter social-media-icon"></i>
						<div class="extra">Followers</div>
						<div id="twitter-count">
							@if ( $store->twitter )
							<div class="ui active inline loader mini"></div>
							@else
							<em class="font-small extra">Not set</em>
							@endif
						</div>
					</td>
					<td data-toggle="popup" data-content="Instagram Followers" data-position="bottom center" data-variation="small inverted">
						<i class="fa fa-instagram social-media-icon"></i>
						<div class="extra">Followers</div>
						<div id="instagram-count">
							@if ( $store->instagram )
							<div class="ui active inline loader mini"></div>
							@else
							<em class="font-small extra">Not set</em>
							@endif
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
@stop


@section('scripts')
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
$(document).ready(function(){
	var ctx_orders = $("#ordersChart");
	var ctx_sales = $("#salesChart");
	ctx_orders.attr('height', 250);
	ctx_sales.attr('height', 140);


	// Orders Report
	var ordersChart = new Chart(ctx_orders, {
	    type: 'pie',
	    data: {
	        labels: ['Pending', 'Processing', 'Completed', 'Cancelled', 'Failed'],
	        datasets: [{
	            data: [
	            	'{{ $store->orders->where('status', 'pending')->count() }}', 
	            	'{{ $store->orders->where('status', 'processing')->count() }}', 
	            	'{{ $store->orders->where('status', 'completed')->count() }}', 
	            	'{{ $store->orders->where('status', 'cancelled')->count() }}', 
	            	'{{ $store->orders->where('status', 'failed')->count() }}'
	            ],
	            backgroundColor: [
	                '#FBBD08',
	                '#00B5AD',
	                '#21BA45',
	                '#767676',
	                '#DB2828',
	            ],
	            borderWidth: 0,
	        }]
	    },
	    options: {
		    responsive: true,
	    }
	});


	// Sales Analytics
	var salesChart = new Chart(ctx_sales, {
	    type: 'bar',
	    data: {
	        labels: {!! $salesAnalyticsLabels !!},
	        datasets: [{
	            data: {{ $salesAnalytics }},
	            backgroundColor: 'rgba(247,164,1,.3)',
	            borderColor: 'rgba(247,164,1,1)',
	            borderWidth: 1,
	        }]
	    },
	    options: {
		    responsive: true,
		    legend: {
		        display: false
		    },
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true,
	                    userCallback: function(label, index, labels) {
		                    if (Math.floor(label) === label) {
		                        return '₱' + label;
		                    }
		                },
	                }
	            }],
	        },
            tooltips: {
                enabled: true,
                mode: 'single',
                callbacks: {
                    label: function(tooltipItems, data) {
                        return '₱' + tooltipItems.yLabel;
                    },
                }
            },
	    }
	});


	// Social Media report
    $.post("{{ route('manager.store.socialMediaReport', $store->id) }}",
    {},
    function(data){
    	//console.log(data);
    	var response = JSON.parse(data);
    	$('#facebook-count').html(response.facebook);
    	$('#twitter-count').html(response.twitter);
    	$('#instagram-count').html(response.instagram);
    });
});
</script>

@if( !$store->is_basic )
<script>
$.extend( true, $.fn.dataTable.defaults, {
    "searching": false,
    "bLengthChange" : false, 
} );


$(document).ready(function(){
	var ctx_analytics = $("#analyticsChart");
	var ctx_pixels = $("#pixelsChart");
	ctx_pixels.attr('height', 100);

	new Chart(ctx_analytics, {});
	new Chart(ctx_pixels, {});



	// Google Analytics report
	$.post("{{ route('manager.store.googleAnalyticsReport', $store->id) }}",
    {},
    function(data){
    	$('#analytics-sessions-loader').removeClass('active');
    	var response = JSON.parse(data);
    	if(response.error){
    		$('#ga-sessions-error-text').css('display', 'block');
    		$('#ga-sessions-error-text span').text(response.message);
    	} else if(response.success){
    		var dataReport = JSON.parse(response.dataReport);
    		var dates = []; 
    		var page_paths = [];
    		var cities = [];
    		var sessions = [];
    		var pageviews = [];
    		for( var i = 0; i < dataReport.length; i += 5 ){
    			dates.push(stringToDate(dataReport[i]));
    			page_paths.push(dataReport[i+1]);
    			cities.push(dataReport[i+2]);
    			sessions.push(dataReport[i+3]);
    			pageviews.push(dataReport[i+4]);
    		}

    		// Sessions chart
    		var sessions_report = [];
    		for( var i = 0; i < dates.length; i++ ){
    			if( (dates[i] in sessions_report) ){
    				sessions_report[dates[i]] += parseInt(sessions[i]);
    			} else {
    				sessions_report[dates[i]] = parseInt(sessions[i]);
    			}
    		}

	    	var date_labels = [];
	    	var date_body = [];
    		var last_7_days = LastXDays(7);
    		for( var i = 0; i < last_7_days.length; i++ ){
    			date_labels.push(last_7_days[i]);
    			if( last_7_days[i] in sessions_report ){
    				date_body.push(sessions_report[last_7_days[i]]);
    			} else {
    				date_body.push(0);
    			}
    		}

    		date_labels.reverse();
    		date_body.reverse();
	    	date_labels.splice(date_labels.length-1, 1, "Today");

			new Chart(ctx_analytics, {
			    type: 'line',
			    data: {
			        labels: date_labels,
			        datasets: [{
                		label: "Sessions",
			            data: date_body,
			            backgroundColor: 'rgba(239,70,11,.1)',
			            borderColor: 'rgba(239,70,11,1)',
			            borderWidth: 2
			        }]
			    },
			    options: {
				    legend: {
				        display: false
				    },
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true,
			                    userCallback: function(label, index, labels) {
				                    if (Math.floor(label) === label) {
				                        return label;
				                    }
				                },
			                }
			            }]
			        }
			    }
			});


			// Cities report
			var cities_report = [];
    		for( var i = 0; i < cities.length; i++ ){
    			if( (cities[i] in cities_report) ){
    				cities_report[cities[i]] += parseInt(sessions[i]);
    			} else {
    				cities_report[cities[i]] = parseInt(sessions[i]);
    			}
    		}
    		$('#analytics-cities-loader').removeClass('active');
    		$('#topCitiesContainer table').DataTable({
    			"pageLength" : 5,
    			"pagingType": "simple",
    		    responsive: true,
		        language: {
		            paginate: {
		                previous: '<button class="ui circular basic icon button mini"><i class="icon angle left"></i></button>',
		                next: '<button class="ui circular basic icon button mini"><i class="icon angle right"></i></button>',
		            },
		            "sEmptyTable": "No data available"
		        },
		        data: arrayToMulti(Object.keys(cities_report), Object.values(cities_report)),
		        columns: [
		            { title: "City" },
		            { title: "Sessions" }
		        ],
		        "order": [[ 1, "desc" ]]
		    });



			// Pages report
			var pages_report = [];
			for( var i = 0; i < page_paths.length; i++ ){
    			if( (page_paths[i] in pages_report) ){
    				pages_report[page_paths[i]] += parseInt(pageviews[i]);
    			} else {
    				pages_report[page_paths[i]] = parseInt(pageviews[i]);
    			}
    		}

    		$('#analytics-pages-loader').removeClass('active');
    		$('#topPagesContainer table').DataTable({
    			"pageLength" : 5,
    			"pagingType": "simple",
    		    responsive: true,
		        language: {
		            paginate: {
		                previous: '<button class="ui circular basic icon button mini"><i class="icon angle left"></i></button>',
		                next: '<button class="ui circular basic icon button mini"><i class="icon angle right"></i></button>',
		            },
		            "sEmptyTable": "No data available"
		        },
		        data: arrayToMulti(Object.keys(pages_report), Object.values(pages_report)),
		        columns: [
		            { title: "Page Path" },
		            { title: "Page Views" }
		        ],
		        "order": [[ 1, "desc" ]]
		    });
    	}
    });



	 // Facebook Pixel Fires
	$.post("{{ route('manager.store.facebookPixelFires', $store->id) }}",
    {},
    function(data){
    	$('#facebook-pixelfires-loader').removeClass('active');
    	var response = JSON.parse(data);
    	if(response.error){
    	} else if(response.success){
	    	var date_labels = [];
	    	var date_body = [];
    		var last_14_days = LastXDays(14);
    		for( var i = 0; i < last_14_days.length; i++ ){
    			date_labels.push(last_14_days[i]);
    			if( last_14_days[i] in response.pixel_fires ){
    				date_body.push(response.pixel_fires[last_14_days[i]]);
    			} else {
    				date_body.push(0);
    			}
    		}

    		date_labels.reverse();
    		date_body.reverse();
	    	date_labels.splice(date_labels.length-1, 1, "Today");

    		$('#facebook-pixels-loader').removeClass('active');
    		$('#total-fires').text(getSumOfValuesArray(date_body) + ' Pixel Fires');

   			new Chart(ctx_pixels, {
			    type: 'line',
			    data: {
			        labels: date_labels,
			        datasets: [{
                		label: "Pixel fires",
			            data: date_body,
			            backgroundColor: 'rgba(25,118,210,.1)',
			            borderColor: 'rgba(25,118,210,1)',
			            borderWidth: 2
			        }]
			    },
			    options: {
				    legend: {
				        display: false
				    },
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true,
			                    userCallback: function(label, index, labels) {
				                    if (Math.floor(label) === label) {
				                        return label;
				                    }
				                },
			                }
			            }]
			        }
			    }
			});
    	}
    });
});

function formatDate(date){
    var dd = date.getDate();
    var mm = date.getMonth();
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
	  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
	];

    date = monthNames[mm]+' '+dd;
    return date;
 }


function LastXDays(days){
    var result = [];
    for (var i=0; i<days; i++) {
        var d = new Date();
        d.setDate(d.getDate() - i);
        result.push( formatDate(d) )
    }

    return(result);
}
function getSumOfValuesArray(values)
{
	var sum = 0;
	for( var i = 0; i < values.length; i++ ){
		sum += values[i];
	}
	return sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


function stringToDate(string){
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
	  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
	];
	var formattedDate;
	var month = parseInt(string.substring(4, 6));
	var date = parseInt(string.substring(6, 8));
	formattedDate = monthNames[month-1] + ' ' + date;

	return formattedDate;
}


function arrayToMulti(keys, values) {
	var arr = [];
    for(var i = 0, ii = keys.length; i<ii; i++) {
        arr.push([keys[i], values[i]]);
    }
    return arr;
}
</script>
@endif
@stop
