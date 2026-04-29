<?php
require_once __DIR__ . '/Database.php';

class Committee {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllCommittees() {
        $stmt = $this->db->query("SELECT * FROM Committees ORDER BY CommitteeID DESC");
        return $stmt->fetchAll();
    }

    public function getCommitteesByOfficer($officerId) {
        $stmt = $this->db->prepare("SELECT * FROM Committees WHERE OfficerID = :officer_id ORDER BY CommitteeID DESC");
        $stmt->execute(['officer_id' => $officerId]);
        return $stmt->fetchAll();
    }

    public function createCommittee($data) {
        $sql = "INSERT INTO Committees (OfficerID, FirstName, LastName, Age, Course, YearLevel, ContactNumber, SchoolEmail, CommitteeType, TermYear) 
                VALUES (:officer_id, :first_name, :last_name, :age, :course, :year_level, :contact_number, :school_email, :committee_type, :term_year) RETURNING CommitteeID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'officer_id' => $data['OfficerID'],
            'first_name' => $data['FirstName'],
            'last_name' => $data['LastName'],
            'age' => $data['Age'] ?? null,
            'course' => $data['Course'] ?? null,
            'year_level' => $data['YearLevel'] ?? null,
            'contact_number' => $data['ContactNumber'] ?? null,
            'school_email' => $data['SchoolEmail'] ?? null,
            'committee_type' => $data['CommitteeType'] ?? 'General',
            'term_year' => $data['TermYear'] ?? null
        ]);
        return $stmt->fetchColumn();
    }
}
?>
