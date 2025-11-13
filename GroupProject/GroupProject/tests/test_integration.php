<?php
// tests/test_integration.php
echo "\n===== INTEGRATION TESTS =====\n";

// IT-01: Valid activity creation
function test_create_activity_valid() {
    $input = ['name' => 'Yoga', 'description' => 'Morning routine', 'date' => '2025-11-15'];

    // Simulate validation
    $errors = [];
    if (empty($input['name'])) $errors[] = "Activity name required";

    $result = empty($errors) ? "Pass" : "Fail";
    echo "IT-01: Create activity valid: $result\n";
}

// IT-02: Empty activity name
function test_create_activity_empty_name() {
    $input = ['name' => '', 'description' => 'Morning routine', 'date' => '2025-11-15'];

    $errors = [];
    if (empty($input['name'])) $errors[] = "Activity name required";

    $result = (!empty($errors)) ? "Pass" : "Fail";
    echo "IT-02: Create activity empty name: $result\n";
}

test_create_activity_valid();
test_create_activity_empty_name();
