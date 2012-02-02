<?php
	ob_start();
	include "functions/config.php";

	// username and password sent from form
	$username=$_POST['username'];
	$password=$_POST['password'];

	// To protect MySQL injection (more detail about MySQL injection)
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	
	$encrypted_password=md5($password);

	$sql="SELECT * FROM users WHERE username='$username' and password='$encrypted_password'";
	$result=mysql_query($sql);

	$count=mysql_num_rows($result);

	if($count==1){
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		header("location:index.php");
	}
	else {
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html>
			<head>
				<link rel="stylesheet" type="text/css" href="css/style.css" />
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Workout Planner: Login</title>
			</head>
			<body>
				<div class="header">
							<div class="innerHeader">
								<div class="logo">
									<h1>Workout Planner</h1>
								</div>
								<img src="images/icon_dumbbells.png"/>
							</div>	
					</div>
					<div class="content">
						<div class="page-content">
							<p>
								<b>Wrong Username or Password</b>
								<br/><br/>
								<input type="button" value="Try again" onClick="history.go(-1);return true;">
							</p>
						</div>
					</div>
				</div>
			</body>
		</html>
<?php
	}
	ob_end_flush();
?>

