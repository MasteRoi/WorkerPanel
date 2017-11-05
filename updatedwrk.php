<?php

// This page is the engine for the edited worker

if(isset($_POST['submit'])){
	
	
	$data_missing = array();
	
	if (empty($_POST['first_name'])){
		
		//add name to array
		$data_missing[] = 'First Name';
 	} else {
		
		//trim white space from the name and store it
		$f_name = trim($_POST['first_name']);
		
	}
	
	if (empty($_POST['last_name'])){
		
		//add name to array
		$data_missing[] = 'Last Name';
 	} else {
		
		//trim white space from the name and store it
		$l_name = trim($_POST['last_name']);
		
	}
	
	if (empty($_POST['email'])){
		
		//add email to array
		$data_missing[] = 'Email';
 	} else {
		
		//trim white space from the name and store it
		$email = trim($_POST['email']);
		
	}
	
	if (empty($_POST['street'])){
		
		//add street to array
		$data_missing[] = 'Street';
 	} else {
		
		//trim white space from the name and store it
		$street = trim($_POST['street']);
		
	}
	
	if (empty($_POST['city'])){
		
		//add city to array
		$data_missing[] = 'City';
 	} else {
		
		//trim white space from the name and store it
		$city = trim($_POST['city']);
		
	}
	
	if (empty($_POST['state'])){
		
		//add state to array
		$data_missing[] = 'State';
 	} else {
		
		//trim white space from the name and store it
		$state = trim($_POST['state']);
		
	}
	
	if (empty($_POST['zip'])){
		
		//add zip to array
		$data_missing[] = 'Zip';
 	} else {
		
		//trim white space from the name and store it
		$zip = trim($_POST['zip']);
		
	}
	
	if (empty($_POST['phone'])){
		
		//add phone to array
		$data_missing[] = 'Phone';
 	} else {
		
		//trim white space from the name and store it
		$phone = trim($_POST['phone']);
		
	}
	
	if (empty($_POST['birth_date'])){
		
		//add Birth Date to array
		$data_missing[] = 'Birth Date';
 	} else {
		
		//trim white space from the name and store it
		$b_date = trim($_POST['birth_date']);
		
	}
	
	if (empty($_POST['sex'])){
		
		//add sex to array
		$data_missing[] = 'Sex';
 	} else {
		
		//trim white space from the name and store it
		$sex = trim($_POST['sex']);
		
	}
	
	if (empty($_POST['lunch'])){
		
		//add lunch to array
		$data_missing[] = 'lunch';
 	} else {
		
		//trim white space from the name and store it
		$lunch = trim($_POST['lunch']);
		
	}
	
	
	if (empty($data_missing)){
		
		$wrk_id = $_POST['wrk_id'];
		
		require_once('../mysqli_connect.php');
		
		$query = "UPDATE workers SET first_name='$f_name', last_name='$l_name', email='$email', 
		street='$street', city='$city', state='$state', zip='$zip', phone='$phone', birth_date='$b_date', sex='$sex', lunch_cost='$lunch' WHERE worker_id = '$wrk_id' ";
		if (mysqli_query($dbc, $query)) {
			
			echo "Record " . $wrk_id . "updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($dbc);
		}

		mysqli_close($dbc);

		
	} else {
		
		echo 'You need to enter the following data <br />';
		
		foreach($data_missing as $missing){
			
			echo "$missing<br />";
			
		}
		
	}
	
}


// Delete section

if(isset($_POST['delete'])){
	
	$wrk_id = $_POST['wrk_id'];
	require_once('../mysqli_connect.php');
	
	
	$query = "DELETE FROM workers WHERE worker_id = '$wrk_id' ";

	if (mysqli_query($dbc, $query)) {
		echo "Record deleted successfully";
		
	} else {
		echo "Error deleting record: " . mysqli_error($dbc);
	}
	
	mysqli_close($dbc);
}


// Delete from checkbox

if (isset($_REQUEST['delete'])){
	if($_REQUEST['delete'] != ''){
		if(!empty($_POST['checkwrk'])){
			$checked_values = $_POST['checkwrk'];
			foreach($checked_values as $val) {
				$query = "DELETE FROM workers WHERE worker_id = '$wrk_id' ";
			   mysql_query($query);

			}
		}
	} 
}

	header('Location: getworkerinfo.php');

?>