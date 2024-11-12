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

    <script type='text/javascript'>
        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <style>
        #myInput {
            background-image: url('img/search.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }
    </style>

</head>

<body>
    <?php include_once('menu.php') ?>
    <br>
    <div class="container">
        <div class="row">

            <div class="col-md-1"></div>
            <div class="col-md-10">

                <!-- Insert Data -->
                <?php

                if (isset($_POST['submit'])) {
                    $collection = $db->arts;
                    $art = $_POST['Name'];
                    $description = $_POST['Description'];

                    $output_dir = "upload/";/* Path for file upload */
                    $RandomNum   = time();
                    $ImageName      = str_replace(' ', '-', strtolower($_FILES['image']['name'][0]));
                    $ImageType      = $_FILES['image']['type'][0];

                    $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                    $ImageExt       = str_replace('.', '', $ImageExt);
                    $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                    $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                    $ret[$NewImageName] = $output_dir . $NewImageName;

                    /* Try to create the directory if it does not exist */
                    if (!file_exists($output_dir)) {
                        @mkdir($output_dir, 0777);
                    }
                    move_uploaded_file($_FILES["image"]["tmp_name"][0], $output_dir . "/" . $NewImageName);

                    $document = array(
                        "Name" => "$art",
                        "Description" => "$description",
                        "image" => "$NewImageName",
                        
                    );
                    $collection->insertOne($document);
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> <?php echo $document["Name"]; ?> Added Successfully</strong>
                        <?php echo "<meta http-equiv='refresh' content='0.6'>"; ?>
                    </div>
                <?php
                }
                ?>
                <!-- // Insert Data -->

                <!-- Modify Data -->
                <?php
                $f_name = null;
                $image1 = null;
                $f_description = null;

                if (isset($_GET['edit'])) {
                    $id = $_GET['edit'];
                    $collection = $db->arts;
                    $food = $collection->find(["_id" => new MongoDB\BSON\ObjectID($id)]);
                    foreach ($art as $arts) {
                        $f_name = $arts['Name'];
                        $image1 = $arts['image'];
                        $f_description = $arts['Description'];
                    }
                }
                ?>
                <!-- // Modify Data -->

                <!-- Delete Data -->
                <?php
                if (isset($_GET['delete'])) {
                    $id = $_GET['delete'];
                    $collection = $db->arts;
                    $collection->deleteOne(["_id" => new MongoDB\BSON\ObjectID($id)]);

                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> <?php echo $document["Name"]; ?> Deleted Successfully</strong>
                    </div>
                <?php
                }
                ?>
                <!-- Delete Data -->

                <?php if (isset($_GET['new'])) {
                ?>
                    <div class="card mb-3">
                        <div class="card-header">New Arts</div>
                        <div class="card-body ">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">

                                        <div class="form-group">
                                            <label>Art Name</label>
                                            <input type="text" class="form-control" value="<?php echo $f_name; ?>" name="art" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" value="<?php echo $f_description; ?>" name="description" id="pwd" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image[]" id="pwd" accept="image/*" onchange="preview_image(event)" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <img <?php if (isset($_GET['edit'])) {
                                                ?> src="upload/<?php echo $image1; ?>" <?php
                                                                                    } ?> id="output_image" style="width: 100%;">
                                    </div>
                                </div>


                


                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col"></div>
                                <div class="col-auto">
                                    <?php if (isset($_GET['edit'])) {
                                    ?>
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="art.php" class="btn btn-warning ">Cancel</a>
                                </div>
                            <?php
                                    } else {
                            ?>
                                <button type="submit" name="submit" class="btn btn-success">Add Art</button>
                            </div>
                        <?php
                                    }
                        ?>
                        </div>
                        </form>
                    </div>
            </div>
        <?php
                } else {
        ?>
            <div class="card  mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-auto"><a href="?new" class="btn btn-success btn-sm">New Art</a></div>
                    </div>
                </div>
                <div class="card-body ">
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Arts..">

                    <table class="table" id="myTable">

                        <thead>
                            <tr>
                                <th>Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $collection = $db->arts;
                            $cursor = $collection->find();
                            foreach ($cursor as $document) {
                            ?>
                                <tr>
                                    <td><?php $image = $document["image"]; ?>
                                        <img src="upload/<?php echo $image; ?>" alt="Food Image" style="width: 50px; height: 50px;">
                                    </td>
                                    <td><?php echo $document["Name"]; ?></td>
                                    <td><?php echo $document["Description"]; ?></td>

                                    <td>
                                        <div class="row">
                                            <div class="col"></div>
                                            <div class="col-auto">
                                                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                                    <a href="food.php?edit=<?php echo $document["_id"]; ?>&new" class=" btn btn-sm" style="background-color: #ffaa00 ;"><img src="https://img.icons8.com/pastel-glyph/15/000000/edit--v2.png" alt="Edit" />
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

    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
    <!-- Blocking Resubmission on Reload -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <?php include_once('footer.php') ?>
</body>

</html>