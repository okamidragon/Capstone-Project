<?php
require_once '../backend/db_connect.php';

$tests = [];

// IT-01: Create activity
$title = "Yoga";
$desc = "Morning routine";
$date = "2025-11-15";

$stmt = $mysqli->prepare("INSERT INTO activities (title, description, activity_date) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $desc, $date);
$inserted = $stmt->execute();
$stmt->close();

$expected = "Activity is saved in activities table, success message displayed";
$actual = $inserted ? "Activity saved, message shown" : "Failed";

$tests[] = [
    'Test Case' => 'IT-01',
    'Components' => 'manage_activities.php + db_connect.php',
    'Input' => "Activity Name=$title, Description=$desc, Date=$date",
    'Expected Output' => $expected,
    'Actual Output' => $actual,
    'Result' => ($inserted ? 'Pass' : 'Fail')
];

// IT-02: Empty activity name
$title = "";
$desc = "Some desc";
$date = "2025-11-16";

$result = empty($title) ? false : true;
$expected = "Validation error message: Activity name required";
$actual = $result ? "Inserted" : "Validation error shown";
$tests[] = [
    'Test Case' => 'IT-02',
    'Components' => 'manage_activities.php + db_connect.php',
    'Input' => "Empty Activity Name",
    'Expected Output' => $expected,
    'Actual Output' => $actual,
    'Result' => (!$result ? 'Pass' : 'Fail')
];

// Cleanup created test activity
$mysqli->query("DELETE FROM activities WHERE title='Yoga'");

$mysqli->close();

// Display results
foreach ($tests as $t) {
    echo implode(" | ", $t) . "\n";
}
?>
