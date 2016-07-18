<?php

//SQL CONNECTION

function connect(){
	$servername = "127.0.0.1";
	$username = "crowleys";
	$password = "crowleys";
	$dbname = "crowleys";
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		echo "ERROR : Connected unsuccessfully<br /><br />";
		die("Connection failed: " . $conn->connect_error);
	} 

	return $conn;
}

//LOGIN

function login($email, $password){
	$sql="SELECT * FROM users WHERE email='$email' and password='$password'";
	$conn = connect();
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		session_start();
		$row = $result->fetch_assoc();

		$_SESSION['email'] = $row["email"];
		$_SESSION['name'] = $row["name"];
		$_SESSION['admin'] = $row["admin"];

		header("Location: project.php");
	}

	$conn->close();
}

//SONGS

function createTableSongs(){
	$sql = "create table if not exists songs(id int(30) NOT NULL AUTO_INCREMENT, name varchar(30), artist varchar(30), albumn varchar(30), comment varchar(30), user varchar(30), PRIMARY KEY (id))";
	$conn = connect();
	$result = $conn->query($sql);

	$conn->close();
}

function rebuildSongs(){
	$sql = "drop table songs";
	$conn = connect();
	$result = $conn->query($sql);

	createTableSongs();
	addDummySongs();

	$conn->close();
}

function insertSongs($name, $artist, $albumn, $comment, $user){
	$conn = connect();
	$sql = "insert into songs(name, artist, albumn, comment, user) values ('$name', '$artist', '$albumn', '$comment', '$user')";
	$result = $conn->query($sql);

	$conn->close();
}

function addDummySongs(){
	insertSongs("Flip", "Glass Animals", "ZABA", "Start at 1:03", "Sean");
	insertSongs("Ms", "Alt-J", "An Awesome Wave", "Great song!", "Sean");
	insertSongs("Alright", "Kendrick Lamar", "To Pimp A Butterfly", "", "Josh");
	insertSongs("The Next Episode", "Snoop Dogg", "2001", "Classic!", "Sean");
	insertSongs("Middle", "DJ Snake", "Middle", "Party Song", "Caleb");
}

function displayAllSongs(){
	$sql = "SELECT * FROM songs";
	$conn = connect();
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$i = 1;
		while($row = $result->fetch_assoc()) {
			echo "<input type='submit' name='", $i, "' class='voteElementUser' style='font-size:0.8em;border-style: solid;border-width: 6px;border-color: rgba(235, 235, 235, 1);' value='", $row["name"], " by ", $row["artist"], " | ", getVotes($i), "'/>";

			if($row["comment"] != ""){
				echo "<p class='voteElementUser voteElementUserDescription' style='font-size:0.8em;background-color: rgba(235, 235, 235, 1);'>", $row["albumn"], "<br/>", $row["comment"], "<br/>Submitted by : ", $row["user"], "</p>";
			}else{
				echo "<p class='voteElementUser voteElementUserDescription' style='font-size:0.8em;background-color: rgba(235, 235, 235, 1);'>", $row["albumn"], "<br/>Submitted by : ", $row["user"], "</p>";
			}

			$i++;
		}
	}

	$conn->close();
}

function displayAllSongsUser($email){
	$sql1 = "SELECT * FROM songs";
	$conn = connect();
	$result1 = $conn->query($sql1);

	if ($result1->num_rows > 0) {
		$i = 1;
		while($row1 = $result1->fetch_assoc()) {
			$sql2 = "SELECT * FROM votes WHERE email = '$email' AND id = $i";
			$result2 = $conn->query($sql2);

			echo '<form name="voteForm" method="post">';

			if($result2->num_rows > 0){
				echo "<input type='submit' name='", $i, "' class='voteElementUser' style='border-style: solid;border-width: 6px;border-color: rgba(114, 188, 30, 1);font-size:0.8em;' value='", $row1["name"], " by ", $row1["artist"], " | ", getVotes($i), "'/>";
				if($row1["comment"] != ""){
					echo "<p class='voteElementUser voteElementUserDescription' style='font-size:0.8em;background-color: rgba(114, 188, 30, 1);'>", $row1["albumn"], "<br/>", $row1["comment"], "<br/>Submitted by : ", $row1["user"], "</p>";	
				}else{
					echo "<p class='voteElementUser voteElementUserDescription' style='font-size:0.8em;background-color: rgba(114, 188, 30, 1);'>", $row1["albumn"], "<br/>Submitted by : ", $row1["user"], "</p>";	
				}
			}else{
				echo "<input type='submit' name='", $i, "' class='voteElementUser' style='font-size:0.8em;border-style: solid;border-width: 6px;border-color: rgba(235, 235, 235, 1);' value='", $row1["name"], " by ", $row1["artist"], " | ", getVotes($i), "'/>";
				if($row1["comment"] != ""){
					echo "<p class='voteElementUser voteElementUserDescription' style='font-size:0.8em;background-color: rgba(235, 235, 235, 1);'>", $row1["albumn"], "<br/>", $row1["comment"], "<br/>Submitted by : ", $row1["user"], "</p>";
				}else{
					echo "<p class='voteElementUser voteElementUserDescription' style='font-size:0.8em;background-color: rgba(235, 235, 235, 1);'>", $row1["albumn"], "<br/>Submitted by : ", $row1["user"], "</p>";
				}
			}

			$i++;

			echo '</form>';
		}
	}

	$conn->close();
}

