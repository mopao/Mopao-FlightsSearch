<?php
//api for flights search
//use Mopao\ObjectManagers\FlightManager;
// Loading Requests
require_once '../vendor/rmccue/requests/library/Requests.php';
require_once '../objectManagers/AuthManager.php';
require_once '../objectManagers/FlightManager.php';

if (isset($_GET['keyword'])) {
  $keyword = $_GET['keyword'];
  //$token = $_GET['token'];
  if($keyword !== ""){
    //find airports macthing the keyword
    $flightManager = new FlightManager();
    $results = $flightManager->getAirports($keyword);
    echo json_encode($results, JSON_PRETTY_PRINT);
  }
  else{
    echo json_encode(array()) ;
  }
}
elseif(isset($_GET['airportCode'])){
  $iataCode = $_GET['airportCode'];
  if($iataCode !== ""){
    //find airports macthing the keyword
    $flightManager = new FlightManager();
    $results = $flightManager->findAirportGeocodeByCode($iataCode);
    //var_dump($results);
    echo json_encode($results, JSON_PRETTY_PRINT);
  }

}

?>
