<?php
$mysqli = new mysqli("localhost", "root", "", "mental_health");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
?>
