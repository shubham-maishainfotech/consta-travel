<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include('flight_search_static_api_data.php');
    $res = $api_data;
    $res = json_decode($res, true)['data'];
    $result = json_encode($res);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Store JSON in Session Storage</title>
    <script>
        function getTotalPrice(flight) {
            return parseFloat(flight.price.total);
        }

        function sortFlightsByTotalPrice(flightSearchData) {
            try {
                // Parse the JSON string into a JavaScript object
                let flightData = JSON.parse(flightSearchData);

                // Check if the data is an array
                if (!Array.isArray(flightData)) {
                    throw new Error("Expected data to be an array");
                }
                
                // Sort the array by total price
                flightData.sort((a, b) => {
                    let totalPriceA = getTotalPrice(a);
                    let totalPriceB = getTotalPrice(b);
                    return totalPriceB - totalPriceA;
                    // return totalPriceA - totalPriceB;
                });
                
                // Convert the sorted array back to a JSON string
                return JSON.stringify(flightData, null, 2); // Pretty-print with indentation
            } catch (error) {
                console.error("Error sorting flights:", error);
                return null;
            }
        }
    </script>
    <script>
        // This script will run when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            // Get the JSON string from the PHP variable
            var jsonData = <?php echo $result; ?>;
            
            // Store the JSON string in the session storage
            sessionStorage.setItem('flight_search_result', JSON.stringify(jsonData));

            // Verify the data is stored (for demonstration purposes)
            let flightSearchData = sessionStorage.getItem('flight_search_result');
            let sortedData = JSON.parse(sortFlightsByTotalPrice(flightSearchData));
            // console.log(sortedData);
            // sortedData.forEach((values) =>{
            //     // Getting itineraries Array
            //     const itineraries = values.itineraries[0];
            //     // Calculating travel time
            //     let duration = itineraries.duration;
            //     duration = duration.substring(2); // Equivalent to PHP's substr
            //     // console.log(duration, ' | ');
            // });
            createFlightDetails(sortedData);
        });
    </script>
</head>
<body>
    <div class="theme-search-results" id="tobePagination"></div>
</body>
</html>

<script>
    const total = 1; // Assuming you have a total count variable

    function createFlightDetails(data) {
        const container = document.getElementById('tobePagination');

        if (total >= 1) {
            const value = data;
            const onwardsCounter = 100;

            if (onwardsCounter >= 1) {
            let sr = 1;
            value.forEach(values => {
                const itineraries = values.itineraries[0];
                const duration = itineraries.duration.substring(2);
                const depdate = itineraries.segments[0].departure.at;
                const depArray = depdate.split("T");
                const depDate = depArray[0];
                const depTime = depArray[1].substring(0, 5);
                const deparDate = new Date(depDate).toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' });
                
                const arrdate = itineraries.segments[itineraries.segments.length - 1].arrival.at;
                const dArray = arrdate.split("T");
                const arrivalDate = dArray[0];
                const arrivalTime = dArray[1].substring(0, 5);
                const arDate = new Date(arrivalDate).toLocaleDateString('en-US', { day: 'numeric', month: 'long', weekday: 'long' });
                
                const noOfStops = itineraries.segments.length - 1;
                const totalFare = values.travelerPricings[0].price.total;

                const flightItem = document.createElement('div');
                flightItem.className = 'theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-';
                flightItem.innerHTML = `
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
                                        <p class="theme-search-results-item-flight-section-meta-city">Departure City</p>
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
                                        <div class="theme-search-results-item-flight-section-path-line-title">Departure Code</div>
                                        </div>
                                        <div class="theme-search-results-item-flight-section-path-line-end">
                                        <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                        <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                        <div class="theme-search-results-item-flight-section-path-line-title">Destination Code</div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="theme-search-results-item-flight-section-meta">
                                        <p class="theme-search-results-item-flight-section-meta-time">${arrivalTime}</p>
                                        <p class="theme-search-results-item-flight-section-meta-city">Destination City</p>
                                        <p class="theme-search-results-item-flight-section-meta-date">${arDate}</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                            <h5 class="theme-search-results-item-flight-section-airline-title">${values.airline} (${noOfStops === 0 ? 'Non Stop' : 'Stops: ' + noOfStops})</h5>
                            <a href="#searchResultsItem-${sr}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-${sr}">
                            <h5 class="theme-search-results-item-flight-section-airline-title">View Flight Details</h5>
                            </a>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="theme-search-results-item-book">
                        <div class="theme-search-results-item-price">
                            <p class="theme-search-results-item-price-tag"><i class="fa fa-eur" aria-hidden="true"></i> ${totalFare}</p>
                            <p class="theme-search-results-item-price-sign">Economy</p>
                        </div>
                        <a class="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" target="_blank" href="flight-payment.php?token=token&flightid=${values.FlHash}">Book Now</a>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="collapse theme-search-results-item-collapse" id="searchResultsItem-${sr}">
                    <div class="theme-search-results-item-extend">
                    <a class="theme-search-results-item-extend-close" href="#searchResultsItem-${sr}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-${sr}">&#10005;</a>
                    <div class="theme-search-results-item-extend-inner">
                        <div class="theme-search-results-item-flight-detail-items">
                        <div class="theme-search-results-item-flight-details">
                            <div class="row">
                            <div class="col-md-3">
                                <div class="theme-search-results-item-flight-details-info">
                                <h5 class="theme-search-results-item-flight-details-info-title">Depart</h5>
                                <p class="theme-search-results-item-flight-details-info-date">${deparDate}</p>
                                <p class="theme-search-results-item-flight-details-info-cities">Departure City → Destination City</p>
                                <p class="theme-search-results-item-flight-details-info-fly-time">${duration}</p>
                                <p class="theme-search-results-item-flight-details-info-stops">${noOfStops === 0 ? 'Non Stop' : 'Stops: ' + noOfStops}</p>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="theme-search-results-item-flight-details-schedule">
                                <ul class="theme-search-results-item-flight-details-schedule-list">
                                    <li>
                                    <i class="fa fa-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                    <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                    <p class="theme-search-results-item-flight-details-schedule-date">${deparDate}</p>
                                    <div class="theme-search-results-item-flight-details-schedule-time">
                                        <span class="theme-search-results-item-flight-details-schedule-time-item">${depTime} - ${arrivalTime}</span>
                                        <span class="theme-search-results-item-flight-details-schedule-time-separator">&mdash;</span>
                                    </div>
                                    <p class="theme-search-results-item-flight-details-schedule-fly-time">${duration}</p>
                                    <div class="theme-search-results-item-flight-details-schedule-destination">
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                        <p class="theme-search-results-item-flight-details-schedule-destination-title">Departure Airport</p>
                                        <p class="theme-search-results-item-flight-details-schedule-destination-city">Departure City</p>
                                        </div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-separator">&rarr;</div>
                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                        <p class="theme-search-results-item-flight-details-schedule-destination-title">Destination Airport</p>
                                        <p class="theme-search-results-item-flight-details-schedule-destination-city">Destination City</p>
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
                `;
                container.appendChild(flightItem);
                sr++;
            });
            }
        }
    }

    
</script>
