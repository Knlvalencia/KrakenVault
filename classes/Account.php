<?php
require_once __DIR__ . '/Database.php';

class Account {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createAccount($officerId, $password) {
        // Enforce Google-like password policy: min 8 chars, 1 letter, 1 number, 1 special char
        if (strlen($password) < 8 || !preg_match("/[a-zA-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[^a-zA-Z0-9]/", $password)) {
            throw new Exception("Password must be at least 8 characters long, contain at least one letter, one number, and one special character.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Account (OfficerID, Password) VALUES (:officer_id, :password) RETURNING AccountID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'officer_id' => $officerId,
            'password' => $hashedPassword
        ]);
        return $stmt->fetchColumn();
    }

    public function verifyAccount($officerId, $password) {
        $stmt = $this->db->prepare("SELECT Password FROM Account WHERE OfficerID = :id");
        $stmt->execute(['id' => $officerId]);
        $row = $stmt->fetch();
        if ($row) {
            return password_verify($password, $row['password']);
        }
        return false;
    }

    public function verifyAccountByStudentId($studentId, $password) {
        $stmt = $this->db->prepare("SELECT a.Password, o.OfficerID FROM Account a JOIN Officers o ON a.OfficerID = o.OfficerID WHERE o.StudentID = :student_id");
        $stmt->execute(['student_id' => $studentId]);
        $row = $stmt->fetch();
        if ($row) {
            if (password_verify($password, $row['password'])) {
                return $row['officerid']; // Return the OfficerID upon success
            }
        }
        return false;
    }
}
?>
