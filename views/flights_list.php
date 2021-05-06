<?php
require_once 'vendor/rmccue/requests/library/Requests.php';
require_once 'objectManagers/AuthManager.php';
require_once 'objectManagers/FlightManager.php';
//instantiate a flights manager
$flightManager = new FlightManager();
$airports_infos = array();
$airlines_infos = array();
//var_dump($_SESSION['flights_details']);
//retrieve the departure airport's code
$parse = explode("-",$_SESSION['flights_details']["origin"]);
$originId = trim($parse[1]);
$origin = $flightManager->findAirportById($originId);
//var_dump($origin);
//retrieve the destination airport's code
$parse = explode("-",$_SESSION['flights_details']["destination"]);
$destId = trim($parse[1]);
$dest = $flightManager->findAirportById($destId);
//var_dump($_SESSION['flights_details']["destination"]);
// fetch the flight offers
$returnDate = "";
if ($_SESSION['flights_details']["trip_type"] === "roundtrip") {
  $returnDate = $_SESSION['flights_details']["returnDate"];
}

$results = $flightManager->searchFlights($origin["iataCode"],$dest["iataCode"],trim($_SESSION['flights_details']["departureDate"]),
$returnDate, "CAD",trim($_SESSION['flights_details']["travelClass"]),
trim($_SESSION['flights_details']["adults"]), trim($_SESSION['flights_details']["infants"]));
//var_dump($results);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta description="Mopao" content=" flight offers">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      MOPAO - flights offers
    </title>

    <!-- library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- my css -->
    <link rel="stylesheet" href="css/general.css" type="text/css"/>
    <link rel="stylesheet" href="css/map.css" type="text/css"/>
    <link rel="stylesheet" href="css/flights_list.css" type="text/css"/>
    <link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.ico" />
    <script src="js/flights_list.js"></script>
  </head>
  <body class="fluid-container">
    <?php
    require_once 'header.php';
    ?>
    <div class="jumbotron">
      <div id="map">  </div>
    </div>
    <main class="content-wrapper">

      <section class="flight-details">
        <h1>Search Details</h1>
        <div class="row ">
          <div class="col-md-6">
            <div>
              <span class="label">Origin:</span>
              <span><?= $origin['name']. ' AIRPORT ('.$origin['iataCode'].')'?></span>
              <span><?= $origin['cityName']. ', '?></span>
              <span><?= $origin['countryName']?></span>
            </div>
            <div>
              <span class="label">Destination:</span>
              <span><?= $dest['name']. ' AIRPORT ('.$dest['iataCode'].')'?></span>
              <span><?= $dest['cityName']. ', '?></span>
              <span><?= $dest['countryName']?></span>
            </div>

          </div>
          <div class="col-md-3">
            <div>
              <span class="label">Departure Date:</span>
              <span><?= $_SESSION['flights_details']["departureDate"]?></span>
            </div>
            <?php if ($_SESSION['flights_details']["trip_type"] === "roundtrip"): ?>
            <div>
              <span class="label">Return Date:</span>
              <span><?= $_SESSION['flights_details']["returnDate"]?></span>
            </div>
           <?php endif; ?>
          </div>
          <div class="col-md-3">
            <div>
              <span class="label">Adults:</span>
              <span><?= $_SESSION['flights_details']["adults"] ?></span>
            </div>
            <div>
              <span class="label">Infants:</span>
              <span><?= $_SESSION['flights_details']["infants"] ?></span>
            </div>
            <div>
              <span class="label">Flight Type:</span>
              <span><?= $_SESSION['flights_details']["trip_type"]?></span>
            </div>
            <div>
              <span class="label">Travel class:</span>
              <span><?= $_SESSION['flights_details']["travelClass"]?></span>
            </div>
          </div>
        </div>

      </section>

     <section class="list-offers">
       <h2>List of top 10 flights</h2>
       <?php if (count($results)==0): ?>
         <p class="no-flights-msg"> Sorry, no flight available for this Journey!</p>
       <?php endif; ?>
       <?php for ($i=0; $i < count($results) ; $i++) { ?>
         <div class="offer">

         <?php
         //retrieve bookable seats
         //$seats = $results[$i]->numberOfBookableSeats;
         // retrieve trip Duration
         for ($k=0; $k < count($results[$i]->itineraries); $k++) {
           $duration = $results[$i]->itineraries[$k]->duration;
           $duration = explode("PT",$duration)[1];
           //var_dump($results[$i]->itineraries[$k]);
           //retieve the fees
           $price = $results[$i]->price->grandTotal;
           //retieve list flights operators and airports
           $segments = $results[$i]->itineraries[$k]->segments;
           //number of stops
           $stops = count($segments) - 1;
           $airports_segment = array();
           $operators_segment = array();
           $operators_str = "";
           for ($j=0; $j < count($segments); $j++) {
             //retieve list flights airports
             $airport = $segments[$j]->departure->iataCode;
             if (!in_array($airport, $airports_segment)) {
               $airports_segment[] = $airport;
             }

             $airport = $segments[$j]->arrival->iataCode;
             if (!in_array($airport, $airports_segment)) {
               $airports_segment[] = $airport;
             }

             //retieve list flights operators
             $operator = $segments[$j]->carrierCode;
             if (!in_array($operator, $operators_segment)) {
               $operators_segment[] = $operator;
               $operators_str = $operators_str . $operator . ',';
             }

           }

          $airlines = $flightManager->getAirlineInfo($operators_str);
          foreach ($airlines as $key => $value) {
            if (!array_key_exists($key, $airlines_infos)) {
              // code...
              $airlines_infos[$key] = $value;
            }
          }

          //var_dump($airlines_infos);

         ?>
        <section class="flight">
         <?php if ($k == 0): ?>
           <h3>one-way : <?=$_SESSION['flights_details']['departureDate']?></h3>
         <?php else: ?>
           <h3>return :  <?=$_SESSION['flights_details']['returnDate']?></h3>
         <?php endif; ?>
           <div class="row">
             <div class="col-md-4">
               <div class="">
                 <?= $_SESSION['flights_details']['travelClass']?>
               </div>
               <div class="">
                 Operated by:
                 <ul class="">
                  <?php foreach ($operators_segment as  $value): ?>
                    <li><?= $airlines_infos[$value]?></li>
                  <?php endforeach; ?>
                 </ul>
               </div>
             </div>
             <div class="col-md-4">
               <div class="">
                 Duration: <?= $duration ?> (<?= $stops.' '?> stops)
               </div>
               <div class="">
                 Itineraries:
                 <ul class="">
                  <?php foreach ($airports_segment as  $value): ?>
                    <li><?= $value ?></li>
                  <?php endforeach; ?>
                 </ul>
               </div>
             </div>
             <div class="col-md-4">
               <div class="">
                 CAD <?= $price ?>
               </div>
               <div class="">
                 Trip:
                 <?php if ($k == 0): ?>
                   <p><?= $origin["iataCode"].' - '.$dest["iataCode"] ?></p>
                 <?php else: ?>
                  <p> <?= $dest["iataCode"].' - '.$origin["iataCode"] ?> <p>
                 <?php endif; ?>
                 <form name="f-map-airports">
                  <input type="hidden" class="airports" value="<?= implode(',', $airports_segment)?>">
                  <input type="button" class="viewMap" value=" View Itinerary">
                 </form>
               </div>
             </div>
           </div>
       </section>
     <?php } ?>
   </div>
  <?php  } ?>
     </section>
    </main>
    <?php
    require_once 'footer.php';
    ?>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
        <script
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_YZ6LZmY8FhMhgOOmQmZ230h08WaCom0&callback=initMap&libraries=&v=weekly"
          async
        ></script>
  </body>
</html>
