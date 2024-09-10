<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('connection.php');
$token = $_GET['token'];

if(!isset($_GET['token'])){
  // echo "<pre>";
  // print_r($_POST);

  // $departure_city = explode(',', substr($_POST['source'], 6))['0'];
  $departure_city = $_GET['source'];
  $departure_city_code = substr($_GET['source'], 0, 3);

  // $destination_city = explode(',', substr($_GET['destination'], 6))['0'];
  $destination_city = $_GET['destination'];
  $destination_city_code = substr($_GET['destination'], 0, 3);

  $adult = $_GET['adults'];
  $child = $_GET['child'];
  $infants = $_GET['infants'];

  $travelclass = $_GET['travel_class'];
  $departure_date = $_GET['departure_date'];
  $return_date = $_GET['arrival_date'];
  // echo "$departure_city $departure_city_code $destination_city $destination_city_code $adult $infants $child  $travelclass $departure_date";
  // die;
}else{
  $slquery = mysql_query("SELECT * FROM `flight_search` WHERE token='" . $token . "'");
  while ($flightdata =  mysql_fetch_array($slquery)) {
    $departure_city = $flightdata['departure_city'];
    $destination_city = $flightdata['destination_city'];
    $departure_city_code = $flightdata['departure_city_code'];
    $destination_city_code = $flightdata['destination_city_code'];
    $departure_date = $flightdata['departure_date'];
    $return_date = $flightdata['return_date'];
    $adult = $flightdata['adult'];
    $child = $flightdata['child'];
    $infants = $flightdata['infants'];
    $travelclass = $flightdata['travelclass'];
    $counter = $flightdata['counter'];
  }
}
  
// Default search value starts
$adult = isset($adult) && !empty($adult)?$adult:1;
$child = isset($child) && !empty($child)?$child:0;
$infants = isset($infants) && !empty($infants)?$infants:0;
$travelclass = isset($travelclass) && !empty($travelclass)?$travelclass:'ECONOMY';
// Default search value Ends

// echo "$departure_city | $destination_city | $departure_city_code | $destination_city_code | $departure_date | $return_date | $adult | $child | $infants| $travelclass | $counter";die;
// ======================================================================
// Getting Access Token
$url = 'https://test.api.amadeus.com/v1/security/oauth2/token';
$auth_data = array(
  'client_id' => '6AXfgRxX9hrTAAIgWL6EAX5whMejnY5F',
  'client_secret' => 'NY3iah65GGbRrwhi',
  'grant_type' => 'client_credentials',
);

// URL-encode the data
$post_fields = http_build_query($auth_data);
$headers = array('Content-Type: application/x-www-form-urlencoded');

// Initializing and Setting cURL options
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute the request
$response = curl_exec($ch);
curl_close($ch);

$response = json_decode($response);
$access_token = $response->access_token;
// echo $access_token."<br>";

function fetchAPiData($url_slug, $data, $access_token)
{
  $params = http_build_query($data);
  $url = 'https://test.api.amadeus.com/' . $url_slug;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url . '?' . $params); //Url together with parameters
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); //Timeout after 7 seconds
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json' // Adjust the content type if needed
  ));
  $result = curl_exec($ch);
  curl_close($ch);

  if (curl_errno($ch)) {
    //  echo 'Curl error: ' . curl_error($ch); //catch if curl error exists and show it
    return array();
  } else return $result;
}
// ======================================================================

// formatting travel date if not formated starts
$datePattern = '/^\d{4}-\d{2}-\d{2}$/';
if ($departure_date && preg_match($datePattern, $departure_date)){

}
else if($departure_date){
  $yy = substr($departure_date . "", 0, 4);
  $mm = substr($departure_date . "", 4, 2);
  $dd = substr($departure_date . "", 6, 2);
  $departure_date = $yy . '-' . $mm . '-' . $dd;
}

if ($return_date && preg_match($datePattern, $return_date)){

}
else if ($return_date) {
  $yy = substr($return_date . "", 0, 4);
  $mm = substr($return_date . "", 4, 2);
  $dd = substr($return_date . "", 6, 2);
  $return_date = $yy . '-' . $mm . '-' . $dd;
  // echo $return_date;
}
// formatting travel date if not formated ends

$dateRange = date('Y-m-d', strtotime($departure_date . " +9 day"));
$cheapestDateRequestData = array(
  'origin' => $departure_city_code,
  'destination' => $destination_city_code,
  'departureDate' => "$departure_date,$dateRange",
  'oneWay' => 'true',
  'nonStop' => 'false',
  'viewBy' => "DATE",
);

// === uncomment below line to get response from live API
include('api_static_data/cheapest-date-flight.php');
$result = $api_data;

if (!isset($_GET['date'])) {
  // $result = fetchAPiData("v1/shopping/flight-dates", $cheapestDateRequestData, $access_token);
  $chepestPriceArr = json_decode($result, true)['data'];
  $priceDateArr = array();
  foreach ($chepestPriceArr as $k => $v) {
    $priceDateArr[$v['departureDate']] = array('date' => $v['departureDate'], 'cheapest_price' => $v['price']['total']);
  }

  uksort($priceDateArr, function ($a, $b) {
    return strtotime($a) - strtotime($b);
  });
}
// echo "<pre>";
// print_r($priceDateArr);
// die;

if (isset($_GET['date'])) {
  $departure_date = $_GET['date'];
  // echo $departure_date;
}
// static city_code data for testing
// $departure_city_code = 'SYD';
// $destination_city_code = 'BKK';
$departure_city_code = substr($departure_city_code, 0, 3);
$destination_city_code = substr($destination_city_code, 0, 3);

$data = array(
  'originLocationCode' => $departure_city_code,  // airport code
  'destinationLocationCode' => $destination_city_code, // airport code

  'departureDate' => $departure_date,
  // 'returnDate' => $return_date , //for round trip 

  'travelClass' => $travelclass, // Travel Class/Cabin Type. E(Economy) or B(Business)
  'currencyCode' => 'INR',

  'adults' => $adult,
  'children' => $child,
  'infants' => $infants,
);

// =========== Flight Offers search
// $result = fetchAPiData("v2/shopping/flight-offers", $data, $access_token);

