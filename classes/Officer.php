<?php
require_once __DIR__ . '/Database.php';

class Officer {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllOfficers() {
        $stmt = $this->db->query("SELECT * FROM Officers ORDER BY OfficerID DESC");
        return $stmt->fetchAll();
    }

    public function getOfficerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Officers WHERE OfficerID = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function createOfficer($data) {
        $sql = "INSERT INTO Officers (FirstName, LastName, Age, ContactNumber, Course, YearLevel, Position, DateAssumed, DateEnded, TermYear, AccessLevel) 
                VALUES (:first_name, :last_name, :age, :contact_number, :course, :year_level, :position, :date_assumed, :date_ended, :term_year, :access_level) RETURNING OfficerID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'first_name' => $data['FirstName'],
            'last_name' => $data['LastName'],
            'age' => $data['Age'] ?? null,
            'contact_number' => $data['ContactNumber'] ?? null,
            'course' => $data['Course'] ?? null,
            'year_level' => $data['YearLevel'] ?? null,
            'position' => $data['Position'] ?? null,
            'date_assumed' => $data['DateAssumed'] ?? null,
            'date_ended' => $data['DateEnded'] ?? null,
            'term_year' => $data['TermYear'] ?? null,
            'access_level' => $data['AccessLevel'] ?? 'Member'
        ]);
        return $stmt->fetchColumn();
    }

    public function updateOfficer($id, $data) {
        $sql = "UPDATE Officers SET 
                FirstName = :first_name, LastName = :last_name, Age = :age, ContactNumber = :contact_number, 
                Course = :course, YearLevel = :year_level, Position = :position, TermYear = :term_year, AccessLevel = :access_level
                WHERE OfficerID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'first_name' => $data['FirstName'],
            'last_name' => $data['LastName'],
            'age' => $data['Age'] ?? null,
            'contact_number' => $data['ContactNumber'] ?? null,
            'course' => $data['Course'] ?? null,
            'year_level' => $data['YearLevel'] ?? null,
            'position' => $data['Position'] ?? null,
            'term_year' => $data['TermYear'] ?? null,
            'access_level' => $data['AccessLevel'] ?? 'Member'
        ]);
    }
}
?>
