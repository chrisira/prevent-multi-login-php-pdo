<?php
//checking if session started if not start it
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(!isset($_SESSION['user_session_id'])){
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Home </title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto m-3">
            <h1>Welcome Home!</h1>
                <div class="m-3">
                    <a class="btn btn-danger" href="logout.php">logout</a>
                    <?php

                    print_r($_SESSION);

                    ?>


                </div>
            </div>

        </div>

    </div>
    <script>
        function check_session_id(){
            let session_id = "<?php echo $_SESSION['user_session_id'];?>"
            fetch('check_login.php').then(function(response){
                return response.json();
            }).then(function(responseData){

                if(responseData.output == 'logout'){
                    window.location.href="logout.php";
                }

            });

              }

              // calling the function on regular interval
              setInterval(function(){
                check_session_id();

              },10000);
    </script>
</body>
</html>