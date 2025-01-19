<?php
use PHPUnit\Framework\TestCase;

class PmfkiTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        global $conn;
        $this->conn = $conn;
    }

    public function testCreatePmfkiAccount() {
        // Simulate a POST request to create a new PMFKI account
        $_POST['pmfki_name'] = 'John Doe';
        $_POST['pmfki_ic'] = '123456789';
        $_POST['pmfki_id'] = 'PMFKI123';
        $_POST['pmfki_pwd'] = 'password123';
        $_POST['pmfki_phone'] = '0123456789';
        $_POST['confirm'] = true;

        ob_start();
        include __DIR__ . '/../resources/admin/pmfki_acc/pmfki.php';
        $output = ob_get_clean();

        // Assert that the account was created successfully
        $result = $this->conn->query("SELECT * FROM pmfki WHERE pmfki_id = 'PMFKI123'");
        $this->assertEquals(1, $result->num_rows);

        // Clean up
        $this->conn->query("DELETE FROM pmfki WHERE pmfki_id = 'PMFKI123'");
    }
}