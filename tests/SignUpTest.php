<?php
use PHPUnit\Framework\TestCase;

class SignUpTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        global $conn;
        $this->conn = $conn;
    }

    public function testStudentRegistration() {
        // Simulate a POST request to register a new student
        $_POST['student_name'] = 'Jane Doe';
        $_POST['student_ic'] = '987654321';
        $_POST['student_id'] = 'STUDENT123';
        $_POST['student_pwd'] = 'password123';
        $_POST['student_email'] = 'jane@example.com';
        $_POST['student_phone'] = '0123456789';
        $_POST['student_address'] = '123 Main St';

        // Simulate file upload
        $_FILES['student_profilePic'] = [
            'name' => 'test.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__ . '/test.jpg',
            'error' => UPLOAD_ERR_OK,
            'size' => 1024
        ];

        ob_start();
        include __DIR__ . '/../resources/auth/signup.php';
        $output = ob_get_clean();

        // Assert that the student was registered successfully
        $result = $this->conn->query("SELECT * FROM student WHERE student_id = 'STUDENT123'");
        $this->assertEquals(1, $result->num_rows);

        // Clean up
        $this->conn->query("DELETE FROM student WHERE student_id = 'STUDENT123'");
        unlink(__DIR__ . '/../../public/storage/profile/STUDENT123.jpg');
    }
}
