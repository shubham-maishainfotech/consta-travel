
const onward_flights_cntnr = document.getElementById('onward_flights');
const returning_flights_cntnr = document.getElementById('returning_flights');

renderFlightDetails(ongoingFlights, ongoingCarriers, onward_flights_cntnr);
renderFlightDetails(returningFlights, returningCarriers, returning_flights_cntnr);

function renderFlightDetails(flights, carriers, container) {
    // container.innerHTML = '';

    flights.forEach(function (flight, idx) {
        let values = flight;
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
        const deparDate = dedate.toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            weekday: 'long'
        });

        // Computing Arrival Date
        const arrdate = itineraries.segments[itineraries.segments.length - 1].arrival.at;
        const arrArray = arrdate.split("T");
        const arrivalDate = arrArray[0];
        const arrivalTime = arrArray[1].substr(0, 5);
        const adate = new Date(arrivalDate);
        const ardate = adate.toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            weekday: 'long'
        });

        // Total stops between source & destination
        const noOfStops = itineraries.segments.length - 1;
        // Fetching Total Fare/price
        const totalFare = Math.ceil(values.travelerPricings[0].price.total).toLocaleString();
        let flightDetail = `
          <div class="theme-search-results" id="tobePagination-">
            <div class="theme-search-results-item theme-search-results-item-rounded" data-index="${idx}">
              <div class="theme-search-results-item-preview" >
                <div class="row main_container" data-gutter="20">
                  <div class="col-md-9 ">
                    <div class="theme-search-results-item-flight-sections">
                      <div class="row row-no-gutter row-eq-height" style="display: flex; align-items:center;">
                        <div class="col-md-2 colks">
                          <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                            <img class="theme-search-results-item-flight-section-airline-logo flight_img" src="https://pics.avs.io/200/100/${itineraries.segments[0].carrierCode}.png" alt="Consta Travel" title="Image Title">
                          </div>
                          <p style="font-size: 10px; line-height: 1;" class="carrier_name">${carriers[itineraries.segments[0].carrierCode]}</p>
                        </div>
                        <div class="col-md-10 ">
                          <div class="theme-search-results-item-flight-section-item">
                            <div class="row" style="display: flex;justify-content: space-between;align-items: center;">
                              <div class="col-md-3">
                                <div class="theme-search-results-item-flight-section-meta">
                                  <p class="theme-search-results-item-flight-section-meta-time deperture_time" >
                                    ${depTime} </p>
                                </div>
                              </div>
                              <div class="col-md-6 ">
                                <div class="theme-search-results-item-flight-section-path">
                                  <div class="theme-search-results-item-flight-section-path-fly-time">
                                    <p class="flight_duration">${duration}</p>
                                  </div>
                                  <div class="theme-search-results-item-flight-section-path-line"></div>

                                  <div class="theme-search-results-item-flight-section-path-status">
                                    <h5 class="theme-search-results-item-flight-section-airline-title flight_stops">
                                      ${noOfStops === 0 ? '( Non Stop )' : `( Stops : ${noOfStops} )`}
                                    </h5>

                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3 ">
                                <div class="theme-search-results-item-flight-section-meta">

                                  <p class="theme-search-results-item-flight-section-meta-time arrival_time">
                                  ${arrivalTime}  
                                  </p>
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
                        <p class="theme-search-results-item-price-tag"><i class="fa fa-inr" aria-hidden="true"></i><span class="total_fare"> ${totalFare}</span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      `;
        container.innerHTML += flightDetail;
    });
}



function setFlightDetailModalData(values1, carriers1, aircraft1, airportCodes1, values2, carriers2, aircraft2, airportCodes2) {
    let detail_modal_cntnr_onward = document.getElementById('flight_detail_modal_onward');
    detail_modal_cntnr_onward.innerHTML = '';
    let detailModal = `${renderDetails(values1, carriers1, aircraft1, airportCodes1)}`;
    detail_modal_cntnr_onward.innerHTML += detailModal;
    // Setting Return Flight Detail Model
    let detail_modal_cntnr_return = document.getElementById('flight_detail_modal_return');
    detail_modal_cntnr_return.innerHTML = '';
    detailModal = `${renderDetails(values2, carriers2, aircraft2, airportCodes2)}`;
    detail_modal_cntnr_return.innerHTML += detailModal;
}



