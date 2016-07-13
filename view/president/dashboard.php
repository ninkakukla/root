<?php

session_start();
if(!isset($_SESSION['president'])){
	
	 header('Location:http://tobolkin.com/');
	   exit();
}  
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="../../public/css.css">
		
	</head>

	<body >
		<div class="container-fluid">
			
		<div class="meny">
			
			<img src="../../public/menu.png" alt="menu" class="menuimg" />
			<h2>Choose your way</h2>
			<ul>
				<?php if(isset($_SESSION['alian']) || isset($_SESSION['president'])) {
					echo '	<li>
						<form action="http://tobolkin.com/controller/functions.php" method="post">
							<input type="hidden" name="logmeout" value="logmeout" />
						<input type="submit" value="LOG OUT" />
						</form>
					</li>';
				}
				
				?>
				<li><a href= "http://tobolkin.com/" onclick="meny.close()">Home page</a></li>
				<li><a href="#users" id="user" onclick="meny.close();">Check who`s on earth</a></li>
				<li><a href="#games" id="perm" onclick="meny.close();">Bored?</a></li>
				
				
			</ul>
		</div>


		
		<div class="contents container-fluid">
							<div id='title' class=" row col-xs-12 col-sm-10 col-md-10">
 <p>
	Wlcome dear president!<br>
	Hope your`e having an amazing week!
</p>

<table class="table-fill"><thead><tr><th class="text-left">Name</th><th class="text-left">Planet</th><th class="text-left">Arrive time</th></tr></thead><tbody class="table-hover" id="tb">
</div>	

		</div>

		

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="../../public/meny.js"></script>
		<script type="text/javascript">
	

$(document).ready(function(){
		var default_content="";
	
	//games
	$('#perm').on('click',function(){
		
		$('.table-fill').css('display','none');
       	 $('#title p').css('display','none');
       	 $('#title').append('<iframe src="http://www.freegamesjungle.com/gameroom.php?theme=1" width="420" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>');
		
		
	})
	
	
	//get users
$('#user').on('click',function(){
	
	$.ajax({
    type: "POST",
    url: "http://tobolkin.com/controller/functions.php",
    data: {user: 'user'},
    dataType:'JSON', 
    success: function(response){
        
        
       for (var i = 0,len = response.users.length; i < len; i++) {
       	var user = response.users[i];
       	$('#title iframe').css('display','none');
       	$('.table-fill').css('display','block');
       	$('#tb').append ( '<tr><td class="text-left">'+user.name+'</td><td class="text-left">'+user.planet+'</td><td class="text-left">'+user.time_stamp+'</td></tr>');
       $('#tb').append ( '</tbody></table>');
        $('#title p').css('display','none');
   
       }
    
     
    }
});
	
})
	
	
	
	
	
	
	
	
	
	
	
	checkURL();
	$('ul li a').click(function (e){

			checkURL(this.hash);

	});
	
	//filling in the default content
	default_content = $('#title').html();
	
	
	setInterval("checkURL()",250);
	
});

var lasturl="";

function checkURL(hash)
{
	if(!hash) hash=window.location.hash;
	
	if(hash != lasturl)
	{
		lasturl=hash;
		
		// FIX - if we've used the history buttons to return to the homepage,
		// fill the pageContent with the default_content
		
		if(hash=="")
		$('#title').html(default_content);
		
		else
		loadPage(hash);
	}
}


function loadPage(url)
{
	url=url.replace('#page','');
	

	
	$.ajax({
		type: "POST",
		url: "load_page.php",
		data: 'page='+url,
		dataType: "html",
		success: function(msg){
			
			if(parseInt(msg)!=0)
			{
				$('#title').html(msg);
			
			}
		}
		
	});

}

		
			// Create an instance of Meny
			var meny = Meny.create({
				// The element that will be animated in from off screen
				menuElement: document.querySelector( '.meny' ),

				// The contents that gets pushed aside while Meny is active
				contentsElement: document.querySelector( '.contents' ),

				// [optional] The alignment of the menu (top/right/bottom/left)
				position: Meny.getQuery().p || 'right',

				// [optional] The height of the menu (when using top/bottom position)
				height: 100,

				// [optional] The width of the menu (when using left/right position)
				width: 360,

				// [optional] Distance from mouse (in pixels) when menu should open
				threshold: 50,

				// [optional] Use mouse movement to automatically open/close
				mouse: true,

				// [optional] Use touch swipe events to open/close
				touch: true
			});

			// API Methods:
			// meny.open();
			// meny.close();
			// meny.isOpen();

			// Events:
			// meny.addEventListener( 'open', function(){ console.log( 'open' ); } );
			// meny.addEventListener( 'close', function(){ console.log( 'close' ); } );

			// Embed an iframe if a URL is passed in
			if( Meny.getQuery().u && Meny.getQuery().u.match( /^http/gi ) ) {
				var contents = document.querySelector( '.contents' );
				contents.style.padding = '0px';
				contents.innerHTML = '<div class="cover"></div><iframe src="'+ Meny.getQuery().u +'" style="width: 100%; height: 100%; border: 0; position: absolute;"></iframe>';
			}
		</script>

	</body>
</html>
