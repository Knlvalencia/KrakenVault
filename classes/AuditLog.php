<?php
require_once __DIR__ . '/Database.php';

class AuditLog {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllLogs() {
        $stmt = $this->db->query("
            SELECT a.*, o.FirstName, o.LastName 
            FROM AuditLog a 
            LEFT JOIN Officers o ON a.OfficerID = o.OfficerID 
            ORDER BY a.ActivityID DESC
        ");
        return $stmt->fetchAll();
    }

    public function logActivity($officerId, $activity) {
        $sql = "INSERT INTO AuditLog (OfficerID, Activity) VALUES (:officer_id, :activity) RETURNING ActivityID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'officer_id' => $officerId,
            'activity' => $activity
        ]);
        return $stmt->fetchColumn();
    }
}
?>
