<?php include_once('header.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Art Gallery</title>

  <link type="text/css" rel="stylesheet" href="css/style.css" />
</head>

<body>

  <div class="slideshow-container">

    <div class="mySlides fade">
      <div class="numbertext">1 / 3</div>
      <img src="images/ArtGalleryNormalView.jpg" style="width:100%">
      <div class="text">Art Gallery Normal View</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">2 / 3</div>
      <img src="images/ArtGalleryVisitor View1 n.jpg" style="width:100%">
      <div class="text">Art Gallery Visitor View one</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">3 / 3</div>
      <img src="images/ArtGalleryVisitor View2 n.jpg" style="width:100%">
      <div class="text">Art Gallery Visitor View Two</div>
    </div>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>

  </div>
  <br>

  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>

</body>
<?php include_once('footer.php') ?>
</html>
<script src="js/script.js"></script>