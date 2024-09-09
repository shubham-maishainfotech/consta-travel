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

$data = array(
  'originLocationCode' => $departure_city_code,  // airport code
  'destinationLocationCode' => $destination_city_code, // airport code

  'departureDate' => $departure_date,
  'returnDate' => $return_date,

  'travelClass' => $travelclass, // Travel Class/Cabin Type. E(Economy) or B(Business)

  'adults' => $adult,
  'children' => $child,
  'infants' => $infants,
);

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
// if (curl_errno($ch)) echo 'Curl error: ' . curl_error($ch); //catch if curl error exists and show it
// else $result;


// uncomment above lines of code to execute Live API and comment following three lines of code to hide static data
include('api_static_data/flight_round_trip.php');
$result = $api_data;
// echo $result; die;


$datas = json_decode($result, true);
$datas = $datas['data'];
$total = count($datas);

$totalresult = $total;

// $returntotalresult = count($datas['data']['returnflights']);

$returntotalresult = $totalresult;
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Consta Travel - Flight results </title>
  <?php
  include('head.php');
  ?>
  <style>
    .sticky {
      position: fixed;
      margin: 0;
      top: 0;
      width: 100%;
      background-color: #725d93;
      z-index: 1000;
    }
  </style>

</head>

<body style="    overflow-x: hidden !important;">
  <?php
  include('header.php');
  ?>
      <style>

    .colks a {
      font-size: 7px;
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
  </style>
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
              <?php
              if ($counter == 100) {
              ?>
                <h1 class="theme-search-area-title theme-search-area-title-sm"><?php echo $totalresult; ?> Flights <?php echo $departure_city; ?> to <?php echo $destination_city; ?> and <?php echo $returntotalresult; ?> Flights <?php echo $destination_city; ?> to <?php echo $departure_city; ?></h1>
              <?php
              } else {
              ?>
                <h1 class="theme-search-area-title theme-search-area-title-sm"><?php echo $totalresult; ?> Flights</h1>

              <?php
              }
              ?>
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
                          $rdate = date_create($return_date);
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
                  <input type="radio" name="flight-options" id="flight-option-1" checked />Round Trip
                </label>
                <label class="btn btn-primary">
                  <input type="radio" name="flight-options" id="flight-option-2" />One Way
                </label>
              </div>
            </div>
          </div>
          <div class="theme-search-area-inline _desk-h theme-search-area-inline-white">
            <h4 class="theme-search-area-inline-title"><?php echo $totalresult; ?> Flights <?php echo $departure_city; ?> to <?php echo $destination_city; ?> and <?php echo $returntotalresult; ?> Flights <?php echo $destination_city; ?> to <?php echo $departure_city; ?></h4>
            <!--  <p class="theme-search-area-inline-details">June 27 &rarr; July 02, 1 Passnger</p> -->
            <a class="theme-search-area-inline-link magnific-inline" href="#searchEditModal">
              <i class="fa fa-pencil"></i>Edit
            </a>
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
  <?php
  // for domestic flight
  // if ($counter == 100) {
  if ($counter == $counter) {
  ?>
    <div class="row " id="book" style="padding: 20px 0; background-color:#725d93;">
      <form method="post">

        <div class="container">
          <div class="col-md-8">
            <div id="bookbox">
              <script>
                //onwards selector
                function bookingvalue() {

                  var onwardflightid = $("input[name='onwardflights']:checked").attr("title");
                  var returnflightid = $("input[name='returnflights']:checked").attr("title");

                  var bookingvalue = Number(onwardflightid) + Number(returnflightid);


                  //alert(bookingvalue);
                  document.getElementById('bookv').innerHTML = bookingvalue;
                };


                window.onload = bookingvalue;
              </script>
              <?php
              echo $var = "<script>document.write(onwardflightid);</script>";
              ?>
            </div>
          </div>
          <div class="col-md-2">
            <p style="color: #fff; line-height: 24px; font-size: 20px; letter-spacing: 1px; text-align:right;">
              <i class="fa fa-inr" aria-hidden="true"></i> <span id="bookv"></span>
            </p>
          </div>
          <div class="col-md-2">
            <input type="submit" name="submit" class="btn btn-primary-inverse btn-block btn-lg theme-search-results-item-price-btn" value="Book Now">
            <?php
            if (isset($_POST['submit'])) {
              $onwardflights = $_POST['onwardflights'];
              $returnflights = $_POST['returnflights'];
              echo "<script type='text/javascript'>";

              echo 'window.location.href = "flight-payment-return.php?token=' . $token . '&flightid=' . $onwardflights . '&returnflightid=' . $returnflights . '" ;';
              echo "</script>";
            }
            ?>



          </div>
        </div>
    </div>


    <div class="row">
      <div style="padding: 36px 0 36px 0;" class="container">
        <div class="col-md-6">
          <h1>Hello...1</h1>
          <div class="theme-search-results-sort  clearfix">
            <h3 style="text-align:center; color: #725d93;	"> Departure Flights</h3>
            <p style="text-align:center;	"><?php echo $departure_city; ?> to <?php echo $destination_city; ?> </p>
          </div>
          <div class="theme-search-results-sort _mob-h clearfix">
            <h5 class="theme-search-results-sort-title">Sort by:</h5>
            <ul class="theme-search-results-sort-list">
              <li>
                <a href="#">Price
                  <span>Low → High</span>
                </a>
              </li>
              <li class="active">
                <a href="#">Duration
                  <span>Long → Short</span>
                </a>
              </li>
              <li>
                <a href="#">Recommended
                  <span>High → Low</span>
                </a>
              </li>
              <li>
                <a href="#">Airline Name
                  <span>Name &nbsp; A → Z</span>
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



          <?php

          if ($total >= 1) {
            // foreach ($datas as $key => $value) {
            // $onwards_counter = count($value['onwardflights']);
            $onwards_counter = $total;
            if ($onwards_counter >= 1) {
              $sr = 1;
              // print_r($datas);die;
              foreach ($datas as  $values) {
                //echo $orgin = $values['origin']."<br>"; 
                $duration = substr($values['itineraries'][0]['duration'], 2);

          ?>
                <?php
                // $depdate = $values['depdate'];
                // $dep_array = explode("t", $depdate); // split the array
                // $dep_date = $dep_array[0]; //day seqment
                // $dedate = date_create($dep_date);
                // $depar_date =  date_format($dedate, "d  F , l ");

                // $arrdate = $values['arrdate'];
                // $d_array = explode("t", $arrdate); // split the array
                // $arrivaldate = $d_array[0]; //day seqment
                // $adate = date_create($arrivaldate);
                // $ardate =  date_format($adate, "d  F , l ");

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
                // print_r($d_array);die;
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
                                        <p class="theme-search-results-item-flight-section-meta-time"><?php echo $values['deptime']; ?>
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
                                      <?php
                                      if ($values['stops'] == 0) {
                                        $arrivaltym = $values['arrtime'];
                                      }
                                      if ($values['stops'] == 1) {
                                        $arrivaltym = $values['onwardflights']['0']['arrtime'];
                                      }
                                      if ($values['stops'] == 2) {
                                        $arrivaltym = $values['onwardflights']['0']['onwardflights']['0']['arrtime'];
                                      }
                                      ?>
                                      <div class="theme-search-results-item-flight-section-meta">
                                        <p class="theme-search-results-item-flight-section-meta-time"><?php echo $arrivaltym; ?>

                                        </p>
                                        <p class="theme-search-results-item-flight-section-meta-city"><?php echo $destination_city; ?></p>
                                        <p class="theme-search-results-item-flight-section-meta-date"><?php echo $ardate; ?></p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <h5 class="theme-search-results-item-flight-section-airline-title"><?php echo $values['airline']; ?> ( <?php if (count($itineraries['segments']) == 1) {
                                                                                                                                      echo "Non Stop";
                                                                                                                                    } else {
                                                                                                                                      echo "Stops : " . (count($itineraries['segments']) - 1);
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
                            <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $values['fare']['totalbasefare']; ?></p>
                            <p class="theme-search-results-item-price-sign"><?php if ($travelclass == 'E') {
                                                                              echo "Economy";
                                                                            }
                                                                            if ($travelclass == 'B') {
                                                                              echo "Bussiness";
                                                                            } ?></p>
                          </div>
                          <div style="text-align: center;margin: 0 auto;" class="form-check">
                            <input class="form-check-input radiobtn " type="radio" name="onwardflights" value="<?php echo $values['FlHash']; ?>" <?php if ($sr == 1) {
                                                                                                                                                    echo "checked";
                                                                                                                                                  } ?> title="<?php echo $values['fare']['totalbasefare']; ?>" onclick="bookingvalue()">

                          </div>
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
                                  <p class="theme-search-results-item-flight-details-info-stops"><?php if (count($itineraries['segments']) == 1) {
                                                                                                    echo "Non Stop";
                                                                                                  } else {
                                                                                                    echo "Stops : " . (count($itineraries['segments']) - 1);
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
                                        <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $values['deptime'] . " - " . $values['arrtime']; ?>

                                        </span>
                                        <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                      </div>
                                      <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $values['splitduration']; ?></p>
                                      <div class="theme-search-results-item-flight-details-schedule-destination">
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                          <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                            <b><?php echo $values['origin']; ?></b>
                                          </p>
                                          <?php
                                          $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $values['origin'] . "' ");
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
                                            <b><?php echo $values['destination']; ?></b>
                                          </p>
                                          <?php
                                          $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $values['destination'] . "' ");
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
                                if (empty($values['onwardflights'])) {
                                  //echo "empty";
                                } else {
                                  $v = 1;
                                  foreach ($values['onwardflights'] as  $keys => $values2) {

                                    $depdate2 = $values2['depdate'];
                                    $dep_array2 = explode("t", $depdate2); // split the array
                                    $dep_date2 = $dep_array2[0]; //day seqment
                                    $dedate2 = date_create($dep_date2);
                                    $depar_date2 =  date_format($dedate2, "d  F , l ");

                                    $arrdate2 = $values2['arrdate'];
                                    $d_array2 = explode("t", $arrdate2); // split the array
                                    $arrivaldate2 = $d_array2[0]; //day seqment
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
                                            <span class="theme-search-results-item-flight-details-schedule-time-item"> <?php echo $values2['origin']; ?> ( Layover )

                                            </span>

                                            <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                          </div>

                                          <?php
                                          if ($v == 1) {
                                            $date1 = $arrivaldate . " " . $values['arrtime'];
                                            $date2 = $dep_date2 . " " . $values2['deptime'];
                                            $save =  $arrivaldate2 . " " . $values2['arrtime'];
                                            $dateDiff = intval((strtotime($date2) - strtotime($date1)) / 60);

                                            $hours = intval($dateDiff / 60);
                                            $minutes = $dateDiff % 60;
                                          } else {

                                            $date1 = $save;
                                            $date2 = $dep_date2 . " " . $values2['deptime'];

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
                                            <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $values2['deptime'] . " - " . $values2['arrtime']; ?>

                                            </span>
                                            <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                          </div>
                                          <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $values2['splitduration']; ?></p>
                                          <div class="theme-search-results-item-flight-details-schedule-destination">
                                            <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                              <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                <b><?php echo $values2['origin']; ?></b>
                                              </p>
                                              <?php
                                              $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $values2['origin'] . "' ");
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
                                                <b><?php echo $values2['destination']; ?></b>
                                              </p>
                                              <?php
                                              $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $values2['destination'] . "' ");
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
          <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
            <div class="theme-search-results-item-preview">
              <div class="row main_container" data-gutter="20">
                <div class="col-md-9 ">
                  <div class="theme-search-results-item-flight-sections">
                    <div class="theme-search-results-item-flight-section">
                      <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                        <div class="col-md-2 colks">
                          <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                            <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/UK.png" alt="Consta Travel" title="Image Title">
                          </div>
                          <p style="font-size: 10px; line-height: 1;">VISTARA</p>
                          <a href="#searchResultsItem1" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem1" id="accordion_btn1">
                            View Flight Details
                          </a>
                        </div>
                        <div class="col-md-10 ">
                          <div class="theme-search-results-item-flight-section-item">
                            <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                              <div class="col-md-3">
                                <div class="theme-search-results-item-flight-section-meta">
                                  <p class="theme-search-results-item-flight-section-meta-time">
                                    10:20 </p>
                                  <p class="theme-search-results-item-flight-section-meta-city">
                                  </p>
                                  <p class="theme-search-results-item-flight-section-meta-date">
                                    15 August , Thursday </p>
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

                                  <div class="theme-search-results-item-flight-section-path-line-start">
                                    <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                    <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                    <div class="theme-search-results-item-flight-section-path-line-title"></div>
                                  </div>

                                  <div class="theme-search-results-item-flight-section-path-line-end">
                                    <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                    <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                    <div class="theme-search-results-item-flight-section-path-line-title"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3 ">
                                <div class="theme-search-results-item-flight-section-meta">

                                  <p class="theme-search-results-item-flight-section-meta-time">
                                    18:15 </p>
                                  <p class="theme-search-results-item-flight-section-meta-city"></p>
                                  <p class="theme-search-results-item-flight-section-meta-date">15 August , Thursday </p>
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
                      <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i>34566.00</p>
                      <p class="theme-search-results-item-price-sign">PREMIUM_ECONOMY</p>
                    </div>
                    <a class="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" target="_blank" href="flight-payment.php?token">Book Now</a>

                  </div>
                </div>
              </div>
            </div>
            <div class="collapse theme-search-results-item-collapse" id="searchResultsItem1" style="display: none;">
              <div class="theme-search-results-item-extend">
                <a class="theme-search-results-item-extend-close" href="#searchResultsItem1" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem1" id="accordion_close1">✕</a>
                <div class="theme-search-results-item-extend-inner">
                  <div class="theme-search-results-item-flight-detail-items">
                    <div class="theme-search-results-item-flight-details">

                      <div class="containerks">

                        <!-- Displays Flight Shedule (new design) -->
                        <div class="row" style="margin: 0px 0px 12px 0px;">
                          <div class="col-md-3">
                            <div class="d-flex flex-column align-items-start colks1">
                              <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/UK.png" alt="Consta Travel" title="Image Title">
                              <h5>VISTARA</h5>
                              <p>AIRBUS A320</p>
                              <p>
                              </p>
                              <p>PREMIUM_ECONOMY</p>
                              <p></p>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-between colks2">
                              <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                <h3>DEL <strong>10:20</strong></h3>
                                <p>15 August , Thursday </p>
                                <p>Indira Gandhi Intl Airport, Terminal 3, New Delhi</p>
                              </div>
                              <div class="d-flex flex-column colks22 align-items-center">
                                <i class="fa fa-clock"></i>
                                <p>2H15M</p>
                              </div>
                              <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                <h3> BOM <strong>12:35</strong></h3>
                                <p>15 August , Thursday </p>
                                <p>Chhatrapati Shivaji International Airport , Terminal 2, Mumbai</p>
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

                        <!-- </div> -->
                        <div class="row">
                          <div class="col">


                            <!-- <div class="containerks"> -->
                            <hr>
                            <!-- Displays Delays (new design) -->
                            <div class="div_middle">
                              <span>BOM ( Layover 3h : 50m )</span>
                            </div>

                            <!-- Displays Flight Shedule (new design) -->
                            <div class="row rowks" style="margin-bottom: 12px;">
                              <div class="col-md-3">
                                <div class="d-flex flex-column align-items-start colks1">
                                  <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/UK.png" alt="Consta Travel" title="Image Title">
                                  <h5>VISTARA</h5>
                                  <p>AIRBUS A321</p>
                                  <p>PREMIUM_ECONOMY </p>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between colks2">
                                  <div class="d-flex align-items-center flex-column colks21 align-items-start">
                                    <h3>BOM <strong>16:25</strong></h3>
                                    <p>15 August , Thursday </p>
                                    <p>Chhatrapati Shivaji International Airport, Terminal 2, Mumbai</p>
                                  </div>
                                  <div class="d-flex flex-column colks22 align-items-center">
                                    <i class="fa fa-clock"></i>
                                    <p>3H20M</p>
                                  </div>
                                  <div class="d-flex align-items-center flex-column colks23 align-items-start">
                                    <h3>DXB <strong> 18:15</strong></h3>
                                    <p>15 August , Thursday </p>
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
                            <!-- </div> Containerks ends here -->
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
        <div class="col-md-6">
          <h1>hello......2</h1>
          <div class="theme-search-results-sort  clearfix">
            <h3 style="text-align:center; color: #725d93;	"> Return Flights</h3>
            <p style="text-align:center;	"><?php echo $destination_city; ?> to <?php echo $departure_city; ?> </p>
          </div>
          <div class="theme-search-results-sort _mob-h clearfix">
            <h5 class="theme-search-results-sort-title">Sort by:</h5>
            <ul class="theme-search-results-sort-list">
              <li>
                <a href="#">Price
                  <span>Low → High</span>
                </a>
              </li>
              <li class="active">
                <a href="#">Duration
                  <span>Long → Short</span>
                </a>
              </li>
              <li>
                <a href="#">Recommended
                  <span>High → Low</span>
                </a>
              </li>
              <li>
                <a href="#">Airline Name
                  <span>Name &nbsp; A → Z</span>
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

          <?php

          if ($total >= 1) {
            foreach ($datas as $key => $value) {
              $onwards_counter = count($value['returnflights']);
              if ($onwards_counter >= 1) {
                $sr = 1;
                foreach ($value['returnflights'] as  $keys => $values) {

                  //echo $orgin = $values['origin']."<br>"; 
                  $duration = $values['duration'];

          ?>
                  <?php
                  $depdate = $values['depdate'];
                  $dep_array = explode("t", $depdate); // split the array
                  $dep_date = $dep_array[0]; //day seqment
                  $dedate = date_create($dep_date);
                  $depar_date =  date_format($dedate, "d  F , l ");

                  $arrdate = $values['arrdate'];
                  $d_array = explode("t", $arrdate); // split the array
                  $arrivaldate = $d_array[0]; //day seqment
                  $adate = date_create($arrivaldate);
                  $ardate =  date_format($adate, "d  F , l ");


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
                                          <p class="theme-search-results-item-flight-section-meta-time"><?php echo $values['deptime']; ?>
                                          </p>
                                          <p class="theme-search-results-item-flight-section-meta-city"><?php echo $destination_city; ?></p>
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
                                        <?php
                                        if ($values['stops'] == 0) {
                                          $arrivaltym = $values['arrtime'];
                                        }
                                        if ($values['stops'] == 1) {
                                          $arrivaltym = $values['onwardflights']['0']['arrtime'];
                                        }
                                        if ($values['stops'] == 2) {
                                          $arrivaltym = $values['onwardflights']['0']['onwardflights']['0']['arrtime'];
                                        }
                                        ?>
                                        <div class="theme-search-results-item-flight-section-meta">
                                          <p class="theme-search-results-item-flight-section-meta-time"><?php echo $arrivaltym; ?>

                                          </p>
                                          <p class="theme-search-results-item-flight-section-meta-city"><?php echo $departure_city; ?></p>
                                          <p class="theme-search-results-item-flight-section-meta-date"><?php echo $ardate; ?></p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <h5 class="theme-search-results-item-flight-section-airline-title"><?php echo $values['airline']; ?> ( <?php if ($values['stops'] == 0) {
                                                                                                                                        echo "Non Stop";
                                                                                                                                      } else {
                                                                                                                                        echo "Stops : " . $values['stops'];
                                                                                                                                      } ?> )</h5>
                              <a href="#searchResultsItem2-<?php echo $sr; ?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem2-<?php echo $sr; ?>">
                                <h5 class="theme-search-results-item-flight-section-airline-title">View Flight Details</h5>
                              </a>

                            </div>
                          </div>
                        </div>
                        <div class="col-md-2 ">
                          <div class="theme-search-results-item-book">
                            <div class="theme-search-results-item-price">
                              <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $values['fare']['totalbasefare']; ?></p>
                              <p class="theme-search-results-item-price-sign"><?php if ($travelclass == 'E') {
                                                                                echo "Economy";
                                                                              }
                                                                              if ($travelclass == 'B') {
                                                                                echo "Bussiness";
                                                                              } ?></p>
                            </div>
                            <div style="text-align: center;margin: 0 auto;" class="form-check">
                              <?php $values['FlHash']; ?>
                              <input class="form-check-input radiobtn rflights" type="radio" name="returnflights" value="<?php echo $values['FlHash']; ?>" <?php if ($sr == 1) {
                                                                                                                                                              echo "checked";
                                                                                                                                                            } ?> title="<?php echo $values['fare']['totalbasefare']; ?>" onclick="bookingvalue()">

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="collapse theme-search-results-item-collapse" id="searchResultsItem2-<?php echo $sr; ?>">
                      <div class="theme-search-results-item-extend">
                        <a class="theme-search-results-item-extend-close" href="#searchResultsItem2-<?php echo $sr; ?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem2-<?php echo $sr; ?>">&#10005;</a>
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
                                    <p class="theme-search-results-item-flight-details-info-stops"><?php if ($values['stops'] == 0) {
                                                                                                      echo "Non Stop";
                                                                                                    } else {
                                                                                                      echo "Stops : " . $values['stops'];
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
                                          <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $values['deptime'] . " - " . $values['arrtime']; ?>

                                          </span>
                                          <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                        </div>
                                        <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $values['splitduration']; ?></p>
                                        <div class="theme-search-results-item-flight-details-schedule-destination">
                                          <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                              <b><?php echo $values['origin']; ?></b>
                                            </p>
                                            <?php
                                            $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $values['origin'] . "' ");
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
                                              <b><?php echo $values['destination']; ?></b>
                                            </p>
                                            <?php
                                            $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $values['destination'] . "' ");
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
                                  if (empty($values['onwardflights'])) {
                                    //echo "empty";
                                  } else {
                                    $v = 1;
                                    foreach ($values['onwardflights'] as  $keys => $values2) {

                                      $depdate2 = $values2['depdate'];
                                      $dep_array2 = explode("t", $depdate2); // split the array
                                      $dep_date2 = $dep_array2[0]; //day seqment
                                      $dedate2 = date_create($dep_date2);
                                      $depar_date2 =  date_format($dedate2, "d  F , l ");

                                      $arrdate2 = $values2['arrdate'];
                                      $d_array2 = explode("t", $arrdate2); // split the array
                                      $arrivaldate2 = $d_array2[0]; //day seqment
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
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"> <?php echo $values2['origin']; ?> ( Layover )

                                              </span>

                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>

                                            <?php
                                            if ($v == 1) {
                                              $date1 = $arrivaldate . " " . $values['arrtime'];
                                              $date2 = $dep_date2 . " " . $values2['deptime'];
                                              $save =  $arrivaldate2 . " " . $values2['arrtime'];
                                              $dateDiff = intval((strtotime($date2) - strtotime($date1)) / 60);

                                              $hours = intval($dateDiff / 60);
                                              $minutes = $dateDiff % 60;
                                            } else {

                                              $date1 = $save;
                                              $date2 = $dep_date2 . " " . $values2['deptime'];

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
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $values2['deptime'] . " - " . $values2['arrtime']; ?>

                                              </span>
                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>
                                            <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $values2['splitduration']; ?></p>
                                            <div class="theme-search-results-item-flight-details-schedule-destination">
                                              <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                  <b><?php echo $values2['origin']; ?></b>
                                                </p>
                                                <?php
                                                $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $values2['origin'] . "' ");
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
                                                  <b><?php echo $values2['destination']; ?></b>
                                                </p>
                                                <?php
                                                $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $values2['destination'] . "' ");
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
            }
          } else {
            echo 'No result found';
          }
          ?>


        </div>
      </div>
    </div>

    </form>
  <?php
  }
  ///for international
  else {
  ?>
    <div class="row">
      <div style="padding: 36px 0 36px 0;" class="container">
        <div class="col-md-12">
          <div class="theme-search-results-sort  clearfix">
            <h3 style="text-align:center; color: #725d93;	"> All Departure and Returns Flights</h3>

          </div>
          <div class="theme-search-results-sort _mob-h clearfix">
            <h5 class="theme-search-results-sort-title">Sort by:</h5>
            <ul class="theme-search-results-sort-list">
              <li>
                <a href="#">Price
                  <span>Low → High</span>
                </a>
              </li>
              <li class="active">
                <a href="#">Duration
                  <span>Long → Short</span>
                </a>
              </li>
              <li>
                <a href="#">Recommended
                  <span>High → Low</span>
                </a>
              </li>
              <li>
                <a href="#">Airline Name
                  <span>Name &nbsp; A → Z</span>
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



          <?php

          if ($total >= 1) {
            foreach ($datas as $key => $value) {
              $onwards_counter = count($value['onwardflights']);
              if ($onwards_counter >= 1) {
                $sr = 1;
                foreach ($value['onwardflights'] as  $keys => $values) {
                  //echo"<pre>";	print_r($values);  echo"</pre>";
                  //echo $orgin = $values['origin']."<br>"; 
                  $duration = $values['duration'];

          ?>
                  <?php
                  $depdate = $values['depdate'];
                  $dep_array = explode("t", $depdate); // split the array
                  $dep_date = $dep_array[0]; //day seqment
                  $dedate = date_create($dep_date);
                  $depar_date =  date_format($dedate, "d  F , l ");

                  $arrdate = $values['arrdate'];
                  $d_array = explode("t", $arrdate); // split the array
                  $arrivaldate = $d_array[0]; //day seqment
                  $adate = date_create($arrivaldate);
                  $ardate =  date_format($adate, "d  F , l ");


                  ?>
                  <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                    <div class="theme-search-results-item-preview">
                      <div class="row" data-gutter="20">
                        <div class="col-md-11 ">
                          <div class="theme-search-results-item-flight-sections">
                            <div class="theme-search-results-item-flight-section">
                              <div class="row row-no-gutter row-eq-height">
                                <div class="col-md-2 ">
                                  <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                    <img class="theme-search-results-item-flight-section-airline-logo" src="img/flight.png" alt="Consta Travel" title="Image Title" />
                                  </div>
                                </div>
                                <div class="col-md-5 " style="border-right: 1px solid #725d93;">
                                  <div class="theme-search-results-item-flight-section-item">
                                    <div class="row">
                                      <div class="col-md-3 ">
                                        <div class="theme-search-results-item-flight-section-meta">
                                          <p class="theme-search-results-item-flight-section-meta-time"><?php echo $values['deptime']; ?>
                                          </p>
                                          <p class="theme-search-results-item-flight-section-meta-city"><?php echo $departure_city; ?></p>
                                          <p class="theme-search-results-item-flight-section-meta-date"><?php echo  $depar_date; ?></p>
                                        </div>
                                      </div>
                                      <div class="col-md-6 ">
                                        <div class="theme-search-results-item-flight-section-path">
                                          <div class="theme-search-results-item-flight-section-path-fly-time">
                                            <p><?php echo $duration; ?> ( <?php if ($values['stops'] == 0) {
                                                                            echo "Non Stop";
                                                                          } else {
                                                                            echo "Stops : " . $values['stops'];
                                                                          } ?> )</p>
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
                                        <?php
                                        if ($values['stops'] == 0) {
                                          $arrivaltym = $values['arrtime'];
                                        }
                                        if ($values['stops'] == 1) {
                                          $arrivaltym = $values['onwardflights']['0']['arrtime'];
                                        }
                                        if ($values['stops'] == 2) {
                                          $arrivaltym = $values['onwardflights']['0']['onwardflights']['0']['arrtime'];
                                        }
                                        ?>
                                        <div class="theme-search-results-item-flight-section-meta">
                                          <p class="theme-search-results-item-flight-section-meta-time"><?php echo $arrivaltym; ?>

                                          </p>
                                          <p class="theme-search-results-item-flight-section-meta-city"><?php echo $destination_city; ?></p>
                                          <p class="theme-search-results-item-flight-section-meta-date"><?php echo $ardate; ?></p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <?php
                                //print_r($values['returnfl']);
                                foreach ($values['returnfl'] as $returnkey => $rvalues) {

                                  $rdepdate = $rvalues['depdate'];
                                  $rdep_array = explode("t", $rdepdate); // split the array
                                  $rdep_date = $rdep_array[0]; //day seqment
                                  $rdedate = date_create($rdep_date);
                                  $rdepar_date =  date_format($rdedate, "d  F , l ");

                                  $rarrdate = $rvalues['arrdate'];
                                  $rd_array = explode("t", $rarrdate); // split the array
                                  $rarrivaldate = $rd_array[0]; //day seqment
                                  $radate = date_create($rarrivaldate);
                                  $rardate =  date_format($radate, "d  F , l ");

                                ?>

                                  <div class="col-md-5 ">
                                    <div class="theme-search-results-item-flight-section-item">
                                      <div class="row">
                                        <div class="col-md-3 ">
                                          <div class="theme-search-results-item-flight-section-meta">
                                            <p class="theme-search-results-item-flight-section-meta-time"><?php echo $rvalues['deptime']; ?>
                                            </p>
                                            <p class="theme-search-results-item-flight-section-meta-city"><?php echo $destination_city; ?></p>
                                            <p class="theme-search-results-item-flight-section-meta-date"><?php echo  $rdepar_date; ?></p>
                                          </div>
                                        </div>
                                        <div class="col-md-6 ">
                                          <div class="theme-search-results-item-flight-section-path">
                                            <div class="theme-search-results-item-flight-section-path-fly-time">
                                              <p><?php echo $rvalues['duration']; ?> ( <?php if ($rvalues['stops'] == 0) {
                                                                                          echo "Non Stop";
                                                                                        } else {
                                                                                          echo "Stops : " . $rvalues['stops'];
                                                                                        } ?> )</p>
                                            </div>
                                            <div class="theme-search-results-item-flight-section-path-line"></div>

                                            <div class="theme-search-results-item-flight-section-path-line-start">
                                              <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                              <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                              <div class="theme-search-results-item-flight-section-path-line-title"><?php echo $destination_city_code; ?></div>
                                            </div>

                                            <div class="theme-search-results-item-flight-section-path-line-end">
                                              <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                              <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                              <div class="theme-search-results-item-flight-section-path-line-title"><?php echo $departure_city_code; ?></div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-3 ">
                                          <?php
                                          if ($rvalues['stops'] == 0) {
                                            $rarrivaltym = $rvalues['arrtime'];
                                          }
                                          if ($rvalues['stops'] == 1) {
                                            $rarrivaltym = $rvalues['onwardflights']['0']['arrtime'];
                                          }
                                          if ($rvalues['stops'] == 2) {
                                            $rarrivaltym = $rvalues['onwardflights']['0']['onwardflights']['0']['arrtime'];
                                          }
                                          ?>
                                          <div class="theme-search-results-item-flight-section-meta">
                                            <p class="theme-search-results-item-flight-section-meta-time"><?php echo $rarrivaltym; ?>

                                            </p>
                                            <p class="theme-search-results-item-flight-section-meta-city"><?php echo $departure_city; ?></p>
                                            <p class="theme-search-results-item-flight-section-meta-date"><?php echo $rardate; ?></p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php

                                }
                                ?>

                              </div>
                              <h5 class="theme-search-results-item-flight-section-airline-title">
                                <?php
                                if ($values['airline'] == $rvalues['airline']) {
                                  echo $values['airline'];
                                } else {
                                  echo $values['airline'] . " and " . $rvalues['airline'];
                                }

                                ?>

                              </h5>
                              <a href="#searchResultsItem-<?php echo $sr; ?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-<?php echo $sr; ?>">
                                <h5 class="theme-search-results-item-flight-section-airline-title">View Flight Details</h5>
                              </a>

                            </div>
                          </div>
                        </div>
                        <div class="col-md-1 ">
                          <div class="theme-search-results-item-book">
                            <div class="theme-search-results-item-price">
                              <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $values['fare']['totalbasefare']; ?></p>
                              <p class="theme-search-results-item-price-sign"><?php if ($travelclass == 'E') {
                                                                                echo "Economy";
                                                                              }
                                                                              if ($travelclass == 'B') {
                                                                                echo "Bussiness";
                                                                              } ?></p>
                            </div>
                            <div style="text-align: center;margin: 0 auto;" class="form-check">
                              <!-- <input class="form-check-input radiobtn " type="radio" name="onwardflights" value="<?php echo $values['FlHash']; ?>" <?php if ($sr == 1) {
                                                                                                                                                          echo "checked";
                                                                                                                                                        } ?> title="<?php echo $values['fare']['totalbasefare']; ?>" onclick="bookingvalue()">
  -->
                              <a href="flight-payment-return.php?token=<?php echo $token; ?>&flightid=<?php echo $values['FlHash']; ?>&returnflightid=<?php echo $rvalues['FlHash']; ?>"><button type="button" class="btn btn-primary">Book</button></a>
                            </div>
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
                                    <p class="theme-search-results-item-flight-details-info-stops"><?php if ($values['stops'] == 0) {
                                                                                                      echo "Non Stop";
                                                                                                    } else {
                                                                                                      echo "Stops : " . $values['stops'];
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
                                          <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $values['deptime'] . " - " . $values['arrtime']; ?>

                                          </span>
                                          <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                        </div>
                                        <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $values['splitduration']; ?></p>
                                        <div class="theme-search-results-item-flight-details-schedule-destination">
                                          <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                              <b><?php echo $values['origin']; ?></b>
                                            </p>
                                            <?php
                                            $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $values['origin'] . "' ");
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
                                              <b><?php echo $values['destination']; ?></b>
                                            </p>
                                            <?php
                                            $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $values['destination'] . "' ");
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
                                  if (empty($values['onwardflights'])) {
                                    //echo "empty";
                                  } else {
                                    $v = 1;
                                    foreach ($values['onwardflights'] as  $keys => $values2) {

                                      $depdate2 = $values2['depdate'];
                                      $dep_array2 = explode("t", $depdate2); // split the array
                                      $dep_date2 = $dep_array2[0]; //day seqment
                                      $dedate2 = date_create($dep_date2);
                                      $depar_date2 =  date_format($dedate2, "d  F , l ");

                                      $arrdate2 = $values2['arrdate'];
                                      $d_array2 = explode("t", $arrdate2); // split the array
                                      $arrivaldate2 = $d_array2[0]; //day seqment
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
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"> <?php echo $values2['origin']; ?> ( Layover )

                                              </span>

                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>

                                            <?php
                                            if ($v == 1) {
                                              $date1 = $arrivaldate . " " . $values['arrtime'];
                                              $date2 = $dep_date2 . " " . $values2['deptime'];
                                              $save =  $arrivaldate2 . " " . $values2['arrtime'];
                                              $dateDiff = intval((strtotime($date2) - strtotime($date1)) / 60);

                                              $hours = intval($dateDiff / 60);
                                              $minutes = $dateDiff % 60;
                                            } else {

                                              $date1 = $save;
                                              $date2 = $dep_date2 . " " . $values2['deptime'];

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
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $values2['deptime'] . " - " . $values2['arrtime']; ?>

                                              </span>
                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>
                                            <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $values2['splitduration']; ?></p>
                                            <div class="theme-search-results-item-flight-details-schedule-destination">
                                              <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                  <b><?php echo $values2['origin']; ?></b>
                                                </p>
                                                <?php
                                                $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $values2['origin'] . "' ");
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
                                                  <b><?php echo $values2['destination']; ?></b>
                                                </p>
                                                <?php
                                                $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $values2['destination'] . "' ");
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

                              <hr>
                              <div class="row">
                                <div class="col-md-3 ">
                                  <div class="theme-search-results-item-flight-details-info">
                                    <h5 class="theme-search-results-item-flight-details-info-title">Depart</h5>
                                    <p class="theme-search-results-item-flight-details-info-date"><?php echo  $rdepar_date2 =  date_format($rdedate, "l , F d  "); ?></p>
                                    <p class="theme-search-results-item-flight-details-info-cities"><?php echo $destination_city; ?> &rarr; <?php echo $departure_city; ?></p>
                                    <p class="theme-search-results-item-flight-details-info-fly-time"><?php echo $rvalues['duration']; ?></p>
                                    <p class="theme-search-results-item-flight-details-info-stops"><?php if ($rvalues['stops'] == 0) {
                                                                                                      echo "Non Stop";
                                                                                                    } else {
                                                                                                      echo "Stops : " . $rvalues['stops'];
                                                                                                    } ?></p>
                                  </div>
                                </div>
                                <div class="col-md-9 ">
                                  <div class="theme-search-results-item-flight-details-schedule">
                                    <ul class="theme-search-results-item-flight-details-schedule-list">
                                      <li>
                                        <i class="fa fa-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                        <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                        <p class="theme-search-results-item-flight-details-schedule-date"><?php echo  $rdepar_date2; ?></p>
                                        <div class="theme-search-results-item-flight-details-schedule-time">
                                          <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $rvalues['deptime'] . " - " . $rvalues['arrtime']; ?>

                                          </span>
                                          <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                        </div>
                                        <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $rvalues['splitduration']; ?></p>
                                        <div class="theme-search-results-item-flight-details-schedule-destination">
                                          <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                              <b><?php echo $rvalues['origin']; ?></b>
                                            </p>
                                            <?php
                                            $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $rvalues['origin'] . "' ");
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
                                              <b><?php echo $rvalues['destination']; ?></b>
                                            </p>
                                            <?php
                                            $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $rvalues['destination'] . "' ");
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
                                  if (empty($rvalues['onwardflights'])) {
                                    //echo "empty";
                                  } else {
                                    $v = 1;
                                    foreach ($rvalues['onwardflights'] as  $keys => $rvalues2) {

                                      $rdepdate2 = $rvalues2['depdate'];
                                      $rdep_array2 = explode("t", $rdepdate2); // split the array
                                      $rdep_date2 = $rdep_array2[0]; //day seqment
                                      $rdedate2 = date_create($rdep_date2);
                                      $rdepar_date2 =  date_format($rdedate2, "d  F , l ");

                                      $rarrdate2 = $rvalues2['arrdate'];
                                      $rd_array2 = explode("t", $rarrdate2); // split the array
                                      $rarrivaldate2 = $rd_array2[0]; //day seqment
                                      $radate2 = date_create($rarrivaldate2);
                                      $rardate2 =  date_format($radate2, "d  F , l ");
                                  ?>

                                      <div class="theme-search-results-item-flight-details-schedule">
                                        <ul class="theme-search-results-item-flight-details-schedule-list">
                                          <li>
                                            <i class="fa fa-clock-o theme-search-results-item-flight-details-schedule-icon"></i>
                                            <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                            <p class="theme-search-results-item-flight-details-schedule-date"> &nbsp; </p>
                                            <div class="theme-search-results-item-flight-details-schedule-time">
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"> <?php echo $rvalues2['origin']; ?> ( Layover )

                                              </span>

                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>

                                            <?php
                                            if ($v == 1) {
                                              $date1 = $rarrivaldate . " " . $rvalues['arrtime'];
                                              $date2 = $rdep_date2 . " " . $rvalues2['deptime'];
                                              $save =  $rarrivaldate2 . " " . $rvalues2['arrtime'];
                                              $dateDiff = intval((strtotime($date2) - strtotime($date1)) / 60);

                                              $hours = intval($dateDiff / 60);
                                              $minutes = $dateDiff % 60;
                                            } else {

                                              $date1 = $save;
                                              $date2 = $rdep_date2 . " " . $rvalues2['deptime'];

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
                                            <p class="theme-search-results-item-flight-details-schedule-date"><?php echo  $rdepar_date2 =  date_format($rdedate2, "l , F d  "); ?></p>
                                            <div class="theme-search-results-item-flight-details-schedule-time">
                                              <span class="theme-search-results-item-flight-details-schedule-time-item"><?php echo  $rvalues2['deptime'] . " - " . $rvalues2['arrtime']; ?>

                                              </span>
                                              <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>

                                            </div>
                                            <p class="theme-search-results-item-flight-details-schedule-fly-time"><?php echo $rvalues2['splitduration']; ?></p>
                                            <div class="theme-search-results-item-flight-details-schedule-destination">
                                              <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                  <b><?php echo $rvalues2['origin']; ?></b>
                                                </p>
                                                <?php
                                                $res = mysql_query("SELECT * FROM `airport_codes` where code='" . $rvalues2['origin'] . "' ");
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
                                                  <b><?php echo $values2['destination']; ?></b>
                                                </p>
                                                <?php
                                                $res2 = mysql_query("SELECT * FROM `airport_codes` where code='" . $rvalues2['destination'] . "' ");
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
            }
          } else {
            echo 'No result found';
          }
          ?>

        </div>

      </div>
    </div>

    </form>

  <?php
  }
  ?>

  <?php
  include('footer.php');
  ?>
  <script>
    window.onscroll = function() {
      myFunction()
    };

    var header = document.getElementById("book");
    var sticky = header.offsetTop;

    function myFunction() {
      if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    }
  </script>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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