$dataReturn = array(
  // 'originLocationCode' => $departure_city_code,  // airport code
  // 'destinationLocationCode' => $destination_city_code, // airport code

  'originLocationCode' => $destination_city_code,  // airport code
  'destinationLocationCode' => $departure_city_code, // airport code

  // 'departureDate' => $departure_date,
  // 'returnDate' => $return_date , //for round trip
  'departureDate' => $return_date,

  'travelClass' => $travelclass, // Travel Class/Cabin Type. E(Economy) or B(Business)
  'currencyCode' => 'INR',

  'adults' => $adult,
  'children' => $child,
  'infants' => $infants,
);
// echo "<pre>";
// print_r($data);
// echo "<br>";
// print_r($dataReturn);die;
// $resultReturn = fetchAPiData("v2/shopping/flight-offers", $dataReturn, $access_token);
// uncomment above lines of code to execute Live API and comment following three lines of code to hide static data
include('flight_search_static_api_data.php');
$result = $api_data;

// Onward Flights
$data = json_decode($result, true);
$datas = $data['data'];
$total = count($datas);
$dictonary = $data['dictionaries'];
$carriers = $dictonary['carriers'];
$aircraft = $dictonary['aircraft'];
// AirportCodes
$airportCodes = array();
foreach ($datas as $d) {
  $itinerariess = $d['itineraries'][0]['segments'];
  foreach ($itinerariess as $itineraries) {
    // collecting departure Airport Code  
    $citynameCode = $itineraries['departure']['iataCode'];
    $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode . "' ");
    $resrow = mysql_fetch_array($res);
    $cityname1 = $resrow['city'];
    $airport_name1 = $resrow['airportname'];
    $airportCodes["$citynameCode"] = array('airportname' => "$airport_name1", 'city' => "$cityname1");

    // collecting Arrival Airport Codes 
    $citynameCode = $itineraries['arrival']['iataCode'];
    $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode . "' ");
    $resrow = mysql_fetch_array($res);
    $cityname1 = $resrow['city'];
    $airport_name1 = $resrow['airportname'];
    $airportCodes["$citynameCode"] = array('airportname' => "$airport_name1", 'city' => "$cityname1");
  }
}
// Ends AirportCodes

// Returning Flights
// $dataReturn = json_decode($resultReturn, true);
$dataReturn = json_decode($result, true);
$datasReturn = $dataReturn['data'];
$dictonaryReturn = $dataReturn['dictionaries'];
$carriersReturn = $dictonaryReturn['carriers'];
$aircraftReturn = $dictonaryReturn['aircraft'];
// AirportCodes Returning Flights
$airportCodesReturn = array();
foreach ($datasReturn as $d) {
  $itinerariess = $d['itineraries'][0]['segments'];
  foreach ($itinerariess as $itineraries) {
    // collecting departure Airport Code  
    $citynameCode = $itineraries['departure']['iataCode'];
    $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode . "' ");
    $resrow = mysql_fetch_array($res);
    $cityname1 = $resrow['city'];
    $airport_name1 = $resrow['airportname'];
    $airportCodesReturn["$citynameCode"] = array('airportname' => "$airport_name1", 'city' => "$cityname1");

    // collecting Arrival Airport Codes 
    $citynameCode = $itineraries['arrival']['iataCode'];
    $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode . "' ");
    $resrow = mysql_fetch_array($res);
    $cityname1 = $resrow['city'];
    $airport_name1 = $resrow['airportname'];
    $airportCodesReturn["$citynameCode"] = array('airportname' => "$airport_name1", 'city' => "$cityname1");
  }
}

// Ends AirportCodes Returning Flights
?>



<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Consta Travel - Flight results </title>
  <link rel="stylesheet" href="./css/new-styles.css">
  <?php
  include('head.php');
  ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" />
</head>

