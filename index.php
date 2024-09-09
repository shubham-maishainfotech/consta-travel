<?php

include('connection.php');
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Consta Travel</title>
  <?php
  include('head.php');
  ?>
  <style type="text/css">
    .select2-container--default .select2-selection--single {
      /* background-color: #fff; */
      border: none !important;
      border-radius: 4px;
    }

    .ui-widget.ui-widget-content {
      border: 1px solid #c5c5c5;
      overflow: scroll !important;
      max-height: 300px !important;
    }

    @media only screen and (max-width: 600px) {
      .theme-search-area-section-icon {

        width: 20px !important;
        height: 32px !important;
        line-height: 62px !important;

      }
    }

    .tab-content {
      margin-top: 7px;
    }

    .tabbable {
      padding: 30px 30px;
      border-radius: 11px;
      border: 1px solid rgb(230, 230, 230);
      box-shadow: rgba(0, 0, 0, 0.04) 0px 8px 16px;
    }

    .col-md-6 {
      position: relative;
      min-height: 1px;
      padding-right: 10px;
      padding-left: 10px;
    }

    .fa-solid.fa-plane-departure,
    .fa-solid.fa-plane-arrival {
      position: absolute;
      top: 21px;
      font-size: 18px;
    }

    img.active {
      width: 100%;
    }

    .main_container {
      display: flex;
      align-items: center;
    }
    .second_container{
      display: flex;
      align-items: center;
    }
    .no_line{
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>
  <?php
  include('header.php');
  ?>
  <div class="_pt-90 container _pt-mob-30">
    <div class="row main_container">
      <div class="col-md-6 ">
        <div class="theme-search-area-tabs">
          <div class="theme-search-area-tabs-header">
            <h1 class="theme-search-area-tabs-title">Book Your Trip</h1>
            <p class="theme-search-area-tabs-subtitle theme-search-area-tabs-subtitle-sm">Compare hundreds travel websites at once</p>
          </div>
          <div class="tabbable">
            <ul class="nav nav-tabs nav-lg nav-line nav-default nav-mob-inline" id="slideTabs" role="tablist">
              <li class="active" role="presentation">
                <a aria-controls="SearchAreaTabs-3" role="tab" data-toggle="tab" href="#SearchAreaTabs-3">Flights</a>
              </li>
              <li role="presentation">
                <a aria-controls="SearchAreaTabs-1" role="tab" data-toggle="tab" href="#SearchAreaTabs-1">Hotels</a>
              </li>
              <!-- <li role="presentation">
                <a aria-controls="SearchAreaTabs-2" role="tab" data-toggle="tab" href="#SearchAreaTabs-2">Bus</a>
              </li> -->


            </ul>
            <div class="tab-content _pt-20">
              <div class="tab-pane active" id="SearchAreaTabs-3" role="tab-panel">
                <div class="theme-search-area theme-search-area-vert">

                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#oneway">One Way</a></li>
                    <li><a data-toggle="tab" href="#roundway"> Round Trip</a></li>

                  </ul>

                  <div class="tab-content">
                    <div id="oneway" class="tab-pane fade in active">
                      <div class="theme-search-area-form">

                        <div class="row second_container" data-gutter="30">
                          <?php

                          // $fcodequery = mysql_query("SELECT * FROM `airport_codes`");
                          // $sr = 1;
                          // while ($fcodedata = mysql_fetch_array($fcodequery)) {
                          //   $sr++;
                          //   echo "<pre>";
                          //   print_r($fcodedata);
                          //   if($sr == 3) break;
                          // } 

                          ?>
                          <div class="col-md-5 ">
                            <div class="col-md-12" style="border-bottom: 2px solid #989898; padding: 0px;">



                              <div class="col-md-2 ">
                                <i class="fa-solid fa-plane-departure"></i>
                              </div>
                              <div class="col-md-10 ">

                                <!-- <script>
                                  $(function() {
                                    var availableTags = [
                                      <?php
                                      // $fcodequery = mysql_query("SELECT  DISTINCT city FROM `airport_codes`");
                                      // while ($fcodedata = mysql_fetch_array($fcodequery)) {
                                      //   echo '"' . $fcodedata['city'] . '",';
                                      // } 
                                      ?> "Scheme"
                                    ];
                                    $("#flightonewayfrom").autocomplete({
                                      source: availableTags
                                    });
                                    $("#flightonewayto").autocomplete({
                                      source: availableTags
                                    });
                                    $("#flightroundwayfrom").autocomplete({
                                      source: availableTags
                                    });
                                    $("#flightroundwayto").autocomplete({
                                      source: availableTags
                                    });
                                  });
                                </script> -->
                                <script>
                                  $(function() {
                                    var availableTags = [
                                      <?php
                                      $fcodequery = mysql_query("SELECT DISTINCT city, code, country FROM `airport_codes`");
                                      $tags = [];
                                      while ($fcodedata = mysql_fetch_array($fcodequery)) {
                                        $tags[] = '"' . $fcodedata['code'] . ' - ' . $fcodedata['city'] . ', ' . $fcodedata['country'] . '"';
                                      }
                                      echo implode(',', $tags);
                                      ?>
                                    ];

                                    function customSort(term, results) {
                                      term = term.toLowerCase();

                                      return results.sort(function(a, b) {
                                        var aLower = a.toLowerCase();
                                        var bLower = b.toLowerCase();

                                        var aStartsWith = aLower.indexOf(term) === 0;
                                        var bStartsWith = bLower.indexOf(term) === 0;

                                        if (aStartsWith && !bStartsWith) return -1;
                                        if (!aStartsWith && bStartsWith) return 1;
                                        return 0;
                                      });
                                    }

                                    $("#flightonewayfrom, #flightonewayto, #flightroundwayfrom, #flightroundwayto").autocomplete({
                                      source: function(request, response) {
                                        var filteredResults = $.ui.autocomplete.filter(availableTags, request.term);
                                        var sortedResults = customSort(request.term, filteredResults);
                                        response(sortedResults);
                                      },
                                      minLength: 2,
                                      delay: 300,
                                    });
                                  });
                                </script>


                                <form autocomplete="off">
                                  <input class="theme-search-area-section-input" id="flightonewayfrom" name="departure_city" style="padding-left:8px;" placeholder="Departure City" onchange="dpairportcode(this.value)" required="">

                                </form>




                                <!-- <input  class="theme-search-area-section-input typeahead" id="flightfrom"   type="text" placeholder="Departure" required /> -->

                                <input type="hidden" id="flightonewayairportcode1" name="departure_city_code" class="fo9rm-control" required>
                                <script type="text/javascript">
                                  //--------------Destination Valid Check -------------->
                                  function dpairportcode(str) {
                                    $("#flightonewayairportcode1").val(str.substring(0, 3));
                                    $("#flightonewayerror1").html("");
                                    console.log(str.substring(0, 3));
                                    // $.ajax({
                                    //   type: "POST",
                                    //   data: "sid=" + str,
                                    //   url: 'flight-ajax.php',
                                    //   success: function(response) {
                                    //     if (response != "") {
                                    //       $("#flightonewayairportcode1").val(response);
                                    //       $("#flightonewayerror1").html("");
                                    //     } else {
                                    //       //$("#error1").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Destination Source </p> ");	
                                    //     }
                                    //   }
                                    // });

                                  }
                                </script>

                              </div>

                            </div>
                            <div id="flightonewayerror1"></div>
                          </div>
                           <div class="col-md-1">
                           <i class="fa-solid fa-right-left"></i>
                           </div>
                          <div class="col-md-6 ">
                            <div class="col-md-12" style="border-bottom: 2px solid #989898; padding: 0px;">



                              <div class="col-md-2 ">
                                <i class="fa-solid fa-plane-arrival"></i>
                              </div>
                              <div class="col-md-10 ">

                                <form autocomplete="off">
                                  <input class="theme-search-area-section-input" id="flightonewayto" name="destination_city" style="padding-left:8px;" placeholder="Destination City" onchange="dairportcode(this.value)" required="">
                                </form>



                                <!-- <input  class="theme-search-area-section-input typeahead" id="flightfrom"   type="text" placeholder="Departure" required /> -->

                                <input type="hidden" id="flightonewayairportcode" name="destination_city_code" class="fo9rm-control" required>
                                <script type="text/javascript">
                                  //--------------Destination Valid Check -------------->
                                  function dairportcode(str) {
                                    $("#flightonewayairportcode").val(str.substring(0, 3));
                                    $("#flightonewayerror2").html("");
                                    console.log(str.substring(0, 3));

                                    // $.ajax({
                                    //   type: "POST",
                                    //   data: "sid=" + str,
                                    //   url: 'flight-ajax.php',
                                    //   success: function(response) {
                                    //     if (response != "") {
                                    //       $("#flightonewayairportcode").val(response);
                                    //       $("#flightonewayerror2").html("");
                                    //     } else {
                                    //       //$("#error").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Source </p> ");  
                                    //     }
                                    //   }
                                    // });

                                  }
                                </script>

                              </div>
                            </div>
                            <div id="flightonewayerror2"></div>
                          </div>


                          <!-- <div class="col-md-6 ">
                          <div class="theme-search-area-section theme-search-area-section-line">
                            <div class="theme-search-area-section-inner">
                              <i class="theme-search-area-section-icon lin lin-location-pin"></i>

                              <input class="theme-search-area-section-input typeahead" id="flightto" name="destination_city" onblur="dairportcode(this.value)" type="text" placeholder="Arrival" required />
								<div id="error" ></div>
								<input type="hidden" id="airportcode"  name="destination_city_code" class="form-control" required >   
								<script type="text/javascript">       
								function dairportcode(str)
								{
								//alert('');

								$.ajax({
								type: "POST",
								data: "sid=" + str ,
								url: 'flight-ajax.php',
								success: function(response) {
								if(response!= "") 
								{
								//alert(response);
								//$("#airportcode").html(response);
								$("#airportcode").val(response);
								$("#error").html("");	
								}
								else{
								$("#error").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Source </p> ");	
								}
								}
								});

								}


								</script>  								
						   </div>
                          </div>
                        </div> -->
                        </div>
                        <div class="row" data-gutter="30">
                          <div class="col-md-6 ">
                            <div class="theme-search-area-section theme-search-area-section-line">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon lin lin-calendar"></i>
                                <input type="text" class="form-control theme-search-area-section-input" name="checkin_date" id="flightonewaydeparture_date" value="<?php echo date("d-m-Y"); ?>" autocomplete="off" style="background-color:#fff;" readonly />
                                <script type="text/javascript">
                                  var dateToday = new Date();

                                  $('#flightonewaydeparture_date').datepicker({
                                    dateFormat: "dd-m-yy",
                                    minDate: dateToday,
                                  });
                                </script>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 ">
                            <div class="theme-search-area-section theme-search-area-section-line">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon fa fa-plane"></i>
                                <select class="theme-search-area-section-input typeahead" id="flightonewaytravelclass" name="travelclass" required>
                                  <option value="ECONOMY">Economy</option>
                                  <option value="PREMIUM_ECONOMY">Premium Economy</option>
                                  <option value="BUSINESS">Business </option>
                                  <option value="FIRST">First </option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" data-gutter="30">
                          <div class="col-md-4 ">
                            <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Adults">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon lin lin-people"></i>
                                <input class="theme-search-area-section-input" value="1" name="adult" id="flightonewayadult" type="text" onchange="totaltravellers();" readonly required />
                                <div class="quantity-selector-box" id="FlySearchAdults">
                                  <div class="quantity-selector-inner">
                                    <p class="quantity-selector-title">Adults</p>
                                    <ul class="quantity-selector-controls">
                                      <li id="decrease" onclick="decreaseValue4()" value="Decrease Value">
                                        <a href="javascript:;">&#45;</a>
                                      </li>

                                      <li id="increase" onclick="increaseValue4()" value="Increase Value">
                                        <a href="javascript:;">&#43;</a>
                                      </li>
                                    </ul>

                                    <script type="text/javascript">
                                      function increaseValue4() {

                                        var value = parseInt(document.getElementById('flightonewayadult').value, 10);
                                        if (value < 9) {
                                          value = isNaN(value) ? 0 : value;
                                          value++;
                                          document.getElementById('flightonewayadult').value = value;
                                        }
                                      }

                                      function decreaseValue4() {
                                        var value = parseInt(document.getElementById('flightonewayadult').value, 10);
                                        if (value > 1) {
                                          value = isNaN(value) ? 0 : value;
                                          value < 1 ? value = 1 : '';
                                          value--;
                                          document.getElementById('flightonewayadult').value = value;
                                        }
                                      }
                                    </script>
                                  </div>
                                </div>
                              </div>
                              <p class="subtitleform">12+ Years</p>
                            </div>

                          </div>
                          <div class="col-md-4 ">
                            <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Childs">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon fa fa-child"></i>
                                <input class="theme-search-area-section-input" value="0" name="child" id="flightonewaychild" type="text" onchange="totaltravellers();" readonly required />
                                <div class="quantity-selector-box" id="FlySearchChilds">
                                  <div class="quantity-selector-inner">
                                    <p class="quantity-selector-title">Childs</p>
                                    <ul class="quantity-selector-controls">
                                      <li class="quantity-selector-decrement">
                                        <a href="#">&#45;</a>
                                      </li>
                                      <li class="quantity-selector-current">0</li>
                                      <li class="quantity-selector-increment">
                                        <a href="#">&#43;</a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <p class="subtitleform">2-12 Years</p>
                            </div>

                          </div>
                          <div class="col-md-4 ">
                            <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Infants">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon fas fa-baby"></i>
                                <input class="theme-search-area-section-input" value="0" type="text" name="infants" id="flightonewayinfants" onchange="totaltravellers();" readonly required />
                                <div class="quantity-selector-box" id="FlySearchInfants">
                                  <div class="quantity-selector-inner">
                                    <p class="quantity-selector-title">Infants</p>
                                    <ul class="quantity-selector-controls">
                                      <li class="quantity-selector-decrement">
                                        <a href="#">&#45;</a>
                                      </li>
                                      <li class="quantity-selector-current">0</li>
                                      <li class="quantity-selector-increment">
                                        <a href="#">&#43;</a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <p class="subtitleform">Below 2 Years</p>
                            </div>

                            <script>
                              $(document).ready(function() {
                                $("#oneway .quantity-selector-controls li").click(function() {
                                  //alert('hey');
                                  var flightonewayadult = $('#flightonewayadult').val();
                                  var flightonewaychild = $('#flightonewaychild').val();
                                  var flightonewayinfants = $('#flightonewayinfants').val();

                                  var totaltraveller = parseInt(flightonewayadult, 10) + parseInt(flightonewaychild, 10) + parseInt(flightonewayinfants, 10);
                                  //alert(totaltraveller);
                                  if (totaltraveller > 9) {
                                    document.getElementById("flightonewayerror3").innerHTML = "<p style='color: red;padding-left: 15px;' > Maximum 9 traveller Allowed</p>";
                                    $("#onewaysubmitbtn").attr("onclick", "javascript:;");
                                  } else {

                                    if (flightonewayinfants > flightonewayadult) {
                                      document.getElementById("flightonewayerror3").innerHTML = "<p style='color: red;padding-left: 15px;' > Number of infants cannot be more than adults </p>";

                                    } else {
                                      $("#onewaysubmitbtn").attr("onclick", "flightonewaysubmit()");
                                      document.getElementById("flightonewayerror3").innerHTML = "";

                                    }
                                  }

                                });
                              });
                            </script>
                          </div>
                          <div id="flightonewayerror3"></div>
                        </div>

                        <div class="row" data-gutter="30">

                          <div class="col-md-6 ">
                            <button class="theme-search-area-submit _mt-20 theme-search-area-submit-curved theme-search-area-submit-primary btks" id="onewaysubmitbtn" onclick="flightonewaysubmit()">Search</button>
                            <script type="text/javascript">
                              function flightonewaysubmit() {
                                //alert('hey');
                                var flightonewayairportcode1 = document.getElementById("flightonewayairportcode1").value;
                                var flightonewayairportcode = document.getElementById("flightonewayairportcode").value;
                                var flightonewayfrom = document.getElementById("flightonewayfrom").value;
                                var flightonewayto = document.getElementById("flightonewayto").value;
                                var flightonewaydeparture_date = document.getElementById("flightonewaydeparture_date").value;
                                var flightonewaytravelclass = document.getElementById("flightonewaytravelclass").value;
                                var flightonewayadult = document.getElementById("flightonewayadult").value;
                                var flightonewaychild = document.getElementById("flightonewaychild").value;
                                var flightonewayinfants = document.getElementById("flightonewayinfants").value;


                                if (flightonewayfrom == "") {
                                  $("#flightonewayerror1").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a Departure city </p> ");
                                } else {
                                  $("#flightonewayerror1").html(" ");
                                }

                                if (flightonewayto == "") {
                                  $("#flightonewayerror2").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a Destination city </p> ");
                                } else {
                                  $("#flightonewayerror2").html(" ");
                                }


                                if (flightonewayfrom != "" && flightonewayto != "") {
                                  if (flightonewayfrom == flightonewayto) {
                                    $("#flightonewayerror2").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 20px;'> Departure city and Destination City Cannot Be Same </p> ");

                                  } else {


                                    var xhttp = new XMLHttpRequest();

                                    xhttp.onreadystatechange = function() {
                                      if (this.readyState == 4 && this.status == 200) {
                                        //document.getElementById("demo").innerHTML = this.responseText;
                                        var z = this.responseText;
                                        //alert(""+z+"");
                                        // window.location.href = "flight-search.php?token=" + z + "";
                                        window.location.href = "new-flight-search.php?token=" + z + "";
                                      }
                                    };

                                    xhttp.open("GET", "flight-token.php?departure_city_code=" + flightonewayairportcode1 + "&destination_city_code=" + flightonewayairportcode + "&departure_city=" + flightonewayfrom + "&destination_city=" + flightonewayto + "&departure_date=" + flightonewaydeparture_date + "&adult=" + flightonewayadult + "&child=" + flightonewaychild + "&infants=" + flightonewayinfants + "&travelclass=" + flightonewaytravelclass + "", true);
                                    xhttp.send();
                                    let abc = "flight-token.php?departure_city_code=" + flightonewayairportcode1 + "&destination_city_code=" + flightonewayairportcode + "&departure_city=" + flightonewayfrom + "&destination_city=" + flightonewayto + "&departure_date=" + flightonewaydeparture_date + "&adult=" + flightonewayadult + "&child=" + flightonewaychild + "&infants=" + flightonewayinfants + "&travelclass=" + flightonewaytravelclass + "";
                                    console.log(abc);
                                  }
                                }

                              }
                            </script>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div id="roundway" class="tab-pane fade">
                      <div class="theme-search-area-form">

                        <div class="row second_container" data-gutter="30">

                          <div class="col-md-5 ">
                            <div class="col-md-12" style="border-bottom: 2px solid #989898; padding: 0px;">



                              <div class="col-md-2 ">
                                <i class="fa-solid fa-plane-departure"></i>
                              </div>
                              <div class="col-md-10 ">


                                <form autocomplete="off">

                                  <input class="theme-search-area-section-input " id="flightroundwayfrom" name="departure_city" style="padding-left:8px;" placeholder="Departure City" onchange="rdpairportcode(this.value)" required="">
                                </form>


                                </select>

                                <!-- <input  class="theme-search-area-section-input typeahead" id="flightfrom"   type="text" placeholder="Departure" required /> -->

                                <input type="hidden" id="flightroundwayairportcode1" name="departure_city_code" class="form-control" required>
                                <script type="text/javascript">
                                  function rdpairportcode(str) {
                                    //alert('');

                                    $.ajax({
                                      type: "POST",
                                      data: "sid=" + str,
                                      url: 'flight-ajax.php',
                                      success: function(response) {
                                        if (response != "") {
                                          //alert(response);
                                          //$("#airportcode").html(response);
                                          $("#flightroundwayairportcode1").val(response);
                                          $("#rerror1").html("");
                                        } else {
                                          $("#rerror1").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Destination Source </p> ");
                                        }
                                      }
                                    });

                                  }
                                </script>

                              </div>
                            </div>
                            <div id="flightroundwayerror1"></div>
                          </div>

                          <!--  <div class="col-md-6 ">
                          <div class="theme-search-area-section first theme-search-area-section-line">
                            <div class="theme-search-area-section-inner">
                              <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                              <input  class="theme-search-area-section-input typeahead" id="rflightfrom" name="departure_city" onblur="rdpairportcode(this.value)"  type="text" placeholder="Departure" required />
								<div id="rerror1" ></div>
								<input type="hidden" id="rairportcode1"  name="departure_city_code" class="form-control" required >
								<script type="text/javascript">        
								function rdpairportcode(str)
								{
								//alert('');

								$.ajax({
								type: "POST",
								data: "sid=" + str ,
								url: 'flight-ajax.php',
								success: function(response) {
								if(response!= "") 
								{
								//alert(response);
								//$("#airportcode").html(response);
								$("#rairportcode1").val(response);
								$("#rerror1").html("");	
								}
								else{
								$("#rerror1").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Destination Source </p> ");	
								}
								}
								});

								}


								</script>
							</div>
                          </div>
                        </div> -->
                          <div class="col-md-1">
                           <i class="fa-solid fa-right-left"></i>
                           </div>
                          <div class="col-md-6 ">
                            <div class="col-md-12" style="border-bottom: 2px solid #989898; padding: 0px;">



                              <div class="col-md-2 ">
                                <i class="fa-solid fa-plane-arrival"></i>
                              </div>
                              <div class="col-md-10 ">

                                <form autocomplete="off">

                                  <input class="theme-search-area-section-input " id="flightroundwayto" name="destination_city" style="padding-left:8px;" placeholder="Destination City" onchange="rdairportcode(this.value)" required="">
                                </form>
                                <!-- <input  class="theme-search-area-section-input typeahead" id="flightfrom"   type="text" placeholder="Departure" required /> -->

                                <input type="hidden" id="flightroundwayairportcode" name="destination_city_code" class="form-control" required>
                                <script type="text/javascript">
                                  function rdairportcode(str) {
                                    //alert('');

                                    $.ajax({
                                      type: "POST",
                                      data: "sid=" + str,
                                      url: 'flight-ajax.php',
                                      success: function(response) {
                                        if (response != "") {
                                          //alert(response);
                                          //$("#airportcode").html(response);
                                          $("#flightroundwayairportcode").val(response);
                                          $("#flightroundwayerror2").html("");
                                        } else {
                                          $("#flightroundwayerror2").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Source </p> ");
                                        }
                                      }
                                    });

                                  }
                                </script>

                              </div>
                            </div>
                            <div id="flightroundwayerror2"></div>
                          </div>

                          <!--  <div class="col-md-6 ">
                          <div class="theme-search-area-section theme-search-area-section-line">
                            <div class="theme-search-area-section-inner">
                              <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                              <input class="theme-search-area-section-input typeahead" id="rflightto" name="destination_city" onblur="rdairportcode(this.value)" type="text" placeholder="Arrival" required />
								<div id="rerror" ></div>
								<input type="hidden" id="rairportcode"  name="destination_city_code" class="form-control" required >   
								<script type="text/javascript">      
								function rdairportcode(str)
								{
								//alert('');

								$.ajax({
								type: "POST",
								data: "sid=" + str ,
								url: 'flight-ajax.php',
								success: function(response) {
								if(response!= "") 
								{
								//alert(response);
								//$("#airportcode").html(response);
								$("#rairportcode").val(response);
								$("#rerror").html("");	
								}
								else{
								$("#rerror").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Source </p> ");	
								}
								}
								});

								}


								</script>  								
						   </div>
                          </div>
                        </div> -->
                        </div>
                        <div class="row" data-gutter="30">
                          <div class="col-md-6 ">
                            <div class="theme-search-area-section theme-search-area-section-line">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon lin lin-calendar"></i>
                                <input class="form-control theme-search-area-section-input" type="text" id="flightroundwaydeparture_date" name="departure_date" value="<?php echo date("d-m-Y"); ?>" autocomplete="off" style="background-color:#fff;" readonly required />


                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 ">
                            <div class="theme-search-area-section theme-search-area-section-line">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon lin lin-calendar"></i>
                                <?php
                                $stop_date = date('d-m-Y', strtotime($todaydate . ' +1 day'));
                                ?>
                                <input class="form-control theme-search-area-section-input" type="text" id="flightroundwayreturn_date" name="return_date" value="<?php echo date("d-m-Y"); ?>" autocomplete="off" style="background-color:#fff;" readonly required />
                                <script type="text/javascript">
                                  var dateToday = new Date();
                                  var tomorrow = new Date();
                                  tomorrow.setDate(tomorrow.getDate() + 0);
                                  $('#flightroundwayreturn_date').datepicker({
                                    dateFormat: "dd-m-yy",
                                    minDate: tomorrow,
                                  });

                                  $("#flightroundwaydeparture_date").datepicker({
                                    dateFormat: "dd-m-yy",
                                    minDate: dateToday,
                                    onSelect: function(date) {
                                      var date1 = $('#flightroundwaydeparture_date').datepicker('getDate');
                                      var date = new Date(Date.parse(date1));
                                      date.setDate(date.getDate() + 0);
                                      var newDate = date.toDateString();
                                      newDate = new Date(Date.parse(newDate));
                                      $('#flightroundwayreturn_date').datepicker("option", "minDate", newDate);
                                    }
                                  });
                                </script>

                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" data-gutter="30">
                          <div class="col-md-12 ">
                            <div class="theme-search-area-section theme-search-area-section-line">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon fa fa-plane"></i>
                                <select class="theme-search-area-section-input typeahead" id="flightroundwaytravelclass" name="travelclass" required>
                                  <option value="ECONOMY">Economy</option>
                                  <option value="PREMIUM_ECONOMY">Premium Economy</option>
                                  <option value="BUSINESS">Business </option>
                                  <option value="FIRST">First </option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" data-gutter="30">
                          <div class="col-md-4 ">
                            <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Adults">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon lin lin-people"></i>
                                <input class="theme-search-area-section-input" value="1" name="adult" id="flightroundwayadult" type="text" readonly required />
                                <div class="quantity-selector-box" id="FlySearchAdults">
                                  <div class="quantity-selector-inner">
                                    <p class="quantity-selector-title">Adults</p>
                                    <ul class="quantity-selector-controls">
                                      <li id="decrease" onclick="decreaseValue5()" value="Decrease Value">
                                        <a href="javascript:;">&#45;</a>
                                      </li>

                                      <li id="increase" onclick="increaseValue5()" value="Increase Value">
                                        <a href="javascript:;">&#43;</a>
                                      </li>
                                    </ul>

                                    <script type="text/javascript">
                                      function increaseValue5() {

                                        var value = parseInt(document.getElementById('flightroundwayadult').value, 10);
                                        if (value < 9) {
                                          value = isNaN(value) ? 0 : value;
                                          value++;
                                          document.getElementById('flightroundwayadult').value = value;
                                        }
                                      }

                                      function decreaseValue5() {
                                        var value = parseInt(document.getElementById('flightroundwayadult').value, 10);
                                        if (value > 1) {
                                          value = isNaN(value) ? 0 : value;
                                          value < 1 ? value = 1 : '';
                                          value--;
                                          document.getElementById('flightroundwayadult').value = value;
                                        }
                                      }
                                    </script>

                                  </div>
                                </div>
                              </div>
                              <p class="subtitleform">12+ Years</p>
                            </div>

                          </div>
                          <div class="col-md-4 ">
                            <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Childs">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon fa fa-child"></i>
                                <input class="theme-search-area-section-input" value="0" name="child" id="flightroundwaychild" type="text" readonly required />
                                <div class="quantity-selector-box" id="FlySearchChilds">
                                  <div class="quantity-selector-inner">
                                    <p class="quantity-selector-title">Childs</p>
                                    <ul class="quantity-selector-controls">
                                      <li class="quantity-selector-decrement">
                                        <a href="#">&#45;</a>
                                      </li>
                                      <li class="quantity-selector-current">0</li>
                                      <li class="quantity-selector-increment">
                                        <a href="#">&#43;</a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <p class="subtitleform">2-12 Years</p>
                            </div>

                          </div>
                          <div class="col-md-4 ">
                            <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Infants">
                              <div class="theme-search-area-section-inner">
                                <i class="theme-search-area-section-icon fas fa-baby"></i>
                                <input class="theme-search-area-section-input" value="0" type="text" id="flightroundwayinfants" name="infants" readonly required />
                                <div class="quantity-selector-box" id="FlySearchInfants">
                                  <div class="quantity-selector-inner">
                                    <p class="quantity-selector-title">Infants</p>
                                    <ul class="quantity-selector-controls">
                                      <li class="quantity-selector-decrement">
                                        <a href="#">&#45;</a>
                                      </li>
                                      <li class="quantity-selector-current">0</li>
                                      <li class="quantity-selector-increment">
                                        <a href="#">&#43;</a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <p class="subtitleform">Below 2 Years</p>
                              <script>
                                $(document).ready(function() {
                                  $("#roundway .quantity-selector-controls li").click(function() {
                                    //alert('hey');
                                    var flightroundwayadult = $('#flightroundwayadult').val();
                                    var flightroundwaychild = $('#flightroundwaychild').val();
                                    var flightroundwayinfants = $('#flightroundwayinfants').val();

                                    var rtotaltraveller = parseInt(flightroundwayadult, 10) + parseInt(flightroundwaychild, 10) + parseInt(flightroundwayinfants, 10);
                                    //alert(totaltraveller);
                                    if (rtotaltraveller > 9) {
                                      document.getElementById("flightroundwayerror3").innerHTML = "<p style='color: red;padding-left: 15px;' > Maximum 9 traveller Allowed</p>";
                                      $("#roundwaysubmitbtn").attr("onclick", "javascript:;");
                                    } else {

                                      if (flightroundwayinfants > flightroundwayadult) {
                                        document.getElementById("flightroundwayerror3").innerHTML = "<p style=' color: red;padding-left: 15px;' > Number of infants cannot be more than adults </p>";

                                      } else {
                                        $("#roundwaysubmitbtn").attr("onclick", "flightroundwaysubmit()");
                                        document.getElementById("flightroundwayerror3").innerHTML = "";

                                      }
                                    }

                                  });
                                });
                              </script>
                            </div>


                          </div>
                          <div id="flightroundwayerror3"></div>
                        </div>

                        <div class="row" data-gutter="30">

                          <div class="col-md-6 ">
                            <button class="theme-search-area-submit _mt-20 theme-search-area-submit-curved theme-search-area-submit-primary btks" id="roundwaysubmitbtn" onclick="flightroundwaysubmit()">Search</button>
                            <script type="text/javascript">
                              function flightroundwaysubmit() {
                                var flightroundwayairportcode1 = document.getElementById("flightroundwayairportcode1").value;
                                var flightroundwayairportcode = document.getElementById("flightroundwayairportcode").value;
                                var flightroundwayfrom = document.getElementById("flightroundwayfrom").value;
                                var flightroundwayto = document.getElementById("flightroundwayto").value;
                                var flightroundwaydeparture_date = document.getElementById("flightroundwaydeparture_date").value;
                                var flightroundwayreturn_date = document.getElementById("flightroundwayreturn_date").value;
                                var flightroundwaytravelclass = document.getElementById("flightroundwaytravelclass").value;
                                var flightroundwayadult = document.getElementById("flightroundwayadult").value;
                                var flightroundwaychild = document.getElementById("flightroundwaychild").value;
                                var flightroundwayinfants = document.getElementById("flightroundwayinfants").value;


                                if (flightroundwayfrom == "") {
                                  $("#flightroundwayerror1").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a Departure city </p> ");
                                } else {
                                  $("#flightroundwayerror1").html(" ");
                                }

                                if (flightroundwayto == "") {
                                  $("#flightroundwayerror2").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a Destination city </p> ");
                                } else {
                                  $("#flightroundwayerror2").html(" ");
                                }


                                if (flightroundwayfrom != "" && flightroundwayto != "") {
                                  if (flightroundwayfrom == flightroundwayto) {
                                    $("#flightroundwayerror2").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 20px;'> Departure city and Destination City Cannot Be Same </p> ");

                                  } else {

                                    // let parameter = flightroundwayairportcode1 + "&destination_city_code=" + flightroundwayairportcode + "&departure_city=" + flightroundwayfrom + "&destination_city=" + flightroundwayto + "&departure_date=" + flightroundwaydeparture_date + "&return_date=" + flightroundwayreturn_date + "&adult=" + flightroundwayadult + "&child=" + flightroundwaychild + "&infants=" + flightroundwayinfants + "&travelclass=" + flightroundwaytravelclass + "";
                                    // alert(parameter);
                                    // console.log(parameter);


                                    var xhttp = new XMLHttpRequest();

                                    xhttp.onreadystatechange = function() {
                                      if (this.readyState == 4 && this.status == 200) {
                                        //document.getElementById("demo").innerHTML = this.responseText;
                                        var z = this.responseText;
                                        //alert(""+z+"");
                                        window.location.href = "new-flight-return.php?token=" + z + "";
                                      }
                                    };
                                    xhttp.open("GET", "flight-token.php?departure_city_code=" + flightroundwayairportcode1 + "&destination_city_code=" + flightroundwayairportcode + "&departure_city=" + flightroundwayfrom + "&destination_city=" + flightroundwayto + "&departure_date=" + flightroundwaydeparture_date + "&return_date=" + flightroundwayreturn_date + "&adult=" + flightroundwayadult + "&child=" + flightroundwaychild + "&infants=" + flightroundwayinfants + "&travelclass=" + flightroundwaytravelclass + "", true);
                                    xhttp.send();
                                  }

                                }

                              }
                            </script>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </div>

              <div class="tab-pane " id="SearchAreaTabs-1" role="tab-panel">
                <div class="theme-search-area theme-search-area-vert">
                  <div class="theme-search-area-form">
                    <div class="theme-search-area-section first theme-search-area-section-line">


                      <div class="row" data-gutter="30">
                        <div class="col-md-12" style=" ">

                          <div class="col-md-12" style=" border-bottom: 2px solid #989898; padding: 0px;">

                            <div class="col-md-1 ">
                              <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                            </div>
                            <div class="col-md-11 ">
                              <form autocomplete="off">
                                <input type="text" class="theme-search-area-section-input" placeholder="Enter Hotel City" style="padding-left:8px;" name="destination_city" onchange="hotelcitycode(this.value)" id="hotelto" required>
                              </form>
                              <script>
                                $(function() {
                                  var availableHotels = [
                                    <?php
                                    $hotelcitynamequery = mysql_query("SELECT * FROM `cityids` ");

                                    while ($hotelcitynamedata =  mysql_fetch_array($hotelcitynamequery)) {
                                      echo $city_name = '"' . $hotelcitynamedata['city_name'] . '",';
                                    }
                                    ?> "0"
                                  ];
                                  $("#hotelto").autocomplete({
                                    source: availableHotels
                                  });

                                });
                              </script>

                              <!-- <input  class="theme-search-area-section-input typeahead" id="flightfrom"   type="text" placeholder="Departure" required /> -->

                              <input type="hidden" id="citycode" name="citycode" class="form-control" required>

                              <script type="text/javascript">
                                //--------------Destination Valid Check -------------->
                                function hotelcitycode(str) {
                                  //alert('');

                                  $.ajax({
                                    type: "POST",
                                    data: "sid=" + str,
                                    url: 'hotelcity-ajax.php',
                                    success: function(response) {
                                      if (response != "") {
                                        //alert(response);
                                        //$("#airportcode").html(response);
                                        $("#citycode").val(response);
                                        $("#hotelerror1").html("");
                                      } else {
                                        //$("#hotelerror1").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Destination  </p> ");	
                                        //$("#citycode").val("");
                                      }
                                    }
                                  });

                                }
                              </script>

                            </div>
                          </div>
                        </div>
                        <div id="hotelerror1"></div>


                      </div>
                    </div>
                    <!--  <div class="theme-search-area-section-inner">
						<form action="hotel-token.php" method="post" autocomplete="off" >
                          <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                          <input class="theme-search-area-section-input typeahead" type="text" placeholder="Hotel Location" name="destination_city" onblur="hotelcitycode(this.value)" id="hotelto" />
							<div id="hotelerror" ></div>
							<input type="hidden" id="citycode"   name="citycode" class="form-control" required >
							
							<script type="text/javascript">        
								function hotelcitycode(str)
								{
								//alert('');

								$.ajax({
								type: "POST",
								data: "sid=" + str ,
								url: 'hotelcity-ajax.php',
								success: function(response) {
								if(response!= "") 
								{
								//alert(response);
								//$("#airportcode").html(response);
								$("#citycode").val(response);
								$("#hotelerror").html("");	
								}
								else{
								$("#hotelerror").html("<p style='color: red; background: #fff; font-size: 13px;'> Not A Valid Destination  </p> ");	
								$("#citycode").val("");
								}
								}
								});

								}


								</script> 
								
						</div>
                      </div>
                     
-->
                    <div class="row" data-gutter="30">
                      <div class="col-md-6 ">
                        <div class="theme-search-area-section theme-search-area-section-line">
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon lin lin-calendar"></i>


                            <input type="text" class="form-control theme-search-area-section-input" name="checkin_date" id="hotelcheckindate" value="<?php echo date("d-m-Y"); ?>" autocomplete="off" style="background-color:#fff;" readonly />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 ">
                        <div class="theme-search-area-section theme-search-area-section-line">
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon lin lin-calendar"></i>
                            <?php
                            $stop_date = date('d-m-Y', strtotime($todaydate . ' +1 day'));
                            ?>
                            <input type="text" class="form-control theme-search-area-section-input" name="checkout_date" id="hotelcheckoutdate" value="<?php echo $stop_date; ?>" autocomplete="off" style="background-color:#fff;" readonly />

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" data-gutter="30">
                      <div class="col-md-4 ">
                        <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Rooms">
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon fa fa-bed"></i>
                            <input class="theme-search-area-section-input" value="1" id="hotelrooms" name="rooms" type="number" readonly />
                            <div class="quantity-selector-box" id="HotelSearchRooms">
                              <div class="quantity-selector-inner">
                                <p class="quantity-selector-title">Rooms</p>
                                <ul class="quantity-selector-controls">
                                  <li id="decrease" onclick="decreaseValue()" value="Decrease Value">
                                    <a href="javascript:;">&#45;</a>
                                  </li>

                                  <li id="increase" onclick="increaseValue()" value="Increase Value">
                                    <a href="javascript:;">&#43;</a>
                                  </li>
                                </ul>

                                <script type="text/javascript">
                                  function increaseValue() {

                                    var value = parseInt(document.getElementById('hotelrooms').value, 10);
                                    if (value < 8) {
                                      value = isNaN(value) ? 0 : value;
                                      value++;
                                      document.getElementById('hotelrooms').value = value;
                                    }
                                  }

                                  function decreaseValue() {
                                    var value = parseInt(document.getElementById('hotelrooms').value, 10);
                                    if (value > 1) {
                                      value = isNaN(value) ? 0 : value;
                                      value < 1 ? value = 1 : '';
                                      value--;
                                      document.getElementById('hotelrooms').value = value;
                                    }
                                  }
                                </script>

                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="col-md-4 ">
                        <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Adults">
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon lin lin-people"></i>
                            <input class="theme-search-area-section-input" value="2" id="hoteladult" name="adult" type="number" readonly />
                            <div class="quantity-selector-box" id="HotelSearchAdults">
                              <div class="quantity-selector-inner">
                                <p class="quantity-selector-title">Adults</p>
                                <ul class="quantity-selector-controls">
                                  <li id="decrease" onclick="decreaseValue2()" value="Decrease Value">
                                    <a href="javascript:;">&#45;</a>
                                  </li>

                                  <li id="increase" onclick="increaseValue2()" value="Increase Value">
                                    <a href="javascript:;">&#43;</a>
                                  </li>
                                </ul>
                                <script type="text/javascript">
                                  function increaseValue2() {

                                    var value = parseInt(document.getElementById('hoteladult').value, 10);
                                    if (value < 20) {
                                      value = isNaN(value) ? 0 : value;
                                      value++;
                                      document.getElementById('hoteladult').value = value;
                                    }
                                  }

                                  function decreaseValue2() {
                                    var value = parseInt(document.getElementById('hoteladult').value, 10);
                                    if (value > 1) {
                                      value = isNaN(value) ? 0 : value;
                                      value < 1 ? value = 1 : '';
                                      value--;
                                      document.getElementById('hoteladult').value = value;
                                    }
                                  }
                                </script>
                              </div>
                            </div>
                          </div>
                          <p class="subtitleform">12+ Years</p>
                        </div>
                      </div>
                      <div class="col-md-4 ">
                        <div class="theme-search-area-section theme-search-area-section-line quantity-selector" data-increment="Childs">
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon fa fa-child"></i>
                            <input class="theme-search-area-section-input" value="0" id="hotelchild" name="child" type="number" readonly required />

                            <div class="quantity-selector-box" id="FlySearchChilds">
                              <div class="quantity-selector-inner">
                                <p class="quantity-selector-title">Childs</p>
                                <ul class="quantity-selector-controls">
                                  <li id="decrease" onclick="decreaseValue3(); childagebox()" value="Decrease Value">
                                    <a href="javascript:;">&#45;</a>
                                  </li>

                                  <li id="increase" onclick="increaseValue3() ; childagebox()" value="Increase Value">
                                    <a href="javascript:;">&#43;</a>
                                  </li>
                                </ul>

                                <script type="text/javascript">
                                  function increaseValue3() {

                                    var value = parseInt(document.getElementById('hotelchild').value, 10);
                                    if (value < 10) {
                                      value = isNaN(value) ? 0 : value;
                                      value++;
                                      document.getElementById('hotelchild').value = value;


                                    }
                                  }

                                  function decreaseValue3() {
                                    var value = parseInt(document.getElementById('hotelchild').value, 10);
                                    if (value > 0) {
                                      value = isNaN(value) ? 0 : value;
                                      value < 1 ? value = 1 : '';
                                      value--;
                                      document.getElementById('hotelchild').value = value;
                                    }
                                  }

                                  function childagebox() {
                                    //alert('hey');
                                    var value = parseInt(document.getElementById('hotelchild').value, 10);
                                    $.ajax({
                                      type: "POST",
                                      data: "noc=" + value,
                                      url: 'childagebox.php',
                                      success: function(response) {
                                        if (response != "") {
                                          //alert(response);
                                          $("#childage").html(response);

                                        }

                                      }
                                    });
                                  }
                                </script>

                              </div>
                            </div>

                          </div>
                          <p class="subtitleform">2-12 Years</p>
                        </div>

                      </div>
                    </div>
                    <div class="row" data-gutter="30" id="childage">

                    </div>
                    <div class="row" data-gutter="30">
                      <div class="col-md-6 ">

                        <button class="theme-search-area-submit _mt-20 theme-search-area-submit-curved theme-search-area-submit-primary btks" onclick="hotelsubmit()">Search</button>
                        <script type="text/javascript">
                          function hotelsubmit() {
                            //alert('hey');
                            var hotelto = document.getElementById("hotelto").value;
                            var citycode = document.getElementById("citycode").value;
                            var hotelchild = document.getElementById("hotelchild").value;
                            var hoteladult = document.getElementById("hoteladult").value;
                            var hotelrooms = document.getElementById("hotelrooms").value;
                            var hotelcheckindate = document.getElementById("hotelcheckindate").value;
                            var hotelcheckoutdate = document.getElementById("hotelcheckoutdate").value;
                            var childageArray = new Array();
                            $(".childage").each(function() {
                              childageArray.push($(this).val());
                            });
                            //alert(childageArray);

                            if (hotelto == "") {
                              $("#hotelerror1").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a Hotel city </p> ");
                            } else {
                              $("#hotelerror1").html(" ");
                            }
                            if (citycode == "") {
                              $("#hotelerror1").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Hotel city is not valid. </p> ");
                            } else {
                              $("#hotelerror1").html(" ");
                            }



                            if (hotelto != "") {
                              if (citycode != "") {
                                var xhttp = new XMLHttpRequest();

                                xhttp.onreadystatechange = function() {
                                  if (this.readyState == 4 && this.status == 200) {
                                    //document.getElementById("demo").innerHTML = this.responseText;
                                    var z = this.responseText;
                                    //alert(""+z+"");
                                    window.location.href = "hotel-search.php?token=" + z + "";
                                  }
                                };
                                xhttp.open("GET", "hotel-token.php?childages=" + childageArray + "&citycode=" + citycode + "&rooms=" + hotelrooms + "&adult=" + hoteladult + "&child=" + hotelchild + "&checkin_date=" + hotelcheckindate + "&checkout_date=" + hotelcheckoutdate + "&childagearray" + childageArray + "", true);
                                xhttp.send();



                              }
                            }

                          }
                        </script>
                        <script type="text/javascript">
                          var dateToday = new Date();
                          var tomorrow = new Date();
                          tomorrow.setDate(tomorrow.getDate() + 1);
                          $('#hotelcheckoutdate').datepicker({
                            dateFormat: "dd-m-yy",
                            minDate: tomorrow,
                          });

                          $("#hotelcheckindate").datepicker({
                            dateFormat: "dd-m-yy",
                            minDate: dateToday,
                            onSelect: function(date) {
                              var date1 = $('#hotelcheckindate').datepicker('getDate');
                              var date = new Date(Date.parse(date1));
                              date.setDate(date.getDate() + 1);
                              var newDate = date.toDateString();
                              newDate = new Date(Date.parse(newDate));
                              $('#hotelcheckoutdate').datepicker("option", "minDate", newDate);
                            }
                          });
                        </script>


                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="SearchAreaTabs-2" role="tab-panel">
                <!-- <div class="theme-search-area theme-search-area-vert">

                  <div class="theme-search-area-form">
                    <div class="row" data-gutter="30">
                      <div class="col-md-6 ">
                        <div class="col-md-12" style=" border-bottom: 2px solid #989898; padding: 0px;">
                          <div class="col-md-2 ">
                            <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                          </div>
                          <div class="col-md-10 ">
                            <form autocomplete="off">
                              <input type="text" class="theme-search-area-section-input" placeholder="Departure City" name="bus_departure_city" style="padding-left:8px;" id="busfrom" required="">
                            </form>
                            <script>
                              $(function() {
                                var availableTags = [
                                  <?php
                                  $buscityquery = mysql_query("SELECT * FROM `bus_city`");

                                  while ($buscitydata =  mysql_fetch_array($buscityquery)) {
                                    echo '"' . $buscitydata['city'] . '",';
                                  }
                                  ?> "0"
                                ];
                                $("#busfrom").autocomplete({
                                  source: availableTags
                                });
                                $("#busto").autocomplete({
                                  source: availableTags
                                });
                              });
                            </script>




                          </div>
                        </div>

                        <div id="buserror1"></div>

                      </div>
                      <div class="col-md-6 ">
                        <div class="col-md-12" style=" border-bottom: 2px solid #989898; padding: 0px;">
                          <div class="col-md-2 ">
                            <i class="theme-search-area-section-icon lin lin-location-pin"></i>
                          </div>
                          <div class="col-md-10 ">
                            <form autocomplete="off">
                              <input type="text" class="theme-search-area-section-input" placeholder="Destination City" name="bus_destination_city" style="padding-left:8px;" id="busto" required="">
                            </form>
                          </div>

                        </div>
                        <div id="buserror2"></div>
                      </div>
                    </div>
                    <div class="row" data-gutter="30">
                      <div class="col-md-12 ">
                        <div class="theme-search-area-section theme-search-area-section-line">
                          <div class="theme-search-area-section-inner">
                            <i class="theme-search-area-section-icon lin lin-calendar"></i>
                            <input class="form-control theme-search-area-section-input" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" name="bus_departure_date" type="date" id="dep_date" name="checkout_date" required />
                          </div>
                        </div>
                        <div id="buserror3"></div>
                      </div>

                    </div>
                    <div class="row" data-gutter="30">
                      <div class="col-md-6 ">
                        <button class="theme-search-area-submit _mt-20 theme-search-area-submit-curved theme-search-area-submit-primary btks" onclick="bussubmit()">Search</button>
                        <div id="demo"></div>
                        <script type="text/javascript">
                          function bussubmit() {
                            //alert('hey');
                            var busfrom = document.getElementById("busfrom").value;
                            var busto = document.getElementById("busto").value;
                            var dep_date = document.getElementById("dep_date").value;


                            if (busfrom == "") {
                              $("#buserror1").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a departure city </p> ");
                            } else {
                              $("#buserror1").html(" ");
                            }

                            if (busto == "") {
                              $("#buserror2").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a destination city </p> ");
                            } else {
                              $("#buserror2").html(" ");
                            }
                            if (busfrom == busto) {
                              $("#buserror1").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Departure City And Destination City Cannot be Same </p> ");
                            }
                            if (dep_date == "") {
                              $("#buserror3").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a departure date </p> ");
                            }
                            if (busfrom != "" && dep_date != "" && busto != "") {
                              if (busfrom !== busto) {

                                var availablebuscitys = [
                                  <?php
                                  $buscityquery = mysql_query("SELECT * FROM `bus_city`");

                                  while ($buscitydata =  mysql_fetch_array($buscityquery)) {
                                    echo '"' . $buscitydata['city'] . '",';
                                  }
                                  ?> "0"
                                ];
                                var n = availablebuscitys.includes(busfrom);
                                var m = availablebuscitys.includes(busto);
                                var tot = n + m;
                                if (n == 1) {
                                  if (m == 1) {
                                    var xhttp = new XMLHttpRequest();

                                    xhttp.onreadystatechange = function() {
                                      if (this.readyState == 4 && this.status == 200) {
                                        //document.getElementById("demo").innerHTML = this.responseText;
                                        var z = this.responseText;
                                        //alert(""+z+"");
                                        window.location.href = "bus-search.php?token=" + z + "";
                                      }
                                    };
                                    xhttp.open("GET", "bus-token.php?departure_city=" + busfrom + "&descity=" + busto + "&dd=" + dep_date + "", true);
                                    xhttp.send();
                                  } else {
                                    $("#buserror2").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a valid Destination </p>");
                                  }
                                } else {
                                  $("#buserror1").html("<p style='color: red; background: #fff; font-size: 13px; line-height: 26px;'> Please Select a valid Destination </p>");
                                }

                              }
                            }

                          }
                        </script>

                      </div>

                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 ">
        <div class="theme-tab-slider _mob-h" id="slideTabsSlides">
          <img src="img/index/hero/slide/hotel.png" alt="Image Alternative text" title="Hotel" data-tab="SearchAreaTabs-1" />
          <img src="img/index/hero/slide/bus.png" alt="Image Alternative text" title="Bus" data-tab="SearchAreaTabs-2" />
          <img class="active" src="img/index/hero/slide/flight-7.png" alt="Flight" title="Image Title" data-tab="SearchAreaTabs-3" />

        </div>
      </div>
    </div>
  </div>
  <div class="theme-page-section _pt-desk-30 theme-page-section-xxl">
    <div class="container">
      <div class="row row-col-mob-gap" data-gutter="60">
        <div class="col-md-3 ">
          <div class="feature">
            <i class="feature-icon feature-icon-gray feature-icon-box feature-icon-round fa fa-globe no_line"></i>
            <div class="feature-caption _op-07">
              <h5 class="feature-title">Explore the World</h5>
              <p class="feature-subtitle">Start to discrover. We will help you to visit any place you can imagine</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 ">
          <div class="feature">
            <i class="feature-icon feature-icon-gray feature-icon-box feature-icon-round fa fa-gift no_line"></i>
            <div class="feature-caption _op-07">
              <h5 class="feature-title">Gifts & Rewards</h5>
              <p class="feature-subtitle">Get even more from our service. Spend less and travel more</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 ">
          <div class="feature">
            <i class="feature-icon feature-icon-gray feature-icon-box feature-icon-round fa fa-credit-card no_line"></i>
            <div class="feature-caption _op-07">
              <h5 class="feature-title">Best prices</h5>
              <p class="feature-subtitle">We are comparing hundreds travel websites to find best price for you</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 ">
          <div class="feature">
            <i class="feature-icon feature-icon-gray feature-icon-box feature-icon-round fa fa-comments-o no_line"></i>
            <div class="feature-caption _op-07">
              <h5 class="feature-title">27/7 Support</h5>
              <p class="feature-subtitle">Contact us anytime, anywhere. We will resolve any issues ASAP</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="theme-page-section _pt-0 theme-page-section-lg">
    <div class="container">
      <div class="theme-page-section-header _ta-l">
        <h5 class="theme-page-section-title">Recommended Places</h5>
        <p class="theme-page-section-subtitle">Top destinations picked by our stuff</p>
        <a class="theme-page-section-header-link theme-page-section-header-link-rb" href="#">+ More Reccomendations</a>
      </div>
      <div class="theme-inline-slider row" data-gutter="10">
        <div class="owl-carousel" data-items="5" data-loop="true" data-nav="true">
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/washington-monument-sunset-twilight-1628558_400x400.jpg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Washington DC</h5>
                <p class="banner-subtitle _fw-n">United States</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/lvjzhhoijj4_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Moscow</h5>
                <p class="banner-subtitle _fw-n">Russia</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/taj-mahal-india-tourist-2574056_400x400.jpg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Agra</h5>
                <p class="banner-subtitle _fw-n">India</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/viva_las_vegas_400x400.jpg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Las Vegas</h5>
                <p class="banner-subtitle _fw-n">United States</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/scenic-view-of-city-at-sunset-316001_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Dubai</h5>
                <p class="banner-subtitle _fw-n">United Arab Emirates</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/vynkvknewja_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Buenos Aires</h5>
                <p class="banner-subtitle _fw-n">Argentina</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="theme-page-section theme-page-section-lg">
    <div class="container">
      <div class="theme-page-section-header _ta-l">
        <h5 class="theme-page-section-title">Most Visited</h5>
        <p class="theme-page-section-subtitle">Popular places in 2018</p>
        <a class="theme-page-section-header-link theme-page-section-header-link-rb" href="#">+ Find More</a>
      </div>
      <div class="theme-inline-slider row" data-gutter="10">
        <div class="owl-carousel" data-items="5" data-loop="true" data-nav="true">
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/photo-of-eiffel-tower-739407_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Paris</h5>
                <p class="banner-subtitle _fw-n">France</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/architecture-art-clouds-landmark-290386_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">New York</h5>
                <p class="banner-subtitle _fw-n">United States</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/gvwfedcc1ry_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Venice</h5>
                <p class="banner-subtitle _fw-n">Italy</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/architecture-bridge-buildings-calm-waters-427679_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">London</h5>
                <p class="banner-subtitle _fw-n">United Kindom</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/rxgcjsathdq_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Bali</h5>
                <p class="banner-subtitle _fw-n">Indonesia</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/ypkiwlvhopi_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Rome</h5>
                <p class="banner-subtitle _fw-n">Italy</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="theme-page-section theme-page-section-lg">
    <div class="container">
      <div class="theme-page-section-header _ta-l">
        <h5 class="theme-page-section-title">Trending Cities</h5>
        <p class="theme-page-section-subtitle">Most searched cities in June</p>
        <a class="theme-page-section-header-link theme-page-section-header-link-rb" href="#">+ Explore</a>
      </div>
      <div class="theme-inline-slider row" data-gutter="10">
        <div class="owl-carousel" data-items="5" data-loop="true" data-nav="true">
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/pbrqvukjqf8_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Sydney</h5>
                <p class="banner-subtitle _fw-n">Australia</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/kvlxfxfleuo_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Amsterdam</h5>
                <p class="banner-subtitle _fw-n">Netherlands</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/ancient-architecture-asia-buddhism-460376_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Bangkok</h5>
                <p class="banner-subtitle _fw-n">Thailand</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/blue-sky-daylight-hollywood-landscape-305256_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Los Angeles</h5>
                <p class="banner-subtitle _fw-n">United States</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/wapfd4fmy2o_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Prague</h5>
                <p class="banner-subtitle _fw-n">Czech Republic</p>
              </div>
            </div>
          </div>
          <div class="theme-inline-slider-item">
            <div class="banner _br-4 banner-sqr banner-animate banner-animate-mask-in">
              <div class="banner-bg" style="background-image:url(img/asia-japan-japanese-japanese-culture-590478_400x400.jpeg);"></div>
              <div class="banner-mask"></div>
              <a class="banner-link" href="#"></a>
              <div class="banner-caption _pt-40 _ph-25 _pb-20 banner-caption-bottom banner-caption-grad">
                <h5 class="banner-title _fs">Tokyo</h5>
                <p class="banner-subtitle _fw-n">Japan</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="theme-page-section _pb-60 theme-page-section-lg">
    <div class="container">
      <div class="theme-page-section-header _ta-l">
        <h5 class="theme-page-section-title">Travel Inspirations</h5>
        <p class="theme-page-section-subtitle">Our latest travel tips, hacks and insights</p>
        <a class="theme-page-section-header-link theme-page-section-header-link-rb" href="#">+ More Stories</a>
      </div>
      <div class="row row-col-gap" data-gutter="10">
        <div class="col-md-3 ">
          <div class="theme-blog-item _br-4 theme-blog-item-full">
            <a class="theme-blog-item-link" href="#"></a>
            <div class="banner _h-45vh  banner-">
              <div class="banner-bg" style="background-image:url(img/city-sun-hot-child_350x260.jpg);"></div>
              <div class="banner-caption banner-caption-bottom banner-caption-grad">
                <p class="theme-blog-item-time">day ago</p>
                <h5 class="theme-blog-item-title">Booking hotel in India</h5>
                <p class="theme-blog-item-desc">Molestie ullamcorper scelerisque velit venenatis parturient porttitor vitae tincidunt auctor</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 ">
          <div class="theme-blog-item _br-4 theme-blog-item-full">
            <a class="theme-blog-item-link" href="#"></a>
            <div class="banner _h-45vh  banner-">
              <div class="banner-bg" style="background-image:url(img/woman-hiker-outside-forest_730x435.jpg);"></div>
              <div class="banner-caption banner-caption-bottom banner-caption-grad">
                <p class="theme-blog-item-time">3 days ago</p>
                <h5 class="theme-blog-item-title">Canada: forest trip</h5>
                <p class="theme-blog-item-desc">Commodo commodo ut ridiculus ullamcorper cursus pharetra egestas ligula sapien</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 ">
          <div class="theme-blog-item _br-4 theme-blog-item-full">
            <a class="theme-blog-item-link" href="#"></a>
            <div class="banner _h-45vh  banner-">
              <div class="banner-bg" style="background-image:url(img/man-wearing-black-and-red-checkered_350x435.jpeg);"></div>
              <div class="banner-caption banner-caption-bottom banner-caption-grad">
                <p class="theme-blog-item-time">week ago</p>
                <h5 class="theme-blog-item-title">Total Solar Eclipse</h5>
                <p class="theme-blog-item-desc">Facilisi torquent fames nullam dictumst sit tellus purus justo morbi</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 ">
          <div class="theme-blog-item _br-4 theme-blog-item-full">
            <a class="theme-blog-item-link" href="#"></a>
            <div class="banner _h-45vh  banner-">
              <div class="banner-bg" style="background-image:url(img/lights_350x260.jpeg);"></div>
              <div class="banner-caption banner-caption-bottom banner-caption-grad">
                <p class="theme-blog-item-time">2 weeks ago</p>
                <h5 class="theme-blog-item-title">Lights of Venice</h5>
                <p class="theme-blog-item-desc">Taciti velit litora penatibus ullamcorper lacus felis nulla integer dolor</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="theme-hero-area">
    <div class="theme-hero-area-bg-wrap">
      <div class="theme-hero-area-bg" style="background-image:url(img/main-background.png);"></div>
      <div class="theme-hero-area-mask theme-hero-area-mask-half"></div>
    </div>
    <div class="theme-hero-area-body">
      <div class="theme-page-section _pv-100">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="theme-hero-text theme-hero-text-white theme-hero-text-center">
                <div class="theme-hero-text-header">
                  <h2 class="theme-hero-text-title">Pay less travel more</h2>
                  <p class="theme-hero-text-subtitle">Subscribe now and unlock our secret deals. Save up to 70% by getting access to our special offers for hotels, flights, cars, vacation rentals and travel experiences.</p>
                </div>
                <a class="btn _tt-uc _mt-20 btn-white btn-ghost btn-lg" href="#">Sign Up Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  include('footer.php');
  ?>

  <!---Autofill--->


  <!-- Select Box -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });

    function matchStart(params, data) {
      // If there are no search terms, return all of the data
      if ($.trim(params.term) === '') {
        return data;
      }

      // Skip if there is no 'children' property
      if (typeof data.children === 'undefined') {
        return null;
      }

      // `data.children` contains the actual options that we are matching against
      var filteredChildren = [];
      $.each(data.children, function(idx, child) {
        if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
          filteredChildren.push(child);
        }
      });

      // If we matched any of the timezone group's children, then set the matched children on the group
      // and return the group object
      if (filteredChildren.length) {
        var modifiedData = $.extend({}, data, true);
        modifiedData.children = filteredChildren;

        // You can return modified objects from here
        // This includes matching the `children` how you want in nested data sets
        return modifiedData;
      }

      // Return `null` if the term should not be displayed
      return null;
    }

    $(".js-example-matcher-start").select2({
      matcher: matchStart
    });
  </script>
  <!--End  Select Box -->
  <script src="js/moment.js"></script>
  <script src="js/bootstrap.js"></script>
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

  <script src="js/quantity-selector.js"></script>
  <script src="js/countdown.js"></script>
  <script src="js/window-scroll-action.js"></script>
  <script src="js/fitvid.js"></script>
  <script src="js/youtube-bg.js"></script>
  <script src="js/custom.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>

</html>