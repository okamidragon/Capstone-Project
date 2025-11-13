// tests/test_system.php
require_once 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

$host = 'http://localhost:4444'; // Selenium server
$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());

// ST-01: User login and enroll
$driver->get('http://localhost/GroupProject/frontend/login.php');
$driver->findElement(WebDriverBy::id('username'))->sendKeys('testuser');
$driver->findElement(WebDriverBy::id('password'))->sendKeys('password123');
$driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'))->click();

// Check redirection
$driver->wait()->until(
    WebDriverExpectedCondition::urlContains('index.php')
);

echo "ST-01 | User login flow | Pass\n";

// Close browser
$driver->quit();
