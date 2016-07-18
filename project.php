<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include 'projectsql.php';

	session_start();

	$loggedIn = false;

	if(isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['admin'])){
		$email=$_SESSION['email'];
		$name=$_SESSION['name'];
		$admin=$_SESSION['admin'];
		$loggedIn = true;
	}

	//rebuildUsers();
	//rebuildSongs();
	//rebuildVotes();

	//printAllUsers();
	//printAllSongs();
	//printAllVotes();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=iso-8859-1"/>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" href="project.css" type="text/css"/>
    <script type="text/javascript" src="project.js"></script>

	<title>Sean Crowley : Project</title>
</head>
<body>
	<div id="rightSideBar">
		<div id="userInfo">
			<?php
				if($loggedIn){
					echo "<h2 id='songListTitle'>Welcome back ", $name, "!</h2><br/>";
				}else{
					echo "<h2 id='songListTitle'>Welcome!</h2><br/>";
				}

				echo '<form method="post" style="height: 5vh;">';

				if($loggedIn){
					echo '<input type="submit" name="buttonLogout" value="Logout" id="logoutButton"/>';
				}else{
					echo '<input type="submit" name="buttonLogin" value="Login" id="logoutButton"/>';
				}

				echo '</form>';

				if(isset($_POST['buttonLogout'])){
					session_destroy();
					header("Location: project.php");
					exit;
				}

				if(isset($_POST['buttonLogin'])){
					session_destroy();
					header("Location: projectlogin.php");
					exit;
				}

				foreach ($_POST as $key => $value) {
					insertVotes($key, $email);
					header("Location: project.php");
					exit;
		    	}
			?>
		</div>

		<div id="listDiv">
			<h2 id="songListTitle">Song List</h2>
			<p id="songlist"></p>
		</div>
	</div>

	<div id="videos">
		<table id='videoDiv'>
			<tr id='videoRow'>
				<td>
					<video width="640" height="360" controls id="video">
					  <source src="videos/big_buck_bunny.mp4" type="video/mp4">
					</video>
				</td>
				<td>
					<a href="javascript:void(0);" id="list" onclick="loadSongList(1)">
						<img border="0" alt="W3Schools" src="images/list.png" width="75" height="75" id="list">
					</a><br/>
					<a href="videos/big_buck_bunny.mp4" download>
						<img border="0" alt="W3Schools" src="images/download.png" width="75" height="75" id="download">
					</a>
				</td>
			</tr>
			<tr id='videoRow'>
				<td>
					<video width="640" height="360" controls id="video">
					  <source src="videos/small.mp4" type="video/mp4">
					</video>
				</td>
				<td>
					<a href="javascript:void(0);" id="list" onclick="loadSongList(2)">
						<img border="0" alt="W3Schools" src="images/list.png" width="75" height="75" id="list">
					</a><br/>
					<a href="videos/small.mp4" download>
						<img border="0" alt="W3Schools" src="images/download.png" width="75" height="75" id="download">
					</a>
				</td>
			</tr>
			<tr id='videoRow'>
				<td>
					<video width="640" height="360" controls id="video">
					  <source src="videos/vid.mp4" type="video/mp4">
					</video>
				</td>
				<td>
					<a href="javascript:void(0);" id="list" onclick="loadSongList(3)">
						<img border="0" alt="W3Schools" src="images/list.png" width="75" height="75" id="list">
					</a><br/>
					<a href="videos/vid.mp4" download>
						<img border="0" alt="W3Schools" src="images/download.png" width="75" height="75" id="download">
					</a>
				</td>
			</tr>
		</table>
	</div>

	<div id="sidebar">
		<center>
		<h2 id="voting">Vote for Next Power Hour!</h2>
		<?php
			if(isset($email)){
				echo '<form action="projectaddsong.php">';
				echo '<input type="submit" name="addSong" value="Add Song" align="center" id="addSongButton"/>';
				echo '</form>';
				displayAllSongsUser($email);
			}else{
				displayAllSongs();
			}
		?>
		</center>
	</div>
</body>
</html>
