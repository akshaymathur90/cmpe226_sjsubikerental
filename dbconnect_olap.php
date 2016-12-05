<?php
function connectDB(){
	$con = new PDO("mysql:host=localhost:3307;dbname=datawrench_project_analytical",
                           "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE,
                               PDO::ERRMODE_EXCEPTION);
    return $con;
}

?>