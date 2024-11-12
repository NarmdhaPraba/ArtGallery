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
    <div class="row" style="height: 100%;">

        <div class="col-2">
            <img src="images/pro_background.jpg" alt="" style="height: 100%; width: 230px; position: absolute;">
            <img src="images/user.jpg" alt="" width="300px" style="position: absolute; margin-left: 75px; margin-top: 100px; border: 2px solid #5e0a04e3; border-radius: 100%; padding: 10px;">
        </div>
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $collection = $db->users;
                        $cursor = $collection->find(["_id" => new MongoDB\BSON\ObjectID($id)]);
                        foreach ($cursor as $cursors) {
                            $email = $cursors['Email'];
                            $user = $cursors['UserName'];
                        }
                        if (isset($_POST['submit'])) {


                            $collection = $db->users;
                            $email = $_POST['email'];
                            $username = $_POST['username'];
                            $password = md5($_POST['password']);
                            $collection->updateOne(
                                ['_id' => new MongoDB\BSON\ObjectID($id)],

                                ['$set' => [
                                    'Email' => "$email",
                                    'UserName' => "$username",
                                    'Password' => "$password"
                                ]]
                            );
                    ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong> Profile Details Updated successfully</strong>
                                <?php echo "<meta http-equiv='refresh' content='0.6'>"; ?>
                                
                            </div>
                        <?php
                        }
                        ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control " value="<?php echo $user; ?>" required>
                            </div>
                            <div class="form-group">
                                <span class="input-icon">
                                    <label>Password</label>
                                    <input type="password" class="form-control " name="password" ; placeholder="New Password">

                                    <div class="card-footer ">
                                        <div class="row">
                                            <div class="col"></div>
                                            <div class="col-auto">
                                                <button type="submit" name="submit" class="btn btn-success ">Update</button>
                                                <a href="dashboard.php" class="btn btn-warning ">Cancel</a>
                                            </div>
                                        </div>

                                    </div>
                        </form>
                    <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>
    <div class="card-footer "> <?php include_once('footer.php') ?></div>
    <!-- Blocking Resubmission on Reload -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>