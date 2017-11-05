<html>
	<head>
		<title>Workers List</title>
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="style/global.css" type="text/css"/>
		<script src="http://malsup.github.com/jquery.form.js"></script> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>



</head>
<body>


<?PHP
// Require the db file settings

require_once('../mysqli_connect.php');



// Sorting the fetched table by one of the properties by Asc or Desc oreder

if (isset($_GET['order'])){
	$order = $_GET['order'];
}else{
	$order = 'worker_id';
}
if (isset($_GET['sort'])){
	$sort = $_GET['sort'];
}else{
	$sort = 'ASC';
}

// First Query

$query = "SELECT first_name, last_name, email, street, city, state, zip, phone, birth_date, worker_id, unilink FROM Workers ORDER BY $order $sort ";
$response = @mysqli_query($dbc, $query);

$result=mysqli_query($dbc,$query);

$count=mysqli_num_rows($result);



function sendSMS($phone, $f_name, $unilink){
	
	//This is a SMS function using a private API for sending SMS messagess
	$url = "sms-api-url";

	$xml = '<?xml version="1.0" encoding="UTF-8"?>  
			<sms>  
			<user>  
			<username>your username</username>  
			<password>your password</password>  
			</user>  
			<source>Sender</source>  
			<destinations>  
				<phone id="someid1">'.$phone.'</phone>    
			</destinations>  
			<message>Hey '.$f_name.', your registration has been successfully completed! You can Visit your Profile in the Following link: http://some-example-url/landing.php?uid='.$unilink.'</message>  
			</sms>'; 
			
			
			
	$CR = curl_init(); 
	curl_setopt($CR, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($CR, CURLOPT_URL, $url); 
	curl_setopt($CR, CURLOPT_POST, 1);  
	curl_setopt($CR, CURLOPT_FAILONERROR, true); 
	curl_setopt($CR, CURLOPT_POSTFIELDS, $xml); 
	curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($CR,CURLOPT_HTTPHEADER,array("charset=utf-8")); 
	 
	 
	$result = curl_exec($CR);  
	$error = curl_error ($CR); 
	 
	if(!empty( $error ))
		die("Error: ".$error); 
	else
		$response = new SimpleXMLElement($result); 

}

	
if ($response){

	$stdid = array();
	$sort =='DESC' ? $sort = 'ASC' : $sort = 'DESC';
	
// If there's response, let's create the table

echo '<div class="container">'.
	'<table class="responsive-table">'.
	'<caption>Worker List</caption>'.
	
	'<thead><tr>
		<th scope="col"><b>#</b></th>
		<th scope="col"><b><a href=?order=first_name&&sort='.$sort.' >First Name</a></b></th>'.
		'<th scope="col"><b><a href=?order=last_name&&sort='.$sort.'>Last Name</b></th>
		<th scope="col"><b><a href=?order=email&&sort='.$sort.'>Email</b></th>
		<th scope="col"><b><a href=?order=street&&sort='.$sort.'>Street</b></th>
		<th scope="col"><b><a href=?order=city&&sort='.$sort.'>City</b></th>
		<th scope="col"><b><a href=?order=state&&sort='.$sort.'>State</b></th>
		<th scope="col"><b><a href=?order=zip&&sort='.$sort.'>Zip</b></th>
		<th scope="col"><b><a href=?order=phone&&sort='.$sort.'>Phone</b></th>
		<th scope="col"><b><a href=?order=birth_date&&sort='.$sort.'>Birth Day</b></th>
		<th scope="col"><b><a href=?order=worker_id&&sort='.$sort.'>Id</b></th>
	</tr></thead>';
	
	echo '<tfoot><tr>'.
        '<td colspan="7">Created by Roi Sadika 2017</td></tr>'.
    '</tfoot>';
	
	

	
	while($row = @mysqli_fetch_array($response)){
		
		

		
		echo '<tr><td align="center"><form id="updateForm" method="post"><input type="checkbox" name="wrkrbox[]" value="'.$row['worker_id'].'" /></td><td align="left">' . 
		$row['first_name'] . '</td><td align="left">' .
		$row['last_name'] . '</td><td align="left">' .
		$row['email'] . '</td><td align="left">' .
		$row['street'] . '</td><td align="left">' .
		$row['city'] . '</td><td align="left">' .
		$row['state'] . '</td><td align="left">' .
		$row['zip'] . '</td><td align="left">' .
		$row['phone'] . '</td><td align="left">' .
		$row['birth_date'] . '</td><td align="left">';
		echo '<a href=update.php?id='.$row['worker_id'].' title="Edit '.$row['first_name'].' '. $row['last_name'].' details">'.$row['worker_id'] . '';
		echo '</tr>';
		
		
		
	}
	echo '</div></table>';
	
	echo '<div id="testBtn"><input type="submit"  class="redButton" name="clear1" id="clear1" value="Delete Selected Workers">'.
			'<input class="blueButton" name="sms" type="submit" id="sms" value="Invite poll by SMS"></form></td></tr>';
	echo '<form action="addworker.php"><input class="greenButton" type=submit align="buttom" value="Add a New Worker" /></p></form></div>';

	// Delete the checked workers from the table
	
	if(isset($_POST['clear1'])){
        $delete_id = (isset($_POST['wrkrbox']) ? $_POST['wrkrbox'] :null);
        $id = count($delete_id);
        if (count($id) > 0){
			if (is_array($delete_id) || is_object($delete_id)){
				foreach ($delete_id as $id_d){

					$query = "DELETE FROM `Workers` WHERE worker_id='$id_d'";
					if (mysqli_query($dbc, $query)) {
						echo "Worker with id ".$id_d." deleted.</br>";			
					} else {
						echo "Error deleting record: " . mysqli_error($dbc);
					}
					
					
				}

				
			}
        }
		usleep(150000); echo '<META HTTP-EQUIV="Refresh" Content="0; URL="getworkerinfo.php">';

      
    }
	
	// SMS send to selected workers by using the SMS function
	
	if(isset($_POST['sms'])){
		$sms_obj = (isset($_POST['wrkrbox']) ? $_POST['wrkrbox'] :null);
		$id = count($sms_obj);
		if (count($id) > 0){
			if (is_array($sms_obj) || is_object($sms_obj)){
				
				
				
				foreach ($sms_obj as $id_d){
					
					
					$query = "SELECT first_name, phone, unilink FROM Workers WHERE worker_id=".$id_d;

					if ($result = $mysqli->query($query)) {

						
						while ($obj = $result->fetch_object()) {
							$f_name = $obj->first_name;
							$phone = $obj->phone;
							$unilink = $obj->unilink;
							
							
						sendSMS($phone, $f_name, $unilink);	
						echo 'SMS sent to '.$f_name.', phone number: '.$phone.'</br>';	
							
						}

					
						$result->close();
					}


			
				}
				echo "</br>SMS proccess done successfully.";
			}
		}
	  
	}
	
	
} else {
	
	// If there's an error in query

	echo "Couldn't issue DB query <br />";
	
	echo mysqli_error($dbc);
	
}
mysqli_close($dbc);


echo '</body>';

echo '<script src="./scripts/main-script.js"></script>';
echo '</html>';


?>



