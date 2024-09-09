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
