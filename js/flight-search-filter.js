// ........................... Test Code Area
// ........................... Ends Test Code Area
// Handling Filter related click events When After DOM Loaded
let filteredData = null;
let filter_conditions = new Map();
filter_conditions.set('stoppage', []);
filter_conditions.set('departure_time', []);
filter_conditions.set('total_price', []);
filter_conditions.set('airline', []);

document.addEventListener('DOMContentLoaded', (event) => {
    // Collecting Data from Session Storage to perform sorting operations
    let carriers = sessionStorage.getItem('carriers');
    let aircraft = sessionStorage.getItem('aircraft');
    // ############### Filter By Stops (Non Stops)
    const radioButton1 = document.getElementById('filter_stops_0');
    radioButton1.addEventListener('change', function() {
        // Reading data from cache
        let datas = sessionStorage.getItem('flight_search_result');
        let carriers = sessionStorage.getItem('carriers');
        let aircraft = sessionStorage.getItem('aircraft');
        if (radioButton1.checked) {
          
          // setting filter conditions
          let condition = filter_conditions.get('stoppage');
          condition.push("numberOfStops == 0");
          filter_conditions.set('stoppage', condition);
          
          filteredData = filterFlights(datas, apply_filter);
          renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
        } else {
          // clearing filter conditions
          let condition = filter_conditions.get('stoppage');
          let indx = condition.indexOf("numberOfStops == 0");
          if(indx >= 0){
            condition.splice(indx, 1);
          }
          
          filteredData = filterFlights(datas, apply_filter);
          renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
        }
    });

    // ############### Filter By Stops (1 Stop)
    const radioButton2 = document.getElementById('filter_stops_1');
    radioButton2.addEventListener('change', function() {
        // Reading Data from cache
        let datas = sessionStorage.getItem('flight_search_result');
        let carriers = sessionStorage.getItem('carriers');
        let aircraft = sessionStorage.getItem('aircraft');
        if (radioButton2.checked) {

          // setting filter conditions
          let condition = filter_conditions.get('stoppage');
          condition.push("numberOfStops == 1");
          filter_conditions.set('stoppage', condition);

          // displaying filtered data
          filteredData = filterFlights(datas, apply_filter);
          renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
        } else {
          // clearing filter conditions
          let condition = filter_conditions.get('stoppage');
          let indx = condition.indexOf("numberOfStops == 1");
          if(indx >= 0){
            condition.splice(indx, 1);
          }

          // displaying filtered data
          filteredData = filterFlights(datas, apply_filter);
          renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
        }
    });

    // ############### Filter By Stops (2 Stop)
    const radioButton2a = document.getElementById('filter_stops_1+');
    radioButton2a.addEventListener('change', function() {
        // Reading Data from cache
        let datas = sessionStorage.getItem('flight_search_result');
        let carriers = sessionStorage.getItem('carriers');
        let aircraft = sessionStorage.getItem('aircraft');
        if (radioButton2a.checked) {
          // setting filter conditions
          let condition = filter_conditions.get('stoppage');
          condition.push("numberOfStops == 2");
          filter_conditions.set('stoppage', condition);

          // displaying filtered data
          filteredData = filterFlights(datas, apply_filter);
          renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
        } else {
          let datas = sessionStorage.getItem('flight_search_result');
          renderPage(JSON.parse(datas), JSON.parse(carriers), JSON.parse(aircraft));
          // clearing filter conditions
          let condition = filter_conditions.get('stoppage');
          let indx = condition.indexOf("numberOfStops == 2");
          if(indx >= 0){
            condition.splice(indx, 1);
          }

          // displaying filtered data
          filteredData = filterFlights(datas, apply_filter);
          renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
        }
    });

    // ############### Filter by timing 00:00 - 08:00
    const radioButton3 = document.getElementById('flexRadioDefault3');
    radioButton3.addEventListener('change', function() {
      // Reading Data from cache
      let datas = sessionStorage.getItem('flight_search_result');
      let carriers = sessionStorage.getItem('carriers');
      let aircraft = sessionStorage.getItem('aircraft');
      if (radioButton3.checked) {
        // setting filter conditions
        let condition = filter_conditions.get('departure_time');
        condition.push("departureTime >= '00:00:00' && departureTime <= '08:00:00'");
        filter_conditions.set('departure_time', condition);

        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      } else {
        // clearing filter conditions
        let condition = filter_conditions.get('departure_time');
        let indx = condition.indexOf("departureTime >= '00:00:00' && departureTime <= '08:00:00'");
        if(indx >= 0){
          condition.splice(indx, 1);
        }
        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      } 
    });
    // ############### Filter by timing 08:00 - 12:00
    const radioButton4 = document.getElementById('flexRadioDefault4');
    radioButton4.addEventListener('change', function() {
      // Reading Data from cache
      let datas = sessionStorage.getItem('flight_search_result');
      let carriers = sessionStorage.getItem('carriers');
      let aircraft = sessionStorage.getItem('aircraft');
      if (radioButton4.checked) {
        // setting filter conditions
        let condition = filter_conditions.get('departure_time');
        condition.push("departureTime >= '08:00:01' && departureTime <= '12:00:00'");
        filter_conditions.set('departure_time', condition);

        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      } else {
        // clearing filter conditions
        let condition = filter_conditions.get('departure_time');
        let indx = condition.indexOf("departureTime >= '08:00:01' && departureTime <= '12:00:00'");
        if(indx >= 0){
          condition.splice(indx, 1);
        }
        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      }
    });

    // ############### Filter by timing 12:00 - 16:00
    const radioButton5 = document.getElementById('flexRadioDefault5');
    radioButton5.addEventListener('change', function() {
      // Reading Data from cache
      let datas = sessionStorage.getItem('flight_search_result');
      let carriers = sessionStorage.getItem('carriers');
      let aircraft = sessionStorage.getItem('aircraft');
      if (radioButton5.checked) {
        // setting filter conditions
        let condition = filter_conditions.get('departure_time');
        condition.push("departureTime >= '12:00:01' && departureTime <= '16:00:00'");
        filter_conditions.set('departure_time', condition);

        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      } else {
        // clearing filter conditions
        let condition = filter_conditions.get('departure_time');
        let indx = condition.indexOf("departureTime >= '12:00:01' && departureTime <= '16:00:00'");
        if(indx >= 0){
          condition.splice(indx, 1);
        }
        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      }
    });

    // ############### Filter by timing 16:00 - 20:00
    const radioButton6 = document.getElementById('flexRadioDefault6');
    radioButton6.addEventListener('change', function() {
      // Reading Data from cache
      let datas = sessionStorage.getItem('flight_search_result');
      let carriers = sessionStorage.getItem('carriers');
      let aircraft = sessionStorage.getItem('aircraft');
      if (radioButton6.checked) {
        // setting filter conditions
        let condition = filter_conditions.get('departure_time');
        condition.push("departureTime >= '16:00:01' && departureTime <= '20:00:00'");
        filter_conditions.set('departure_time', condition);

        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      } else {
        // clearing filter conditions
        let condition = filter_conditions.get('departure_time');
        let indx = condition.indexOf("departureTime >= '16:00:01' && departureTime <= '20:00:00'");
        if(indx >= 0){
          condition.splice(indx, 1);
        }
        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      } 
    });

    // ############### Filter by timing 20:00 - 24:00
    const radioButton7 = document.getElementById('flexRadioDefault7');
    radioButton7.addEventListener('change', function() {
      // Reading Data from cache
      let datas = sessionStorage.getItem('flight_search_result');
      let carriers = sessionStorage.getItem('carriers');
      let aircraft = sessionStorage.getItem('aircraft');
      if (radioButton7.checked) {
        // setting filter conditions
        let condition = filter_conditions.get('departure_time');
        condition.push("departureTime >= '20:00:01' && departureTime <= '24:00:00'");
        filter_conditions.set('departure_time', condition);

        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      } else {
        // clearing filter conditions
        let condition = filter_conditions.get('departure_time');
        let indx = condition.indexOf("departureTime >= '20:00:01' && departureTime <= '24:00:00'");
        if(indx >= 0){
          condition.splice(indx, 1);
        }
        // displaying applied filtered data
        filteredData = filterFlights(datas, apply_filter);
        renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
      }
    });

    // ############### Filter By Price Range
    const priceRange = document.getElementById('customRange3');
    priceRange.addEventListener('change', function() {
      let datas = sessionStorage.getItem('flight_search_result');
      let carriers = sessionStorage.getItem('carriers');
      let aircraft = sessionStorage.getItem('aircraft');
      
      // calling function to filter flights and render the filtered data
      // let filteredData = filterFlights(datas, filterBy_priceRange(this.value));

      // setting filter conditions
      let condition_ = filter_conditions.get('total_price');
      condition_.splice(0, 1, 'totalPrice <= '+this.value);
      filter_conditions.set('total_price', condition_);

      let filteredData = filterFlights(datas, apply_filter);
      renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
    });

    
});

