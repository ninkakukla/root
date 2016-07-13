<?php
session_start();
if(!$_POST['page']) die("0");

$page = (int)$_POST['page'];

if(file_exists('view/sketch/page_'.$page.'.php')){
	if(isset($_SESSION['empty']))session_unset($_SESSION['empty']);
	if(isset($_SESSION['error']))session_unset($_SESSION['error']);
	if(isset($_SESSION['wrongName']))session_unset($_SESSION['wrongName']);

	echo file_get_contents('view/sketch/page_'.$page.'.php');
}

else echo 'There is no such page!';
?>