<body style="overflow-x: hidden !important;">
  <?php
  include('header.php');
  ?>
  <style>
    .colks a {
      font-size: 10px;
      margin: 0;
      padding: 0;
      color: #725d93;
      text-decoration: underline;
      font-weight: 400;
    }

    .colks p {
      margin: 0;
      padding: 0;
      font-weight: 600;
      color: #725d93;
    }

    a.btn.btn-primary-inverse.btn-block.theme-search-results-item-price-btn {
      background: #725d93;
      border: 1px solid #5f4d7b;
    }

    .theme-search-results-item-book {
      flex-direction: column;
    }

    .d-flex {
      display: flex;
    }

    .justify-content-center {
      justify-content: center;
    }

    .justify-content-between {
      justify-content: between;
    }

    .align-items-center {
      align-items: center;
    }

    .flex-column {
      flex-direction: column;
    }

    .align-items-start {
      align-items: flex-start;
    }

    .colks1 img {
      width: 60px;
    }

    .colks1 h5 {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 12px;
      margin: 0;
      padding: 0;
      line-height: 1.5;
    }

    .colks1 p {
      font-weight: 300;
      text-transform: uppercase;
      font-size: 10px;
      margin: 0;
      padding: 0;
      line-height: 2;
    }

    .colks21 h3 {
      font-size: 15px;
      text-transform: uppercase;
      margin: 0;
      line-height: 2;
    }

    .colks21 p {
      font-size: 10px;
      text-transform: uppercase;
      margin: 0;
      line-height: 2;
    }

    .colks23 h3 {
      font-size: 15px;
      text-transform: uppercase;
      margin: 0;
      line-height: 2;
    }

    .colks23 p {
      font-size: 10px;
      text-transform: uppercase;
      margin: 0;
      line-height: 2;
    }

    .colks22 p {
      font-size: 12px;
    }

    @media(min-width:991px) {
      .colks21 {
        width: 40%;
      }

      .colks22 {
        width: 20%;
      }

      .colks23 {
        width: 40%;
      }
    }

    .colks31 {
      gap: 20px;
    }

    .colks31 p {
      font-size: 11px;
    }

    .containerks {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 10px;
    }

    .div_middle {
      position: relative;
    }

    .div_middle span {
      position: absolute;
      right: 44%;
      top: -31px;
      background: #b8b8b8;
      padding: 2px 10px;
      color: white;
      border-radius: 10px;
    }

    .rowks {
      margin-left: 0px;
      margin-right: 0px;
    }

    .theme-search-results-item-flight-section-airline-logo {
      width: 100%;
    }

    .theme-search-results-item-price-tag {
      font-size: 20px;
    }

    .theme-search-results-item-preview {
      padding: 23px 17px;
    }

    .theme-search-results-item-flight-section-path-fly-time>p {
      margin-bottom: 0px !important;
    }

    .theme-search-results-item-flight-section-path-fly-time {
      top: 9px;
    }

    .my-3 {
      /* margin-top: 10px; */
      /* margin-bottom: 10px; */
      padding: 0px !important;
      /* padding-right: 10px !important; */
    }

    .padz {
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
    border-bottom-left-radius: 0px;
    margin-bottom: 0px;
    border-bottom: 0;
}

    .padx {
      border-top-left-radius: 0px;
      border-bottom-left-radius: 0px;
      border-bottom-right-radius: 0px;
      margin-bottom: 0px;
      border-bottom: 0;
    }

    hr.hrks1 {
      margin: 9px;
      border-color: #725d9347;
    }

    .sticky {
      position: fixed;
      top: 0%;
      /* left: 0%; */
      /* right: 6%; */
      /* width: 87.7rem; */
      width: 87.7rem;
      z-index: 10;
      backdrop-filter: blur(4px);
      /* box-shadow: 0px 3px 0px #ddd; */
    }


    .sticky2 {
      position: fixed;
      top: 1116px;
      /* left: 0%; */
      /* right: 6%; */
      /* width: 87.7rem; */
      width: 71.6rem;
      z-index: 12;
      backdrop-filter: blur(4px);
      /* box-shadow: 0px 3px 0px #ddd; */
    }

    .selected {
      border: 1px solid #007fff;
      /* Example highlight color */
      background-color: #e9eeef;
      /* Example background color for selected */
    }

    .a_flight {
      background-color: #F7F7F7;
      padding: 5px 5px 5px 15px;
      border-radius: 5px;
      border-top-left-radius: 0px;
      border-top-right-radius: 0px;
      border-bottom: 1px solid #e6e6e6;
      border-left: 1px solid #e6e6e6;
      border-right: 1px solid #e6e6e6;
      margin-bottom: 10px;
    }

    .flight__a {
      color: #5f4d7b;
      font-size: 13px;
      font-weight: 600;
    }
    .paddy{
      padding-top: 25px;
      padding-bottom: 24px;
    }
    .modal-header {
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    position: sticky;
    top: 0;
    background: #5f4d7b;
    color: #ffffff;
    z-index: 7;
}
  .closee{
    color: #ffffff !important;
  }
  .modal-footer {
    padding: 15px;
    text-align: right;
    /* border-top: 1px solid #e5e5e5; */
    border: 0;
    position: sticky;
    bottom: 0;
    right: 0;
    z-index: 7;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(36, 39, 41, .2);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
}
span.bold_price {
    font-weight: 700;
    font-size: 22px;
}
.modal-open .modal {
    overflow-x: hidden;
    overflow-y: hidden;
}
.modal-body {
    position: relative;
    padding: 15px;
    width: 100%;
    height: 70vh;
    overflow-y: auto;
}
::-webkit-scrollbar{
  width: 7px;
  height: 5px;
}
::-webkit-scrollbar-thumb{
  background-color: #725d93;
    border-radius: 4px;
    border: 0;
}
::-webkit-scrollbar-track {
    border-radius: 4px;
}
  </style>
  <section class="main_flight__results">
    <div class="container">
      <div class="row">
        <div class="col-12">
        <div class="top_search__form">
            <form action="/new-flight-return.php" method="GET" id="header_search_form">
              <div class="re_form__control">
                <select class="form-select" aria-label="Default select example" id="trip_type">
                  <option value="1">One way</option>
                  <option value="2" selected>Round Trip</option>
                </select>
              </div>
              <div class="re_form__control">
                <div class="hny_switch">
                  <!-- <form autocomplete="off"> -->
                    <input type="text" name="source" minlength="3" id="flightonewayfrom" class="input-field" placeholder="Source" value="<?= $departure_city ?>" required>
                  <!-- </form> -->
                    <button type="button" id="toggleButton">
                    <svg width="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#735C93">
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                      <g id="SVGRepo_iconCarrier">
                        <path d="M21 9L9 9" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15 15L3 15" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18 12L20.913 9.08704V9.08704C20.961 9.03897 20.961 8.96103 20.913 8.91296V8.91296L18 6" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M6 18L3.08704 15.087V15.087C3.03897 15.039 3.03897 14.961 3.08704 14.913V14.913L6 12" stroke="#735C93" stroke-width="0.8879999999999999" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g> 
                    </svg>
                  </button>
                  <!-- <form autocomplete="off"> -->
                    <input type="text" name="destination" minlength="3" id="flightonewayto" class="input-field" placeholder="Destination" value="<?= $destination_city ?>" required required>
                  <!-- </form> -->
                </div>
              </div>
              <div class="re_form__control">
                <input type="text" name="departure_date" class="input-field" id="flightonewaydeparture_date" placeholder="Departure" value="<?= $departure_date ?>" readonly required/>
              </div>
              <div class="re_form__control">
                <input type="text"  name="arrival_date" class="input-field" id="flightonewayarrival_date" placeholder="Return" value="<?= $return_date ?>" readonly/>
                <span id="clear_date_btn" ><i class="fas fa-times"></i></span>
              </div>
              <div class="re_form__control">
                <h3 id="no_of_adults_display"><?= $adult ?> Traveller <i class="fa fa-angle-down"></i></h3>
                <input name="adults" id="no_of_adults" type="hidden" value="<?= $adult ?>" />
                <input type="hidden" name="travel_class" value="<?= $travelclass ?>" />
                <input type="hidden" name="child" value="<?= $child ?>">
                <input type="hidden" name="infants" value="<?= $infants ?>">
                <div class="travler_list">
                  <h5>Travellers</h5>
                  <div class="add_trav__more">
                    <ul>
                      <li>
                        <h4>Adults</h4>
                        <div class="quantity-field">
                          <button type="button" class="value-button decrease-button" onclick="decreaseValue(this)" title="Decrease">-</button>
                          <div class="number"><?= $adult ?></div>
                          <button type="button" class="value-button increase-button" onclick="increaseValue(this, 5)" title="Increase">+</button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="re_form__control">
                <button type="submit" id="main_re__search">Search</button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-12">
          <div class="row">
            <div class="col-md-3">
              <div class="aside_left__section">
                <p><strong><?= $total ?> of <?= $total ?></strong> Flights</p>

                <div class="flight_upgrade">
                  <p>Get discounted seats and meals with Cleartrip Upgrade</p>

                  <div class="shop_flight">
                    <p>Show flights with Upgrade</p>
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="accordion-container">
                  <div class="set">
                    <a href="javascript:;"> Stops <i class="fa fa-angle-up"></i> </a>
                    <div class="content">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="filter_stops_0">
                        <label class="form-check-label" for="filter_stops_0">
                          Non-Stop
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="filter_stops_1">
                        <label class="form-check-label" for="filter_stops_1">
                          1 Stop
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="filter_stops_1+">
                        <label class="form-check-label" for="filter_stops_1+">
                          2 Stops
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="set">
                    <a href="javascript:;"> Departure time<i class="fa fa-angle-up"></i></a>
                    <div class="content">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault3">
                        <label class="form-check-label hny" for="flexRadioDefault3">
                          Early Morning: <span>00:00-08:00</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault4">
                        <label class="form-check-label hny" for="flexRadioDefault4">
                          Morning: <span>08:00-12:00</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault5">
                        <label class="form-check-label hny" for="flexRadioDefault5">
                          Afternoon: <span>12:00-16:00</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault6">
                        <label class="form-check-label hny" for="flexRadioDefault6">
                          Evening: <span>16:00-20:00</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault7">
                        <label class="form-check-label hny" for="flexRadioDefault7">
                          Night: <span>20:00-24:00</span>
                        </label>
                      </div>
                    </div>

                  </div>
                  <div class="set">
                    <a href="javascript:;">Pricing<i class="fa fa-angle-up"></i></a>
                    <div class="content">
                      <!-- <label for="customRange3" class="form-label">Example range</label> -->
                      <p class="d-flex justify-content-start" id="selected_price"><span>Up to &#8377; <?= number_format(ceil(end($datas)['price']['total'])) ?> </span></p>
                      <input type="range" class="form-range" min="<?= $datas[0]['price']['total'] ?>" max="<?= end($datas)['price']['total'] ?>" step="1" id="customRange3" value="<?= end($datas)['price']['total'] ?>">
                      <div class="d-flex justify-content-between">
                        <p>&#8377; <?= number_format(ceil($datas[0]['price']['total'])) ?></p>
                        <p>&#8377; <?= number_format(ceil(end($datas)['price']['total'])) ?></p>
                      </div>
                    </div>
                  </div>

                  <div class="set">
                    <a href="javascript:;"> Airlines <i class="fa fa-angle-up"></i></a>
                    <div class="content">
                      <!-- <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault8">
                        <label class="form-check-label hny" for="flexRadioDefault1">
                          Early morning <span>Midnight-8pm</span>
                        </label> 
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault9">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Morning <span>8am - Noon</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault10">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Afternoon <span>8am - Noon</span>
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault11">
                        <label class="form-check-label hny" for="flexRadioDefault2">
                          Evening <span>8am - Noon</span>
                        </label>
                      </div> -->
                      <?php foreach ($carriers as $k => $v) { ?>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="<?= $k ?>" name="flexRadioDefault" id="airline_<?= $k ?>" onchange="filtrAirline(this)">
                          <label class="form-check-label" for="airline_<?= $k ?>">
                            <?= $v ?>
                          </label>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-md-9">
              <div class="right_top__offerslider">
                <div class="slider responsive">
                  <div>
                    <div class="offer_card__hny">
                      <img src="img/ct_offer.png" alt="">
                      <div>
                        <h3>Up to 20% off + No Cost EMI</h3>
                        <p><strong>TRAVELMAX</strong> Applicable on all payments modes</p>
                      </div>
                    </div>
                  </div>

                  <div>
                    <div class="offer_card__hny">
                      <img src="img/sbi.svg" alt="">
                      <div>
                        <h3>Up to 25% off + No Cost EMI</h3>
                        <p><strong>SBIMAX</strong> with SBI Credit Cards</p>
                      </div>
                    </div>
                  </div>

                  <div>
                    <div class="offer_card__hny">
                      <img src="img/ct_offer.png" alt="">
                      <div>
                        <h3>Up to 20% off + No Cost EMI</h3>
                        <p><strong>TRAVELMAX</strong> Applicable on all payments modes</p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="offer_card__hny">
                      <img src="img/sbi.svg" alt="">
                      <div>
                        <h3>Up to 25% off + No Cost EMI</h3>
                        <p><strong>SBIMAX</strong> with SBI Credit Cards</p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="offer_card__hny">
                      <img src="img/ct_offer.png" alt="">
                      <div>
                        <h3>Up to 20% off + No Cost EMI</h3>
                        <p><strong>TRAVELMAX</strong> Applicable on all payments modes</p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div id="material-tabs">
                <div class="teb_slider__area">
                  <?php
                  $timestamp = strtotime($departure_date);
                  $formattedDate = date('D, j M', $timestamp);
                  ?>
                  <?php $i = 1;
                  foreach ($priceDateArr as $e) {
                    // $incrementedDate = date('Y-m-d', strtotime($departure_date . " +$i day"));
                    $timestamp = strtotime($e['date']);
                    $formattedDate = date('D, j M', $timestamp);
                  ?>
                    <div><a id="tab<?= $i ?>-tab" href="#tab<?= $i ?>" onclick="getDataByDate('<?= $e['date'] ?>')"><?= $formattedDate ?><span>&#8377; <?= number_format(ceil($e['cheapest_price'])) ?></a></div>
                  <?php $i++;
                  } ?>
                </div>
                <span class="yellow-bar"></span>
              </div>
              <div id="tobe_outer" class="details-section">
                <!-- Upper Selected Flight Detail -->
                <div class="row rowks1  " style="margin-bottom: 12px;">
                  <!-- First Column Onward Flights -->
                  <div class="col col-md-5 my-3">
                    <div class="theme-search-results" id="tobePagination-">
                      <div class="theme-search-results-item theme-search-results-item-rounded theme-search-results-item- padz">
                        <div class="theme-search-results-item-preview paddy">
                          <div class="row main_container" data-gutter="20">
                            <div class="col-md-12">
                              <div class="theme-search-results-item-flight-sections">
                                <div class="theme-search-results-item-flight-section">
                                  <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                                    <div class="col-md-3 colks">
                                      <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                        <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/100/50/UK.png" alt="Consta Travel" title="Image Title" style="height: 31px;" id="onward_flight_img">
                                      </div>
                                      <p style="font-size: 10px; line-height: 1;" id="onward_carrier_name">VISTARA</p>
                                      <!-- <a href="#" data-toggle="modal" data-target="#myModal">
                                        Flight Details
                                      </a> -->

                                      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Open Modal
                                      </button> -->


                                    </div>
                                    <div class="col-md-9 ">
                                      <div class="theme-search-results-item-flight-section-item">
                                        <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                                          <div class="col-md-3">
                                            <div class="theme-search-results-item-flight-section-meta">
                                              <p class="theme-search-results-item-flight-section-meta-time" id="onward_deperture_time">
                                                10:20 </p>
                                            </div>
                                          </div>
                                          <div class="col-md-6 ">
                                            <div class="theme-search-results-item-flight-section-path">
                                              <div class="theme-search-results-item-flight-section-path-fly-time">
                                                <p id="onward_flight_duration">9H25M</p>
                                              </div>
                                              <div class="theme-search-results-item-flight-section-path-line"></div>

                                              <div class="theme-search-results-item-flight-section-path-status">
                                                <h5 class="theme-search-results-item-flight-section-airline-title" id="onward_flight_stops">
                                                  ( Stops : 1 ) </h5>

                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3 ">
                                            <div class="theme-search-results-item-flight-section-meta">

                                              <p class="theme-search-results-item-flight-section-meta-time" id="onward_arrival_time">
                                                18:15 </p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Second Column Returning Flights -->
                  <div class="col col-md-7 my-3">
                    <div class="theme-search-results" id="tobePagination-">
                      <div class="theme-search-results-item theme-search-results-item-rounded theme-search-results-item- padx">
                        <div class="theme-search-results-item-preview">
                          <div class="row main_container" data-gutter="20">
                            <div class="col-md-9 ">
                              <div class="theme-search-results-item-flight-sections">
                                <div class="theme-search-results-item-flight-section">
                                  <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                                    <div class="col-md-2 colks">
                                      <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                        <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/100/50/UK.png" alt="Consta Travel" title="Image Title" id="return_flight_img">
                                      </div>
                                      <p style="font-size: 10px; line-height: 1;" id="return_carrier_name">VISTARA</p>

                                    </div>
                                    <div class="col-md-10 ">
                                      <div class="theme-search-results-item-flight-section-item">
                                        <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                                          <div class="col-md-3">
                                            <div class="theme-search-results-item-flight-section-meta">
                                              <p class="theme-search-results-item-flight-section-meta-time" id="return_deperture_time">
                                                10:20 </p>
                                            </div>
                                          </div>
                                          <div class="col-md-6 ">
                                            <div class="theme-search-results-item-flight-section-path">
                                              <div class="theme-search-results-item-flight-section-path-fly-time">
                                                <p id="return_flight_duration">9H25M</p>
                                              </div>
                                              <div class="theme-search-results-item-flight-section-path-line"></div>

                                              <div class="theme-search-results-item-flight-section-path-status">
                                                <h5 class="theme-search-results-item-flight-section-airline-title" id="return_flight_stops">
                                                  ( Stops : 1 )
                                                </h5>

                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3 ">
                                            <div class="theme-search-results-item-flight-section-meta">

                                              <p class="theme-search-results-item-flight-section-meta-time" id="return_arrival_time">
                                                18:15 </p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3 ">
                              <div class="theme-search-results-item-book">
                                <div class="theme-search-results-item-price">
                                  <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> <span id="combined_total_fare">34,566</span></p>
                                </div>
                                <button class="btn btn-primary">Book Now</button>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col col-md-12 a_flight">
                    <a href="#" data-toggle="modal" data-target="#myModal" class="flight__a">
                      Flight Details
                    </a>
                  </div>
                  <!-- <div class="row">
                    <div class="col-md-2">
                      <span class="btn btn-sm btn-primary"  onclick="fpop_show()">Flight details</span>
                    </div>
                  </div> -->

                  <div class="row">
                    <div class="col col-md-6 ">
                      <div class="d-flex " style="justify-content: space-between; background: #f2f2f2; padding: 3px 6px;">

                        <div class="">Airlines</div>
                        <!-- <div class="d-flex " style="gap: 15px;">
                            <div class="">Departure</div>
                          </div> -->
                        <div class="" style="    padding-right: 41px;">Duration</div>
                        <span class="text-primary">Price <i class="fa fa-arrow-up"></i></span>
                      </div>

                    </div>

                    <div class="col col-md-6 " style="margin: 0px -14px; padding: 0px 15px;">
                      <div class="d-flex " style="justify-content: space-between; background: #f2f2f2; padding: 3px 6px;">

                        <div class="">Airlines</div>
                        <!-- <div class="d-flex " style="gap: 15px;">
                            <div class="">Departure</div>
                          </div> -->
                        <div class="" style="    padding-right: 41px;">Duration</div>
                        <span class="text-primary">Price <i class="fa fa-arrow-up"></i></span>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- Ends Upper Selected Flight Detail -->

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header sticky-top">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="closee">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Details of your round trip</h4>
                      </div>
                      <div class="modal-body">

                        <div class="flight_onward">
                          <h3>Onward Flights</h3>
                          <div id="flight_detail_modal_onward"></div>
                        </div>

                        <div class="flight_return">
                          <h3>Return Flights</h3>
                          <div id="flight_detail_modal_return"></div>
                        </div>

                        
                        <!-- Onwards Flight Details Container -->
                        <!-- <div class="theme-search-results-item-flight-details">
                          <div class="containerks">
                            <div class="row" style="margin-bottom: 12px;">
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-start colks1">
                                  <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/XY.png" alt="Consta Travel" title="Image Title">
                                  <h5>FLYNAS</h5>
                                  <p>AIRBUS A320</p>
                                  <p>PREMIUM_ECONOMY</p>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between colks2">
                                  <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                    <h3>DEL <strong>04:15</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>Indira Gandhi Intl Airport, Terminal undefined, New Delhi</p>
                                  </div>
                                  <div class="d-flex flex-column colks22 align-items-center">
                                    <i class="fa fa-clock"></i>
                                    <p>4H25M</p>
                                  </div>
                                  <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                    <h3>RUH <strong>06:10</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>King Khaled Intl Airport, Terminal 3, Riyadh</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-center colks3">

                                  <div class="d-flex justify-content-between colks31">
                                    <p>Check-in bags</p>
                                    <p><strong>2 Qty</strong></p>
                                  </div>

                                </div>
                              </div>
                            </div>

                            <hr>
                            <div class="div_middle">
                              <span>RUH ( Layover 1h : 30m )</span>
                            </div>
                            <div class="row" style="margin-bottom: 12px;">
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-start colks1">
                                  <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/XY.png" alt="Consta Travel" title="Image Title">
                                  <h5>FLYNAS</h5>
                                  <p>AIRBUS A320</p>
                                  <p>PREMIUM_ECONOMY</p>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between colks2">
                                  <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                    <h3>RUH <strong>07:40</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>King Khaled Intl Airport, Terminal 3, Riyadh</p>
                                  </div>
                                  <div class="d-flex flex-column colks22 align-items-center">
                                    <i class="fa fa-clock"></i>
                                    <p>1H55M</p>
                                  </div>
                                  <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                    <h3>DXB <strong>10:35</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>Dubai Airport, Terminal 1, Dubai</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-center colks3">

                                  <div class="d-flex justify-content-between colks31">
                                    <p>Check-in bags</p>
                                    <p><strong>2 Qty</strong></p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> -->
                        <!-- Ends Onwards Flight Details Container -->

                        <!-- Return Flight Details Container -->
                        <!-- <div class="theme-search-results-item-flight-details">
                          <div class="containerks">
                            <div class="row" style="margin-bottom: 12px;">
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-start colks1">
                                  <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/UK.png" alt="Consta Travel" title="Image Title">
                                  <h5>VISTARA</h5>
                                  <p>AIRBUS A320</p>
                                  <p>PREMIUM_ECONOMY</p>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between colks2">
                                  <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                    <h3>DEL <strong>10:20</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>Indira Gandhi Intl Airport, Terminal 3, New Delhi</p>
                                  </div>
                                  <div class="d-flex flex-column colks22 align-items-center">
                                    <i class="fa fa-clock"></i>
                                    <p>2H15M</p>
                                  </div>
                                  <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                    <h3>BOM <strong>12:35</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>Chhatrapati Shivaji International Airport, Terminal 2, Mumbai</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-center colks3">

                                  <div class="d-flex justify-content-between colks31">
                                    <p>Check-in baggage: </p>
                                    <p><strong>35KG</strong></p>
                                  </div>

                                </div>
                              </div>
                            </div>

                            <hr>
                            <div class="div_middle">
                              <span>BOM ( Layover 3h : 50m )</span>
                            </div>
                            <div class="row" style="margin-bottom: 12px;">
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-start colks1">
                                  <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/UK.png" alt="Consta Travel" title="Image Title">
                                  <h5>VISTARA</h5>
                                  <p>AIRBUS A321</p>
                                  <p>PREMIUM_ECONOMY</p>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between colks2">
                                  <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                    <h3>BOM <strong>16:25</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>Chhatrapati Shivaji International Airport, Terminal 2, Mumbai</p>
                                  </div>
                                  <div class="d-flex flex-column colks22 align-items-center">
                                    <i class="fa fa-clock"></i>
                                    <p>3H20M</p>
                                  </div>
                                  <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                    <h3>DXB <strong>18:15</strong></h3>
                                    <p>Thursday, August 15</p>
                                    <p>Dubai Airport, Terminal 1, Dubai</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-center colks3">

                                  <div class="d-flex justify-content-between colks31">
                                    <p>Check-in baggage: </p>
                                    <p><strong>35KG</strong></p>
                                  </div>

                                </div>
                              </div>
                            </div>

                          </div>
                        </div> -->
                        <!-- Ends Return Flight Details Container -->
                        
                      </div>
                      <div class="modal-footer">
                        <div class="footer-price">
                          <span class="bold_price">₹ <span id="combined_modal_price" class="bold_price">11,450</span></span>
                        </div>
                        <div class="footer-button">
                          <button type="button" class="btn btn-primary">Book</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Rendering Flight Details -->
                <div class="row">
                  <!-- First Column Onward Flights -->
                  <div id="onward_flights" class="col col-md-6">
                    <!-- <div class="col col-md-6 my-3">
                      <div class="theme-search-results" id="tobePagination-">
                        <div class="theme-search-results-item theme-search-results-item-rounded theme-search-results-item-">
                          <div class="theme-search-results-item-preview">
                            <div class="row main_container" data-gutter="20">
                              <div class="col-md-9 ">
                                <div class="theme-search-results-item-flight-sections">
                                  <div class="theme-search-results-item-flight-section">
                                    <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                                      <div class="col-md-2 colks">
                                        <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                          <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/100/50/UK.png" alt="Consta Travel" title="Image Title">
                                        </div>
                                        <p style="font-size: 10px; line-height: 1;">VISTARA</p>
                                      </div>
                                      <div class="col-md-10 ">
                                        <div class="theme-search-results-item-flight-section-item">
                                          <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                                            <div class="col-md-3">
                                              <div class="theme-search-results-item-flight-section-meta">
                                                <p class="theme-search-results-item-flight-section-meta-time">
                                                  10:20 </p>
                                              </div>
                                            </div>
                                            <div class="col-md-6 ">
                                              <div class="theme-search-results-item-flight-section-path">
                                                <div class="theme-search-results-item-flight-section-path-fly-time">
                                                  <p>9H25M</p>
                                                </div>
                                                <div class="theme-search-results-item-flight-section-path-line"></div>

                                                <div class="theme-search-results-item-flight-section-path-status">
                                                  <h5 class="theme-search-results-item-flight-section-airline-title">
                                                    ( Stops : 1 ) </h5>

                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-3 ">
                                              <div class="theme-search-results-item-flight-section-meta">

                                                <p class="theme-search-results-item-flight-section-meta-time">
                                                  18:15 </p>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3 ">
                                <div class="theme-search-results-item-book">
                                  <div class="theme-search-results-item-price">
                                    <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> 34,566</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </div>
                  <!-- Second Column Returning Flights -->
                  <div id="returning_flights" class="col col-md-6">
                    <!-- <div class="my-3">
                      <div class="theme-search-results" id="tobePagination-">
                        <div class="theme-search-results-item theme-search-results-item-rounded theme-search-results-item-">
                          <div class="theme-search-results-item-preview">
                            <div class="row main_container" data-gutter="20">
                              <div class="col-md-9 ">
                                <div class="theme-search-results-item-flight-sections">
                                  <div class="theme-search-results-item-flight-section">
                                    <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                                      <div class="col-md-2 colks">
                                        <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                          <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/100/50/UK.png" alt="Consta Travel" title="Image Title">
                                        </div>
                                        <p style="font-size: 10px; line-height: 1;">VISTARA</p>
                                      </div>
                                      <div class="col-md-10 ">
                                        <div class="theme-search-results-item-flight-section-item">
                                          <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                                            <div class="col-md-3">
                                              <div class="theme-search-results-item-flight-section-meta">
                                                <p class="theme-search-results-item-flight-section-meta-time">
                                                  10:20 </p>
                                              </div>
                                            </div>
                                            <div class="col-md-6 ">
                                              <div class="theme-search-results-item-flight-section-path">
                                                <div class="theme-search-results-item-flight-section-path-fly-time">
                                                  <p>9H25M</p>
                                                </div>
                                                <div class="theme-search-results-item-flight-section-path-line"></div>

                                                <div class="theme-search-results-item-flight-section-path-status">
                                                  <h5 class="theme-search-results-item-flight-section-airline-title">
                                                    ( Stops : 1 ) </h5>

                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-3 ">
                                              <div class="theme-search-results-item-flight-section-meta">

                                                <p class="theme-search-results-item-flight-section-meta-time">
                                                  18:15 </p>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3 ">
                                <div class="theme-search-results-item-book">
                                  <div class="theme-search-results-item-price">
                                    <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> 34,566</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>

                <!-- Ends Rendering Flight Details -->
              </div>
            </div>
          </div>
        </div>
  </section>




  <!-- offcanvas -->
  <div class="overlay"></div>
  <div class="offcanvas__hny">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
      <button class="btn-close-hny"><i class="fa fa-close"></i></button>
    </div>
    <div class="offcanvas-body">
      ...
    </div>
  </div>
  <?php include('footer.php'); ?>


  <!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
  <script src="js/buzina-pagination.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#tobePagination').buzinaPagination({
        itemsOnPage: 10
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#material-tabs').each(function() {

        var $active, $content, $links = $(this).find('a');

        $active = $($links[0]);
        $active.addClass('active_hny'); 

        $content = $($active[0].hash);

        $links.not($active).each(function() {
          $(this.hash).hide();
        });

        $(this).on('click', 'a', function(e) {

          $active.removeClass('active_hny');
          $content.hide();

          $active = $(this);
          $content = $(this.hash);

          $active.addClass('active_hny');
          $content.show();

          e.preventDefault();
        });
      });
    });
  </script>
  <script>
    $('.offer_card__hny').click(function() {
      $('.offcanvas__hny').animate({
        right: "0%"
      }, 200);
      $('.overlay').addClass('hddd');
      $('body').addClass('hddd_over');
    });
    $('.btn-close-hny').click(function() {
      $('.offcanvas__hny').animate({
        right: "-100%"
      }, 200);
      $('.overlay').removeClass('hddd');
      $('body').removeClass('hddd_over');

    });
    $('.overlay').click(function() {
      $('.offcanvas__hny').animate({
        right: "-100%"
      }, 200);
      $('.overlay').removeClass('hddd');
      $('body').removeClass('hddd_over');

    });
  </script>
  <script>
    $('.responsive').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 3,
      prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-arrow-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>',
      slidesToScroll: 1,
      draggable: false,
      swipeToSlide: false,
      touchMove: false,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
  </script>
  <script>
    $('.teb_slider__area').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 7,
      slidesToScroll: 1,
      draggable: false,
      swipeToSlide: false,
      touchMove: false,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
  </script>
  <script>
    $(".travler_list").hide()
    $(".re_form__control h3").click(function() {
      $(".travler_list").toggle(200)
      $('.re_form__control i').addClass("hny_rota")
    })
  </script>

  <script>
    function increaseValue(button, limit) {
      const numberInput = button.parentElement.querySelector('.number');
      var value = parseInt(numberInput.innerHTML, 10);
      if (isNaN(value)) value = 0;
      if (limit && value >= limit) return;
      numberInput.innerHTML = value + 1;
    }


    function decreaseValue(button) {
      const numberInput = button.parentElement.querySelector('.number');
      var value = parseInt(numberInput.innerHTML, 10);
      if (isNaN(value)) value = 0;
      if (value < 1) return;
      numberInput.innerHTML = value - 1;
    }
  </script>
  <script>

  </script>

  <script>
    $(window).on('load', function() { // makes sure the whole site is loaded 
      //alert('loaded');
      document.getElementById("preloader").style.display = "none";
    })
  </script>
  <script src="./js/custom-javascript.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll('[id^="accordion_btn"]').forEach((btn) => {
        btn.addEventListener('click', function(event) {
          event.preventDefault();
          const collapseDiv = document.getElementById(btn.getAttribute('aria-controls'));
          if (collapseDiv.style.display === 'none' || collapseDiv.style.display === '') {
            collapseDiv.style.display = 'block';
          } else {
            collapseDiv.style.display = 'none';
          }
        });
      });

      document.querySelectorAll('[id^="accordion_close"]').forEach((btn) => {
        btn.addEventListener('click', function(event) {
          event.preventDefault();
          const collapseDiv = document.getElementById(btn.getAttribute('aria-controls'));
          if (collapseDiv.style.display === 'block' || collapseDiv.style.display === '') {
            collapseDiv.style.display = 'none';
          } else {
            collapseDiv.style.display = 'block';
          }
        });
      });
    });
  </script>
