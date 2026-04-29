<?php
require_once __DIR__ . '/Database.php';

class DocumentArchive {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllDocuments() {
        $stmt = $this->db->query("
            SELECT d.*, o.FirstName, o.LastName 
            FROM DocumentArchive d 
            LEFT JOIN Officers o ON CAST(NULLIF(d.OfficerInCharge, '') AS INTEGER) = o.OfficerID 
            ORDER BY d.DocumentID DESC
        ");
        return $stmt->fetchAll();
    }

    public function createDocument($data) {
        $sql = "INSERT INTO DocumentArchive (DocumentName, Category, DocumentType, DocumentFilePath, OfficerInCharge, FileSize) 
                VALUES (:document_name, :category, :document_type, :document_file_path, :officer_in_charge, :file_size) RETURNING DocumentID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'document_name' => $data['DocumentName'],
            'category' => $data['Category'] ?? 'Internal',
            'document_type' => $data['DocumentType'] ?? null,
            'document_file_path' => $data['DocumentFilePath'],
            'officer_in_charge' => $data['OfficerInCharge'] ?? null,
            'file_size' => $data['FileSize'] ?? null
        ]);
        return $stmt->fetchColumn();
    }

    public function deleteDocument($id) {
        // First get the file path to delete it from storage
        $stmt = $this->db->prepare("SELECT DocumentFilePath FROM DocumentArchive WHERE DocumentID = :id");
        $stmt->execute(['id' => $id]);
        $filePath = $stmt->fetchColumn();

        if ($filePath && file_exists(__DIR__ . '/../' . $filePath)) {
            unlink(__DIR__ . '/../' . $filePath);
        }

        $sql = "DELETE FROM DocumentArchive WHERE DocumentID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
