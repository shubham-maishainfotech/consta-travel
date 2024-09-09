<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('connection.php');
$token = $_GET['token'];

 
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
// ======================================================================

if ($travelclass == 'E') {
  $travelclass = 'ECONOMY';
} else if ($travelclass == 'B') {
  $travelclass = 'BUSINESS';
}

// formatting travel date
if ($departure_date) {
  $yy = substr($departure_date . "", 0, 4);
  $mm = substr($departure_date . "", 4, 2);
  $dd = substr($departure_date . "", 6, 2);
  $departure_date = $yy . '-' . $mm . '-' . $dd;
}

if ($return_date) {
  $yy = substr($return_date . "", 0, 4);
  $mm = substr($return_date . "", 4, 2);
  $dd = substr($return_date . "", 6, 2);
  $return_date = $yy . '-' . $mm . '-' . $dd;
  // echo $return_date;
}
// static city_code data for testing
// $departure_city_code = 'SYD';
// $destination_city_code = 'BKK';

$data = array(
  'originLocationCode' => $departure_city_code,  // airport code
  'destinationLocationCode' => $destination_city_code, // airport code

  'departureDate' => $departure_date,
  // 'returnDate' => $return_date ,

  'travelClass' => $travelclass, // Travel Class/Cabin Type. E(Economy) or B(Business)

  'adults' => $adult,
  'children' => $child,
  'infants' => $infants,
);

// echo "<pre>";
// print_r($data);
// die;
// $params = http_build_query($data);

// $url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url . '?' . $params); //Url together with parameters
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); //Timeout after 7 seconds
// curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
// curl_setopt($ch, CURLOPT_HEADER, 0);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//   'Authorization: Bearer ' . $access_token,
//   'Content-Type: application/json' // Adjust the content type if needed
// ));
// $result = curl_exec($ch);
// curl_close($ch);

// // echo "<br>".$url.'?'.$params.'<br>';
// // print_r($result);
// // die;
// if (curl_errno($ch)) echo 'Curl error: ' . curl_error($ch); //catch if curl error exists and show it
// else $result;

// uncomment above lines of code to execute Live API and comment following three lines of code to hide static data
include('flight_search_static_api_data.php');
$result = $api_data;
// echo $result; die;

$datas = json_decode($result, true);
$datas = $datas['data'];
$total = count($datas);
// $totalresult = count($datas['data']['onwardflights']);
$totalresult = $total;
// print_r($datas);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Consta Travel - Flight results </title>
  <?php include('head.php'); ?>
  <script>
        // This script will run when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            // Get the JSON string from the PHP variable
            var jsonData = <?php echo json_encode($datas); ?>;
            // Store the JSON string in the session storage
            sessionStorage.setItem('flight_search_result', JSON.stringify(jsonData));
        });
    </script>
</head>

