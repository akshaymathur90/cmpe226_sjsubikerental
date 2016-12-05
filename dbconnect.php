
<?php
function connectDB(){
	$con = new PDO("mysql:host=localhost:3307;dbname=datawrench",
                           "root1", "root123");
    $con->setAttribute(PDO::ATTR_ERRMODE,
                               PDO::ERRMODE_EXCEPTION);
    return $con;
}

?>