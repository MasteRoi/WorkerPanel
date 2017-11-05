<html>
	<head>
	<link rel="stylesheet" href="style/form.css" type="text/css"/>
	<title>Add Worker</title>
		<script>
		function goBack() {
			window.history.back();
		}
		</script> 
	</head>
	<body>

<?php

/*
		This is the update worker details page
*/

require_once('../mysqli_connect.php');

$wrk_id = $_GET['id'];

$query = "SELECT first_name, last_name, email, street, city, state, zip,
phone, birth_date, sex, lunch_cost, unilink FROM workers WHERE worker_id=$wrk_id";


$response = @mysqli_query($dbc, $query);

if($response){

	while ($row = mysqli_fetch_array($response)){
		
		// Put all the current details in their fields
		
		echo '<div class="form-style-6"><form class="form-style-9" action="updatedwrk.php" method="POST">';
		echo '<h1>Edit Worker</h1>';
		echo '<p>First Name:
		<input type="text" name="first_name" size=30 value="' . $row['first_name'] . '"/></p>' . 
		'<p>Last Name:
		<input type="text" name="last_name" size=30 value="' . $row['last_name'] . '"/></p>' . 
		'<p>Email:
		<input type="text" name="email" size=30 value="' . $row['email'] . '"/></p>' .
		'<p>Street:
		<input type="text" name="street" size=30 value="' . $row['street'] . '"/></p>' .
		'<p>City:
		<input type="text" name="city" size=30 value="' . $row['city'] . '"/></p>' .
		'<p>State (2 Char):
		<input type="text" name="state" size=30 maxlength=2 value="' . $row['state'] . '"/></p>' .
		'<p>Zip Code:
		<input type="text" name="zip" size=30 maxlength=5 value="' . $row['zip'] . '"/></p>' .
		'<p>Phone Number:
		<input type="text" name="phone" size=30 value="' . $row['phone'] . '"/></p>' .
		'<p>Birth Date (YYYY-MM-DD):
		<input type="text" name="birth_date" size=30 value="' . $row['birth_date'] . '"/></p>' .
		'<p>Sex (M or F):
		<input type="text" name="sex" size=2 maxlength=1 value="' . $row['sex'] . '"/></p>' .
		'<p>Lunch Cost:
		<input type="text" name="lunch" size=30 maxlength=5 value="' . $row['lunch_cost'] . '"/></p>' .
		
		
		'<input type="hidden" name="wrk_id" value="'. $wrk_id .'">';
		
		echo '<a href="landing?uid='.$row['unilink'].'">Answer the worker poll</a> <br/>';

		echo '<ul><li><input type=submit name="submit" value="Update" />&nbsp;&nbsp;';
		echo '<input type=submit name="delete" value="Delete" />&nbsp;&nbsp;'.
			'<input type="button" onclick="goBack()" value="Go Back" /></li><ul></form></div>';
	}
} else {

echo "Couldn't issue database query<br />";

echo mysqli_error($dbc);

}

mysqli_close($dbc);


?>


