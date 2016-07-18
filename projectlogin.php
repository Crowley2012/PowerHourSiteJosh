<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();

	if(isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['admin'])){
		header("Location: project.php");
	}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" href="project.css" type="text/css"/>
    <title>Login</title>
</head>
<body>

	<h1 id="loginTitle" align="center">Login</id>

	<div id="loginInfo">
		<form method="post" align="center">
		    <input class="loginField loginInput" type="text" name="email" placeholder="Email"/><br/>

		    <input class="loginField loginInput" type="password" name="password" placeholder="Password"/><br/>

		    <input class="loginField" id="loginInfoButton" type="submit" name="buttonSubmit" value="Login"/><br/>

		    <input class="loginField" id="loginInfoButton" type="submit" name="buttonCreate" value="Create Account"/>
		</form>
	</div>

	<?php
		include 'projectsql.php';

		if(isset($_POST['buttonSubmit'])){
			$name=$_POST['email']; 
			$password=$_POST['password']; 

			login($name, $password);
			header("Location: project.php");
			exit;
		}

		if(isset($_POST['buttonCreate'])){
			header("Location: projectcreate.php");
			exit;
		}
	?>
</body>
</html>
