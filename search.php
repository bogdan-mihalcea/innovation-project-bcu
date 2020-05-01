<?php
	// show all the errors to help development
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	// Credentials
	include 'config.php';
	
	// API calls & form
	if ($_SERVER['REQUEST_METHOD'] == 'POST') // check if form was submitted
	{
		$address = $_POST['autocomplete']; // get input address
		// firstly we use Google Autocomplete Form to get user's address
		// then we are using Google's Geocode API to get the latitude and longitude of our previously autocompleted address
		$geocode_url = "https://maps.googleapis.com/maps/api/geocode/xml?address=".$address."&key=".$apikey."";
		$geocode_xml = simplexml_load_file($geocode_url);
		// checking if we've got a valid response from the API
		if ($geocode_xml->status == "OK"){
			$lat = $geocode_xml->result->geometry->location->lat;
			$lng = $geocode_xml->result->geometry->location->lng;
			// now that we have latitude and longitute, we can go forward and call the next API that will get convenience stores in the area within a 2km radius
			$shops_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/xml?location=".$lat.",".$lng."&radius=2000&type=grocery_or_supermarket&keyword=local&key=".$apikey."";
			$shops_xml = simplexml_load_file($shops_url);
			// checking if we've got a valid response from the API
			if ($shops_xml->status == "OK"){
				// sample concept
				echo "Shops available within a 2km radius: (not sorted yet)<br>";
				foreach ($shops_xml->result as $children) {
					echo $children->name;
					echo "<br>";
				}
				echo "<br>";
				echo "<br>";
				// first shop name [index: 0], address, number of user ratings and unique google ID
				echo $shops_xml->result[0]->name;
				echo "<br>";
				echo $shops_xml->result[0]->vicinity;
				echo "<br>";
				echo $shops_xml->result[0]->user_ratings_total;
				echo "<br>";
				echo $shops_xml->result[0]->place_id;
				echo "<br>";
				echo "<br>";
				// second shop name [index: 1], address, number of user ratings and unique google ID
				echo $shops_xml->result[1]->name;
				echo "<br>";
				echo $shops_xml->result[1]->vicinity;
				echo "<br>";
				echo $shops_xml->result[1]->user_ratings_total;
				echo "<br>";
				echo $shops_xml->result[1]->place_id;	
				echo "<br>";
				echo "<br>";
				// third shop name [index: 2], address, number of user ratings and unique google ID
				echo $shops_xml->result[2]->name;
				echo "<br>";
				echo $shops_xml->result[2]->vicinity;
				echo "<br>";
				echo $shops_xml->result[2]->user_ratings_total;
				echo "<br>";
				echo $shops_xml->result[2]->place_id;	
			}
			else echo "The Places API returned an invalid response. Please contact the website administrator! (Error code #002)";
		}
		else echo "The Geocode API returned an invalid response. Please contact the website administrator! (Error code #001)";
		// close the PHP session
		exit();
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Innovation Project</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
	<link type="text/css" rel="stylesheet" href="search.css">
  </head>

<style>
	  #locationField, #controls {
        position: relative;
        width: 480px;
      }
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }

      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
</style>
  <body>



        <form method="post">
			Please search for your address: 
    <div id="locationField">
      <input id="autocomplete"
             placeholder="Enter your address"
             onFocus="geolocate()"
             type="text"
			 name="autocomplete"/>
    </div>
            <input type="submit" name="submit_btn"/>
        </form>


    <!-- Note: The address components in this sample are typical. You might need to adjust them for
               the locations relevant to your app. For more information, see
         https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
    -->

    <script>
// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:


var placeSearch, autocomplete;

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(['address_component']);
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
      </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apikey; ?>&libraries=places&callback=initAutocomplete"
        async defer></script>
  </body>
</html>