function printAllSongs(){
	$sql = "SELECT * FROM songs";
	$conn = connect();
	$result = $conn->query($sql);

	echo "<center><table id='sqltable' width='50%'>";
	echo "<tr><th>ID</th><th>Song</th><th>Artist</th><th>Albumn</th><th>Comments</th><th>Submitted By</th></tr>";

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>", $row["id"], "</td><td>", $row["name"], "</td><td>", $row["artist"],  "</td><td>", $row["albumn"], "</td><td>", $row["comment"], "</td><td>", $row["user"], "</td></tr>";	
		}
	} else {
		echo "0 results";
	}

	echo "</table></center>";

	$conn->close();
}

//VOTES

function createTableVotes(){
	$sql = "create table if not exists votes(id int(30), email varchar(30), PRIMARY KEY (id, email))";
	$conn = connect();
	$result = $conn->query($sql);

	$conn->close();
}

function rebuildVotes(){
	$sql = "drop table votes";
	$conn = connect();
	$result = $conn->query($sql);

	createTableVotes();
	addDummyVotes();

	$conn->close();
}

function insertVotes($id, $email){
	$conn = connect();

	$sqlCheck = "select * from votes where id = $id and email='$email'";
	$result = $conn->query($sqlCheck);

	if ($result->num_rows > 0) {
		$sql = "delete from votes where id = $id and email='$email'";
		$result = $conn->query($sql);
	}else{
		$sql = "insert into votes(id, email) values ('$id', '$email')";
		$result = $conn->query($sql);
	}

	$conn->close();
}

function addDummyVotes(){
	insertVotes("1", "admin");
	insertVotes("2", "admin");
	insertVotes("5", "admin");
	insertVotes("2", "crowley.p.sean@gmail.com");
	insertVotes("5", "crowley.p.sean@gmail.com");
	insertVotes("4", "test@gmail.com");
	insertVotes("3", "test@gmail.com");
	insertVotes("5", "test@gmail.com");
}

function printAllVotes(){
	$sql = "SELECT * FROM votes";
	$conn = connect();
	$result = $conn->query($sql);

	echo "<center><table id='sqltable' width='50%'>";
	echo "<tr><th>ID</th><th>Email</th></tr>";

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>", $row["id"], "</td><td>", $row["email"], "</td></tr>";	
		}
	} else {
		echo "0 results";
	}

	echo "</table></center>";

	$conn->close();
}

function getVotes($id){
	$sql = "SELECT count(*) as total FROM votes WHERE id = $id";
	$conn = connect();
	$result = $conn->query($sql);

	$conn->close();

	return $result->fetch_assoc()['total'];
}

//USERS

function createTableUsers(){
	$sql = "create table if not exists users(email varchar(30), name varchar(30), password varchar(30), admin int(1), PRIMARY KEY (email))";
	$conn = connect();
	$result = $conn->query($sql);

	$conn->close();
}

function rebuildUsers(){
	$sql = "drop table users";
	$conn = connect();
	$result = $conn->query($sql);

	createTableUsers();
	addDummyUsers();

	$conn->close();
}

function insertUsers($email, $name, $password, $admin){
	$conn = connect();
	$sql = "insert into users(email, name, password, admin) values ('$email', '$name', '$password', '$admin')";
	$result = $conn->query($sql);

	$conn->close();
}

function addDummyUsers(){
	insertUsers("admin", "Admin", "asdf", 1);
	insertUsers("crowley.p.sean@gmail.com", "Sean Crowley", "asdf", 0);
	insertUsers("test@gmail.com", "Test Account", "asdf", 0);
}

function printAllUsers(){
	$sql = "SELECT * FROM users";
	$conn = connect();
	$result = $conn->query($sql);

	echo "<center><table id='sqltable' width='50%'>";
	echo "<tr><th>Email</th><th>Name</th><th>Password</th><th>Admin</th></tr>";

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>", $row["email"], "</td><td>", $row["name"], "</td><td>", $row["password"],  "</td><td>", $row["admin"], "</td></tr>";	
		}
	} else {
		echo "0 results";
	}

	echo "</table></center>";

	$conn->close();
}
?>
