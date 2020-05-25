<?php
// API calls & form
if ($_SERVER['REQUEST_METHOD'] == 'POST') // check if form was submitted
{
	// get input address + checking if we've got valid input
	if ($_POST['autocomplete'] == ''){
		exit("The request was not successful. Reason: No input address received. Please inform the website administrator! (Error code #001)<hr>Please <a href='index.php'>click here</a> to try again.");
	}
	else {
		$address = $_POST['autocomplete'];
	}

	// get option value + checking if we've got valid input
	if ($_POST['search_type'] == 'check_pharmacies'){
		$search_type = "pharmacy";
	}
	else if ($_POST['search_type'] == 'check_grocery_supermarkets'){
		$search_type = "grocery_or_supermarket";
	}
	else if ($_POST['search_type'] == 'check_convenience_stores'){
		$search_type = "convenience_store";
	}
	else {
		exit("The request was not successful. Reason: Invalid search type. Please inform the website administrator! (Error code #002)<hr>Please <a href='index.php'>click here</a> to try again.");
	}

	// firstly we use Google Autocomplete Form to get user's address
	// then we are using Google's Geocode API to get the latitude and longitude of our previously autocompleted address
	$geocode_url = "https://maps.googleapis.com/maps/api/geocode/xml?address=".$address."&key=".$apikey_web."";
	$geocode_xml = simplexml_load_file($geocode_url);
	//echo $geocode_url;
	// checking if we've got a valid response from the API
	if ($geocode_xml->status == "OK"){
		$lat = $geocode_xml->result->geometry->location->lat;
		$lng = $geocode_xml->result->geometry->location->lng;
		// get country code and setting region
		foreach ($geocode_xml->result->address_component as $geocode) {
			if ($geocode->type[0] == "country"){
				$region = strtolower($geocode->short_name);
			}
		}
		// now that we have latitude and longitute, we can go forward and call the next API that will get places in the area within a 2km radius
		$places_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/xml?location=".$lat.",".$lng."&radius=2000&type=".$search_type."&region=".$region."&key=".$apikey_web."";
		$places_xml = simplexml_load_file($places_url);
		// checking if we've got a valid response from the API
		if ($places_xml->status == "OK"){
			// adapting HTML table design
			echo "<section>";
			echo "<h3 class='major'><font color='orange'>Check the information by contacting the locations! The work schedule or services may differ due to the COVID-19 pandemic.</font></h3>";
			echo "<h4>Results - places are located within 2km of your address (<font color='orange'>".$address."</font>):</h4>";
			echo "<div class='table-wrapper'>";
			echo "<table class='alt'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Name:</th>";
			echo "<th>Address & business status:</th>";
			echo "<th>Opening hours today:</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			// iterating every result we get from calling the nearby search API to display all of them
			foreach ($places_xml->result as $places) {
				// calling the next API to get the place's URL, opening hours and phone number
				$place_id = $places->place_id;
				$places_details_url = "https://maps.googleapis.com/maps/api/place/details/xml?place_id=".$place_id."&fields=url,opening_hours,formatted_phone_number&key=".$apikey_web."";
				$places_details_xml = simplexml_load_file($places_details_url);
				// iterating every result we get from calling the Place Details API
				foreach ($places_details_xml->result as $places_details) {
					echo "<tr>";
					// Name and URL
					echo "<td><a href='".$places_details->url."' target='_blank'>".$places->name."</a></td>";
					// address and whether the place is open currently or not, and directions + contact details
					if ($places->opening_hours->open_now == "true"){
						if ($places_details->formatted_phone_number == ""){
							//echo "<td>".$places->vicinity."<br><strong><font color='green'>Open now!</font></strong> <a href='https://maps.google.com/maps?saddr=".$address."&daddr=".$places->vicinity."' target='_blank'>Get directions.</a></td>";
							echo "<td>".$places->vicinity."<br><strong><font color='green'>Open now!</font></strong> <a href='".$places_details->url."' target='_blank'>Get directions</a>.</td>";

						}
						else {
							//echo "<td>".$places->vicinity."<br><strong><font color='green'>Open now!</font></strong> <a href='https://maps.google.com/maps?saddr=".$address."&daddr=".$places->vicinity."' target='_blank'>Get directions.</a> Contact: <a href='tel:".$places_details->formatted_phone_number."'>".$places_details->formatted_phone_number."</a></td>";
							echo "<td>".$places->vicinity."<br><strong><font color='green'>Open now!</font></strong> <a href='".$places_details->url."' target='_blank'>Get directions</a>. Contact: <a href='tel:".$places_details->formatted_phone_number."'>".$places_details->formatted_phone_number."</a>.</td>";
						}
					}
					else if ($places_details->opening_hours->weekday_text[6] == ""){
						echo "<td>Sorry. We could not find any information about this location.<br>As an alternative, you can still click <a href='".$places_details->url."' target='_blank'>here</a> to visit Google Maps.</td>";
					}
					else {
						echo "<td>".$places->vicinity."<br>Sorry. This place is <strong><font color='orange'>closed right now</font></strong>.</td>";
					}
					// iterating and checking the current day to show the correct opening hours
					for ($day=1; $day<8; $day++){
						if (date("N") == $day){
							if ($places_details->opening_hours->weekday_text[$day-1] != ""){
								echo "<td>".$places_details->opening_hours->weekday_text[$day-1]."</td>";
							}
							else {
								echo "<td>No information provided.</td>";
							}
						}
					}
					echo "</tr>";
				}
			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			echo "</section>";
		}
		else if ($places_xml->status == "ZERO_RESULTS"){
			echo "Sorry. Your search has returned zero results. If this happens again, it means that there are no registered places on Google Maps for your location.";
		}
		else {
			exit("The request was not successful. Reason: The Places API returned an invalid response. Please inform the website administrator! (Error code #004)<hr>Please <a href='index.php'>click here</a> to try again.");
		}
	}
	else if ($geocode_xml->status == "ZERO_RESULTS"){
			echo "Sorry. Your search has returned zero results. Please try again.";
	}
	else {
		exit("The request was not successful. Reason: The Geocode API returned an invalid response. Please inform the website administrator! (Error code #003)<hr>Please <a href='index.php'>click here</a> to try again.");
	}
}
?>
