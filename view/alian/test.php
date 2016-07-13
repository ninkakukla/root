<?php
session_start();
    if(!isset($_SESSION['alian'])){
	
	 header('Location:http://tobolkin.com/');
	   exit();
}
	
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="../../public/css.css">

		<title>templete</title>

	</head>

	<body>

		<div class="container-fluid" style="    top: 86px;
		position: relative;">

			<div class="meny" style="position:absolute !important">
				<img src="../../public/menu.png" alt="menu" class="menuimg" />
				<h2>Choose your way</h2>
				<ul>
					
					<li>
						<form action="http://tobolkin.com/controller/functions.php" method="post">
							<input type="hidden" name="logmeout" value="logmeout" />
						<input type="submit" value="LOG OUT" />
						</form>
					</li>
					
					<li>
						<a href="http://tobolkin.com/">Home</a>
					</li>

				</ul>
			</div>

			<div class="contents container-fluid">

				<div id='title2' class=" row col-xs-12 col-sm-10 col-md-10">
					<div class="row">

						
						<div  class='instagram'>
							<section id="gallery" class="generic">
								<div class="container  ">
<div class="img-responsive" id="googleMap" style="width:100%;height:600px;" ></div>
<div id="countryInfo" class="row">
	<h2>About the country</h2>
	<ul style="    list-style-type: none;font-size: 24px;" id="ulInfo">
		
	</ul>
	
</div>
<span id="instagram" ></span>
								</div>
							</section>

						</div>
					</div>

				</div>
			</div>

		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://www.panoramio.com/wapi/wapi.js?v=1"></script>
		<script type="text/javascript" src="../../public/jquery.appear.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAQ4LyyeJCSJPFTD2UzXjvNNJS-mZPvuVA"></script>
	
		<script src="../../public/meny.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				
			//bringing list of static pictures for developing stage	
/*
$.ajax({
  url: "http://tobolkin.com/public/images",
  success: function(data){
     $(data).find("a:contains(.jpg)").each(function(){
      
        var images = $(this).attr("href");

        
        	document.getElementById("instagram").innerHTML += '<div class="col-xs-12 col-sm-8 col-md-4 item"><div class="content "><figure><img src="http://tobolkin.com/public/images/' + images + '" alt="Image" width="300px" height="300px"></figure></div></div>';


     });
  }
});
*/

