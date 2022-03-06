<?php 
include 'db.inc.php';
session_start();
$key = 'thebestsecretkey';
function encrypt($input, $key) {
$encryption_key = base64_decode($key);
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
$encrypted = openssl_encrypt($input, 'aes-128-cbc', $encryption_key, 0, $iv);
return base64_encode($encrypted . '::' . $iv);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $username = trim($_POST['username']);
      $password = trim($_POST['password']);
	  
	  $username_encrypted=encrypt($username, $key);
      $password_encrypted=encrypt($password, $key);
	  
	  
	  $sql = "SELECT ID FROM users WHERE username = '$username_encrypted' and password = '$password_encrypted'";
      $result = mysqli_query($db,$sql);
	  
	     if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['username'] === $username_encrypted && $row['password'] === $password_encrypted) {

                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];

                header("Location: menu.php");
            }
			else{
				echo "Password or Username is inncorrect or not stored in our records";
			}
		 }
}
                 
            		   
 
mysqli_close($db);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HSE - Log In</title>
    <style>
        body{ font: 16px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<form action = "loginScreen.php" method = "POST">

    <div class="wrapper">
        <h2>HSE COVID-19 Anitgen Test Portal</h2>
		<legend>Sign in to your Account</legend>
		<label for="Username">Username:</label>
		<input type="text" name="username" id="username" required placeholder="Enter a username" title="Please enter a username"/><br>
		<label for="Password">Password:</label>
		<input type="text" name="password" id="password" required placeholder="Enter a password" title="Please enter a password"/><br>
		
		<input type="submit" value = "Submit"/>
        <input type="reset" value = "Clear"/>
        <p>Don't have an account? <a href="createAccount.php">Creat Account here</a>.</p>
		
     </form>
    </div>    
</body>
</html>
