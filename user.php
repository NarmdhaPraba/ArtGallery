<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
}
?>
<?php include_once('script.php') ?>
<?php include_once('Connect.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <?php include_once('menu.php') ?>
    <?php

    $collection = $db->users;
    $cursor = $collection->find(["Email" => $_SESSION['email']]);
    foreach ($cursor as $cursors) {
        if ($cursors['Type'] == "Superadmin") {
    ?>
            <br>
            <div class="container">
                <div class="row">

                    <div class="col-md-1"></div>
                    <div class="col-md-10">

                        <?php
                        $email = null;
                        $user = null;
                        $new = null;
                        //delete start
                        if (isset($_GET['delete'])) {
                            $id = $_GET['delete'];
                            $collection = $db->users;
                            $collection->deleteOne(["_id" => new MongoDB\BSON\ObjectID($id)]);
                            echo "User deleted successfully";
                        }
                        //delete end 
                        if (isset($_GET['reset'])) {
                            $id = $_GET['reset'];
                            $collection = $db->users;
                            $collection->updateOne(
                                ['_id' => new MongoDB\BSON\ObjectID($id)],

                                ['$set' => [
                                    'Password' => md5("1234"),
                                ]]
                            );
                            echo"Password Updated successfully";
                        ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong> Password Updated successfully</strong>
                                <?php
                                header("Location: login.php");
                                exit();
                                ?>
                            </div>
                            <?php

                        }

                        // edit start
                        if (isset($_GET['edit'])) {
                            $id = $_GET['edit'];
                            $collection = $db->users;
                            $cursor = $collection->find(["_id" => new MongoDB\BSON\ObjectID($id)]);
                            foreach ($cursor as $cursors) {
                                $email = $cursors['Email'];
                                $user = $cursors['UserName'];
                                $new = "new";
                            }


                            if (isset($_POST['save'])) {


                                $collection = $db->users;
                                $email = $_POST['email'];
                                $username = $_POST['username'];
                                $collection->updateOne(
                                    ['_id' => new MongoDB\BSON\ObjectID($id)],

                                    ['$set' => [
                                        'Email' => "$email",
                                        'UserName' => "$username"
                                    ]]
                                );
                            ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong> Details Updated successfully</strong>
                                    <?php echo "<meta http-equiv='refresh' content='0.6'>"; ?>
                                </div>
                            <?php

                            }
                        }
                        // edit end 



                        // insert  start
                        if (isset($_POST['submit'])) {
                            $collection = $db->users;
                            $email = $_POST['email'];
                            $username = $_POST['username'];
                            $password = md5($_POST['password']);
                            $document = array(
                                "Email" => "$email",
                                "UserName" => "$username",
                                "Password" => "$password",
                                "Type" => "user"
                            );
                            $collection->insertOne($document);
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong> Details Inserted successfully</strong>
                                <?php echo "<meta http-equiv='refresh' content='0.6'>"; ?>
                            </div>
                        <?php
                        }
                        //  insert finish 
                        // if (isset($_POST['new']) || $new == "new") {
                        // ?>
                        //     <div class="card mb-3">
                        //         <div class="card-header">New Users</div>
                        //         <div class="card-body ">

                        //             <form action="" method="POST">
                        //                 <div class="form-group">
                        //                     <label>Email</label>
                        //                     <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                        //                 </div>
                        //                 <div class="form-group">
                        //                     <label>User Name</label>
                        //                     <input type="text" name="username" class="form-control " value="<?php echo $user; ?>" required>
                        //                 </div>
                        //                 <?php if (isset($_GET['edit'])) {
                        //                 } else {
                        //                 ?>
                        //                     <div class="form-group">
                        //                         <label>Password</label>
                        //                         <input type="password" name="password" class="form-control " required>
                        //                     </div>
                        //                 <?php
                        //                 }
                        //                 ?>

                        //         </div>
                                <div class="card-footer ">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-auto">
                                            <?php
                                            if (isset($_GET['edit'])) {
                                            ?>
                                                <button type="submit" name="save" class="btn btn-success ">Save
                                                </button> <a href="user.php" class="btn btn-warning ">Cancel</a>
                                            <?php
                                            } else {
                                            ?>
                                                <button type="submit" name="submit" class="btn btn-success ">Add
                                                </button> <a href="user.php" class="btn btn-warning ">Cancel</a>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    </form>


                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="card mb-3">
                                <div class="card-header " style="height: fit-content;">
                                    <div class="row">
                                        <div class="col text-center">
                                            <h5> Users </h5>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-auto">
                                            <form action="user.php" method="POST">
                                                <input type="submit" value="Add a New User" name="new" class="btn btn-primary btn-sm">
                                            </form>
                                        </div>
                                    </div>

                                    <table class="table">

                                        <thead>
                                            <tr>
                                                <th scope="col">Email</th>
                                                <th scope="col">Username</th>

                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $collection = $db->users;
                                            $cursor = $collection->find();
                                            foreach ($cursor as $document) {
                                                if ($document["Type"] != "Superadmin") {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $document["Email"]; ?></td>
                                                        <td><?php echo $document["UserName"]; ?></td>

                                                        <td>
                                                            <div class="row">
                                                                <div class="col"></div>
                                                                <div class="col-auto">
                                                                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                                                        <a href="?reset=<?php echo $document["_id"]; ?>" style="color: white;" class="btn btn-sm btn-success">Reset
                                                                            Password</a>
                                                                        <a href="user.php?edit=<?php echo $document["_id"]; ?>" class=" btn btn-sm" style="background-color: #ffaa00 ;"><img src="https://img.icons8.com/pastel-glyph/15/000000/edit--v2.png" alt="Edit"/>
                                                                        </a>
                                                                        <a href="?delete=<?php echo $document["_id"]; ?>" class=" btn btn-danger btn-sm"><img src="https://img.icons8.com/material-sharp/15/000000/delete-forever.png" alt="Delete" />
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </div>
                </div>
            </div>

    <?php
        } else {
            echo '<script>alert("Sorry , You are not permitted to Access in this Method")</script>';
        }
    }
    ?>
    <?php include_once('footer.php') ?>
    <!-- Blocking Resubmission on Reload -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>