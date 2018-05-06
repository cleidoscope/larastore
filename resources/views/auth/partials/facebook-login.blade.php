<script>
function FacebookLogin(){
	if( typeof FB != 'undefined' ){
		$('#loginLoader').addClass('active');
		FB.login(function(){
		  	FB.api(
		      "/me",{fields: 'first_name, last_name, email'},
		      	function (response) {
		          	if (response && !response.error){
			            var first_name 	= response.first_name;
			            var last_name 	= response.last_name;
			            var email 		= response.email;
			            $.post("{{ route('auth.login.store.facebook') }}",
			            {
			            	first_name 	: first_name,
			            	last_name 	: last_name,
			            	email 		: email,
			            },
			            function(data){
		      				console.log(data);
			            	var response = JSON.parse(data);
			            	if( response.error ){
								$('#loginLoader').removeClass('active');
								$('#auth-errors-container').html('<div class="ui error small message">' + response.message + '</div>');
			            	}
			            	else if( response.success ){
			            		window.location.href = response.redirect_url;
			            	}
			            }
			            );
		          	}
		      	}
		  	);
		}, {scope: 'email'});
	}
}



window.fbAsyncInit = function() {
    FB.init({
      appId      : '1208410692601134',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.10'
    });
FB.AppEvents.logPageView();   
};

(function(d, s, id){
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) {return;}
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>