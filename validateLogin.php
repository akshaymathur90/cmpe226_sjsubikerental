<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Validate Login</title>
</head>

<body>
    <?php
    	$userEmail = $_POST['userEmailAddress'];
    	$userPassword = $_POST['userPassword'];

    	print "<p> hello " . $userEmail ."</p>\n";
    	print "<p> hello " . $userPassword ."</p>\n";

    	include_once(__DIR__ . "/dbconnect.php");
    	$con = connectDB();

    	$loginCredentialQuery = "SELECT name from person where name=:username and password=:password";
        $loginPS = $con->prepare($loginCredentialQuery);
        $loginPS->bindParam(':username', $userEmail);
        $loginPS->bindParam(':password', $userPassword);
        $loginPS->execute();
        $rows = $loginPS->fetchAll(PDO::FETCH_ASSOC);

        if(count($rows) > 0){
                print "<p>Valid User credentials</p>\n";
                echo '<script type="text/javascript">
           window.location = "http://www.google.com/"
      </script>';
            }
            else{
            	print "<p>In-Valid User credentials</p>\n";
            }
            
     ?>
</body>
</html>