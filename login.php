<?php include_once('script.php') ?>
<?php include_once('Connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background: url('img/login_back_ground.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .card {
            margin-top: 50px;
            padding-top: 20px;
        }

        .card-body {
            padding-right: 40px;
            padding-left: 40px;
        }

        .btn {
            padding-left: 20px;
            padding-right: 20px;
        }

        a {
            color: white;
        }

        a:hover {
            color: yellow;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg " style="background-color: #5e0a04; color: white;">
        <a class="navbar-brand" href="index.php">&nbsp; ART GALLERY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php" style="background-color: yellow; color: #5e0a04;border-radius: 10px; padding-left: 15px; padding-right: 15px;">Go Back
                         <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card" style="background-color: rgba(0, 0, 0, 0.671); color: white;">
                    <div class="card-header text-center">Welcome to Art Gallery </div>

                    <div class="card-body">
                        <?php
                        if (isset($_POST['signin'])) {
                            $email = $_POST['email'];
                            $password = md5($_POST['password']);
                            $collection = $db->users;
                            $cursor = $collection->find(["Email" => "$email"]);
                            $x = 0;
                            foreach ($cursor as $cursors) {


                                if ($password == $cursors['Password'] && $email = $cursors['Email']) {
                                    $_SESSION['email'] = $cursors['Email'];
                                    header("Location: dashboard.php");
                                } 
                                else {
                        ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Your password is wrong,Try Again</strong>
                                    </div>
                                <?php
                                }
                                $x++;
                            }
                                if ($x == 0) {
                                ?>
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <strong>Check Your Email Address,Try Again</strong>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        <form action="login.php" method="POST">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" name="password" id="pwd" required>
                            </div>

                            <div class="row">
                                <div class="col"></div>
                                <div class="col-auto"><button type="submit" name="signin" class="btn btn-success">Sign in</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><?php include_once('footer1.php') ?>
</body>

</html>