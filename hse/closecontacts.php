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

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$fullname = mysqli_real_escape_string($db, $_POST['fullname']);
	$phone= mysqli_real_escape_string($db, $_POST['phone']);
	
$encrypted_fullname=encrypt($fullname, $key);
$encrypted_phone=encrypt($phone, $key);

$sql_query = "INSERT INTO closecontacts (fullname, phone) 
		VALUES ('$encrypted_fullname', '$encrypted_phone')";
mysqli_query($db, $sql_query)or die("Could Not Perform the Query");
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
<form action = "closecontacts.php" method = "POST">

    <div class="wrapper">
        <h2>HSE COVID-19 Anitgen Test Portal - Enter a close contact</h2>
       
		
		<label for="Username">Fullname:</label>
		<input type="text" name="fullname" id="fullname" required placeholder="Enter fullname" title="Please enter a username"/><br>
		<label for="Password">Phone Number:</label>
		<input type="text" name="phone" id="phone" required placeholder="Enter a phone number" title="Please enter a phone number"/><br>
			
	
	<input type="submit" value = "Submit"/>
    <input type="reset" value = "Clear"/>

     </form>
    </div>    
</body>
</html>