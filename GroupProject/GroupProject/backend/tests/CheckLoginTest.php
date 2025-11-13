<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../check_login.php';

class CheckLoginTest extends TestCase {
    public function testValidLogin() {
        $_POST = ['username' => 'testuser', 'password' => 'password123'];
        ob_start();
        include __DIR__ . '/../check_login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('success', $output);
    }

    public function testInvalidLogin() {
        $_POST = ['username' => 'wronguser', 'password' => 'wrong'];
        ob_start();
        include __DIR__ . '/../check_login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid', $output);
    }
}