</body>

</html>
<script id="flightDataScript">
  // storing flight data in cache to perform filtering
  var jsonData = <?php echo json_encode($datas); ?>;
  sessionStorage.setItem('flight_search_result', JSON.stringify(jsonData));

  var carriersJsonData = <?php echo json_encode($carriers); ?>;
  sessionStorage.setItem('carriers', JSON.stringify(carriersJsonData));

  var aircraftJsonData = <?php echo json_encode($aircraft); ?>;
  sessionStorage.setItem('aircraft', JSON.stringify(aircraftJsonData));

  var airportCodes = <?php echo json_encode($airportCodes); ?>;
  sessionStorage.setItem('airportCodes', JSON.stringify(airportCodes));
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="./js/flight-search-filter.js"></script>
<script>
  // $("#tab1-tab").click(function(){
  function getDataByDate(dateValue) {

    let url = window.location.href;
    url = url.split('#')[0];
    let fullUrl = url + "&date=" + dateValue;
    console.log(fullUrl)
    swal({
      title: "Loading...",
      text: "Please wait while we fetch the data.",
      icon: "info",
      buttons: false,
      closeOnClickOutside: false
    });
    $("#tobe_outer").load(fullUrl + " #tobePagination", function(response, status, xhr) {
      swal.close();
      repaginate();
      toggleFlightDetails();

      if (status == "success") {
        var $response = $(response);
        var scriptContent = $response.filter('script#flightDataScript').html();
        // console.log('Script Content:', scriptContent); // Debugging line

        if (scriptContent) {
          try {
            new Function(scriptContent)();
            datas = sessionStorage.getItem('flight_search_result');
            carriers = sessionStorage.getItem('carriers');
            aircraft = sessionStorage.getItem('aircraft');
          } catch (e) {
            console.error('Error executing script:', e);
          }
        }
      }

      if (status == "error") {
        swal("Error", "Failed to load content: " + xhr.status + " " + xhr.statusText, "error");
      }
    });
  }
  // });
