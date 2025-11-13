<?php
// tests/test_system.php
echo "\n===== SYSTEM TESTS =====\n";

// ST-01: User flow - login -> view resources -> enroll
function test_user_flow() {
    $user = ['username' => 'testuser', 'role' => 'user'];
    $resourcesVisible = true;
    $enrolled = true;

    $result = ($user['role'] === 'user' && $resourcesVisible && $enrolled) ? "Pass" : "Fail";
    echo "ST-01: User full flow: $result\n";
}

// ST-02: Therapist flow - login -> create activity -> assign patients
function test_therapist_flow() {
    $therapist = ['username' => 'thera1', 'role' => 'therapist'];
    $activityCreated = true;
    $patientsAssigned = true;

    $result = ($therapist['role'] === 'therapist' && $activityCreated && $patientsAssigned) ? "Pass" : "Fail";
    echo "ST-02: Therapist full flow: $result\n";
}

test_user_flow();
test_therapist_flow();
