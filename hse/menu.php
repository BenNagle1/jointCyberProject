<?php
include 'db.inc.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HSE COVID 19 Antigen Test Portal</title>
    <style>
        body{ font: 11px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Upload Postive Antigen Test</a><br>
		<a href="closecontacts.php" class="btn btn-danger ml-3">Add Close Contacts</a><br>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out</a><br>
    </p>
</body>
</html>