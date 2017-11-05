<?php

/* 
	This is a mid page for showing the worker profile.
	it can be accessed by the 'unilink' into get.
	the syntax should by like this example:
	http://somehost/landing?uid=id59d127864c048
*/

require_once('../mysqli_connect.php');

$wrk_uid = $_GET['uid'];


$query = "SELECT first_name, last_name, email, street, city, state, zip,
phone, birth_date, sex, lunch_cost, unilink ,worker_id FROM workers WHERE unilink='$wrk_uid'";



$response = @mysqli_query($dbc, $query);

if($response){

	// Creating the Worker Card profile with an access to answering available polls
	
	while ($row = mysqli_fetch_array($response)){
		
		$wrk_id = $row['worker_id'];
		
		$row['sex']=='M' ? $gen = 'Male' : $gen = 'Female'; 
		
		echo '<h1>'.$row['first_name'].' '.$row['last_name'].'</h1>';
		
		echo '<form action="#" method="POST">';
		
		echo '<p><b>Contact Info:</b> '.$row['email'].' , '.$row['phone'].'</p>' . 
		 '<p><b>Address:</b> '.$row['street'].', '.$row['city'].': '.$row['state'].' '.$row['zip'].'</p>' .
		'<p><b>Birth Date: </b>'.$row['birth_date'].'<b>&nbsp;Gender :</b> '.$gen.'</p>'.
	
		'<p><b>Lunch Cost: </b>'.$row['lunch_cost'].
		'<p><b>Uniq ID: </b>'.$row['unilink'].
		
		'<input type="hidden" name="wrk_id" value="'. $wrk_id .'">';
		
	
		echo '<p><a href=update.php?id='.$wrk_id.'>Update</a>&nbsp;&nbsp;';
		echo '<input type=hidden name="null" value="null" /></p></form>';
		echo '<form action="getworkerinfo.php"><p><input type=submit align="buttom" value="Worker List" /></p></form>';
		
		
	}
} else {

echo "Couldn't issue database query<br />";

echo mysqli_error($dbc);

}

mysqli_close($dbc);




?>


<html>
<head>
<title>Worker Card</title>
</head>
<body>


	

	<form action="polls/index.php"  method="POST">
		<div class="poll-options">
		
		</div>
		<input type="submit" value="Answer Polls">
		<input type="hidden" name="wrk_id" value="<?php echo $wrk_id;?>">
	</form>



</body>
</html>