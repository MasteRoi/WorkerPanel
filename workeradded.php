<!--

	This is the page form for creating a new worker into the DB

-->
<html>
	<head>
	<link rel="stylesheet" href="style/form.css" type="text/css"/>
	<title>Add Worker</title>
		<script>
		function goBack() {
			window.history.back();
		}
		
		function submitCheck(){
			document.submit();
		}
		
		function test1(){
			var z=[];
			var elements = document.getElementsByClassName("field-style")
			for (var i = 0; i < elements.length; i++) {
				if (elements[i].value == ""){
					z.push(elements[i].placeholder);
				}
			}
			if (z.length > 0){
				alert('Please Fill the following items:\n\n' + z.join("\n"));

				return false;
			}else{
				return true;
			}
		}
		
		
		</script> 
	</head>
	<body>
		<div class="form-style-6">
			<form id="workerForm" class="form-style-9" action="workeradded.php" onsubmit="return test1()" method="POST">

				<h1>Add a New Worker</h1>
				
				<ul>
					<li>
						<input type="text" id="txtField1" name="first_name" class="field-style field-split align-left" placeholder="First Name"  value=""/> 

						<input type="text" id="txtField2" name="last_name" class="field-style field-split align-right" placeholder="Last Name"  value=""/> 
					</li>
				
					<li>
						<input type="text" id="txtField3" name="street" class="field-style field-split align-left" placeholder="Street" value=""/> 
					
						<input type="text" id="txtField4" name="city" class="field-style field-split align-right" placeholder="City" size=10 value=""/> 
					</li>

					<li>
						<input type="text" name="zip" class="field-style field-split align-right" placeholder="Zip (5 Digits)" maxlength=5 value=""/>
						<input type="text" name="state" class="field-style field-split align-left" placeholder="State (2 Char)" maxlength=2 size=2 value=""/> 
					</li>
				
				
					<li>
						 <input type="text" name="email" class="field-style field-full" placeholder="Email" value=""/> 
					</li>
				
					<li>
						<input type="text" name="phone" class="field-style field-sixth align-left" placeholder="Phone" size=30 value=""/>
						
						<input type="checkbox" name="sms_send" value="Yes" /><zz>SMS Notification?</zz>
					</li>
					
					<li>
						<input type="text" name="birth_date" class="field-style field-third align-left" placeholder="Birth Date (YYYY-MM-DD)" size=30 value=""/> 
						<input type="text" name="sex" class="field-style field-third align-center" placeholder="Gender (M or F)" maxlength=2 value=""/> 
						<input type="text" name="lunch" class="field-style field-third align-right" placeholder="Lunch Cost (Ex: 2.50)" value=""/> 
					</li>
				
					<li>
						<input type=submit name="submit" value="Send" />
						<input type="reset" name="reset1" value="Reset" />
						<input type="button" onclick="location.href='getworkerinfo.php';" value="Workers List" />						
					</li>

			</form>
		</div>
	</body>
</html>


<?PHP

// Include the main file for calling the SMS function

include 'getworkerinfo.php';


// NEED TO FIX THE MISSIN DATA FORM!!!!

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
	
	// Generate the uniq id for the worker
	
	$uniq_id = uniqid('id','0'); 
	
	if (empty($data_missing)){
		
		$sms_val = '';
		if(isset($_POST['sms_send']) && $_POST['sms_send'] == 'Yes') {
			sendSMS($phone, $f_name, $uniq_id);
			$sms_val = 'SMS Sent to phone number: '.$phone.'</h3>';
		} else {
			$sms_val =  'SMS not sent.</h3>';
		}	
		
		require_once('../mysqli_connect.php');
		
		$query = "INSERT INTO workers (first_name, last_name, email, 
		street, city, state, zip, phone, birth_date, sex, date_entered, 
		lunch_cost, worker_id, unilink) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, NULL, ?)";

		$stmt = @mysqli_prepare($dbc, $query);
		
		mysqli_stmt_bind_param($stmt, "ssssssisssds", $f_name,
								$l_name, $email, $street, $city, 
								$state, $zip, $phone, $b_date,
								$sex, $lunch, $uniq_id);
								
		mysqli_stmt_execute($stmt);
		
		$affected_rows = mysqli_stmt_affected_rows($stmt);
		
		if ($affected_rows == 1){
			
			echo "<h3>Worker '".$f_name." ".$l_name."' Entered. ".$sms_val;
			
			mysqli_stmt_close($stmt);
			
			mysqli_close($dbc);
			
		} else {
			
			echo "Error Occurred<br />";
			echo mysqli_error($dbc);
			
			mysqli_stmt_close($stmt);
			
			mysqli_close($dbc);
			
		}
		
	} else {
		
		echo 'You need to enter the following data <br />';
		
		foreach($data_missing as $missing){
			
			echo "$missing<br />";
			
		}
		
	}
	
}

?>
