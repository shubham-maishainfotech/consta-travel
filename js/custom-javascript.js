// ================ comparison functions definition for sorting =================
function compareByTotalPrice(a, b) {
    let totalPriceA = parseFloat(a.price.total);
    let totalPriceB = parseFloat(b.price.total);
    return totalPriceA - totalPriceB;
}

function compareByDuration(a, b) {
    // duration is of format PT14H20M, here we are converting durations in minutes
    let durationA = a.itineraries[0].duration.substring(2);
    if(durationA.indexOf('H') != -1 && durationA.indexOf('M') != -1){
        let durArr = durationA.split('H');
        durationA = parseInt(durArr[1])+parseInt(durArr[0])*60;
    }else if(durationA.indexOf('H') != -1){
        durationA = parseInt(durationA)*60;
    }else{
        durationA = parseInt(durationA);
    }
    // second element duration in minutes
    let durationB = b.itineraries[0].duration.substring(2);
    if(durationB.indexOf('H') != -1 && durationB.indexOf('M') != -1){
        let durArr = durationB.split('H');
        durationB = parseInt(durArr[1])+parseInt(durArr[0])*60;
    }else if(durationB.indexOf('H') != -1){
        durationB = parseInt(durationB)*60;
    }else{
        durationB = parseInt(durationB);
    }

    return durationA - durationB;
}
// ---------------- Sorting Function -------------------
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
// ---------------- sorting Function ends -------------------
// ================ comparison functions definition for sorting Ends Here =================

// ============== Filtering Search Data For different Functions ============================
let price_order = 'asc';
function price_filter(){
    // console.log('price filter ...!');
    let flightSearchData = sessionStorage.getItem('flight_search_result');
    let sortedData = '';
    if(price_order == 'asc'){
        sortedData = JSON.parse(sortFlights(flightSearchData, compareByTotalPrice, 'desc'));
        price_order = 'desc';
    }
    else{
        sortedData = JSON.parse(sortFlights(flightSearchData, compareByTotalPrice, 'asc'));
        price_order = 'asc';
    }
    createFlightDetails(sortedData);
}