</script>

<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    const priceRange = document.getElementById('customRange3');
    const selectedPrice = document.getElementById('selected_price').querySelector('span');

    priceRange.addEventListener('input', function() {
      selectedPrice.textContent = `Up to ₹ ${parseInt((this.value)).toLocaleString()}`;
    });

    // priceRange.addEventListener('change', function() {
    //   console.log(this.value); 
    // });

  });
</script>
<script>
  //  document.addEventListener("DOMContentLoaded", () => {
  //     const tgclass = document.querySelector('.rowks1');

  //     window.addEventListener('scroll', () => {
  //         const rect = tgclass.getBoundingClientRect();
  //         if (rect.top <= 0) {
  //             tgclass.classList.add('sticky');
  //         } else {
  //             tgclass.classList.remove('sticky');
  //         }
  //     });
  // });



  document.addEventListener("DOMContentLoaded", () => {
    const tgclass = document.querySelector('.rowks1');
    const viewportHeight = window.innerHeight;

    function handleSticky() {
      const rect = tgclass.getBoundingClientRect();
      const triggerPoint = viewportHeight * 0.4;

      if (window.scrollY >= triggerPoint) {
        tgclass.classList.add('sticky');
      } else {
        tgclass.classList.remove('sticky');
      }
    }
    window.addEventListener('scroll', handleSticky);
    handleSticky();
  });
