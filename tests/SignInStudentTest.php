<?php
use PHPUnit\Framework\TestCase;

class SignInStudentTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        global $conn;
        $this->conn = $conn; // Use the database connection from config.php
    }

    public function testValidLogin() {
        // Insert a test student into the database
        $student_id = 'TEST123';
        $student_pwd = password_hash('password123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO student (student_id, student_pwd) VALUES ('$student_id', '$student_pwd')";
        $this->conn->query($sql);

        // Simulate a POST request
        $_POST['student_id'] = $student_id;
        $_POST['student_pwd'] = 'password123';

        ob_start();
        include __DIR__ . '/../resources/auth/signin_student.php';
        $output = ob_get_clean();

        // Assert that the session is set and the user is redirected
        $this->assertArrayHasKey('student_id', $_SESSION);
        $this->assertEquals('TEST123', $_SESSION['student_id']);

        // Clean up
        $this->conn->query("DELETE FROM student WHERE student_id = '$student_id'");
    }

    public function testInvalidLogin() {
        // Simulate a POST request with invalid credentials
        $_POST['student_id'] = 'INVALID';
        $_POST['student_pwd'] = 'INVALID';

        ob_start();
        include __DIR__ . '/../resources/auth/signin_student.php';
        $output = ob_get_clean();

        // Assert that the session is not set and an error message is displayed
        $this->assertArrayNotHasKey('student_id', $_SESSION);
        $this->assertStringContainsString('Username or Password is incorrect', $output);
    }
}
