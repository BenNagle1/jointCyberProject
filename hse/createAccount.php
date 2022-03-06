<?php
include "db.inc.php";
extract($_POST);
session_start();

$key = 'thebestsecretkey';

function encrypt($input, $key) {
$encryption_key = base64_decode($key);
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
$encrypted = openssl_encrypt($input, 'aes-128-cbc', $encryption_key, 0, $iv);
return base64_encode($encrypted . '::' . $iv);
}

$username = "";
$password = "";
$confirm_Password = "";
$username_err =  "";
$phone_err = "";
$password_err = "";
$fullname = "";
$address1 = ""; 
$address2 = "";
$town = "";
$county = "";
$phone = "";
$dob = "";
$error = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$confirm_Password = mysqli_real_escape_string($db, $_POST['confirmpassword']);
	$fullname = mysqli_real_escape_string($db, $_POST['fullname']);
	$address1 = mysqli_real_escape_string($db, $_POST['address1']);
	$address2 = mysqli_real_escape_string($db, $_POST['address2']);
	$town = mysqli_real_escape_string($db, $_POST['town']);
	$county = mysqli_real_escape_string($db, $_POST['county']);
	$phone = mysqli_real_escape_string($db, $_POST['phone']);
	$dob = mysqli_real_escape_string($db, $_POST['birthday']);
	
	//ensure that username does not already exist in database 
    $user_validate = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($db, $user_validate);
    $user_check = mysqli_fetch_assoc($result);
	 
    if($user_check){
      if ($user_check['username'] === $username) {
		  $error = true;
		  $username_err = "Username already exists in our records"; 
    } 
	  
	}

    if(strlen($password) < 8){
		$error = true;
        $password_err = "Password must have atleast 8 characters.";
    } 
    
    
    if($password != $confirm_Password) {
    $password_err = "Password and Confirm Password doesn't match";
}

$encrypted_username=encrypt($username, $key);
$encrypted_password=encrypt($password, $key);
$encrypted_fullname=encrypt($fullname, $key);
$encrypted_address1=encrypt($address1, $key);
$encrypted_address2=encrypt($address2, $key);
$encrypted_town=encrypt($town, $key);
$encrypted_county=encrypt($county, $key);
$encrypted_phone=encrypt($phone, $key);
$encrypted_dob=encrypt($dob, $key);
    
    if(!$error){
        
       
        $sql_query = "INSERT INTO users (username, password, fullname, address1, address2, town, county, phone, birthday) 
		VALUES ('$encrypted_username', '$encrypted_password', '$encrypted_fullname ', '$encrypted_address1', '$encrypted_address2', '$encrypted_town', '$encrypted_county', '$encrypted_phone', '$encrypted_dob')";
		//mysqli_query($db, $sql_query)or die("Could Not Perform the Query");
		
		if ($db->query($sql_query) === TRUE){
			 header("location: menu.php");
		}
		
	}


        mysqli_close($db);
}


?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HSE - Register</title>
    <style>
        body{ font: 16px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<form action = "createAccount.php" method = "POST">

    <div class="wrapper">
        <h2>HSE COVID-19 Anitgen Test Portal</h2>
        <fieldset>
		<legend>Register your Account</legend>
		<label for="Username">Username:</label>
		<input type="text" name="username" id="username" required placeholder="Enter a username" title="Please enter a username"/><br>
		<label for="Password">Password:</label>
		<input type="text" name="password" id="password" required placeholder="Enter a password" title="Please enter a password"/><br>
		<label for="ConfirmPassword">Confirm Password:</label>
		<input type="text" name="confirmpassword" id="confirmpassword" required placeholder="Enter a password" title="Please enter a password"/><br>
		</fieldset>
		
		<fieldset>
		<legend>Personal Details</legend>
		<label for="Fullname">Full Name:</label>
		<input type="text" name="fullname" id="fullname" required placeholder="Enter your full name" title="Please enter your full name"/><br>
		<label for="Address1">Address Line 1:</label>
		<input type="text" name="address1" id="address1" required placeholder="Enter an address" title="Please enter your address (ie. Street)"/><br>
		<label for="Address2">Address Line 2:</label>
		<input type="text" name="address2" id="address2" required placeholder="Enter an address" title="Please enter your address (ie. Street)"/><br>
		<label for="Town">Town:</label>
		<input type="text" name="town" id="town" required placeholder="Enter an address" title="Please enter your address (ie. Street)"/><br>
		<label for="County">County:</label>
		<input type="text" name="county" id="county" required placeholder="Enter an address" title="Please enter your address (ie. Street)"/><br>
		<label for="Phone">Phone:</label>
		<input type="tel" id="phone" name="phone" required pattern="{0-9}{0-9}{0-9}-{0-9}{0-9}{0-9}-{0-9}{0-9}{0-9}{0-9}" placeholder="000 000 0000" title="Please enter a valid Irish phone number"><br>
		<label for="birthday">Enter your date of birth:</label>
		<input type="date" required id="birthday" name="birthday"><br>
		</fieldset>
		
	</div>
	
	<input type="submit" value = "Submit"/>
    <input type="reset" value = "Clear"/>
    <p>Already have an account? <a href="loginScreen.php">Login here</a>.</p>
     </form>
    </div>    
</body>
</html>