// ################ Filter By Airlines
function filtrAirline(ele){
  // console.log('Hi welcome .....>', ele.value, ele.checked);
  let datas = sessionStorage.getItem('flight_search_result');
  let carriers = sessionStorage.getItem('carriers');
  let aircraft = sessionStorage.getItem('aircraft');

  let airline_code = ele.value;
  if(ele.checked){
    let condition = filter_conditions.get('airline');
    condition.push(`carrier_code == '${airline_code}'`);
    filter_conditions.set('airline', condition);
    
     filteredData = filterFlights(datas, apply_filter);
     renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
  }else{
    let condition = filter_conditions.get('airline');
    let indx = condition.indexOf(`carrier_code == '${airline_code}'`);
    if(indx >= 0){
      condition.splice(indx, 1);
    }

     // displaying applied filtered data
     filteredData = filterFlights(datas, apply_filter);
     renderPage(JSON.parse(filteredData), JSON.parse(carriers), JSON.parse(aircraft));
  }
}
// Handling Filter related click events Ends 

// ---------------------- Functios to be called on filter events -----------------

// ---------------------- Functios to be called on filter events Ends here -----------------
// +++++++++++++++++++++++++ Filter Flight Data Function +++++++++++++++++++++++++
function filterFlights(flightSearchData, filterFunction){
  try {
      // Parse the JSON string into a JavaScript object
      let flightData = JSON.parse(flightSearchData);
      // Check if the data is an array
      if (!Array.isArray(flightData)) {
          throw new Error("Expected data to be an array");
      }

      // Filter the array using the filter function
      let filteredData = flightData.filter(filterFunction);
      
      // Convert the filtered array back to a JSON string
      return JSON.stringify(filteredData, null, 2); // Pretty-print with indentation
  } catch (error) {
      console.error("Error filtering flights:", error);
      return null;
  }
}

