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
    
    // Add this function to return the PDO instance safely
    public function getPDO() {
        return $this->pdo;
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

    

    // Fetch Adidas product details by ID
    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateProductQuantity($id, $quantity) {
        $sql = "UPDATE products SET quantity = quantity - :quantity WHERE id = :id AND quantity >= :quantity";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'quantity' => $quantity,
            'id' => $id
        ]);
    
        return $stmt->rowCount() > 0; // Returns true if update was successful
    }
    
    public function executeQuery($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    
   

}
?>