//google costume search code
				(function() {
					var cx = '017099345064659003613:1xxs0wrvsdm';
					var gcse = document.createElement('script');
					gcse.type = 'text/javascript';
					gcse.async = true;
					gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(gcse, s);
				})();

				//for getting info on map about each country
				$(document).on('click', '.clickme', function(e) {
					var data = $(this).attr("value");
					data = data.split(",");
					
					
				//appending data about countries into a div 
				document.getElementById("ulInfo").innerHTML = "";
				$('#countryInfo ul').append('<li> Native: '+data[2]+'</li>');
				$('#countryInfo ul').append('<li> Population: '+data[3]+'</li>');
				$('#countryInfo ul').append('<li> Region: '+data[4]+'</li>');
				$('#countryInfo ul').append('<li> Subregion: '+data[5]+'</li>');
				$('#countryInfo ul').append('<li> Time zone: '+data[6]+'</li>');
				

					//changing google map depanding on the country that is chosen
					initialize(data[0], data[1], 7);
					google.maps.event.addDomListener(window, 'load', initialize);

					// getting pictures of countries
									$.ajax({
										type : "GET",
										data : {
											q : data[7] + ' pictures'
										},
										url : "https://www.googleapis.com/customsearch/v1?imgType=photo&key=AIzaSyAg1KClFyjrRlhLbunIwdTxGO1ur-i_iwQ&cx=017099345064659003613:1xxs0wrvsdm&callback=getCallback",
										dataType : "jsonp",
										async : 'true',
										success : function(html) {
				
										}
									});
				

					//closing the menu after click
					meny.close();

					//go to the top of the page
					$("html, body").animate({
						scrollTop : 0
					}, "slow");

				});
				// for the ajax menu
				checkURL();
				$('ul li a').click(function(e) {

					checkURL(this.hash);

				});

				//filling in the default content
				default_content = $('#title').html();

				setInterval("checkURL()", 250);
			});

			// getting country list
			$.ajax({
				type : "GET",
				url : "https://restcountries.eu/rest/v1/all",
				dataType : "html",
				success : function(html) {

					var jsonObj = html;
					var obj = $.parseJSON(jsonObj);

					for (var i = 0,
					    len = obj.length; i < len; i++) {
						Object.keys(obj).length
						someFn(obj[i], len);
					}

					function someFn(x, len) {
						//creating list of countries in the menu

						if (x.subregion != null) {
							var subregion = x.subregion;
						} else {
							subregion = 'none';
						}
						if (x.timezones != null) {
							var timezone = x.timezones[0];
						} else {
							timezone = 'none';
						}
						if (x.region != null) {
							var region = x.region;
						} else {
							region = 'none';
						}
						if (x.population != null) {
							var papulation = x.population;
						} else {
							papulation = 'none';
						}
						if (x.nativeName != null) {
							var native = x.nativeName;
						} else {
							native = 'none';
						}
						if (x.latlng[1] != null) {
							var lenghthy = parseFloat(x.latlng[1]);
						} else {
							lenghthy = 'none';
						}
						if (x.latlng[0] != null) {
							var lenghthx = parseFloat(x.latlng[0]);
						} else {
							lenghthx = 'none';
						}

						$('.meny ul').append('<li><a class= "clickme" href="#' + x.name + '"  value="' + lenghthx + ',' + lenghthy + ',' + native + ',' + papulation + ',' + region + ',' + subregion + ',' + timezone + ',' + x.name + '"><span>' + x.name + '</span></a></li>');

					}

				}
			});
			
			
		

			function getCallback(response) {
				document.getElementById("instagram").innerHTML = "";
				console.log(response);
				for (var i = 0; i < response.items.length; i++) {
					var item = response.items[i];

					if (item.pagemap) {
						var objects = item.pagemap.metatags[0];
						for (var key in objects) {
							var key = key;
							var value = objects[key];

							if (key == 'og:image') {

								$('#instagram').append('<div class="col-xs-12 col-sm-8 col-md-4 item"><div class="content "><figure><img src="' + value + '" alt="Image" width="300px" height="300px"></figure></div></div>');


								/*document.getElementById("instagram").innerHTML += "<br><img src='" + value+"' alt='picture' width='300px' height='300px'/>";*/

							}

						}

					}

				}
			}

			function initialize(x, y, z) {
				var mapProp = {
					center : new google.maps.LatLng(x, y),
					zoom : z,
					panControl : true,
					zoomControl : true,
					mapTypeControl : true,
					scaleControl : true,
					streetViewControl : true,
					overviewMapControl : true,
					rotateControl : true,
					mapTypeId : google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

			}

			function initializeb() {
				var mapProp = {
					center : new google.maps.LatLng(51.508742, -0.120850),
					zoom : 1,
					panControl : true,
					zoomControl : true,
					mapTypeControl : true,
					scaleControl : true,
					streetViewControl : true,
					overviewMapControl : true,
					rotateControl : true,
					mapTypeId : google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
			}


			google.maps.event.addDomListener(window, 'load', initializeb);

			var default_content = "";

			var lasturl = "";

			function checkURL(hash) {
				if (!hash)
					hash = window.location.hash;

				if (hash != lasturl) {
					lasturl = hash;

					if (hash == "")
						$('#title').html(default_content);
					
else
						loadPage(hash);
				}
			}

			function loadPage(url) {
				url = url.replace('#', '');

				$.ajax({
					type : "POST",
					url : "load_page.php",
					data : 'page=' + url,
					dataType : "html",
					success : function(msg) {

						if (parseInt(msg) != 0) {
							$('#title').html(msg);

						}
					}
				});

			}

			// Create an instance of Meny
			var meny = Meny.create({
				// The element that will be animated in from off screen
				menuElement : document.querySelector('.meny'),

				// The contents that gets pushed aside while Meny is active
				contentsElement : document.querySelector('.contents'),

				// [optional] The alignment of the menu (top/right/bottom/left)
				position : Meny.getQuery().p || 'right',

				// [optional] The height of the menu (when using top/bottom position)
				height : 100,

				// [optional] The width of the menu (when using left/right position)
				width : 360,

				// [optional] Distance from mouse (in pixels) when menu should open
				threshold : 50,

				// [optional] Use mouse movement to automatically open/close
				mouse : true,

				// [optional] Use touch swipe events to open/close
				touch : true
			});

			// API Methods:
			// meny.open();
			// meny.close();
			// meny.isOpen();

			// Events:
			// meny.addEventListener( 'open', function(){ console.log( 'open' ); } );
			// meny.addEventListener( 'close', function(){ console.log( 'close' ); } );

			// Embed an iframe if a URL is passed in
			if (Meny.getQuery().u && Meny.getQuery().u.match(/^http/gi)) {
				var contents = document.querySelector('.contents');
				contents.style.padding = '0px';
				contents.innerHTML = '<div class="cover"></div><iframe src="' + Meny.getQuery().u + '" style="width: 100%; height: 100%; border: 0; position: absolute;"></iframe>';
			}
		</script>
		<gcse:search></gcse:search>
	</body>
</html>
