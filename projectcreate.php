<html>
<head>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" href="project.css" type="text/css"/>
	<script src="project.js"></script>
    <title>Create Account</title>
</head>
<body>

	<h1 id="loginTitle" align="center">Create Account</id>

	<div id="createInfo">
		<p id="error"></p>
		<form method="post" name="createaccountform" onsubmit="return validateFormCreateAccount();" align="center" style="margin:0">
		    <input class="loginField loginInput" type="text" name="email" placeholder="Email"/><br/>
		    <input class="loginField loginInput" type="text" name="name" placeholder="Name"/><br/>
		    <input class="loginField loginInput" type="password" name="password" placeholder="Password"/><br/>

		    <input class="loginField" id="buttonSubmit" type="submit" name="buttonCreate" value="Submit"/><br/>
		</form>
		<form method="post" align="center" style="margin:0">
		    <input class="loginField" id="buttonCancel" type="submit" name="buttonCancel" value="Cancel"/>
		</form>
	</div>

	<?php
		include 'projectsql.php';

		if(isset($_POST['buttonCreate'])){
			$email=$_POST['email']; 
			$name=$_POST['name']; 
			$password=$_POST['password']; 

			insertUsers($email, $name, $password, 0);
			header("Location: projectlogin.php");
			exit;
		}

		if(isset($_POST['buttonCancel'])){
			header("Location: projectlogin.php");
			exit;
		}
	?>
</body>
</html>
