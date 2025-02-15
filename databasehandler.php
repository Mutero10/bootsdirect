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
 
    // Method to fetch user by email
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Fetch Adidas data from the database
    public function getAdidasProducts() {
        $sql = "SELECT * FROM products"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  

    // Fetch Puma data from the database
    public function getPumaProducts() {
        $sql = "SELECT name, type, price, image FROM puma"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch Adidas product details by ID
    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Method to store the reset token
    public function storeResetToken($email, $token, $expiry) {
        $stmt = $this->conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expiry, $email);
        $stmt->execute();
    }
    

    // Method to fetch user by token
    public function getUserByToken($token) {
        $query = "SELECT * FROM students WHERE reset_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Method to update the user's password
    public function updateUserPassword($email, $hashedPassword) {
        $query = "UPDATE students SET password = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $hashedPassword, $email);
        $stmt->execute();
    }

    // Method to clear reset token
    public function clearResetToken($email) {
        $query = "UPDATE students SET reset_token = NULL, token_expiry = NULL WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
    }

}
?>