// +++++++++++++++++++++++++ Filter Flight Data Function Ends +++++++++++++++++++++++++
// ========================= Filter Functions =======================
// -------------- Filtering by number of stops --------------------
function filterByStops(maxStops){
  return function(flight){
    let numberOfStops = flight.itineraries[0].segments.length - 1;
    return numberOfStops == maxStops;
  }
}

// ----------- Filtering Flights By Departure Time -----------
function filterByTiming(startTime, endTime){
  return function(flight){
    // Extract the departure time from the flight data
    let departureTime = flight.itineraries[0].segments[0].departure.at.split('T')[1];

    // Check if the departure time is within the specified range
    return departureTime >= startTime && departureTime <= endTime;
  }
}

// -------------- Filter By Pricing ------------
function filterBy_priceRange(priceLimit){
  priceLimit += 1;
  return function (flight){
    return flight.price.total <= priceLimit;
  }
}

// ------------ Filter By Airlines ------------
function filterBy_Airline(carrier_c){
  return function (flight){
    let carrier_code = flight.itineraries[0].segments[0].carrierCode;
    // console.log('#', flight.itineraries[0].segments[0].carrierCode)
    return carrier_code == carrier_c;
  }
}

function apply_filter(flight){
  let numberOfStops = flight.itineraries[0].segments.length - 1;
  let departureTime = flight.itineraries[0].segments[0].departure.at.split('T')[1];
  let totalPrice = flight.price.total;
  let carrier_code = flight.itineraries[0].segments[0].carrierCode;

  f_cndtion = new Array();
  let stoppageCondition = filter_conditions.get('stoppage').join(' || ');
  if( stoppageCondition != '') f_cndtion.push('('+stoppageCondition+')');

  let depTimeCondition = filter_conditions.get('departure_time').join(' || ');
  if( depTimeCondition != '') f_cndtion.push('('+depTimeCondition+')');

  let priceCondition = filter_conditions.get('total_price');
  if( priceCondition != '') f_cndtion.push('('+priceCondition+')');

  let airlinesCondition = filter_conditions.get('airline').join(' || ');
  if( airlinesCondition != '') f_cndtion.push('('+airlinesCondition+')');

  let cndition = f_cndtion.join(' && ');
  // console.log(cndition); 
  if(cndition == '') return true;
  return eval(cndition);
}
// ======================= Filter Functions Ends ====================
// +++++++++++++++++++++++++ Sort Flight Data Function +++++++++++++++++++++++++++
function sortFlights(flightSearchData, comparisonFunction, order = 'asc') {
    try {
        // Parse the JSON string into a JavaScript object
        let flightData = JSON.parse(flightSearchData);

        // Check if the data is an array
        if (!Array.isArray(flightData)) {
            throw new Error("Expected data to be an array");
        }

        // Sort the array using the comparison function
        flightData.sort((a, b) => {
            let comparisonResult = comparisonFunction(a, b);
            return order === 'desc' ? -comparisonResult : comparisonResult;
        });

        // Convert the sorted array back to a JSON string
        return JSON.stringify(flightData, null, 2); // Pretty-print with indentation
    } catch (error) {
        console.error("Error sorting flights:", error);
        return null;
    }
}
// +++++++++++++++++++++++++ Ends, Sort Flight Data Function +++++++++++++++++++++++++++

