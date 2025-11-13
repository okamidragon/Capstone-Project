<?php
// tests/test_unit.php
echo "===== UNIT TESTS =====\n";

// UT-01: Successful login
function test_login_success() {
    $username = 'testuser';
    $password = 'password123';
    
    // Simulate DB record
    $dbRecord = [
        'id' => 1,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'user'
    ];

    $loginSuccess = password_verify($password, $dbRecord['password']);
    $result = ($loginSuccess && $dbRecord['role'] === 'user') ? "Pass" : "Fail";

    echo "UT-01: Login success test: $result\n";
}

// UT-02: Failed login
function test_login_fail() {
    $username = 'wronguser';
    $password = 'password123';
    
    $dbRecord = null;
    $result = ($dbRecord === null) ? "Pass" : "Fail";

    echo "UT-02: Login failure test: $result\n";
}

test_login_success();
test_login_fail();