</script>
<!-- Displaying Data -->
<script>
  let ongoingFlights = <?php echo json_encode($datas) ?>;
  let ongoingCarriers = <?= json_encode($carriers) ?>;
  let ongoingAircraft = <?= json_encode($aircraft) ?>;
  let ongoingAirportCodes = <?= json_encode($airportCodes) ?>;

  let returningFlights = <?php echo json_encode($datasReturn) ?>;
  let returningCarriers = <?= json_encode($carriersReturn) ?>;
  let returningAircraft = <?= json_encode($aircraftReturn) ?>;
  let returningAirportCodes = <?= json_encode($airportCodesReturn) ?>;
</script>
<script src="./js/flight-return.js"></script>
<!-- Displaying Data starts Ends-->

<?php include('js/custom/searchbar_js.php'); ?>
<script>
    function toggleLocation(){
      let from = $('#flightonewayfrom').val();
      let to = $('#flightonewayto').val();

      $('#flightonewayto').val(from);
      $('#flightonewayfrom').val(to);
    }
    function increaseValue(button, limit) {
      const numberInput = button.parentElement.querySelector('.number');
      var value = parseInt(numberInput.innerHTML, 10);
      if (isNaN(value)) value = 0;
      if (limit && value >= limit) return;
      $('#no_of_adults').val(value + 1);
      $('#no_of_adults_display').html(value + 1 + ` Traveller <i class="fa fa-angle-down"></i>`);
      numberInput.innerHTML = value + 1;
    }


    function decreaseValue(button) {
      const numberInput = button.parentElement.querySelector('.number');
      var value = parseInt(numberInput.innerHTML, 10);
      if (isNaN(value)) value = 0;
      if (value < 1) return;
      $('#no_of_adults').val(value - 1);
      $('#no_of_adults_display').html(value - 1 + ` Traveller <i class="fa fa-angle-down"></i>`);
      numberInput.innerHTML = value - 1;
    }

    $('#toggleButton').click(function (){
      toggleLocation();
    });
  </script> 