<?php
//namespace Mopao\ObjectManagers;
/**
 * this class enable to get any thing necessary for the flight search engine.
 */
class FlightManager
{

  private $baseUrl;
  private $token;

  function __construct()
  {
    $this->token = AuthManager::getToken();
  }

/**
 * this return a list of airports of a given country matching a specific keyword.
 *
 */
  public function getAirports($keyword){

    $baseUrl = 'https://test.api.amadeus.com/v1/reference-data/locations';
    $airport_data = array(
      'subType'     => 'AIRPORT',
      'keyword' => $keyword,
      'view'            => 'LIGHT');

    $params=http_build_query($airport_data);
    $url = $baseUrl.'?'.$params;
    $headers = array('Authorization' => 'Bearer ' . $this->token);
    $options = array('timeout' => 60, 'blocking' =>true);
    $airports_array = array();
    try{
      // Registering an autoloader
      Requests::register_autoloader();
      $results = Requests::get($url,$headers,$options);
      $results_body = json_decode($results->body);
      //var_dump($results_body);
      if(isset($results_body->data)){
        $data = $results_body->data;

        for ($i=0; $i < count($data) ; $i++) {
          $elt = array();
          $elt['label'] = $data[$i]->address->cityName. ', '.$data[$i]->name . ' '.$data[$i]->subType.' - ' .$data[$i]->id;
          //$elt['value'] = $data[$i]->id;

          //$elt['iataCode'] = $data[$i]->iataCode;
          $airports_array[] = $elt;
        }
      }
      return $airports_array;

     } catch (Exception $e) {
     print_r($e->getMessage());
     }
  }

  /**
   * this return geocode of an airport using its code.
   *
   */
    public function findAirportGeocodeByCode($iataCode){

      $baseUrl = 'https://test.api.amadeus.com/v1/reference-data/locations';
      $airport_data = array(
        'subType'     => 'AIRPORT',
        'keyword' => $iataCode,
        'view'            => 'FULL');

      $params=http_build_query($airport_data);
      $url = $baseUrl.'?'.$params;
      $headers = array('Authorization' => 'Bearer ' . $this->token);
      $options = array('timeout' => 60, 'blocking' =>true);
      $airports_array = array();
      try{
        // Registering an autoloader
        Requests::register_autoloader();
        $results = Requests::get($url,$headers,$options);
        $results_body = json_decode($results->body);
        //var_dump($results_body);
        if(isset($results_body->data)){
          $data = $results_body->data;

          for ($i=0; $i < count($data) ; $i++) {
            $airports_array[] = $data[$i]->geoCode;
          }
        }
        return $airports_array;

       } catch (Exception $e) {
       print_r($e->getMessage());
       }
    }

  /**
   * this return information of an airport using its id.
   *
   */
    public function findAirportById($airportId){

      $baseUrl = 'https://test.api.amadeus.com/v1/reference-data/locations';

      $url = $baseUrl.'/'.$airportId;
      $headers = array('Authorization' => 'Bearer ' . $this->token);
      $options = array('timeout' => 60, 'blocking' =>true);
      $airport_info = array();
      try{
        // Registering an autoloader
        Requests::register_autoloader();
        $results = Requests::get($url,$headers, $options);
        $results_body = json_decode($results->body);
        //collect airport info
        if(isset($results_body->data)){
          $data = $results_body->data;
          $airport_info['cityName'] = $data->address->cityName;
          $airport_info['countryName'] = $data->address->countryName;
          $airport_info['name'] = $data->name;
          $airport_info['id'] = $data->id;
          $airport_info['iataCode'] = $data->iataCode;

        }
        return $airport_info;

       } catch (Exception $e) {
       print_r($e->getMessage());
       }
    }

  /**
   * this return a list of flights matching given search data.
   *
   */
  public function searchFlights($originCode, $destCode,$departureDate, $returnDate="",
  $currency="CAD",$travelClass="ECONOMY", $adults=1, $children=0){

    $baseUrl = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
    $flight_data = array(
      'originLocationCode'     => $originCode,
      'destinationLocationCode' => $destCode,
      'departureDate'           => $departureDate,
      'currencyCode'            => $currency,
      'adults'                  => $adults,
      'children'                => $children,
      'travelClass'             => $travelClass,
      'max'                     => 10);
    if($returnDate !== ""){
      $flight_data['returnDate'] = $returnDate;
    }
    $params=http_build_query($flight_data);
    $url = $baseUrl.'?'.$params;
    $headers = array('Authorization' => 'Bearer ' . $this->token);
    $options = array('timeout' => 60, 'blocking' =>true);
    try{
      // Registering an autoloader
      Requests::register_autoloader();
      $results = Requests::get($url,$headers,$options);
      $results_body = json_decode($results->body);
      //var_dump($results_body);
      // if flights are found, return  them
      if(isset($results_body->data)){
        return $results_body->data;
      }
      // return empty array if no flight found
      return array();

     } catch (Exception $e) {
     print_r($e->getMessage());
     }

  }
/* this return informations about airlines using their iata standard code */
  public function getAirlineInfo($airlineCodes){

    $baseUrl = 'https://test.api.amadeus.com/v1/reference-data/airlines' ;
    $airline_data = array(
      'airlineCodes'     => $airlineCodes);
    $params=http_build_query($airline_data);
    $url = $baseUrl.'?'.$params;
    $headers = array('Authorization' => 'Bearer ' . $this->token);
    $options = array('timeout' => 60, 'blocking' =>true);
    try{
        // Registering an autoloader
        Requests::register_autoloader();
        $results = Requests::get($url,$headers,$options);
        $results_body = json_decode($results->body);
        $airlinesInfo = array();
        //grab airlines info
        if(isset($results_body->data)){
          $data = $results_body->data;
          for ($i=0; $i < count($data) ; $i++) {
            $airlinesInfo[$data[$i]->iataCode] = $data[$i]->businessName;
          }
        }

        return $airlinesInfo;

    } catch (Exception $e) {
       print_r($e->getMessage());
    }
  }

}

?>
