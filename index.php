<?php
	// website config
	include 'inc/config.php';
?>
<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php echo $title;?> - OpenNearMe</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/google.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<h1><a href="index.php">OpenNearMe</a></h1>
						<nav>
							<a href="#menu">Menu</a>
						</nav>
					</header>

				<!-- Menu -->
					<nav id="menu">
						<div class="inner">
							<h2>Menu</h2>
							<ul class="links">
								<li><a href="index.php">Home</a></li>
								<li><a href="https://www.gov.uk/government/publications/covid-19-track-coronavirus-cases" target="_blank">GOV.UK COVID-19</a></li>
								<li><a href="https://www.worldometers.info/coronavirus/">COVID-19 Tracker</a></li>
							</ul>
							<a href="#" class="close">Close</a>
						</div>
					</nav>

				<!-- Banner -->
					<section id="banner">
						<div class="inner">
							<div class="logo"><span class="icon fa-map"></span></div>
							<h2>This is <font color="orange">OpenNearMe</font>!</h2>
							<p>We want to help people in need during COVID-19 by providing easy access to information about local shops, pharmacies and supermarkets, as well as directions, open times and more!</p>
						</div>
					</section>

				<!-- Wrapper -->
					<section id="wrapper">

						<!-- Main Section -->
							<section class="wrapper alt style1">
								<div class="inner">	
									<section>
										<h3 class="major">Search</h3>
										<form method="post">
											<div class="row gtr-uniform">
												<div class="col-12">
													<label>Please enter your address:</label>
													<input id="autocomplete" placeholder="e.g. postcode, street name" onFocus="geolocate()" type="text" name="autocomplete" required /> 
												</div>
												<div class="col-12">
												<label>Please select an option:</label>
												</div>
												<div class="col-4 col-12-small">
													<input type="radio" id="check_pharmacies" name="search_type" value="check_pharmacies" checked>
													<label for="check_pharmacies">Pharmacies</label>
												</div>
												<div class="col-4 col-12-small">
													<input type="radio" id="check_grocery_supermarkets" name="search_type" value="check_grocery_supermarkets">
													<label for="check_grocery_supermarkets">Grocery & Supermarkets</label>
												</div>
												<div class="col-4 col-12-small">
													<input type="radio" id="check_convenience_stores" name="search_type" value="check_convenience_stores">
													<label for="check_convenience_stores">Convenience Stores</label>
												</div>
												<div class="col-12">
													
													<ul class="actions">
														<li><input type="submit" value="Search" class="primary" /></li>
														<li><input type="reset" value="Reset" /></li>
													</ul>
												</div>
											</div>
										</form>
									</section>
									
									<?php include "inc/api.php"; ?>
								</div>
								
							</section>
					</section>

				<!-- Footer -->
					<section id="footer">
						<div class="inner">
							<h2 class="major">The World's Greatest Privacy Policy</h2>
							<p>We do not store your data, period. We also do not use cookies to track you. <br>We physically cannot. We have nowhere to store it. We do not even have a server database to store it. <br>So even if the Queen asked nicely to see your data, we would not have anything to show.</p>		
							<h2 class="major">Hello!</h2>
							<p>We are here to help and answer any questions you might have. Also, we are open to any feedback & suggestions. <br>We look forward to hearing from you!</p>
							<p><strong>INFO: The Contact-us form is currently <font color="orange">disabled</font>.<br>For any queries please e-mail us at <font color="orange">bogdan.mihalcea@icloud.com</font>.</strong></p>
							<form method="post" action="">
								<div class="fields">
									<div class="field">
										<label for="name">Name:</label>
										<input type="text" name="name" id="name" disabled />
									</div>
									<div class="field">
										<label for="email">E-mail:</label>
										<input type="email" name="email" id="email" disabled />
									</div>
									<div class="field">
										<label for="message">Message:</label>
										<textarea name="message" id="message" rows="4" disabled></textarea>
									</div>
								</div>
								<ul class="actions">
									<li><input type="submit" value="Send Message" disabled /></li>
								</ul>
							</form>
							<ul class="contact">
								<li class="icon solid fa-home">
									Birmingham City University<br />
									15 Bartholomew Row<br />
									Birmingham, B5 5JU<br />
									United Kingdom
								</li>
								<!--<li class="icon solid fa-phone">(000) 000-0000</li>-->
								<li class="icon solid fa-envelope"><a href="mailto: bogdan.mihalcea@icloud.com">bogdan.mihalcea@icloud.com</a></li>
								<li class="icon brands fa-facebook-f"><a href="https://www.facebook.com/birminghamcityuniversity" target="_blank">BCU - Facebook</a></li>
								<li class="icon brands fa-instagram"><a href="https://www.instagram.com/mybcu/" target="_blank">BCU - Instagram</a></li>
								<li class="icon brands fa-twitter"><a href="https://twitter.com/mybcu" target="_blank">BCU - Twitter</a></li>
								
							</ul>
							<ul class="copyright">
								<li>&copy; <?php echo date("Y"); ?> - <b><a href="index.php">OpenNearMe</a></b>. All rights reserved.</li><li>Project developed by <b><a href="https://ip.innovationfest.co.uk/student/team-a/">Team A</a></b> for <b><a href="https://innovationfest.co.uk/innovation/" target="_blank">Innovation Fest 2020</a></b>.</li><li>Design: <b><a href="http://html5up.net">HTML5 UP</a></b>.</li>
								<p></p>
							</ul>
						</div>
					</section>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="assets/js/google.js"></script>
			
		<!-- Autocomplete API -->
			<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apikey_js; ?>&libraries=places&callback=initAutocomplete" async defer></script>

	</body>
</html>