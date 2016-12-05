
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



	<section style="height: 10px;" id="services" class="section section-padded">

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

	<div style="margin-top:20px" class="container">
		<?php
		include('dbconnect1.php');


		$id = $_GET['id'];
		echo "<h3 style='text-align:center;text-transform:capitalize;'>$id</h3>";
		// pull info from db based on $id
		#$sql = mysql_query('SELECT LocationID from location WHERE Branch_name ="'.$id.'"');
		$sql = "SELECT LocationID from location WHERE Branch_name ='".$id."'";
		#echo $sql;
		$result = $conn->query($sql);

		#$location_id = mysqli_fetch_assoc($result);
		while($row = mysqli_fetch_assoc($result)) {
			$location_id = $row["LocationID"];
		    }
		#echo $location_id;



		$sql = "SELECT BikeID, Model, Bike_Type from bike WHERE LocationID ='".$location_id."'";
		$result = $conn->query($sql);
		echo "<br><br><table style='width:70%;margin:auto;'>";
		echo "<tr style='font-size:18px;'><th>Model</th><th>Type</th><th>Price</th><th></th></tr>";
		while($row = mysqli_fetch_assoc($result)) {
			$model = $row["Model"];
			$bike_type = $row["Bike_Type"];
			#echo "<tr><td>".$model."</td><td>".$bike_type."</td></tr>";
			$sql_temp1 = "SELECT Bike_model from bike_model WHERE Bike_Model_ID ='".$model."'";
			$sql_temp2 = "SELECT Bike_Type,hourly_rate from bike_type WHERE Bike_Type_ID ='".$bike_type."'";
			$result_temp1 = $conn->query($sql_temp1);
			$result_temp2 = $conn->query($sql_temp2);
			while($row_temp1 = mysqli_fetch_assoc($result_temp1))
			{
				echo "<tr style='font-size:18px;height:50px;'><td>".$row_temp1["Bike_model"]."</td>";
			}
			while($row_temp2 = mysqli_fetch_assoc($result_temp2))
			{
				$bikeId = $row["BikeID"];
				echo "<td>".$row_temp2["Bike_Type"]."</td><td>".$row_temp2["hourly_rate"]."</td><td><a style='width:100%;height:100%;display:block;color:white;background-color:#0d0d0d;text-align:center;' href='./booking.php?bikeid=$bikeId'>Book</a></td></tr>";
			}			
		    }
		echo "</table><br><br>";

		echo "<a style='width:20%;display:block;height:50px;background-color:#0d0d0d;font-size:18px;margin:auto;text-align:center;color:white;padding-top:10px;' href='./mybooking.php'>Show All My Bookings</a>";

		#echo $sql;

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
