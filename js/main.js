$(window).load(function() {
   $("#loading").fadeOut(500);
})


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
        $('#photo').attr('src', e.target.result);               
                        
        };
        reader.readAsDataURL(input.files[0]);
    }
}


function formatar(mascara, documento) {
  var i = documento.value.length;
  var saida = mascara.substring(0, 1);
  var texto = mascara.substring(i)
  
  if (texto.substring(0, 1) !== saida){
            documento.value += texto.substring(0,1);
  }
  
}

    
var placeSearch, autocomplete;
var componentForm = {
  locality: 'long_name',
  sublocality_level_1 : 'short_name',
  administrative_area_level_1: 'short_name',
  
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
    
    var options = {
    types: ['geocode'],
    componentRestrictions: {country: 'br'}
    };
    
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
      options);

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
// [END region_geolocation]

    
