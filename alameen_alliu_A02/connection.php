<?php
$server_name = 'localhost';
$database_name = 'alameen_alliu_syscx';
$username = 'root';
$password = '';


// Create connection
$conn = new mysqli($server_name, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}
