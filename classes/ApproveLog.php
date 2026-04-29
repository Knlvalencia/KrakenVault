<?php
require_once __DIR__ . '/Database.php';

class ApproveLog {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllApproveLogs() {
        $stmt = $this->db->query("SELECT * FROM ApproveLog ORDER BY ApprovalID DESC");
        return $stmt->fetchAll();
    }

    public function createApproveLog($data) {
        $sql = "INSERT INTO ApproveLog (OfficerID, Notes, ApprovalStatus) 
                VALUES (:officer_id, :notes, :approval_status) RETURNING ApprovalID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'officer_id' => $data['OfficerID'],
            'notes' => $data['Notes'] ?? null,
            'approval_status' => $data['ApprovalStatus'] ?? 'Pending'
        ]);
        return $stmt->fetchColumn();
    }
}
?>
