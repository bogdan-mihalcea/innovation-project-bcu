<?php					
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
			// now that we have latitude and longitute, we can go forward and call the next API that will get places in the area within a 2km radius
			$places_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/xml?location=".$lat.",".$lng."&radius=2000&type=pharmacy&keyword=local&key=".$apikey."";
			$places_xml = simplexml_load_file($places_url);
			// checking if we've got a valid response from the API
			if ($places_xml->status == "OK"){
				// adapting HTML table design
				echo "<h3 class='major'><font color='orange'>Check the information by contacting the locations! The work schedule or services may differ due to the COVID-19 pandemic.</font></h3>";
				echo "<h4>Results (places are located within 2km of your address):</h4>";
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
					$places_details_xml = simplexml_load_file("https://maps.googleapis.com/maps/api/place/details/xml?place_id=".$place_id."&fields=url,opening_hours,formatted_phone_number&key=".$apikey."");	
					// iterating every result we get from calling the Place Details API
					foreach ($places_details_xml->result as $places_details) {
						echo "<tr>";
						// Name and URL
						echo "<td><a href='".$places_details->url." target='_blank''>".$places->name."</a></td>";
						// address and whether the place is open currently or not, and directions + contact details
						if ($places->opening_hours->open_now == "true"){
							if ($places_details->formatted_phone_number == ""){
								echo "<td>".$places->vicinity."<br><strong><font color='green'>Open now!</font></strong> <a href='https://maps.google.com/maps?saddr=".$address."&daddr=".$places->vicinity." target='_blank''>Get directions.</a></td>";
							}
							else {
								echo "<td>".$places->vicinity."<br><strong><font color='green'>Open now!</font></strong> <a href='https://maps.google.com/maps?saddr=".$address."&daddr=".$places->vicinity." target='_blank''>Get directions.</a> Contact: <a href='tel:".$places_details->formatted_phone_number."'>".$places_details->formatted_phone_number."</a></td>";
							}
						}
						else {
							echo "<td>".$places->vicinity."<br>Sorry. This place is <strong><font color='orange'>closed right now.</font></strong></td>";
						}
						// iterating and checking the current day to show the correct opening hours
						for ($day=1; $day<8; $day++){
							if (date("N") == $day){
								if ($places_details->opening_hours->weekday_text[$day-1] != "")
									echo "<td>".$places_details->opening_hours->weekday_text[$day-1]."</td>";
								else
									echo "<td>No information provided.</td>";
							}
						}
						echo "</tr>";
					}
				}			
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
			}
			else echo "The Places API returned an invalid response. Please contact the website administrator! (Error code #002)";
		}
		else echo "The Geocode API returned an invalid response. Please contact the website administrator! (Error code #001)";
	}
?>