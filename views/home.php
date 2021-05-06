<!DOCTYPE html>
<html lang="en">
<head>
  <meta description="Mopao" content="search flights and hotels engine">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    MOPAO
  </title>
  <link rel="shortcut icon" type="image/x-icon" href="imgs/plane.png" />
  <!-- boostrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
  integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="css/general.css" type="text/css"/>
  <link rel="stylesheet" href="css/home.css" type="text/css"/>
</head>
<body class="fluid-container">
  <?php
  require_once 'header.php';
  ?>
  <main>
    <div class="jumbotron">
      <h1>Welcome to MOPAO</h1>
      <p>The search engine that will help find the best deal for you to
        travel and enjoy your stay.
      </p>
    </div>
    <section class="container">
      <h2> Our services </h2>
     <p>
       We help you find the best deal if you are planning to travel to or inside
      <strong> the United States, Spain, the United Kingdom, Germany and India</strong>.
     </p>
      <div class="row">
        <div class="col-md-12">
          <div class="img-wrapper">
            <img src="imgs/home-travel.jpg" alt="travel image">
          </div>
          <p>
            No matter who you are, or where you are going, our travel brands help every type of
            traveler to find the trip that is right for them.
          </p>
          <a href="index.php?page=flight_search">Find your travel with us -></a>
        </div>
        <!-- <div class="col-md-6">
          <div class="img-wrapper">
            <img src="imgs/home-hotel.jpg" alt="hotel image">
          </div>
          <p>
            We help  travelers to find  places that will make their stay amazing and memorable.
          </p>
          <a href="#">Find your hotel with us -></a>
        </div>
      -->
      </div>

    </section>
  </main>
  <?php
  require_once 'footer.php';
  ?>
</body>
</html>
