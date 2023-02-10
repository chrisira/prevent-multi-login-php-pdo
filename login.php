<?php

include("db.php");
$message = "";
if(isset($_POST['login'])){
    $formdata = array();
    // validating the email address
    if(empty($_POST['email'])){
        $message .="<li>Email is required</li>";
    }
    else{
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $message .="<li>Invalid Email Address</li>";
        }
        else{
            $formdata['email'] = $_POST['email'];
        }
    }
    // validating the password

    if(empty($_POST['password'])){
        $message .="<li>Password is required</li>";
    }
    else{
        $formdata['password'] = $_POST['password'];
    }
    
    // when all validation tests are passed...

    if($message ==''){
        $data = array(
            ':email'  => $formdata['email']
        );

        $query = "SELECT * FROM users WHERE email = :email";

        $statement = $connection->prepare($query);
        $statement->execute($data);
        $rows = $statement->fetchAll();

        if($statement->rowCount() > 0){
            foreach($rows as $row){
                $row_pass = $row['password'];
                $user_id = $row['id'];
                if($row_pass == $formdata['password']){
                    //starting the session
                    session_start();
                    // regenerating the new session id
                    session_regenerate_id();
                    $user_session_id = session_id();

                    //updating database for new session id
                    $query = "
                    UPDATE users
                    SET user_session_id = '".$user_session_id."' 
                    WHERE id = '".$row['id']."'
                    ";

                    $connection->query($query);
                    //storing user data in session
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_session_id'] = $user_session_id;

                    // redirecting the user to the home page

                    header('location:home.php');

                }
                else{
                    $message .="<li>Wrong Password</li>";
                }
            }

        }
        else{
            $message .="<li>Wrong Email Address</li>";

        }


    }



}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                
                
                <div class="m-3">
                    <strong><h5>Please Login to Continue</h5></strong>
                    <br>
                    <?php
                // displaying error message if it exists
                if($message !=""){
                    echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
                }

                ?>

                </div>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="enter your email">

                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="enter your Password">

                </div>
                <div class="mb-3">
                   <button class="btn btn-primary" name="login">Login</button>
                </div>
            </form>

            </div>

        </div>
    </div>
    
</body>
</html>