<?php
session_start();


if(isset($_POST['login']) && $_POST['login' ]== 'loginform'){//checking if the request came from the login page
	if(!empty( $_POST['name']) && !empty( $_POST['name']) ){
		session_unset($_SESSION['empty']);
   $name= $_POST['name'];
   $password = $_POST['password'];
   getIn($name,$password); 
		
	}else{
		
		$_SESSION['empty']= 'empty';
		 header('Location: http://tobolkin.com/#page1');
	   exit();
	}
  
} 


if(isset($_POST['register']) && $_POST['register' ]== 'registerform'){//checking if the request came from the register page
	if(!empty( $_POST['registername']) && !empty( $_POST['registerpassword']) && !empty( $_POST['planet'])){
   $name= $_POST['registername'];
   $password = $_POST['registerpassword'];
   $planet = $_POST['planet'];
   register($name,$password,$planet); 
	}else{
			
		$_SESSION['empty']= 'empty';
		 header('Location: http://tobolkin.com/#page3');
	   exit();
	}
} 

if(isset($_POST['logmeout'])){//in case of loging out
	 session_destroy();
	 header('Location: http://tobolkin.com');
	   exit();
}

 if(isset($_POST['user']) && !empty($_POST['user'])) {// in case of click on "show users"
 	
	userList();
        
    }



//===================Clean xss attack class =======================//

class xssClean {
    /*
     * Recursive worker to strip risky elements
     *
     * @param   string  $input      Content to be cleaned. It MAY be modified in output
     * @return  string  $output     Modified $input string
     */
    public function clean_input( $input, $safe_level = 0 ) {
        $output = $input;
        do {
            // Treat $input as buffer on each loop, faster than new var
            $input = $output;
            
            // Remove unwanted tags
            $output = $this->strip_tags( $input );
            $output = $this->strip_encoded_entities( $output );
            // Use 2nd input param if not empty or '0'
            if ( $safe_level !== 0 ) {
                $output = $this->strip_base64( $output );
            }
        } while ( $output !== $input );
        return $output;
    }
    /*
     * Focuses on stripping encoded entities
     * *** This appears to be why people use this sample code. Unclear how well Kses does this ***
     *
     * @param   string  $input  Content to be cleaned. It MAY be modified in output
     * @return  string  $input  Modified $input string
     */
    private function strip_encoded_entities( $input ) {
        // Fix &entity\n;
        $input = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $input);
        $input = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $input);
        $input = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $input);
        $input = html_entity_decode($input, ENT_COMPAT, 'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $input = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+[>\b]?#iu', '$1>', $input);
        // Remove javascript: and vbscript: protocols
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $input);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $input);
        return $input;
    }
    /*
     * Focuses on stripping unencoded HTML tags & namespaces
     *
     * @param   string  $input  Content to be cleaned. It MAY be modified in output
     * @return  string  $input  Modified $input string
     */
    private function strip_tags( $input ) {
        // Remove tags
        $input = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $input);
        // Remove namespaced elements
        $input = preg_replace('#</*\w+:\w[^>]*+>#i', '', $input);
        return $input;
    }
    /*
     * Focuses on stripping entities from Base64 encoded strings
     *
     * NOT ENABLED by default!
     * To enable 2nd param of clean_input() can be set to anything other than 0 or '0':
     * ie: xssClean->clean_input( $input_string, 1 )
     *
     * @param   string  $input      Maybe Base64 encoded string
     * @return  string  $output     Modified & re-encoded $input string
     */
    private function strip_base64( $input ) {
        $decoded = base64_decode( $input );
        $decoded = $this->strip_tags( $decoded );
        $decoded = $this->strip_encoded_entities( $decoded );
        $output = base64_encode( $decoded );
        return $output;
    }
}


//============================= functions ================================//

//get user list

function userList(){
$host = 'localhost';
$username = 'galaxynina';
$password = 'galaxynina';
	
		try{
$connect = new PDO("mysql:host=$host;dbname=galaxynina;charset=utf8", $username, $password,
array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare and bind
 $getUsers = $connect->prepare("SELECT name,planet,time_stamp FROM users ");
$getUsers->execute();
$users = $getUsers->fetchAll();

  	if(!empty($users)){
  		
  			
			echo json_encode(array("users"=>$users));
  		
  		
	
	
  	}else{
  		echo json_encode(array("users"=>'none'));
  	}
	


}catch(PDOException $e){
    die('Error connecting to database: '.$e);
}
	$conn = null;
	
}


//register function 

function register($name,$passwordr,$planet){
$host = 'localhost';
$username = 'galaxynina';
$password = 'galaxynina';

	$clean = new xssClean();
	$name= $clean->clean_input($name);
	$passwordr = $clean->clean_input($passwordr);
	$planet = $clean->clean_input($planet);
	
	if($name == 'president'){
		
		$_SESSION['wrongName'] = 'wrong name';
		 header('Location: http://tobolkin.com/#page3');
	   exit();
	}else{
	
	try{
$connect = new PDO("mysql:host=$host;dbname=galaxynina;charset=utf8", $username, $password,
array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare and bind
 $stmt = $connect->prepare("INSERT INTO users (name, password, planet) 
    VALUES (:firstname, :lastname, :email)");
    $stmt->bindParam(':firstname', $name);
    $stmt->bindParam(':lastname', $passwordr);
    $stmt->bindParam(':email', $planet);
	$stmt->execute();

}catch(PDOException $e){
    die('Error connecting to database: '.$e);
}
	$conn = null;
$_SESSION['alian'] = 'alian';
	  header('Location: http://tobolkin.com/view/alian/earth.php');
	   exit();
}
}

//login function
function getIn ($name, $passwordl){
	$clean = new xssClean();
	$name = $clean->clean_input($name);
	$passwordl = $clean->clean_input($passwordl);
	   
   if($name == 'president' && $passwordl == 'cool'){
   	session_unset($_SESSION['error']); 
   	session_unset($_SESSION['alian']); 

	$_SESSION['president'] = 'president';
	   
	   header('Location: http://tobolkin.com/view/president/dashboard.php');
	   exit();
   }else{
   	session_unset($_SESSION['president']); 
	session_unset($_SESSION['error']); 
$host = 'localhost';
$username = 'galaxynina';
$password = 'galaxynina';

	try{
$connect = new PDO("mysql:host=$host;dbname=galaxynina;charset=utf8", $username, $password,
array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare and bind
 $getUsers = $connect->prepare("SELECT name,password FROM users WHERE name = :name AND password = :password");
  $getUsers->bindParam(':name', $name);
    $getUsers->bindParam(':password', $passwordl);
$getUsers->execute();
$users = $getUsers->fetchAll();

  	if(!empty($users)){
  		
	$_SESSION['alian'] = 'alian';
	  header('Location: http://tobolkin.com/view/alian/earth.php');
	   exit();
	
  	}else{
  		$_SESSION['error'] = 'error';
		 header('Location: http://tobolkin.com/#page1');
	   exit();
  	}
	


}catch(PDOException $e){
    die('Error connecting to database: '.$e);
}
	$conn = null;


   }
	
	}
	










 
?>