// $$$$$$$$$$$$$$$$$$$$ Rendering The Page using Javascript $$$$$$$$$$$$$$$$$$$$
function renderPage(datas, carriers, aircraft) {
  const airportCodes = JSON.parse(sessionStorage.getItem('airportCodes'));
  const container = document.getElementById('tobePagination');
  container.innerHTML = '';

  if (datas.length >= 1) {
    datas.forEach((values, index) => {
      const itineraries = values.itineraries[0];

      // Calculating travel time
      let duration = itineraries.duration;
      duration = duration.substr(2);

      // Computing Departure Date
      const depdate = itineraries.segments[0].departure.at;
      const depArray = depdate.split("T");
      const depDate = depArray[0];
      const depTime = depArray[1].substr(0, 5);
      const dedate = new Date(depDate);
      const deparDate = dedate.toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' });

      // Computing Arrival Date
      const arrdate = itineraries.segments[itineraries.segments.length - 1].arrival.at;
      const arrArray = arrdate.split("T");
      const arrivalDate = arrArray[0];
      const arrivalTime = arrArray[1].substr(0, 5);
      const adate = new Date(arrivalDate);
      const ardate = adate.toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' });

      // Total stops between source & destination
      const noOfStops = itineraries.segments.length - 1;
      // Fetching Total Fare/price
      const totalFare =  Math.ceil(values.travelerPricings[0].price.total).toLocaleString();

      const flightDetails = `
        <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
          <div class="theme-search-results-item-preview">
            <div class="row main_container" data-gutter="20">
              <div class="col-md-9 ">
                <div class="theme-search-results-item-flight-sections">
                  <div class="theme-search-results-item-flight-section">
                    <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                      <div class="col-md-2 colks">
                        <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                          <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/${itineraries.segments[0].carrierCode}.png" alt="Consta Travel" title="Image Title" />
                        </div>
                        <p style="font-size: 10px; line-height: 1;">${carriers[itineraries.segments[0].carrierCode]}</p>
                        <a href="#searchResultsItem${index + 1}" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem${index + 1}" id="accordion_btn${index + 1}">
                          View Flight Details
                        </a>
                      </div>
                      <div class="col-md-10 ">
                        <div class="theme-search-results-item-flight-section-item">
                          <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                            <div class="col-md-3">
                              <div class="theme-search-results-item-flight-section-meta">
                                <p class="theme-search-results-item-flight-section-meta-time">${depTime}</p>
                                <p class="theme-search-results-item-flight-section-meta-city">${itineraries.segments[0].departure.iataCode}</p>
                                <p class="theme-search-results-item-flight-section-meta-date">${deparDate}</p>
                              </div>
                            </div>
                            <div class="col-md-6 ">
                              <div class="theme-search-results-item-flight-section-path">
                                <div class="theme-search-results-item-flight-section-path-fly-time">
                                  <p>${duration}</p>
                                </div>
                                <div class="theme-search-results-item-flight-section-path-line"></div>
                                <div class="theme-search-results-item-flight-section-path-status">
                                  <h5 class="theme-search-results-item-flight-section-airline-title">
                                    ${noOfStops === 0 ? '( Non Stop )' : `( Stops : ${noOfStops} )`}
                                  </h5>
                                </div>
                                <div class="theme-search-results-item-flight-section-path-line-start">
                                  <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                  <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                  <div class="theme-search-results-item-flight-section-path-line-title">${itineraries.segments[0].departure.iataCode}</div>
                                </div>
                                <div class="theme-search-results-item-flight-section-path-line-end">
                                  <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                  <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                  <div class="theme-search-results-item-flight-section-path-line-title">${itineraries.segments[itineraries.segments.length - 1].arrival.iataCode}</div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3 ">
                              <div class="theme-search-results-item-flight-section-meta">
                                <p class="theme-search-results-item-flight-section-meta-time">${arrivalTime}</p>
                                <p class="theme-search-results-item-flight-section-meta-city">${itineraries.segments[itineraries.segments.length - 1].arrival.iataCode}</p>
                                <p class="theme-search-results-item-flight-section-meta-date">${ardate}</p>
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
                    <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i> ${totalFare}</p>
                    <p class="theme-search-results-item-price-sign">${values.travelerPricings[0].fareDetailsBySegment[0].cabin}</p>
                  </div>
                  <a class="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" target="_blank" href="flight-payment.php?token">Book Now</a>
                </div>
              </div>
            </div>
          </div>
          ${renderDetails(itineraries, carriers, aircraft, values, index + 1, airportCodes)}
        </div>
      `;

      container.innerHTML += flightDetails;
    });
  } else {
    container.innerHTML = 'No Record Found';
  }
  repaginate();
  toggleFlightDetails();
}
// $$$$$$$$$$$$$$$$$$$$ Ends Rendering The Page using Javascript $$$$$$$$$$$$$$$$$$$$

