<html>
	<head>
	<link rel="stylesheet" href="style/form.css" type="text/css"/>
	<title>Add Worker</title>
		<script>
		// This is Some JS script for the form submit

		function goBack() {
			window.history.back();
		}
		
		function submitCheck(){
			document.submit();
		}
		
		function test1(){

			// This function validate that the form is filled up in every single field
			// and notify for the missing field

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
						<input type="button" onclick="goBack()" value="Go Back" />						
					</li>
				
				
				
					
			</form>
		</div>



	</body>
</html>