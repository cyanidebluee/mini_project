<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visa Apply</title>
    <link rel="stylesheet" type="text/css" href="paper.css"/>
</head>
<body>

<?php

require_once('Connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


if (isset($_POST['submit'])) {



    $passport_office = mysqli_real_escape_string($conn, trim($_POST['office']));

    $given_name = mysqli_real_escape_string($conn, trim($_POST['given_name']));

    $surname = mysqli_real_escape_string($conn, trim($_POST['surname']));

    $date_of_birth = mysqli_real_escape_string($conn, trim($_POST['dob']));

    $email_id = mysqli_real_escape_string($conn, trim($_POST['email']));

    $login_id = mysqli_real_escape_string($conn, trim($_POST['passport_no']));

    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    $conf_password = mysqli_real_escape_string($conn, trim($_POST['conf_password']));

    $hint_question = mysqli_real_escape_string($conn, trim($_POST['hint_question']));

    $hint_answer = mysqli_real_escape_string($conn, trim($_POST['hint_answer']));

    $date_time = date('H:i:s');
    $date_day = date('Y-m-d');



    echo "$passport_office";
    echo "$given_name";

    if (!empty($passport_office) and !empty($given_name) and !empty($surname) and !empty($date_of_birth) and !empty($email_id) and !empty($password) and !empty($hint_question) and !empty($hint_answer) and ($password == $conf_password)){



        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";

       $check="SELECT * FROM Registration WHERE Passport_id='$login_id'";
       $data=mysqli_query($conn,$check);

       if (mysqli_num_rows($data)==0) {

           $sql = "INSERT INTO Registration (Join_date,Join_time,Passport_office,Given_name,Surname,Date_of_birth,Email_id,Passport_id,Password,Hint_question,Hint_answer) VALUES ('$date_day','$date_time','$passport_office','$given_name','$surname','2017-10-12','$email_id','$login_id',SHA('$password'),'$hint_question','$hint_answer')";

           if ($conn->query($sql) === TRUE) {
               echo "New record created successfully";
           } else {
               echo "Error: " . $sql . "<br>" . $conn->error;
           }

           // Confirm success with the user
           echo '<p>Your new account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';

           mysqli_close($conn);

           exit();

       }
       else {
           // An account already exists for this username, so display an error message
           echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
           $login_id = "";
       }


    }
    else {
        echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
}

mysqli_close($conn);
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">


        <fieldset>
            <legend>Registration</legend>
            <label for="given_office">Given Ofiice =</label>
            <select id="given_office" name="office">
                <option>-Select-</option>
                <option value="Chennai">Chennai</option>
                <option value="Delhi">Delhi</option>
                <option value="Mumbai">Mumbai</option>
                <option value="Kolkata">Kolkata</option>
                <option value="Banglore">Banglore</option>
            </select><br>

            <label for="given_name">Given name =</label>
            <input type="text" id="given_name" name="given_name"
                   value="<?php if (!empty($given_name)) echo $given_name; ?>"><br>

            <label for="surname">Surname =</label>
            <input type="text" id="surname" name="surname" value="<?php if (!empty($surname)) echo $surname; ?>"><br>

            <label for="date_of_birth">Date of Birth =</label>
            <input type="date" id="date_of_birth" name="dob"><br>

            <label for="email_id">Email id =</label>
            <input type="email" id="email_id" name="email" value="<?php if (!empty($email_id)) echo $email_id; ?>"><br>

            <label for="login_id">login id =</label>
            <input type="text" id="login_id" name="passport_no" value="<?php if (!empty($login_id)) echo $login_id; ?>"><br>

            <label for="password">password =</label>
            <input type="password" id="password" name="password"><br>

            <label for="conf_password">Retype Password</label>
            <input type="password" id="conf_password" name="conf_password"><br>

            <label for="hint_question">Hint Question =</label>
            <select name="hint_question" id="hint_question">
                <option>-----Select-----</option>
                <option value="Birth City">Birth city</option>
                <option value="Favourite Colour">Favourite colour</option>
                <option value="Favourite Cricketer">Favourite Cricketer</option>
                <option value="Favourite Food">Favourite Food</option>
                <option value="First Colour">First colour</option>
                <option value="Make of First car Owned">Make of first car owned</option>
                <option value="Mother's Maiden Name">Mother's maiden name</option>
            </select><br>

            <label for="hint_answer">Hint Answer =</label>
            <textarea name="hint_answer" id="hint_answer" rows="5" cols="30"></textarea><br>

            <input type="submit" name="submit">

        </fieldset>


    </form>





</body>
</html>
