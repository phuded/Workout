<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner: New User</title>
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

<?php
	include "functions/config.php";
	if(isset($_POST[username])){
		$username = $_POST[username];
		$encrypted_password = md5($_POST[password]);
		$sql="insert into user (username,password) values ('$username','$encrypted_password')";
		//echo $sql;
		$result=mysql_query($sql);
		
		if (!$result) {
			echo '<h3>New user creation failed: </h3>' . mysql_error();
			echo '<br/><br/><a href="createuser.php">Try again.</a>';
		}
		else{
			echo '<h3>New user created: <i>'.$username.'</i></h3>Please login <a href="login.php">here.</a>';
		}

	}
	else{
?>
				<div class="login-form">
					<h3>Please enter your desired username and password:</h3>
					<form name="login" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
						<table>
							<tr>
								<td>
									<label for="username">Username:</label>
								</td>
								<td>
									<input name="username" type="text" id="username">
								</td>
							</tr>
							<tr>
								<td>
									<label for="password">Password:</label>
								</td>
								<td>
									<input name="password" type="password" id="password">
								</td>
							</tr>
							<tr></tr>
							<tr></tr>
							<tr>
								<td>
									<input type="submit" name="Submit" value="Create">
								</td>
								<td>
									<input type="reset" name="Clear" value="Clear">
									<a href="login.php">Back to login.</a>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>

<?php 
	} 
?>		
	</body>
</html>