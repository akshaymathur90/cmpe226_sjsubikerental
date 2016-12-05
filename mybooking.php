

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cardio: Free One Page Template by Luka Cvetinovic</title>
	<meta name="description" content="Cardio is a free one page template made exclusively for Codrops by Luka Cvetinovic" />
	<meta name="keywords" content="html template, css, free, one page, gym, fitness, web design" />
	<meta name="author" content="Luka Cvetinovic for Codrops" />
	<!-- Favicons (created with http://realfavicongenerator.net/)-->
	<link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-touch-icon-60x60.png">
	<link rel="icon" type="image/png" href="img/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="img/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="img/favicons/manifest.json">
	<link rel="shortcut icon" href="img/favicons/favicon.ico">
	<meta name="msapplication-TileColor" content="#00a8ff">
	<meta name="msapplication-config" content="img/favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<!-- Normalize -->
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<!-- Owl -->
	<link rel="stylesheet" type="text/css" href="css/owl.css">
	<!-- Animate.css -->
	<link rel="stylesheet" type="text/css" href="css/animate.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.1.0/css/font-awesome.min.css">
	<!-- Elegant Icons -->
	<link rel="stylesheet" type="text/css" href="fonts/eleganticons/et-icons.css">
	<!-- Main style -->
	<link rel="stylesheet" type="text/css" href="css/cardio.css">
	<style type="text/css">
		body {
			background-color: #ffdb4d;
		}
	</style>
</head>

<body>
	<div class="preloader">
		<img src="img/loader.gif" alt="Preloader image">
	</div>
	<nav class="navbar">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img src="img/logo.png" data-active-url="img/logo-active.png" alt=""></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right main-nav">
					<li><a style="color:black" href="#intro">Intro</a></li>
					<li><a style="color:black" href="analytics.html">Analytics</a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav>



	<section style="height: 130px;" id="services" class="section section-padded">

		<div  class="container">
		<span>&nbsp;</span>
		</div>
		
	</section>
	
	<!-- Holder for mobile navigation -->
	<div class="mobile-nav">
		<ul>
		</ul>
		<a href="#" class="close-link"><i class="arrow_up"></i></a>
	</div>

	<div style="margin-top:50px" class="container">
		<?php
		include('dbconnect1.php');

		session_start();
		// user is not logged in
		if(!$_SESSION["userid"]) {
			header("Location: ./index.html");
			die();
		}

		$userId = $_SESSION["userid"];
		$sql = "SELECT * FROM booking where PersonID=$userId";
		$result = $conn->query($sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    echo "<h3 style='text-align:center;text-transform:capitalize;'>My Bookings</h3>";
		    // print "<p> hello " . $_SESSION["userid"] ."</p>\n";
		    echo "<table border=2 style='width:70%;margin:auto;'>";
			echo "<tr style='font-size:18px;'><th>Booking ID</th><th>Model</th><th>Type</th><th>Start Time</th><th>End Time</th></tr>";
		    while($row = mysqli_fetch_assoc($result)) {
			// echo '<tr><a href="bikedetails.php?id='.$row["Branch_name"].'">'.$row["Branch_name"].'</a><br></tr>';
		        #echo "<tr>".$row["Branch_name"]. "</tr><br>";
		    	$bookingId = $row["booking_id"];
		    	$bikeId = $row["BikeID"];
		    	$bikeSql = "SELECT bk.BikeID as 'BikeID', bm.Bike_model as 'Bike_Model', bt.Bike_Type as 'Bike_Type' FROM bike bk INNER JOIN bike_model bm ON bk.Model = bm.Bike_Model_ID INNER JOIN bike_type bt ON bk.Bike_Type = bt.Bike_Type_ID WHERE bk.BikeID = $bikeId;";
		    	$res = $conn->query($bikeSql);
		    	
		    	$firstrow = mysqli_fetch_assoc($res);
		    	$bikeModel = $firstrow["Bike_Model"];
		    	$bikeType = $firstrow["Bike_Type"];
		    	$endTime = $row["end_time"];
		    	$startTime = $row["start_time"];
		        echo "<tr style='font-size:18px;height:50px;'><td>$bookingId</td><td>$bikeModel</td><td>$bikeType</td><td>$startTime</td><td>$endTime</td></tr>";
		    }
		    echo "</table>";
		} else {
		    echo "You have no bookings!";
		}
		?>
	</div>

	<!-- Scripts -->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/typewriter.js"></script>
	<script src="js/jquery.onepagenav.js"></script>
	<script src="js/main.js"></script>
</body>

</html>

