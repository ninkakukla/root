<?php
session_start();
    if(!isset($_SESSION['alian'])){
	
	 header('Location: http://localhost/eden/');
	   exit();
}
	
?>

<div id="wapiblock"></div>
<div id="googleMap" style="width:500px;height:380px;"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="http://www.panoramio.com/wapi/wapi.js?v=1"></script>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAQ4LyyeJCSJPFTD2UzXjvNNJS-mZPvuVA"></script>

<script type="text/javascript">


// getting country list 
$.ajax({
    type: "GET",
url: "https://restcountries.eu/rest/v1/all",
dataType: "html",
success: function(html) {
	
var jsonObj = html;
var obj = $.parseJSON(jsonObj);

console.log(obj);
}}); 



// getting pictures of countries
var myOptions = {
  'width': 300,
  'height': 200
};
var myRequest = new panoramio.PhotoRequest({
  'tag': 'face',
  'rect': {'sw': {'lat': -30, 'lng': 10.5}, 'ne': {'lat': 50.5, 'lng': 30}}
});

var widget = new panoramio.PhotoWidget('wapiblock', myRequest, myOptions);
widget.setPosition(0);


//google maps

function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);

</script>