document.addEventListener('DOMContentLoaded', function () {

    // Add numbers
    function addFormattedNumbers(numStr1, numStr2) {
        // Remove commas from the strings
        const cleanedNumStr1 = numStr1.replace(/,/g, '');
        const cleanedNumStr2 = numStr2.replace(/,/g, '');

        // Convert the cleaned strings to numbers
        const num1 = parseInt(cleanedNumStr1);
        const num2 = parseInt(cleanedNumStr2);

        // Add the numbers
        const sum = num1 + num2;

        // Optional: Format the result with commas
        const formattedSum = sum.toLocaleString();

        return formattedSum;
    }
    // Function to get Selected Item
    function selectedItemsData() {
        // Get selected items from the onward flights column
        const selectedOnward = document.querySelector('#onward_flights .selected');

        // Get selected items from the returning flights column
        const selectedReturning = document.querySelector('#returning_flights .selected');

        // Collecting Selected Onward Flight Data
        let onwardCarrierName = selectedOnward ? selectedOnward.querySelector('.selected .carrier_name').textContent.trim() : null;
        let onwardDepertureTime = selectedOnward ? selectedOnward.querySelector('.selected .deperture_time').textContent.trim() : null;
        let onwardFlightDuration = selectedOnward ? selectedOnward.querySelector('.selected .flight_duration').textContent.trim() : null;
        let onwardFlightStops = selectedOnward ? selectedOnward.querySelector('.selected .flight_stops').textContent.trim() : null;
        let onwardArrivalTime = selectedOnward ? selectedOnward.querySelector('.selected .arrival_time').textContent.trim() : null;
        let onwardTotalFare = selectedOnward ? selectedOnward.querySelector('.selected .total_fare').textContent.trim() : null;
        let onwardFlightImg = selectedOnward ? selectedOnward.querySelector('.selected .flight_img').getAttribute('src') : null;
        // console.log(onwardCarrierName, onwardDepertureTime, onwardFlightDuration, onwardFlightStops, onwardArrivalTime, onwardTotalFare);

        // Updating Onward Flight Value
        document.getElementById('onward_carrier_name').innerHTML = onwardCarrierName;
        document.getElementById('onward_deperture_time').innerHTML = onwardDepertureTime;
        document.getElementById('onward_flight_duration').innerHTML = onwardFlightDuration;
        document.getElementById('onward_flight_stops').innerHTML = onwardFlightStops;
        document.getElementById('onward_arrival_time').innerHTML = onwardArrivalTime;
        document.getElementById('onward_flight_img').setAttribute('src', onwardFlightImg);

        // Collecting Selected Returning Flight Data
        let returnCarrierName = selectedReturning ? selectedReturning.querySelector('.selected .carrier_name').textContent.trim() : null;
        let returnDepertureTime = selectedReturning ? selectedReturning.querySelector('.selected .deperture_time').textContent.trim() : null;
        let returnFlightDuration = selectedReturning ? selectedReturning.querySelector('.selected .flight_duration').textContent.trim() : null;
        let returnFlightStops = selectedReturning ? selectedReturning.querySelector('.selected .flight_stops').textContent.trim() : null;
        let returnArrivalTime = selectedReturning ? selectedReturning.querySelector('.selected .arrival_time').textContent.trim() : null;
        let returnTotalFare = selectedReturning ? selectedReturning.querySelector('.selected .total_fare').textContent.trim() : null;
        let returnFlightImg = selectedReturning ? selectedReturning.querySelector('.selected .flight_img').getAttribute('src') : null;
        // Updating Returning Flight Value
        document.getElementById('return_carrier_name').innerHTML = returnCarrierName;
        document.getElementById('return_deperture_time').innerHTML = returnDepertureTime;
        document.getElementById('return_flight_duration').innerHTML = returnFlightDuration;
        document.getElementById('return_flight_stops').innerHTML = returnFlightStops;
        document.getElementById('return_arrival_time').innerHTML = returnArrivalTime;
        document.getElementById('return_flight_img').setAttribute('src', returnFlightImg);

        document.getElementById('combined_total_fare').innerHTML = addFormattedNumbers(onwardTotalFare, returnTotalFare);
        document.getElementById('combined_modal_price').innerHTML = addFormattedNumbers(onwardTotalFare, returnTotalFare);
        // setFlightDetailModalData(1);
        let onward_flight_indx = selectedOnward.getAttribute('data-index');
        let return_flight_indx = selectedReturning.getAttribute('data-index');

        // renderDetails(values, carriers, aircraft, airportCodes)
        // console.log(ongoingFlights[onward_flight_indx])
        console.log('airport-codes', returningAirportCodes)
        setFlightDetailModalData(ongoingFlights[onward_flight_indx], ongoingCarriers, ongoingAircraft, ongoingAirportCodes, returningFlights[return_flight_indx], returningCarriers, returningAircraft, returningAirportCodes);
    }

    // Function to handle the selection logic
    function handleSelection(event) {
        // Get the target element
        const target = event.currentTarget;
        const parent = target.closest('.col');

        // Remove 'selected' class from all items in the same column
        parent.querySelectorAll('.theme-search-results-item').forEach(item => {
            item.classList.remove('selected');
        });

        // Add 'selected' class to the clicked item
        target.classList.add('selected');
    }

    // Add event listeners to all items in the 'onward_flights' column
    document.querySelectorAll('#onward_flights .theme-search-results-item').forEach(item => {
        // console.log(getSelectedItems()); handleSelection()
        item.addEventListener('click', item => {
            handleSelection(item);
            selectedItemsData();
            // console.log(item.dataset.index);
            // setFlightDetailModalData(item);
        });
    });

    // Add event listeners to all items in the 'returning_flights' column
    document.querySelectorAll('#returning_flights .theme-search-results-item').forEach(item => {
        item.addEventListener('click', item => {
            handleSelection(item);
            selectedItemsData();
        });
    });

    // Set the default selected state
    document.querySelector('#onward_flights .theme-search-results-item').classList.add('selected');
    document.querySelector('#returning_flights .theme-search-results-item').classList.add('selected');
    selectedItemsData();
});



// $$$$$$$$$$$$$$$$$$$$ Rendering The Flight Details $$$$$$$$$$$$$$$$$$$$
function renderDetails(values, carriers, aircraft, airportCodes) {
    let details = '';
    console.log('1799', airportCodes);
    let itineraries = values.itineraries[0];
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
            // console.log('trt', airportCodes[segment.departure.iataCode].airportname);
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
  `;
}
// $$$$$$$$$$$$$$$$$$$$ Ends Rendering The Flight Details $$$$$$$$$$$$$$$$$$$$ 
