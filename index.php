<?php

session_start();
if(isset($_SESSION['error'])){

	$error =  "<p><strong style='color:red'> Your name or password is wrong </strong></p>";
}  elseif(isset($_SESSION['wrongName'])){
	
	$error ="<p><strong style='color:red'> This name is not allowed for use. please try again with another name </strong></p>";
}elseif(isset($_SESSION['empty'])){
	$error =  "<p><strong style='color:red'>Please fill up all the fields </strong></p>";
}
else{
	
	$error = '';
}

//testing git
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="public/css.css">
		
	</head>

	<body >
		<div class="container-fluid">
			
		<div class="meny">
			<img src="public/menu.png" alt="menu" class="menuimg" />
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
				<li><a href= "<?php if(isset($_SESSION['alian'])){echo 'http://tobolkin.com/view/alian/earth.php';}elseif(isset($_SESSION['president'])){echo 'http://tobolkin.com/view/president/dashboard.php';}else{echo '#page1';} ?>" onclick="meny.close()">Go to Earth</a></li>
				
				<li><a href="#page3" onclick="meny.close();">Add a friend</a></li>
				<li><a href="#page4" onclick="meny.close();">Welcome page</a></li>
				
				
			</ul>
		</div>


		
		<div class="contents container-fluid">
	
<div id='stars'></div>
<div id='stars2'></div>
<div id='stars3'></div>
<?php  echo $error ?>
				<div id='title' class=" row col-xs-12 col-sm-10 col-md-10">

   <span>Having a place to live is home.</span><br>
<span>Having someone to live with is family.</span><br>
<span>Having both is a wonderful life.</span><br><br>
<span>Please feel wellcome to find your new home</span><br> 
<span>on our planet</span><br>
<span> Swipe in the Right way to continue</span><br><br>

</div>	
		</div>

		
		
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="public/meny.js"></script>
		<script type="text/javascript">
		var default_content="";

$(document).ready(function(){
	
	
	checkURL();
	$('ul li a').click(function (e){

			checkURL(this.hash);

	});
	
	//filling in the default content
	default_content = $('#title').html();
	
	
	setInterval("checkURL()",250);
	
});

var lasturl="";

//check valid user



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
