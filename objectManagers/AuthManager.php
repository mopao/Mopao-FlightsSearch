<?php
//namespace Mopao\ObjectManagers;

/**
 * this class manage auhentication token
 */
class AuthManager
{

  public static function getToken(){
    // Registering an autoloader
    Requests::register_autoloader();
    // Preparing the request message
    $url = 'https://test.api.amadeus.com/v1/security/oauth2/token';
    $auth_data = array(
    'client_id' => 'YeNiBeRn7TJ1CltOU4mYH0AGAIg6yj6J',
    'client_secret' => 'wKVA7NesGyzUTxAp',
    'grant_type' => 'client_credentials'
    );
    $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
    //Requests::set_certificate_path("/Applications/MAMP/conf/apache/cacert.pem");

    try {
      // Sending the request message by POST
      $requests_response = Requests::post($url, $headers, $auth_data);
      // Server returns a Requests_Response object
      $response_body = json_decode($requests_response->body);
      //echo '<pre>', json_encode($response_body, JSON_PRETTY_PRINT), '</pre>';
      if(property_exists($response_body, 'error')) die;
      // Extract and store the access token
      return $response_body->access_token;

    } catch (Exception $e) {
    print_r($e->getMessage());
    }
  }
}

 ?>