// @@@@@@@@@@@@@@@@@@@@@@ Helper Functions to show pagination, extra details etc. @@@@@@@@@@@@@@@@@@@@@@
function repaginate(){
  $('#tobePagination--pager').remove();
  $('#tobePagination').buzinaPagination({
    itemsOnPage: 10
  });
}
function toggleFlightDetails(){
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
      if (collapseDiv.style.display === 'block' || collapseDiv.style.display === ''){
        collapseDiv.style.display = 'none';
      }else{
        collapseDiv.style.display = 'block';
      }
    });
  });
}
// @@@@@@@@@@@@@@@@@@@@@@ Ends Helper Functions to show pagination, extra details etc. @@@@@@@@@@@@@@@@@@@@@@

// $$$$$$$$$$$$$$$$$$$$ Rendering The Flight Details $$$$$$$$$$$$$$$$$$$$
function renderDetails(itineraries, carriers, aircraft, values, index, airportCodes) {
  let details = '';

  if (itineraries.segments.length > 1) {
    let onwardFlights = itineraries.segments.slice(1);
    let save = '';
    onwardFlights.forEach((segment, v) => {
      const depdate2 = segment.departure.at;
      const depArray2 = depdate2.split("T");
      const depDate2 = depArray2[0];
      const depTime2 = depArray2[1].substr(0, 5);
      const dedate2 = new Date(depDate2);
      const deparDate2 = dedate2.toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' });

      const arrdate2 = segment.arrival.at;
      const arrArray2 = arrdate2.split("T");
      const arrivalDate2 = arrArray2[0];
      const arrivalTime2 = arrArray2[1].substr(0, 5);
      const adate2 = new Date(arrivalDate2);
      const ardate2 = adate2.toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' });

      let dateDiff = 0;
      if (v === 0) {
        const date1 = new Date(`${itineraries.segments[0].arrival.at}`);
        const date2 = new Date(`${depDate2}T${depTime2}`);
        save = new Date(`${arrivalDate2}T${arrivalTime2}`);
        dateDiff = (date2 - date1) / (1000 * 60);
      } else {
        const date1 = new Date(save);
        const date2 = new Date(`${depDate2}T${depTime2}`);
        dateDiff = (date2 - date1) / (1000 * 60);
      }

      const hours = Math.floor(dateDiff / 60);
      const minutes = dateDiff % 60;

      details += `
        <hr>
        <div class="div_middle">
          <span>${segment.departure.iataCode} ( Layover ${hours}h : ${minutes}m )</span>
        </div>
        <div class="row" style="margin-bottom: 12px;">
          <div class="col-md-3">
            <div class="d-flex flex-column align-items-start colks1">
              <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/${segment.carrierCode}.png" alt="Consta Travel" title="Image Title" />
              <h5>${carriers[segment.carrierCode]}</h5>
              <p>${aircraft[segment.aircraft.code]}</p>
              <p>${values.travelerPricings[0].fareDetailsBySegment[v].cabin}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-between colks2">
              <div class="d-flex align-items-center flex-column colks21 align-items-start">
                <h3>${segment.departure.iataCode} <strong>${depTime2}</strong></h3>
                <p>${deparDate2}</p>
                <p>${airportCodes[segment.departure.iataCode].airportname} Airport, Terminal ${segment.departure.terminal}, ${airportCodes[segment.departure.iataCode].city}</p>
              </div>
              <div class="d-flex flex-column colks22 align-items-center">
                <i class="fa fa-clock"></i>
                <p>${segment.duration.substr(2)}</p>
              </div>
              <div class="d-flex align-items-center flex-column colks23 align-items-start">
                <h3>${segment.arrival.iataCode} <strong>${arrivalTime2}</strong></h3>
                <p>${ardate2}</p>
                <p>${airportCodes[segment.arrival.iataCode].airportname} Airport${segment.arrival.terminal ? `, Terminal ${segment.arrival.terminal}` : ''}, ${airportCodes[segment.arrival.iataCode].city}</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="d-flex flex-column align-items-center colks3">
              ${values.travelerPricings[0].fareDetailsBySegment[v].includedCheckedBags.weight ? `
                <div class="d-flex justify-content-between colks31">
                  <p>Check-in baggage: </p>
                  <p><strong>${values.travelerPricings[0].fareDetailsBySegment[v].includedCheckedBags.weight}${values.travelerPricings[0].fareDetailsBySegment[v].includedCheckedBags.weightUnit}</strong></p>
                </div>
              ` : values.travelerPricings[0].fareDetailsBySegment[v].includedCheckedBags.quantity ? `
                <div class="d-flex justify-content-between colks31">
                  <p>Check-in bags</p>
                  <p><strong>${values.travelerPricings[0].fareDetailsBySegment[v].includedCheckedBags.quantity} Qty</strong></p>
                </div>
              ` : ''}
            </div>
          </div>
        </div>
      `;
    });
  }

  let arrivalDate = itineraries.segments[0].arrival.at.split("T")[0];
  let arrivalTime = itineraries.segments[0].arrival.at.split("T")[1].substr(0, 5);
  let arrivalDateFormatted = new Date(arrivalDate).toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' });

  return `
    <div class="collapse theme-search-results-item-collapse" id="searchResultsItem${index}" style="display: none;">
      <div class="theme-search-results-item-extend">
        <a class="theme-search-results-item-extend-close" href="#searchResultsItem${index}" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="searchResultsItem${index}" id="accordion_close${index}">&#10005;</a>
        <div class="theme-search-results-item-extend-inner">
          <div class="theme-search-results-item-flight-detail-items">
            <div class="theme-search-results-item-flight-details">
              <div class="containerks">
                <div class="row" style="margin-bottom: 12px;">
                  <div class="col-md-3">
                    <div class="d-flex flex-column align-items-start colks1">
                      <img class="theme-search-results-item-flight-section-airline-logo" src="https://pics.avs.io/200/100/${itineraries.segments[0].carrierCode}.png" alt="Consta Travel" title="Image Title" />
                      <h5>${carriers[itineraries.segments[0].carrierCode]}</h5>
                      <p>${aircraft[itineraries.segments[0].aircraft.code]}</p>
                      <p>${values.travelerPricings[0].fareDetailsBySegment[0].cabin}</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-between colks2">
                      <div class="d-flex align-items-center flex-column colks21 align-items-start">
                        <h3>${itineraries.segments[0].departure.iataCode} <strong>${itineraries.segments[0].departure.at.split("T")[1].substr(0, 5)}</strong></h3>
                        <p>${new Date(itineraries.segments[0].departure.at.split("T")[0]).toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' })}</p>
                        <p>${airportCodes[itineraries.segments[0].departure.iataCode].airportname} Airport, Terminal ${itineraries.segments[0].departure.terminal}, ${airportCodes[itineraries.segments[0].departure.iataCode].city}</p>
                      </div>
                      <div class="d-flex flex-column colks22 align-items-center">
                        <i class="fa fa-clock"></i>
                        <p>${itineraries.segments[0].duration.substr(2)}</p>
                      </div>
                      <div class="d-flex align-items-center flex-column colks23 align-items-start">
                        <h3>${itineraries.segments[0].arrival.iataCode} <strong>${arrivalTime}</strong></h3>
                        <p>${arrivalDateFormatted}</p>
                        <p>${airportCodes[itineraries.segments[0].arrival.iataCode].airportname} Airport${itineraries.segments[0].arrival.terminal ? `, Terminal ${itineraries.segments[0].arrival.terminal}` : ''}, ${airportCodes[itineraries.segments[0].arrival.iataCode].city}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center colks3">
                      ${values.travelerPricings[0].fareDetailsBySegment[0].includedCheckedBags.weight ? `
                        <div class="d-flex justify-content-between colks31">
                          <p>Check-in baggage: </p>
                          <p><strong>${values.travelerPricings[0].fareDetailsBySegment[0].includedCheckedBags.weight}${values.travelerPricings[0].fareDetailsBySegment[0].includedCheckedBags.weightUnit}</strong></p>
                        </div>
                      ` : values.travelerPricings[0].fareDetailsBySegment[0].includedCheckedBags.quantity ? `
                        <div class="d-flex justify-content-between colks31">
                          <p>Check-in bags</p>
                          <p><strong>${values.travelerPricings[0].fareDetailsBySegment[0].includedCheckedBags.quantity} Qty</strong></p>
                        </div>
                      ` : ''}
                    </div>
                  </div>
                </div>
                ${details}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
}
// $$$$$$$$$$$$$$$$$$$$ Ends Rendering The Flight Details $$$$$$$$$$$$$$$$$$$$ 