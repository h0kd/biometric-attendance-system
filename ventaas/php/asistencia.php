<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
	// Takes raw data from the request
	$json = file_get_contents('php://input');

	// Converts it into a PHP object
	$data = json_decode($json, true);
	$user_id = $data['user_id'];
	$servername = "localhost";
	$dbuser = "id21489055_admin";
	$dbpassword = "Tutito123.";
	$dbname = "id21489055_deinacridadb";// Create connection
	$conn = new mysqli($servername, $dbuser, $dbpassword, $dbname);// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}


	// Get student rut by fingerprint
	$sql = "SELECT * FROM estudiante WHERE huella_dactilar = ". $user_id;
	if ($conn->query($sql) === FALSE) {
		die("No students found");
	}
	$student = array($conn->query($sql)->fetch_assoc())[0];
	$studentRut = $student["rut"];


	// Get class current class id from current datetime
	date_default_timezone_set('America/Santiago');
	$currentDate = date("Y-m-d");
	$currentTime = date("H:i:s");

	$sql2 = "SELECT * FROM clase WHERE fecha = '".$currentDate."' AND horario_inicio <= '".$currentTime."' AND horario_fin > '".$currentTime."'";

	if ($conn->query($sql2) === FALSE) {
		die("No clases found");
	}
	$clases = array($conn->query($sql2)->fetch_assoc())[0];
	if (is_null($clases)) {
		die("No clases found");
	}
	$claseId = $clases["id"];

	// Verify if student didn't attend this class already
	$sql3 = "SELECT count(*) from asistencia where estudiante_rut = '".$studentRut."'AND fecha >= '".$currentDate." 00:00:00' AND fecha <= '".$currentDate." 23:59:59'";
	if ($conn->query($sql3) === TRUE) {
		die("Cannot access attendance");
	}

	$attendance = array($conn->query($sql3)->fetch_assoc())[0];
	if ($attendance["count(*)"] > 0) {
		die("Student already attended");
	}
	 
	// Verify if student didn't attend this class already
	$sql4 = "INSERT INTO asistencia (fecha, clase_id, estudiante_rut, asistencia, atraso) VALUES ('".$currentDate." ".$currentTime."',".$claseId.",'".$studentRut."',1,0)";
	if ($conn->query($sql4) === FALSE) {
		die("Attendance not created");
	}

	$conn->close();
	die("Attendance created");
}
die("Request method not accepted");
