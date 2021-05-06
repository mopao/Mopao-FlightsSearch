
/* this function find airports matching the word enter by users */
function findMatchingAirports(e) {
  var keyword = $(this).val().trim();
  var data = {
    "keyword": keyword
  };
  var elt = $(this);
  //console.log(data);
  $.ajax({
    dataType: "json",
    url: "api/find_airports.php",
    data: data,
    type: "GET",
    success: function (result,status,xhr) {
      elt.autocomplete("option", "source", result);
      //console.log(result);
    },
    error: function (xhr){ console.log(xhr.responseText);}

 });
  //console.log(data);
}
window.onload = function () {
 var t =""
  let config1 = {
          altInput: true,
          altFormat: "Y-m-d",
          dateFormat: "Y-m-d",
          minDate: 'today',
          allowInput: true,
          onChange: function(selectedDates, dateStr, instance) {
              //...
              t= dateStr;
              config2.minDate = t;
              //console.log(dateStr);
              $("#returnDate").flatpickr(config2);
          }
      }
  let config2 = {
          altInput: true,
          altFormat: "Y-m-d",
          dateFormat: "Y-m-d",
          minDate: $('#departureDate').val(),
          allowInput: true,
      }
  $("#departureDate").flatpickr(config1);
  $("#returnDate").flatpickr(config2);

  // hide the return date field if it is a one-way search
  $('#one-way').click(function () {
    var return_date_div = $('#div-return-date');
    return_date_div.hide();
    $('#returnDate').val("");

    //update class of departure date to occupied more namespace
    $('#div-departure-date').removeClass('col-md-5');
    $('#div-departure-date').addClass('col-md-12');

  });

  // show the return date field if it is a roundtrip search
  $('#roundtrip').click(function () {
    var return_date_div = $('#div-return-date');
    return_date_div.show();
    $('#returnDate').val("");

    //update class of departure date to occupied more namespace
    $('#div-departure-date').removeClass('col-md-12');
    $('#div-departure-date').addClass('col-md-5');
  });
  // add event handler to departure location altInput and enable autocompletion
  $("#origin").autocomplete({
    source: [],
    _resizeMenu: function() {
      this.menu.element.outerWidth( 200 );
    },
    minLength: 0,
    change: function( event, ui ) {
      // force user select from the autocomplete menu
      //console.log(ui);
      if (ui.item === null) {
        $("#origin").val("");
      }
    }
  });
  $('#origin').on( "input", findMatchingAirports );


  // add event handler to destination location altInput and enable autocompletion
  $("#destination").autocomplete({
    source: [],
    _resizeMenu: function() {
      this.menu.element.outerWidth( 200 );
    },
    minLength: 0,
    change: function( event, ui ) {
      // force user select from the autocomplete menu
      //console.log(ui);
      if (ui.item === null) {
        $("#destination").val("");
      }
    }
  });
  $('#destination').on( "input", findMatchingAirports );


};
