<html>
<head>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" href="project.css" type="text/css"/>
	<script src="project.js"></script>
    <title>Add Song</title>
</head>
<body>

	<h1 id="loginTitle" align="center">Add Song</id>

	<div id="addsongInfo">
		<p id="error"></p>
		<form method="post" name="addsongform" align="center" onsubmit="return validateFormAddSong();" style="margin:0">
		    <input class="loginField loginInput" type="text" name="name" placeholder="Song"/><br/>
		    <input class="loginField loginInput" type="text" name="artist" placeholder="Artist"/><br/>
		    <input class="loginField loginInput" type="text" name="albumn" placeholder="Albumn"/><br/>
		    <input class="loginField loginInput" type="text" name="comment" placeholder="Additional Comments (optional)"/><br/>

		    <input class="loginField" id="buttonSubmit" type="submit" name="buttonAddSong" value="Submit"/><br/>
		</form>
		<form method="post" align="center" style="margin:0">
		    <input class="loginField" id="buttonCancel" type="submit" name="buttonCancel" value="Cancel"/>
		</form>
	</div>

	<?php
		include 'projectsql.php';
		session_start();

		if(isset($_POST['buttonAddSong'])){
			$name=$_POST['name']; 
			$artist=$_POST['artist']; 
			$albumn=$_POST['albumn']; 
			$comment=$_POST['comment']; 
			$user=$_SESSION['name'];

			insertSongs($name, $artist, $albumn, $comment, $user);
			header("Location: project.php");
			exit;
		}

		if(isset($_POST['buttonCancel'])){
			header("Location: project.php");
			exit;
		}
	?>
</body>
</html>
