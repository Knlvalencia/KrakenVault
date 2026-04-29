<?php
require_once __DIR__ . '/Database.php';

class DocumentArchive {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllDocuments() {
        $stmt = $this->db->query("SELECT * FROM DocumentArchive ORDER BY DocumentID DESC");
        return $stmt->fetchAll();
    }

    public function createDocument($data) {
        $sql = "INSERT INTO DocumentArchive (ApprovalID, DocumentName, DocumentDescription, VersionNumber, DocumentFilePath, DocumentType, Category, OfficerInCharge, AssociatedEvent, TermYear) 
                VALUES (:approval_id, :document_name, :document_description, :version_number, :document_file_path, :document_type, :category, :officer_in_charge, :associated_event, :term_year) RETURNING DocumentID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'approval_id' => $data['ApprovalID'] ?? null,
            'document_name' => $data['DocumentName'],
            'document_description' => $data['DocumentDescription'] ?? null,
            'version_number' => $data['VersionNumber'] ?? null,
            'document_file_path' => $data['DocumentFilePath'] ?? null,
            'document_type' => $data['DocumentType'] ?? null,
            'category' => $data['Category'] ?? 'Internal',
            'officer_in_charge' => $data['OfficerInCharge'] ?? null,
            'associated_event' => $data['AssociatedEvent'] ?? null,
            'term_year' => $data['TermYear'] ?? null
        ]);
        return $stmt->fetchColumn();
    }
}
?>
