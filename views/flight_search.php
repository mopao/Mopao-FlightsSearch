<?php
//use Mopao\ObjectManagers\{FlightManager,AuthManager};
// Loading Requests
require_once 'vendor/rmccue/requests/library/Requests.php';
require_once 'objectManagers/AuthManager.php';


$token = AuthManager::getToken();

if (isset($_POST['search'])) {
  $isValid = true;
  $origin = filter_input(INPUT_POST, 'origin', FILTER_SANITIZE_SPECIAL_CHARS);
  $destination = filter_input(INPUT_POST, 'destination', FILTER_SANITIZE_SPECIAL_CHARS);
  $departureDate = filter_input(INPUT_POST, 'departureDate', FILTER_SANITIZE_SPECIAL_CHARS);
  $returnDate = filter_input(INPUT_POST, 'returnDate', FILTER_SANITIZE_SPECIAL_CHARS);
  $adults = filter_input(INPUT_POST, 'adults', FILTER_VALIDATE_INT);
  $infants = filter_input(INPUT_POST, 'infants', FILTER_VALIDATE_INT,array("options" => array("min_range" => 0)));
  // inputs validation
  if ( $origin === "") {
    $isValid = false;
    echo " ori";
  }
  if ( $destination === "") {
    $isValid = false;
    echo " des";
  }

  if ( $departureDate === "") {
    $isValid = false;
    echo " dep";
  }
  if ($_POST['trip_type'] === "roundtrip" && $returnDate === "") {
    $isValid = false;
    echo " ret";
  }
  if (!$adults && $_POST['adults'] !== "0") {
    $isValid = false;
    echo " ad";
  }
  if (!$infants && $_POST['infants'] !== "0") {
    $isValid = false;
    echo " chi";
  }

  if ($isValid) {
    $_SESSION['flights_details'] = $_POST;
    header("Location: index.php?page=flights_list");
    exit;
  }


}

 ?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta description="Mopao" content="search flights and hotels engine">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>
     MOPAO - flights search
   </title>
   <!-- library -->
   <link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
   integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <!-- my css -->
   <link rel="stylesheet" href="css/general.css" type="text/css"/>
   <link rel="stylesheet" href="css/flight_search.css" type="text/css"/>
 </head>
 <body class="fluid-container">
   <?php
   require_once 'header.php';
   ?>

   <form class="" action="#" method="post" autocomplete="off">
     <input type="hidden" name="token" id="token" value="<?= $token ?>">
     <div class="form-group">
       <div class="form-check form-check-inline">
         <label class="form-check-label" for="roundtrip">Roundtrip</label>
         <input class="form-check-input" type="radio" name="trip_type" id="roundtrip" value="roundtrip" checked>
       </div>
       <div class="form-check form-check-inline">
         <label class="form-check-label" for="one-way">One-way</label>
         <input class="form-check-input" type="radio" name="trip_type" id="one-way" value="one-way">
       </div>
     </div>
     <div class="form-row">
       <div class="form-group col-md-5">
         <label for="origin">From:</label>
         <input type="text" class="form-control" id="origin" name="origin" required>
       </div>
       <div class="col-md-2" id="icon-aircraft-wrapper">
         <i class="fas fa-fighter-jet"></i>
       </div>
       <div class="form-group col-md-5">
         <label for="destination">To:</label>
         <input type="text" class="form-control" id="destination" name="destination" required>
       </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-5" id="div-departure-date">
        <label for="departureDate">Departure date:</label>
        <input type="text" class="form-control" id="departureDate" name="departureDate" required>
      </div>
      <div class="col-md-2">

      </div>
      <div class="form-group col-md-5" id="div-return-date">
        <label for="returnDate">Return date:</label>
        <input type="text" class="form-control" id="returnDate" name="returnDate">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="adults">Adults:</label>
        <input type="number" class="form-control" id="adults" name="adults" value="1" min="1">
      </div>
      <div class="col-md-1">

      </div>
      <div class="form-group col-md-3">
        <label for="infants">Infants:</label>
        <input type="number" class="form-control" id="infants" name="infants" value="0" min="0">
      </div>
      <div class="col-md-1">

      </div>
      <div class="form-group col-md-4">
        <label for="inputState">Cabin</label>
        <select id="travelClass" name="travelClass" class="form-control">
          <option value="ECONOMY" selected>Economy</option>
          <option value="BUSINESS">Business</option>
          <option value="FIRST">First</option>
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-secondary"  name="search">Search</button>
   </form>
   <?php
   require_once 'footer.php';
   ?>
   <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   <script type="text/javascript" src="js/library/jquery-ui.js"></script>
   <script type="text/javascript" src="js/flight_search.js"></script>

 </body>
 </html>
