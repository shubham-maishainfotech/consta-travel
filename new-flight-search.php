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

// echo $departure_city; die;

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

function fetchAPiData($url_slug, $data, $access_token){
  $params = http_build_query($data);
  $url = 'https://test.api.amadeus.com/'.$url_slug;
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

  if (curl_errno($ch)){
    //  echo 'Curl error: ' . curl_error($ch); //catch if curl error exists and show it
     return array();
  }
  else return $result;
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

// print_r($cheapestDateRequestData);die;
if(!isset($_GET['date'])){
  // $result = fetchAPiData("v1/shopping/flight-dates", $cheapestDateRequestData, $access_token);
  // print_r($result);
  $chepestPriceArr = json_decode($result, true)['data'];
  $priceDateArr = array();
  foreach($chepestPriceArr as $k => $v){
    $priceDateArr[$v['departureDate']] = array('date'=> $v['departureDate'], 'cheapest_price' => $v['price']['total']);
  }

  uksort($priceDateArr, function($a, $b) {
    return strtotime($a) - strtotime($b);
  });
}
// echo "<pre>";
// print_r($priceDateArr);
// die;

if(isset($_GET['date'])){
  $departure_date = $_GET['date'];
  // echo $departure_date;
}
// static city_code data for testing
// $departure_city_code = 'SYD';
// $destination_city_code = 'BKK';

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

// print_r($data); die;
// =========== Flight Offers search
// $result = fetchAPiData("v2/shopping/flight-offers", $data, $access_token);
// uncomment above lines of code to execute Live API and comment following three lines of code to hide static data
include('flight_search_static_api_data.php');
$result = $api_data;
$data = json_decode($result, true);
$datas = $data['data'];
$total = count($datas);

$dictonary = $data['dictionaries'];
$carriers = $dictonary['carriers'];
$aircraft = $dictonary['aircraft'];
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
  </style>
  <section class="main_flight__results">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="top_search__form">
            <form action="/new-flight-search.php" method="GET" id="header_search_form">
              <div class="re_form__control">
                <select class="form-select" aria-label="Default select example" id="trip_type">
                  <option value="1" selected>One way</option>
                  <option value="2">Round Trip</option>
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
                <input type="text"  name="arrival_date" class="input-field" id="flightonewayarrival_date" placeholder="Return" value="" readonly/>
                <span id="clear_date_btn" ><i class="fas fa-times"></i></span>
              </div>
              <div class="re_form__control">
                <h3 id="no_of_adults_display"><?= $adult ?> Traveller <i class="fa fa-angle-down"></i></h3>
                <input type="hidden" name="travel_class" value="<?= $travelclass ?>" />
                <input type="hidden" name="adults" value="<?= $adult ?>">
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
            <div class="col-lg-3">
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
                      <?php foreach($carriers as $k => $v){ ?>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="<?=$k?>" name="flexRadioDefault" id="airline_<?=$k?>" onchange="filtrAirline(this)">
                          <label class="form-check-label" for="airline_<?=$k?>">
                          <?= $v ?>
                          </label>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-lg-9">
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
                  <!-- <div><a id="tab0-tab" href="#tab0" class="active_hny"><?= $formattedDate ?><span>&#8377;3,400</span></a></div> -->
                  <!-- <div><a id="tab2-tab" href="#tab2">Fri, 2 Aug <span>&#8377;3,400</a></div>
                  <div><a id="tab3-tab" href="#tab3">Sat, 3 Aug <span>&#8377;3,400</a></div>
                  <div><a id="tab4-tab" href="#tab4">Sun, 4 Aug <span>&#8377;3,400</a></div>
                  <div><a id="tab5-tab" href="#tab5">Mon, 5 Aug <span>&#8377;3,400</a></div>
                  <div><a id="tab6-tab" href="#tab6">Tue, 6 Aug <span>&#8377;3,400</a></div>
                  <div><a id="tab7-tab" href="#tab7">Wed, 7 Aug <span>&#8377;3,400</a></div>
                  <div><a id="tab8-tab" href="#tab8">Thu, 8 Aug <span>&#8377;3,400</a></div> -->
                  <?php $i = 1; foreach( $priceDateArr as $e ){
                    // $incrementedDate = date('Y-m-d', strtotime($departure_date . " +$i day"));
                    $timestamp = strtotime($e['date']);
                    $formattedDate = date('D, j M', $timestamp);
                  ?>
                    <div><a id="tab<?= $i ?>-tab" href="#tab<?= $i ?>" onclick="getDataByDate('<?= $e['date'] ?>')"><?= $formattedDate ?><span>&#8377; <?= number_format(ceil($e['cheapest_price'])) ?></a></div>
                  <?php $i++; } ?>
                </div>
                <span class="yellow-bar"></span>
              </div>
              <div id="tobe_outer">
                <div class="theme-search-results" id="tobePagination">

                  <?php if ($total >= 1) { ?>
                    <?php
                      $departure_city = explode(',', substr($departure_city, 6));
                      array_pop($departure_city);
                      $departure_city = implode(', ',$departure_city);
                      // --------------------------
                      $destination_city = explode(',', substr($destination_city, 6));
                      array_pop($destination_city);
                      $destination_city = implode(', ',$destination_city);

                      // echo $departure_city." | ". $destination_city;die;  
                    ?>
                    <?php $sr = 0; $airportCodes = array();
                    foreach ($datas as $key => $values) {
                      $sr++; ?>

                      <?php
                      // Getting itineraries Array from individual flight data
                      $itineraries = $values['itineraries'][0];

                      // Calculating travel time
                      $duration = $itineraries['duration'];
                      $duration = substr($duration, 2);

                      // Computing Departure Date
                      $depdate = $itineraries['segments'][0]['departure']['at'];
                      $dep_array = explode("T", $depdate); // split the array
                      $dep_date = $dep_array[0]; //day seqment
                      $dep_time = substr($dep_array[1], 0, -3); //time segment
                      $dedate = date_create($dep_date);
                      $depar_date =  date_format($dedate, "d  F , l ");

                      // Computing Arrival Date
                      $arrdate = end($itineraries['segments'])['arrival']['at'];
                      $d_array = explode("T", $arrdate); // split the array
                      $arrivaldate = $d_array[0]; //day seqment
                      $arrivaltime = substr($d_array[1], 0, -3); //time segment
                      $adate = date_create($arrivaldate);
                      $ardate =  date_format($adate, "d  F , l ");

                      // Total stops between source & destination
                      $no_of_stops = count($itineraries['segments']) - 1;
                      // Fetching Total Fare/price
                      $total_fare = number_format(ceil($values['travelerPricings'][0]['price']['total']));
                      ?>
                      <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                        <div class="theme-search-results-item-preview">
                          <div class="row main_container" data-gutter="20">
                            <div class="col-md-9 ">
                              <div class="theme-search-results-item-flight-sections">
                                <div class="theme-search-results-item-flight-section">
                                  <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                                    <div class="col-md-2 colks">
                                      <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                        <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/<?= $itineraries['segments'][0]['carrierCode'] ?>.png" alt="Consta Travel" title="Image Title" />
                                      </div>
                                      <p style="font-size: 10px; line-height: 1;"><?= $carriers[$itineraries['segments'][0]['carrierCode']] ?></p>
                                      <a href="#searchResultsItem<?= $sr ?>" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem<?= $sr ?>" id="accordion_btn<?= $sr ?>">
                                        View Flight Details
                                      </a>
                                    </div>
                                    <div class="col-md-10 ">
                                      <div class="theme-search-results-item-flight-section-item">
                                        <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                                          <div class="col-md-3">
                                            <div class="theme-search-results-item-flight-section-meta">
                                              <p class="theme-search-results-item-flight-section-meta-time">
                                                <?= $dep_time ?>
                                              </p>
                                              <p class="theme-search-results-item-flight-section-meta-city">
                                                <?= $departure_city ?>
                                              </p>
                                              <p class="theme-search-results-item-flight-section-meta-date">
                                                <?= $depar_date ?>
                                              </p>
                                            </div>
                                          </div>
                                          <div class="col-md-6 ">
                                            <div class="theme-search-results-item-flight-section-path">
                                              <div class="theme-search-results-item-flight-section-path-fly-time">
                                                <p><?= $duration ?></p>
                                              </div>
                                              <div class="theme-search-results-item-flight-section-path-line"></div>

                                              <div class="theme-search-results-item-flight-section-path-status">
                                                <h5 class="theme-search-results-item-flight-section-airline-title">
                                                  <?php if ($no_of_stops == 0) {
                                                    echo "( Non Stop )";
                                                  } else {
                                                    echo "( Stops : " . $no_of_stops . " )";
                                                  } ?>
                                                </h5>

                                              </div>

                                              <div class="theme-search-results-item-flight-section-path-line-start">
                                                <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                                <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                                <div class="theme-search-results-item-flight-section-path-line-title"><?= $departure_city_code ?></div>
                                              </div>

                                              <div class="theme-search-results-item-flight-section-path-line-end">
                                                <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                                <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                                <div class="theme-search-results-item-flight-section-path-line-title"><?= $destination_city_code ?></div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3 ">
                                            <div class="theme-search-results-item-flight-section-meta">

                                              <p class="theme-search-results-item-flight-section-meta-time">
                                                <?= $arrivaltime ?>
                                              </p>
                                              <p class="theme-search-results-item-flight-section-meta-city"><?= $destination_city ?></p>
                                              <p class="theme-search-results-item-flight-section-meta-date"><?= $ardate ?></p>
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
                                  <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> <?= $total_fare; ?></p>
                                  <p class="theme-search-results-item-price-sign"><?= $values['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] //$travelclass; 
                                                                                  ?></p>
                                </div>
                                <a class="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" target="_blank" href="flight-payment.php?token">Book Now</a>

                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                        if ($no_of_stops == 0) {
                          $arrivaltym = $arrivaltime;
                        } else {

                          $arrdate = $itineraries['segments'][0]['arrival']['at'];
                          $d_array = explode("T", $arrdate); // split the array
                          $arrivaldate = $d_array[0]; //day seqment
                          $arrivaltym = substr($d_array[1], 0, -3); //time segment
                          $adate = date_create($arrivaldate);
                          $ardate =  date_format($adate, "d  F , l ");
                        }
                        ?>
                        <div class="collapse theme-search-results-item-collapse" id="searchResultsItem<?= $sr ?>" style="display: none;">
                          <div class="theme-search-results-item-extend">
                            <a class="theme-search-results-item-extend-close" href="#searchResultsItem<?= $sr ?>" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem<?= $sr ?>" id="accordion_close<?= $sr ?>">&#10005;</a>
                            <div class="theme-search-results-item-extend-inner">
                              <div class="theme-search-results-item-flight-detail-items">
                                <div class="theme-search-results-item-flight-details">

                                  <div class="containerks">

                                    <!-- Displays Flight Shedule (new design) -->
                                    <div class="row" style="margin: 0px 0px 12px 0px;">
                                      <div class="col-md-3">
                                        <div class="d-flex flex-column align-items-start colks1">
                                          <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/<?= $itineraries['segments'][0]['carrierCode'] ?>.png" alt="Consta Travel" title="Image Title" />
                                          <h5><?= $carriers[$itineraries['segments'][0]['carrierCode']] ?></h5>
                                          <p><?= $aircraft[$itineraries['segments'][0]['aircraft']['code']] ?></p>
                                          <p>
                                          <p><?= $values['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] ?></p>
                                          </p>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="d-flex align-items-center justify-content-between colks2">
                                          <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                            <?php
                                            $citynameCode = $itineraries['segments'][0]['departure']['iataCode'];
                                            $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode . "' ");
                                            $resrow = mysql_fetch_array($res);
                                            $cityname1 = $resrow['city'];
                                            $airport_name1 = $resrow['airportname'];
                                            $airportCodes["$citynameCode"] = array('airportname' => "$airport_name1", 'city' => "$cityname1");
                                            ?>
                                            <h3><?= $citynameCode ?> <strong><?= $dep_time ?></strong></h3>
                                            <p><?= $depar_date ?></p>
                                            <p><?= $airport_name1 ?> Airport, Terminal <?= $itineraries['segments'][0]['departure']['terminal'] ?>, <?= $cityname1 ?></p>
                                          </div>
                                          <div class="d-flex flex-column colks22 align-items-center">
                                            <i class="fa fa-clock"></i>
                                            <p><?php echo substr($itineraries['segments'][0]['duration'], 2); ?></p>
                                          </div>
                                          <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                            <?php
                                            $cityname2Code = $itineraries['segments'][0]['arrival']['iataCode'];
                                            $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $cityname2Code . "' ");
                                            $resrow2 = mysql_fetch_array($res2);
                                            $cityname2 = $resrow2['city'];
                                            $airport_name2 = $resrow2['airportname'];
                                            $airportCodes["$cityname2Code"] = array('airportname' => "$airport_name2", 'city' => "$cityname2");
                                            ?>
                                            <h3> <?= $cityname2Code; ?> <strong><?= $arrivaltym ?></strong></h3>
                                            <p><?= $ardate ?></p>
                                            <p><?= $airport_name2 ?> Airport <?php echo isset($itineraries['segments'][0]['arrival']['terminal']) ? ", Terminal " . $itineraries['segments'][0]['arrival']['terminal'] : ''; ?>, <?= $cityname2 ?></p>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="d-flex flex-column align-items-center colks3">
                                          <?php
                                          $checkedBags = $values['travelerPricings'][0]['fareDetailsBySegment'][0]['includedCheckedBags'];
                                          if (isset($checkedBags['weight'])) {
                                          ?>
                                            <div class="d-flex justify-content-between colks31">
                                              <p>Check-in baggage: </p>
                                              <p><strong><?= $checkedBags['weight'] ?><?= $checkedBags['weightUnit'] ?></strong></p>
                                            </div>
                                          <?php } else if (isset($checkedBags['quantity'])) { ?>
                                            <div class="d-flex justify-content-between colks31">
                                              <p>Check-in bags</p>
                                              <p><strong><?= $checkedBags['quantity'] ?> Qty</strong></p>
                                            </div>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>

                                    <!-- </div> -->
                                    <div class="row">
                                      <div class="col">


                                        <?php
                                        if (count($itineraries['segments']) > 1) {
                                          $onwardFlights = $itineraries['segments'];
                                          array_shift($onwardFlights);
                                          $v = 1;
                                          foreach ($onwardFlights as $values2) {
                                            $depdate2 = $values2['departure']['at'];
                                            $dep_array2 = explode("T", $depdate2);
                                            $dep_date2 = $dep_array2[0];
                                            $dep_time2 = $dep_array2[1];
                                            $dedate2 = date_create($dep_date2);
                                            $depar_date2 = date_format($dedate2, "d F , l ");
                                            $arrdate2 = $values2['arrival']['at'];
                                            $d_array2 = explode("T", $arrdate2);
                                            $arrivaldate2 = $d_array2[0];
                                            $arrivaltime2 = $d_array2[1];
                                            $adate2 = date_create($arrivaldate2);
                                            $ardate2 = date_format($adate2, "d F , l ");
                                        ?>
                                            <!-- <div class="containerks"> -->
                                            <hr>
                                            <!-- Displays Delays (new design) -->
                                            <div class="div_middle">
                                              <?php
                                              if ($v == 1) {
                                                $date1 = $arrivaldate . " " . $arrivaltym;
                                                $date2 = $dep_date2 . " " . $dep_time2;
                                                $save =  $arrivaldate2 . " " . $arrivaltime2;
                                                $dateDiff = intval((strtotime($date2) - strtotime($date1)) / 60);

                                                $hours = intval($dateDiff / 60);
                                                $minutes = $dateDiff % 60;
                                              } else {

                                                $date1 = $save;
                                                $date2 = $dep_date2 . " " . $dep_time2;

                                                $dateDiff = intval((strtotime($date2) - strtotime($date1)) / 60);

                                                $hours = intval($dateDiff / 60);
                                                $minutes = $dateDiff % 60;
                                              }
                                              ?>
                                              <span><?php echo $values2['departure']['iataCode']; ?> ( Layover <?php echo $hours; ?>h : <?php echo $minutes; ?>m )</span>
                                            </div>

                                            <!-- Displays Flight Shedule (new design) -->
                                            <div class="row rowks" style="margin-bottom: 12px;">
                                              <div class="col-md-3">
                                                <div class="d-flex flex-column align-items-start colks1">
                                                  <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/<?= $itineraries['segments'][0]['carrierCode'] ?>.png" alt="Consta Travel" title="Image Title" />
                                                  <h5><?= $carriers[$values2['carrierCode']] ?></h5>
                                                  <p><?= $aircraft[$values2['aircraft']['code']] ?></p>
                                                  <p><?= $values['travelerPricings'][0]['fareDetailsBySegment'][$v]['cabin'] ?> </p>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between colks2">
                                                  <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                                    <?php
                                                    $citynameCode1 = $values2['departure']['iataCode'];
                                                    $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode1 . "' ");
                                                    $resrow = mysql_fetch_array($res);
                                                    $cityname1 = $resrow['city'];
                                                    $airport_name1 = $resrow['airportname'];
                                                    $airportCodes["$citynameCode1"] = array('airportname' => "$airport_name1", 'city' => "$cityname1");
                                                    ?>
                                                    <h3><?= $citynameCode1 ?> <strong><?= substr($dep_time2, 0, -3) ?></strong></h3>
                                                    <p><?= $depar_date2 ?></p>
                                                    <p><?= $airport_name1 ?> Airport, Terminal <?= $values2['departure']['terminal'] ?>, <?= $cityname1 ?></p>
                                                  </div>
                                                  <div class="d-flex flex-column colks22 align-items-center">
                                                    <i class="fa fa-clock"></i>
                                                    <p><?= substr($values2['duration'], 2) ?></p>
                                                  </div>
                                                  <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                                    <?php
                                                    $citynameCode2 = $values2['arrival']['iataCode'];
                                                    $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode2 . "' ");
                                                    $resrow = mysql_fetch_array($res);
                                                    $cityname2 = $resrow['city'];
                                                    $airport_name2 = $resrow['airportname'];
                                                    $airportCodes["$citynameCode2"] = array('airportname' => "$airport_name2", 'city' => "$cityname2");
                                                    ?>
                                                    <h3><?= $citynameCode2 ?> <strong> <?= substr($arrivaltime2, 0, -3) ?></strong></h3>
                                                    <p><?= $ardate2 ?></p>
                                                    <p><?= $airport_name2  ?> Airport<?php echo isset($values2['arrival']['terminal']) ? ", Terminal " . $values2['arrival']['terminal'] : ''; ?>, <?= $cityname2 ?></p>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="d-flex flex-column align-items-center colks3">
                                                  <?php
                                                  $checkedBags = $values['travelerPricings'][0]['fareDetailsBySegment'][$v]['includedCheckedBags'];
                                                  if (isset($checkedBags['weight'])) {
                                                  ?>
                                                    <div class="d-flex justify-content-between colks31">
                                                      <p>Check-in baggage: </p>
                                                      <p><strong><?= $checkedBags['weight'] ?><?= $checkedBags['weightUnit'] ?></strong></p>
                                                    </div>
                                                  <?php } else if (isset($checkedBags['quantity'])) { ?>
                                                    <div class="d-flex justify-content-between colks31">
                                                      <p>Check-in bags</p>
                                                      <p><strong><?= $checkedBags['quantity'] ?> Qty</strong></p>
                                                    </div>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                            </div>
                                        <!-- </div> Containerks ends here -->
                                        <?php 
                                            $v++;
                                          }//foreach ends (displays if more than 0 stops present)
                                          echo "</div>";
                                        ?>
                                        <?php 
                                          } else {
                                            echo "</div>";
                                          } //if block ends  
                                        ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } //for each ends here
                    ?>
                  <?php } else {
                    echo "No Record Found";
                  } //if block ends here 
                  ?>
                </div>
              <div>
            </div>

          </div>
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

  <?php //die; ?>
  <!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
  <?php //die; ?>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
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
function getDataByDate(dateValue){

  let url = window.location.href;
  url = url.split('#')[0];
  let fullUrl = url + "&date=" + dateValue;
  // console.log(fullUrl)
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

  });
</script>
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