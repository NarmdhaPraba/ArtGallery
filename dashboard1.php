<?php include_once('script.php') ?>
<?php include_once('Connect.php') ?>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        a.angertag {
            text-decoration: none;
            color: white;
        }

        a.angertag:hover {
            text-decoration: underline;
        }

        .c1 {
            padding: 0;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body>

    
  

    <?php include_once('menu.php') ?>

    <?php include_once('footer1.php') ?>
</body>

</html>