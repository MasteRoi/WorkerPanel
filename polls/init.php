<?php

// Session for the current worker to enter his poll page

if(!isset($_SESSION['user_id'])){ 
	session_start();
	if (isset($_POST['wrk_id'])){
		$_SESSION['user_id'] = $_POST['wrk_id'];
	}
} else{
	echo 'Error! You are not logged in.';
}


require('../../mysqli_connect.php');




?>