<body style="overflow-x: hidden !important;">
  <?php
  include('header.php');
  ?>
  <div class="theme-hero-area front">
    <div class="theme-hero-area-bg-wrap">
      <div class="theme-hero-area-bg theme-hero-area-bg-blur" style="background-image:url(img/big-ben-bridge-castle-city-460672_1500x800.jpg);"></div>
      <div class="theme-hero-area-mask theme-hero-area-mask-half"></div>
    </div>
    <div class="theme-hero-area-body">
      <div class="container">
        <div class="_pb-50 _pt-100 _pv-mob-50">
          <div class="theme-search-area _mob-h theme-search-area-white">
            <div class="theme-search-area-header _mb-20">
              <h1 class="theme-search-area-title theme-search-area-title-sm"><?php echo $totalresult; ?> Flights <?php echo $departure_city; ?> to <?php echo $destination_city; ?></h1>
            </div>
            <div class="theme-search-area-form" id="hero-search-form">
              <div class="row" data-gutter="10">
                <div class="col-md-5 ">
                  <div class="row" data-gutter="10">
                    <div class="col-md-6 ">
                      <div class="theme-search-area-section first theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border">
                        <label class="theme-search-area-section-label _op-06">From</label>
                        <div class="theme-search-area-section-inner">
                          <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                          <input class="theme-search-area-section-input typeahead" value="<?php echo $departure_city; ?>" type="text" placeholder="Departure" data-provide="typeahead" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 ">
                      <div class="theme-search-area-section theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border">
                        <label class="theme-search-area-section-label _op-06">To</label>
                        <div class="theme-search-area-section-inner">
                          <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                          <input class="theme-search-area-section-input typeahead" value="<?php echo $destination_city; ?>" type="text" placeholder="Arrival" data-provide="typeahead" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 ">
                  <div class="row" data-gutter="10">
                    <div class="col-md-4 ">
                      <div class="theme-search-area-section theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border">
                        <label class="theme-search-area-section-label _op-06">Depart</label>
                        <div class="theme-search-area-section-inner">
                          <i class="theme-search-area-section-icon lin lin-calendar"></i>
                          <?php

                          $date = date_create($departure_date);
                          if ($rdate) {
                            $rdate = date_create($return_date);
                          } else {
                            $rdate = $date;
                          }
                          ?>
                          <input class="form-control theme-search-area-section-input  _mob-h" style="color: #fff;" value="<?php echo date_format($date, "Y-m-d"); ?>" type="date" placeholder="Check-in" />

                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 ">
                      <div class="theme-search-area-section theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border">
                        <label class="theme-search-area-section-label _op-06">Arrival</label>
                        <div class="theme-search-area-section-inner">
                          <i class="theme-search-area-section-icon lin lin-calendar"></i>
                          <input class="form-control theme-search-area-section-input  _mob-h" style="color: #fff;" value="<?php echo date_format($rdate, "Y-m-d"); ?>" type="date" placeholder="Check-Out" />

                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 ">
                      <div class="theme-search-area-section theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border quantity-selector" data-increment="Passengers">
                        <label class="theme-search-area-section-label _op-06">Passengers</label>
                        <div class="theme-search-area-section-inner">
                          <i class="theme-search-area-section-icon lin lin-people"></i>
                          <input class="theme-search-area-section-input" value="1 Passenger" type="text" />
                          <div class="quantity-selector-box" id="FlySearchPassengers">
                            <div class="quantity-selector-inner">
                              <p class="quantity-selector-title">Passengers</p>
                              <ul class="quantity-selector-controls">
                                <li class="quantity-selector-decrement">
                                  <a href="#">&#45;</a>
                                </li>
                                <li class="quantity-selector-current">1</li>
                                <li class="quantity-selector-increment">
                                  <a href="#">&#43;</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-1 ">
                  <button class="theme-search-area-submit _tt-uc theme-search-area-submit-curved theme-search-area-submit-sm theme-search-area-submit-no-border theme-search-area-submit-primary">Edit</button>
                </div>
              </div>
            </div>
            <div class="theme-search-area-options clearfix">
              <div class="btn-group theme-search-area-options-list" data-toggle="buttons">
                <label class="btn btn-primary active">
                  <input type="radio" name="flight-options" id="flight-option-1" />Round Trip
                </label>
                <label class="btn btn-primary">
                  <input type="radio" name="flight-options" id="flight-option-2" checked />One Way
                </label>
              </div>
            </div>
          </div>
          <div class="theme-search-area-inline _desk-h theme-search-area-inline-white">
            <h4 class="theme-search-area-inline-title"><?php echo $totalresult; ?> Flights <?php echo $departure_city; ?> to <?php echo $destination_city; ?></h1>

              <p class="theme-search-area-inline-details"><?php
                                                          $date = date_create($departure_date);
                                                          echo date_format($date, "d F");
                                                          ?> , <?php echo $adult + $child + $infants; ?> Passenger</p>
              <!-- <a class="theme-search-area-inline-link magnific-inline" href="#searchEditModal">
                <i class="fa fa-pencil"></i>Edit
              </a>-->
              <div class="magnific-popup magnific-popup-sm mfp-hide" id="searchEditModal">
                <div class="theme-search-area theme-search-area-vert">
                  <div class="theme-search-area-header">
                    <h1 class="theme-search-area-title theme-search-area-title-sm">Edit your Search</h1>
                    <p class="theme-search-area-subtitle">Prices might be different from current results</p>
                  </div>
                  <div class="theme-search-area-form">
                    <div class="theme-search-area-section first theme-search-area-section-curved">
                      <label class="theme-search-area-section-label">From</label>
                      <div class="theme-search-area-section-inner">
                        <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                        <input class="theme-search-area-section-input typeahead" value="" type="text" placeholder="Departure" data-provide="typeahead" />
                      </div>
                    </div>
                    <div class="theme-search-area-section theme-search-area-section-curved">
                      <label class="theme-search-area-section-label">To</label>
                      <div class="theme-search-area-section-inner">
                        <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                        <input class="theme-search-area-section-input typeahead" type="text" placeholder="Arrival" data-provide="typeahead" />
                      </div>
                    </div>
                    <div class="row" data-gutter="10">
                      <div class="col-md-6 ">
                        <div class="theme-search-area-section theme-search-area-section-curved">
                          <label class="theme-search-area-section-label">Depart</label>
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon lin lin-calendar"></i>
                            <input class="theme-search-area-section-input datePickerStart _mob-h" value="Wed 06/27" type="text" placeholder="Check-in" />
                            <input class="theme-search-area-section-input _desk-h mobile-picker" value="2018-06-27" type="date" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 ">
                        <div class="theme-search-area-section theme-search-area-section-curved">
                          <label class="theme-search-area-section-label">Arrival</label>
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon lin lin-calendar"></i>
                            <input class="theme-search-area-section-input datePickerEnd _mob-h" value="Mon 07/02" type="text" placeholder="Check-out" />
                            <input class="theme-search-area-section-input _desk-h mobile-picker" value="2018-07-02" type="date" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="theme-search-area-section theme-search-area-section-curved quantity-selector" data-increment="Passengers">
                      <label class="theme-search-area-section-label">Passengers</label>
                      <div class="theme-search-area-section-inner">
                        <i class="theme-search-area-section-icon lin lin-people"></i>
                        <input class="theme-search-area-section-input" value="1 Passenger" type="text" />
                        <div class="quantity-selector-box" id="mobile-FlySearchPassengers">
                          <div class="quantity-selector-inner">
                            <p class="quantity-selector-title">Passengers</p>
                            <ul class="quantity-selector-controls">
                              <li class="quantity-selector-decrement">
                                <a href="#">&#45;</a>
                              </li>
                              <li class="quantity-selector-current">1</li>
                              <li class="quantity-selector-increment">
                                <a href="#">&#43;</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button class="theme-search-area-submit _mt-0 _tt-uc theme-search-area-submit-curved">Change</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="theme-page-section theme-page-section-gray">
    <div id="preloader">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="loader">
              <img src="img/loading.gif" alt="Consta Travel" title="Consta Travel" width="100%" /><br>
              <p>Please Wait...</p>


            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row row-col-static" id="sticky-parent" data-gutter="20">
        <div class="col-md-2-5 ">
          <div class="sticky-col _mob-h">
            <div class="theme-search-results-sidebar">
              <div class="theme-search-results-sidebar-sections _mb-20 _br-2">
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Stops</h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">nonstop</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$493</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">1 stop</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$300</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">2 stops</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$414</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Flight Class</h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Economy</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$316</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Business</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$402</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">First</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$385</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Price</h5>
                  <div class="theme-search-results-sidebar-section-price">
                    <input id="price-slider" name="price-slider" data-min="100" data-max="500" />
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Take-off </h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Morning
                            <span class="icheck-sub-title">05:00am - 11:59am</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$207</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Afternoon
                            <span class="icheck-sub-title">12:00pm - 5:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$168</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Evening
                            <span class="icheck-sub-title">06:00pm - 11:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$439</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Landing </h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Morning
                            <span class="icheck-sub-title">05:00am - 11:59am</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$454</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Afternoon
                            <span class="icheck-sub-title">12:00pm - 5:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$172</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Evening
                            <span class="icheck-sub-title">06:00pm - 11:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$361</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Take-off </h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Morning
                            <span class="icheck-sub-title">05:00am - 11:59am</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$423</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Afternoon
                            <span class="icheck-sub-title">12:00pm - 5:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$235</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Evening
                            <span class="icheck-sub-title">06:00pm - 11:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$408</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Landing </h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Morning
                            <span class="icheck-sub-title">05:00am - 11:59am</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$116</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Afternoon
                            <span class="icheck-sub-title">12:00pm - 5:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$283</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Evening
                            <span class="icheck-sub-title">06:00pm - 11:59pm</span>
                          </span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$274</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Airport</h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">CLY: City</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$476</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">LHR: Heathrow</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$304</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">LCW: Gatwich</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$245</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">STN: Stansed</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$198</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">SEN: Southend</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$454</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Airport</h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">JFK: John F. Kennedy</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$256</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">LGA: LaGuardia</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$212</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">EWR: Liberty</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$384</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="theme-search-results-sidebar-section">
                  <h5 class="theme-search-results-sidebar-section-title">Airlines</h5>
                  <div class="theme-search-results-sidebar-section-checkbox-list">
                    <div class="theme-search-results-sidebar-section-checkbox-list-items">
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">KLM Royal Dutch...</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$426</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">LOT Polish Airlines</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$179</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Wow Airlines</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$105</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Virgin Atlantic...</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$407</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Delta Airlines</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$268</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">SWISS Airlines</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$348</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Lufthansa</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$329</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">American Airlines</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$453</span>
                      </div>
                      <div class="checkbox theme-search-results-sidebar-section-checkbox-list-item">
                        <label class="icheck-label">
                          <input class="icheck" type="checkbox" />
                          <span class="icheck-title">Fly Emirates</span>
                        </label>
                        <span class="theme-search-results-sidebar-section-checkbox-list-amount">$483</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="theme-ad">
              <a class="theme-ad-link" href="#"></a>
              <p class="theme-ad-sign">Advertisement</p>
              <img class="theme-ad-img" src="img/side_banners/flight/2.png" alt="Image Alternative text" title="Image Title" />
            </div>
          </div>
        </div>
        <div class="col-md-7 ">
          <div class="theme-search-results-sort _mob-h clearfix">
            <h5 class="theme-search-results-sort-title">Sort by:</h5>
            <ul class="theme-search-results-sort-list">
              <li>
                <a href="javascript:;" onclick="price_filter()">Price
                  <span>Low &rarr; High</span>
                </a>
              </li>
              <li class="active">
                <a href="javascript:;" onclick="duration_filter()">Duration
                  <span>Long &rarr; Short</span>
                </a>
              </li>
              <li>
                <a href="#">Recommended
                  <span>High &rarr; Low</span>
                </a>
              </li>
              <li>
                <a href="#">Airline Name
                  <span>Name &nbsp; A &rarr; Z</span>
                </a>
              </li>
            </ul>
            <div class="dropdown theme-search-results-sort-alt">
              <a id="dropdownMenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="#">More
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                <li>
                  <a href="#">Departure take-off</a>
                </li>
                <li>
                  <a href="#">Departure landing</a>
                </li>
                <li>
                  <a href="#">Return take-off</a>
                </li>
                <li>
                  <a href="#">Return landing</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="theme-search-results-sort-select _desk-h">
            <select>
              <option>Price</option>
              <option>Duration</option>
              <option>Recommended</option>
              <option>Airline Name</option>
              <option>Departure take-off</option> 
              <option>Departure landing</option>
              <option>Return take-off</option>
              <option>Return landing</option>
            </select>
          </div>

          <div class="theme-search-results" id="tobePagination">

            <?php
            if ($total >= 1) {
              // foreach ($datas as $key => $value) {
              $value = $datas;
              // $onwards_counter = count($value['onwardflights']);
              $onwards_counter = 100;

              if ($onwards_counter >= 1) {
                $sr = 1;
                foreach ($value as  $keys => $values) {
                  // Getting itineraries Array
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
                  $total_fare = $values['travelerPricings'][0]['price']['total'];
            ?>
                  <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                    <div class="theme-search-results-item-preview">
                      <div class="row" data-gutter="20">
                        <div class="col-md-10 ">
                          <div class="theme-search-results-item-flight-sections">
                            <div class="theme-search-results-item-flight-section">
                              <div class="row row-no-gutter row-eq-height">
                                <div class="col-md-2 ">
                                  <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                    <img class="theme-search-results-item-flight-section-airline-logo" src="img/flight.png" alt="Consta Travel" title="Image Title" />
                                  </div>
                                </div>
                                <div class="col-md-10 ">
                                  <div class="theme-search-results-item-flight-section-item">
                                    <div class="row">
                                      <div class="col-md-3 ">
                                        <div class="theme-search-results-item-flight-section-meta">
                                          <p class="theme-search-results-item-flight-section-meta-time"><?php echo $dep_time; ?>
                                          </p>
                                          <p class="theme-search-results-item-flight-section-meta-city"><?php echo $departure_city; ?></p>
                                          <p class="theme-search-results-item-flight-section-meta-date"><?php echo  $depar_date; ?></p>
                                        </div>
                                      </div>
                                      <div class="col-md-6 ">
                                        <div class="theme-search-results-item-flight-section-path">
                                          <div class="theme-search-results-item-flight-section-path-fly-time">
                                            <p><?php echo $duration; ?></p>
                                          </div>
                                          <div class="theme-search-results-item-flight-section-path-line"></div>

                                          <div class="theme-search-results-item-flight-section-path-line-start">
                                            <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                            <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                            <div class="theme-search-results-item-flight-section-path-line-title"><?php echo $departure_city_code; ?></div>
                                          </div>

                                          <div class="theme-search-results-item-flight-section-path-line-end">
                                            <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                            <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                            <div class="theme-search-results-item-flight-section-path-line-title"><?php echo $destination_city_code; ?></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3 ">
                                        <div class="theme-search-results-item-flight-section-meta">
                                          <?php
                                          if ($no_of_stops == 0) {
                                            $arrivaltym = $arrivaltime;
                                          }
                                          if ($no_of_stops == 1) {
                                            $arrdate = $itineraries['segments'][0]['arrival']['at'];
                                            $d_array = explode("T", $arrdate); // split the array
                                            $arrivaldate = $d_array[0]; //day seqment
                                            $arrivaltym = substr($d_array[1], 0, -3); //time segment
                                            $adate = date_create($arrivaldate);
                                            $ardate =  date_format($adate, "d  F , l ");
                                          }
                                          if ($no_of_stops == 2) {
                                            $arrdate = $itineraries['segments'][0]['arrival']['at'];
                                            $d_array = explode("T", $arrdate); // split the array
                                            $arrivaldate = $d_array[0]; //day seqment
                                            $arrivaltym = substr($d_array[1], 0, -3); //time segment
                                            $adate = date_create($arrivaldate);
                                            $ardate =  date_format($adate, "d  F , l ");
                                          }
                                          ?>

                                          <p class="theme-search-results-item-flight-section-meta-time"><?php echo $arrivaltime; ?>

                                          </p>
                                          <p class="theme-search-results-item-flight-section-meta-city"><?php echo $destination_city; ?></p>
                                          <p class="theme-search-results-item-flight-section-meta-date"><?php echo $ardate; ?></p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <h5 class="theme-search-results-item-flight-section-airline-title"><?php echo $values['airline']; ?> ( <?php if ($no_of_stops == 0) {
                                                                                                                                        echo "Non Stop";
                                                                                                                                      } else {
                                                                                                                                        echo "Stops : " . $no_of_stops;
                                                                                                                                      } ?> )</h5>
                              <a href="#searchResultsItem-<?php echo $sr; ?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-<?php echo $sr; ?>">
                                <h5 class="theme-search-results-item-flight-section-airline-title">View Flight Details</h5>
                              </a>

                            </div>
                          </div>
                        </div>
                        <div class="col-md-2 ">
                          <div class="theme-search-results-item-book">
                            <div class="theme-search-results-item-price">
                              <p class="theme-search-results-item-price-tag"><i class="fa fa-eur" aria-hidden="true"></i> <?php echo $total_fare; //$values['fare']['totalbasefare']; 
                                                                                                                          ?></p>
                              <p class="theme-search-results-item-price-sign"><?php if ($travelclass == 'E' || $travelclass == 'ECONOMY') {
                                                                                echo "Economy";
                                                                              }
                                                                              if ($travelclass == 'B' || $travelclass == 'BUSINESS') {
                                                                                echo "Bussiness";
                                                                              } ?></p>
                            </div><?php //echo $keys; 
                                  ?>
                            <a class="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" target="_blank" href="flight-payment.php?token=<?php echo $token; ?>&flightid=<?php echo $values['FlHash']; ?>">Book Now</a>

                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="collapse theme-search-results-item-collapse" id="searchResultsItem-<?php echo $sr; ?>">
                      <div class="theme-search-results-item-extend">
                        <a class="theme-search-results-item-extend-close" href="#searchResultsItem-<?php echo $sr; ?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-<?php echo $sr; ?>">&#10005;</a>
                        <div class="theme-search-results-item-extend-inner">
                          <div class="theme-search-results-item-flight-detail-items">
                            <div class="theme-search-results-item-flight-details">
                              <div class="row">
                                <div class="col-md-3 ">
                                  <div class="theme-search-results-item-flight-details-info">
                                    <h5 class="theme-search-results-item-flight-details-info-title">Depart</h5>
                                    <p class="theme-search-results-item-flight-details-info-date"><?php echo  $depar_date2 =  date_format($dedate, "l , F d  "); ?></p>
                                    <p class="theme-search-results-item-flight-details-info-cities"><?php echo $departure_city; ?> &rarr; <?php echo $destination_city; ?></p>
                                    <p class="theme-search-results-item-flight-details-info-fly-time"><?php echo $duration; ?></p>
                                    <p class="theme-search-results-item-flight-details-info-stops"><?php if ($no_of_stops == 0) {
                                                                                                      echo "Non Stop";
                                                                                                    } else {
                                                                                                      echo "Stops : " . $no_of_stops;
                                                                                                    } ?></p>
                                  </div>
                                </div>
                                <div class="col-md-9 ">
                                  <div class="theme-search-results-item-flight-details-schedule">
                                    <ul class="theme-search-results-item-flight-details-schedule-list">
                                      <li>
                                        <i class="fa fa-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                        <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                        <p class="theme-search-results-item-flight-details-schedule-date"><?php echo  $depar_date2; ?></p>
                                        <div class="theme-search-results-item-flight-details-schedule-time">
                                          <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $dep_time . " - " . $arrivaltym; //echo  $values['deptime'] . " - " . $values['arrtime']; 
                                                                                                                    ?>

                                          </span>
                                          <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                        </div>
                                        <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo substr($itineraries['segments'][0]['duration'], 2); ?></p>
                                        <?php
                                        $citynameCode = $itineraries['segments'][0]['departure']['iataCode'];
                                        ?>
                                        <div class="theme-search-results-item-flight-details-schedule-destination">
                                          <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                              <b><?php echo $citynameCode; ?></b>
                                            </p>
                                            <?php
                                            $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $citynameCode . "' ");
                                            $resrow = mysql_fetch_array($res);
                                            $cityname = $resrow['city'];
                                            ?>
                                            <p class="theme-search-results-item-flight-details-schedule-destination-city"><?php echo $cityname; ?></p>
                                          </div>
                                          <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                            <span>&rarr;</span>
                                          </div>
                                          <?php
                                          $cityname2Code = $itineraries['segments'][0]['arrival']['iataCode'];
                                          ?>
                                          <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                              <b><?php echo $cityname2Code; ?></b>
                                            </p>
                                            <?php

                                            $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $cityname2Code . "' ");
                                            $resrow2 = mysql_fetch_array($res2);
                                            $cityname2 = $resrow2['city'];
                                            ?>
                                            <p class="theme-search-results-item-flight-details-schedule-destination-city"><?php echo $cityname2; ?></p>
                                          </div>
                                        </div>

                                      </li>
                                    </ul>
                                  </div>

                                  <?php
                                  if (count($itineraries['segments']) == 1) {
                                    // echo "empty";
                                  } else {
                                    $onwardFlights = $itineraries['segments'];
                                    array_shift($onwardFlights);

                                    $v = 1;
                                    // print_r($onwardFlights);
                                    // echo "<br>================<br>";
                                    // print_r($itineraries['segments']);
                                    // echo "<br>================<br>";
                                    foreach ($onwardFlights as  $values2) {
                                      // print_r($values2);
                                      // echo "<br>================<br>";

                                      $depdate2 = $values2['departure']['at'];
                                      $dep_array2 = explode("T", $depdate2); // split the array
                                      $dep_date2 = $dep_array2[0]; //day seqment
                                      $dep_time2 = $dep_array2[1];
                                      $dedate2 = date_create($dep_date2);
                                      $depar_date2 =  date_format($dedate2, "d  F , l ");

                                      $arrdate2 = $values2['arrival']['at'];
                                      $d_array2 = explode("T", $arrdate2); // split the array
                                      $arrivaldate2 = $d_array2[0]; //day seqment
                                      $arrivaltime2 = $d_array2[1];
                                      $adate2 = date_create($arrivaldate2);
                                      $ardate2 =  date_format($adate2, "d  F , l ");
                                  ?>

                                      <div class="theme-search-results-item-flight-details-schedule">
                                        <ul class="theme-search-results-item-flight-details-schedule-list">
                                          <li>
                                            <i class="fa fa-clock-o theme-search-results-item-flight-details-schedule-icon"></i>
                                            <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                            <p class="theme-search-results-item-flight-details-schedule-date"> &nbsp; </p>
                                            <div class="theme-search-results-item-flight-details-schedule-time">
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"> <?php echo $values2['departure']['iataCode']; ?> ( Layover )

                                              </span>

                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>

                                            <?php
                                              if ($v == 1) {
                                                $date1 = $arrivaldate . " " . $arrivaltime;
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


                                            <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $hours; ?>h:<?php echo $minutes; ?>m</p>
                                            <div class="theme-search-results-item-flight-details-schedule-destination">
                                              <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                  <b></b>
                                                </p>

                                                <p class="theme-search-results-item-flight-details-schedule-destination-city"></p>
                                              </div>
                                              <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                                <span></span>
                                              </div>
                                              <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                  <b></b>
                                                </p>

                                                <p class="theme-search-results-item-flight-details-schedule-destination-city"></p>
                                              </div>
                                            </div>

                                          </li>
                                        </ul>
                                      </div>





                                      <div class="theme-search-results-item-flight-details-schedule">
                                        <ul class="theme-search-results-item-flight-details-schedule-list">
                                          <li>
                                            <i class="fa fa-exchange theme-search-results-item-flight-details-schedule-icon"></i>
                                            <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                            <p class="theme-search-results-item-flight-details-schedule-date"><?php echo  $depar_date2 =  date_format($dedate2, "l , F d  "); ?></p>
                                            <div class="theme-search-results-item-flight-details-schedule-time">
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo substr($dep_time2,0,-3) . " - " . substr($arrivaltime2, 0, -3); ?>

                                              </span>
                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>
                                            <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo substr($values2['duration'], 2); ?></p>
                                            <div class="theme-search-results-item-flight-details-schedule-destination">
                                              <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                  <b><?php echo $values2['departure']['iataCode']; ?></b>
                                                </p>
                                                <?php
                                                  $origin_city_code = $values2['departure']['iataCode'];
                                                  $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $origin_city_code . "' ");
                                                  $resrow = mysql_fetch_array($res);
                                                  $cityname = $resrow['city'];
                                                ?>
                                                <p class="theme-search-results-item-flight-details-schedule-destination-city"><?php echo $cityname; ?></p>
                                              </div>
                                              <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                                <span>&rarr;</span>
                                              </div>
                                              <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                  <b><?php echo $values2['arrival']['iataCode']; ?></b>
                                                </p>
                                                <?php
                                                  $destination_city_code = $values2['arrival']['iataCode'];
                                                  $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $destination_city_code . "' ");
                                                  $resrow2 = mysql_fetch_array($res2);
                                                  $cityname2 = $resrow2['city'];
                                                ?>
                                                <p class="theme-search-results-item-flight-details-schedule-destination-city"><?php echo $cityname2; ?></p>
                                              </div>
                                            </div>

                                          </li>
                                        </ul>
                                      </div>
                                  <?php
                                      $v++;
                                    }
                                  }
                                  ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
            <?php
                  $sr++;
                }
              } else {
                //echo 'No resultt found';       
              }
              // }
            } else {
              echo 'No result found';
            }
            ?>

          </div>

        </div>
        <div class="col-md-2-5 ">
          <div class="sticky-col _mob-h">
            <div class="theme-ad _mb-20">
              <a class="theme-ad-link" href="#"></a>
              <p class="theme-ad-sign">Advertisement</p>
              <img class="theme-ad-img" src="img/side_banners/flight/1.png" alt="Image Alternative text" title="Image Title" />
            </div>
            <div class="theme-ad">
              <a class="theme-ad-link" href="#"></a>
              <p class="theme-ad-sign">Advertisement</p>
              <img class="theme-ad-img" src="img/side_banners/flight/3.png" alt="Image Alternative text" title="Image Title" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  include('footer.php');
  ?>
  <script src="js/jquery.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYeBBmgAkyAN_QKjAVOiP_kWZ_eQdadeI&callback=initMap&libraries=places"></script>
  <script src="js/owl-carousel.js"></script>
  <script src="js/blur-area.js"></script>
  <script src="js/icheck.js"></script>
  <script src="js/gmap.js"></script>
  <script src="js/magnific-popup.js"></script>
  <script src="js/ion-range-slider.js"></script>
  <script src="js/sticky-kit.js"></script>
  <script src="js/smooth-scroll.js"></script>
  <script src="js/fotorama.js"></script>
  <script src="js/bs-datepicker.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/quantity-selector.js"></script>
  <script src="js/countdown.js"></script>
  <script src="js/window-scroll-action.js"></script>
  <script src="js/fitvid.js"></script>
  <script src="js/youtube-bg.js"></script>
  <script src="js/custom.js"></script>

  <!--- For Pagination -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="js/buzina-pagination.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#tobePagination').buzinaPagination({
        itemsOnPage: 10
      });
    });
  </script>
  <!--- For Preloader -->
  <script>
    $(window).on('load', function() { // makes sure the whole site is loaded 
      //alert('loaded');
      document.getElementById("preloader").style.display = "none";
    })
  </script>
  <script src="./js/custom-javascript.js"></script>


</body>

</html>