<?php
require_once('Connect.php');

//Create and clear the error message
$error_message="";


// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";


//Check if the user has no active session
if (!isset($_COOKIE['user_id']) and isset($_POST['submit'])) {

    //Grab the username and password
    $user_name = mysqli_real_escape_string($conn, trim($_POST['login_id']));

    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (!empty($user_name) and !empty($password)) {

        $check = "SELECT Passport_id , Given_name FROM Registration WHERE Passport_id='$user_name' AND Password=SHA('$password')";

        $data = mysqli_query($conn, $check);

        if (mysqli_num_rows($data) == 1) {
            $row = mysqli_fetch_array($data);
            setcookie('user_id', $row['Passport_id']);
            setcookie('username', $row['Given_name']);
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
            header('Location: ' . $home_url);
        } else {
            $error_message = 'Sorry, you must enter a valid Username and Password';
        }

    } else {
        $error_message = 'Sorry username and password must be entered';
    }

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="paper.css">
</head>
<body>

<?php

//If the cookie is empty show error message or continue
if (empty($_COOKIE['user_id'])) {
    echo '<p class="error">' . $error_message . '</p>';


?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

   <fieldset>
       <legend>Log in</legend>

       <label for="username">Username</label>
       <input type="text" id="username" name="login_id" value="<?php if (!empty($user_name)) echo $user_name; ?>"><br>

       <label for="Password">Password</label>
       <input type="password" id="Password" name="password"><br>

       <input type="submit" name="submit">
   </fieldset>

</form>

<?php

}

else {
    //Confirm successful login
    echo('<p class="login"> You are logged in as' . $_COOKIE['username'] . '.</p>');
}

?>


</body>

</html>
