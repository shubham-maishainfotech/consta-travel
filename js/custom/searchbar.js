
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

    // Function to select all text in the input field
    function selectAllText(event) {
        event.target.select();
    }
    document.getElementById('flightonewayfrom').addEventListener('focus', selectAllText);
    document.getElementById('flightonewayto').addEventListener('focus', selectAllText);

  $(function() {
      // Initialize Departure Datepicker
      $('#flightonewaydeparture_date').datepicker({
          dateFormat: "yy-mm-dd",
          minDate : new Date(),
          onSelect: function(dateText) {
              // Update Arrival Datepicker's minDate when Departure Date changes
              var departureDate = $(this).datepicker('getDate');
              $('#flightonewayarrival_date').datepicker('option', 'minDate', departureDate);
          }
      });

      // Initialize Arrival Datepicker
      $('#flightonewayarrival_date').datepicker({
          dateFormat: "yy-mm-dd",
          minDate: 0, // This will be updated dynamically based on Departure Date
          onSelect : function (dateText){
            $('#clear_date_btn').show();
            $('#header_search_form').attr('action', '/new-flight-return.php');
            $('#trip_type').val('2').change();
          }
      }).focus(function() {
          // Check if the departure date is empty
          if ($('#flightonewaydeparture_date').val() === "") {
              // Trigger the departure datepicker
              $('#flightonewaydeparture_date').datepicker('show');
          }
      });
  });

  function clr_dt_btn(){
    if($('#flightonewayarrival_date').val() == ''){
      $('#clear_date_btn').hide();
      $('#header_search_form').attr('action', '/new-flight-search.php');
      // Select the first option (One way)
      $('#trip_type').val('1').change();
    }else{
      $('#clear_date_btn').show();
      $('#header_search_form').attr('action', '/new-flight-return.php');
      $('#trip_type').val('2').change();
    }
  }
  $('#clear_date_btn').click(function (){
    $('#flightonewayarrival_date').val('');
    $('#clear_date_btn').hide();
    $('#header_search_form').attr('action', '/new-flight-search.php');
    $('#trip_type').val('1').change();
  });

  clr_dt_btn();



  // Funtion to get current date
  function getCurrentDate() {
      const date = new Date();
      const year = date.getFullYear().toString().slice(-2); // Get last 2 digits of the year
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
      const day = String(date.getDate()).padStart(2, '0');

      return `${year}-${month}-${day}`;
  }
  
  // Oneway And round trip selection
  let select_trip_type = document.getElementById('trip_type');
  select_trip_type.addEventListener('change', function(event){
    let search_form = document.getElementById('header_search_form');

    if(event.target.value === '2'){
      search_form.setAttribute('action', '/new-flight-return.php');
      // Set the current date in both fields and trigger the datepicker
      const currentDate = new Date();
      $('#flightonewaydeparture_date').datepicker('setDate', currentDate);
      $('#flightonewayarrival_date').datepicker('setDate', currentDate);
      $('#clear_date_btn').show();

    }else{
      search_form.setAttribute('action', '/new-flight-search.php');
      $('#flightonewayarrival_date').val('');
      $('#clear_date_btn').hide();
    }

  });

  $(document).ready(function() {
    $('#header_search_form').on('submit', function(e) {
        var isValid = true;

        // Check all required fields
        $(this).find('[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).focus(); // Focus on the first empty required field
                return false; // Break out of the each loop
            }
        });

        if (!isValid) {
            e.preventDefault(); // Prevent form submission
            alert('Please fill in all necessary fields[Source, Destination, Departure_Date]');
        }
    });
});