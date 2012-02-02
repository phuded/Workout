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
				<div class="login-form">
					<h2>Login</h2>
					<form name="login" method="post" action="checklogin.php">
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
									<input type="submit" name="Submit" value="Login">
								</td>
								<td>
									<input type="reset" name="Clear" value="Clear">
								</td>
							</tr>
						</table>
					</form>
					<p>Use <i>guest/guest</i> if you don't have an account.</p>
				</div>
			</div>
		</div>
	</body>
</html>