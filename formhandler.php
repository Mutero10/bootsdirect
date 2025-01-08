<?php
class FormHandler {
    private $dbHandler;

    public function __construct($dbHandler) {
        $this->dbHandler = $dbHandler;
    }

    public function handleFormSubmission($postData) {
        // Validate input fields
        $student_id = isset($postData['student_id']) ? trim($postData['student_id']) : null;
        $email = isset($postData['email']) ? trim($postData['email']) : null;
        $password = isset($postData['password']) ? trim($postData['password']) : null;

        // Check if any field is missing
        if (empty($student_id) || empty($email) || empty($password)) {
            echo "Error: All fields are required.";
            return;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Error: Invalid email format.";
            return;
        }

        // Insert user into the database
        try {
            $this->dbHandler->insertUser($student_id, $email, $password);
            echo "User successfully registered!";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
