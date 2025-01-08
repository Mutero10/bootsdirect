<?php
class DatabaseHandler {
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host=localhost;dbname=mydatabase";
        try {
            $this->pdo = new PDO($dsn, 'root', ''); // Update credentials if needed
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function insertUser($student_id, $email, $password) {
        $sql = "INSERT INTO students (student_id, email, password) VALUES (:student_id, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([
                'student_id' => $student_id,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT) // Secure password storage
            ]);
        } catch (PDOException $e) {
            echo "Error inserting user: " . $e->getMessage();
        }
    }

    public function getUsers() {
        $sql = "SELECT * FROM students"; 
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
