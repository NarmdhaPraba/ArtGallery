<style>
    a.menu:hover {
        background-color: yellow;
        border-radius: 5px;
    }

    a {
        color: white;
    }
    
</style>
<?php

if (isset($_GET['logout']) ) {
    unset($_SESSION['email']);
    header('Location: index.php');
}
?>
<div id="app">
    <nav class="navbar navbar-expand-md  shadow-sm" style="background-color: #5e0a04; color: white;">

        <a class="navbar-brand " href="index.php">
            Art Gallery
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">


            </ul>


            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link menu" href="dashboard.php"> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu" href="about1.php"> About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu" href="contact1.php"> Contact us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu" href="?logout"> Logout</a>
                </li>
               

                &nbsp;&nbsp;
                
            </ul>


        </div>

    </nav>


</div>