let duration_order = 'asc';
function duration_filter(){
    // console.log('duration filter called..!');
    let flightSearchData = sessionStorage.getItem('flight_search_result');
    let sortedData = '';
    if(duration_order == 'asc'){
        sortedData = JSON.parse(sortFlights(flightSearchData, compareByDuration, 'desc'));
        duration_order = 'desc';
    }
    else{
        sortedData = JSON.parse(sortFlights(flightSearchData, compareByDuration, 'asc'));
        duration_order = 'asc';
    }
    createFlightDetails(sortedData);
}
// ======================== Rerendering Sorted data ======================
const total = 1; // Assuming you have a total count variable

    function createFlightDetails(data) {
        const container = document.getElementById('tobePagination');
        container.innerHTML = ''; // Clear existing content

        if (data.length >= 1) {
        data.forEach((value, index) => {
            const itineraries = value.itineraries[0];
            const duration = itineraries.duration.substring(2);
            const depdate = itineraries.segments[0].departure.at;
            const depArray = depdate.split("T");
            const depDate = depArray[0];
            const depTime = depArray[1].substring(0, 5);
            const dedate = new Date(depDate);
            const deparDate = dedate.toLocaleDateString("en-US", { day: '2-digit', month: 'long', weekday: 'long' });
            const arrdate = itineraries.segments[itineraries.segments.length - 1].arrival.at;
            const arrArray = arrdate.split("T");
            const arrivaldate = arrArray[0];
            const arrivaltime = arrArray[1].substring(0, 5);
            const adate = new Date(arrivaldate);
            const ardate = adate.toLocaleDateString("en-US", { day: '2-digit', month: 'long', weekday: 'long' });
            const noOfStops = itineraries.segments.length - 1;
            const totalFare = value.travelerPricings[0].price.total;
            const departureCity = "Departure City"; // Replace with actual data
            const departureCityCode = "DEP"; // Replace with actual data
            const destinationCity = "Destination City"; // Replace with actual data
            const destinationCityCode = "DES"; // Replace with actual data
            const travelClass = "ECONOMY"; // Replace with actual data
            const airline = value.airline;
            const flightHash = value.FlHash;

            const flightHTML = `
            <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                <div class="theme-search-results-item-preview">
                <div class="row" data-gutter="20">
                    <div class="col-md-10">
                    <div class="theme-search-results-item-flight-sections">
                        <div class="theme-search-results-item-flight-section">
                        <div class="row row-no-gutter row-eq-height">
                            <div class="col-md-2">
                            <div class="theme-search-results-item-flight-section-airline-logo-wrap">
                                <img class="theme-search-results-item-flight-section-airline-logo" src="img/flight.png" alt="Consta Travel" title="Image Title" />
                            </div>
                            </div>
                            <div class="col-md-10">
                            <div class="theme-search-results-item-flight-section-item">
                                <div class="row">
                                <div class="col-md-3">
                                    <div class="theme-search-results-item-flight-section-meta">
                                    <p class="theme-search-results-item-flight-section-meta-time">${depTime}</p>
                                    <p class="theme-search-results-item-flight-section-meta-city">${departureCity}</p>
                                    <p class="theme-search-results-item-flight-section-meta-date">${deparDate}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="theme-search-results-item-flight-section-path">
                                    <div class="theme-search-results-item-flight-section-path-fly-time">
                                        <p>${duration}</p>
                                    </div>
                                    <div class="theme-search-results-item-flight-section-path-line"></div>
                                    <div class="theme-search-results-item-flight-section-path-line-start">
                                        <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                        <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                        <div class="theme-search-results-item-flight-section-path-line-title">${departureCityCode}</div>
                                    </div>
                                    <div class="theme-search-results-item-flight-section-path-line-end">
                                        <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                        <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                        <div class="theme-search-results-item-flight-section-path-line-title">${destinationCityCode}</div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="theme-search-results-item-flight-section-meta">
                                    <p class="theme-search-results-item-flight-section-meta-time">${arrivaltime}</p>
                                    <p class="theme-search-results-item-flight-section-meta-city">${destinationCity}</p>
                                    <p class="theme-search-results-item-flight-section-meta-date">${ardate}</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <h5 class="theme-search-results-item-flight-section-airline-title">${airline} (${noOfStops === 0 ? "Non Stop" : "Stops: " + noOfStops})</h5>
                        <a href="#searchResultsItem-${index + 1}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-${index + 1}">
                            <h5 class="theme-search-results-item-flight-section-airline-title">View Flight Details</h5>
                        </a>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-2">
                    <div class="theme-search-results-item-book">
                        <div class="theme-search-results-item-price">
                        <p class="theme-search-results-item-price-tag"><i class="fa fa-eur" aria-hidden="true"></i> ${totalFare}</p>
                        <p class="theme-search-results-item-price-sign">${travelClass}</p>
                        </div>
                        <a class="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" target="_blank" href="flight-payment.php?token=token&flightid=${flightHash}">Book Now</a>
                    </div>
                    </div>
                </div>
                </div>
                <div class="collapse theme-search-results-item-collapse" id="searchResultsItem-${index + 1}">
                <div class="theme-search-results-item-extend">
                    <a class="theme-search-results-item-extend-close" href="#searchResultsItem-${index + 1}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-${index + 1}">&#10005;</a>
                    <div class="theme-search-results-item-extend-inner">
                    <div class="theme-search-results-item-flight-detail-items">
                        <div class="theme-search-results-item-flight-details">
                        <div class="row">
                            <div class="col-md-3">
                            <div class="theme-search-results-item-flight-details-info">
                                <h5 class="theme-search-results-item-flight-details-info-title">Depart</h5>
                                <p class="theme-search-results-item-flight-details-info-date">${dedate.toLocaleDateString("en-US", { weekday: 'long', month: 'long', day: '2-digit' })}</p>
                                <p class="theme-search-results-item-flight-details-info-cities">${departureCity} &rarr; ${destinationCity}</p>
                                <p class="theme-search-results-item-flight-details-info-fly-time">${duration}</p>
                                <p class="theme-search-results-item-flight-details-info-stops">${noOfStops === 0 ? "Non Stop" : "Stops: " + noOfStops}</p>
                            </div>
                            </div>
                            <div class="col-md-9">
                            <div class="theme-search-results-item-flight-details-schedule">
                                <ul class="theme-search-results-item-flight-details-schedule-list">
                                <li>
                                    <i class="fa fa-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                    <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                    <p class="theme-search-results-item-flight-details-schedule-date">${dedate.toLocaleDateString("en-US", { weekday: 'long', month: 'long', day: '2-digit' })}</p>
                                    <div class="theme-search-results-item-flight-details-schedule-time">
                                    <span class="theme-search-results-item-flight-details-schedule-time-item">${depTime} - ${arrivaltime}</span>
                                    <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>
                                    </div>
                                    <p class="theme-search-results-item-flight-details-schedule-fly-time">${duration}</p>
                                    <div class="theme-search-results-item-flight-details-schedule-destination">
                                    <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                        <p>${departureCity} (${departureCityCode})</p>
                                        <p>${deparDate}</p>
                                    </div>
                                    <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                        <p>${destinationCity} (${destinationCityCode})</p>
                                        <p>${ardate}</p>
                                    </div>
                                    </div>
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            `;

            container.insertAdjacentHTML('beforeend', flightHTML);
        });
        } else {
        container.innerHTML = `
            <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
            <div class="theme-search-results-item-preview">
                <div class="row" data-gutter="20">
                <div class="col-md-12">
                    <p>No flights found</p>
                </div>
                </div>
            </div>
            </div>
        `;
        }
    }
