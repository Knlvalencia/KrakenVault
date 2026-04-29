<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/DocumentArchive.php';

if (!isset($_SESSION['officer_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

try {
    if (!isset($_FILES['fileInput']) || $_FILES['fileInput']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload failed or no file provided.');
    }

    $file = $_FILES['fileInput'];
    $customName = $_POST['fileName'] ?? '';
    $documentType = $_POST['docCategory'] ?? '';
    $category = $_POST['securityCategory'] ?? 'Internal';

    if (empty($customName) || empty($documentType) || empty($category)) {
        throw new Exception('Missing required fields.');
    }

    $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedExtensions)) {
        throw new Exception('Invalid file format.');
    }

    if ($file['size'] > 10 * 1024 * 1024) {
        throw new Exception('File exceeds 10MB limit.');
    }

    $uploadDir = __DIR__ . '/../tempupload/';
    
    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $customName) . '_' . time() . '.' . $fileExt;
    $uploadPath = $uploadDir . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception('Failed to save file to server.');
    }

    $docData = [
        'OfficerInCharge' => $_SESSION['officer_id'],
        'DocumentName' => $customName,
        'Category' => $category,
        'DocumentType' => $documentType,
        'FileSize' => $file['size'],
        'DocumentFilePath' => 'tempupload/' . $safeName
    ];

    $docModel = new DocumentArchive();
    $newId = $docModel->createDocument($docData);

    $responseData = $docData;
    $responseData['DocumentID'] = $newId;
    $responseData['UploadDate'] = date('Y-m-d H:i:s');
    $responseData['ApprovalStatus'] = 'Pending';

    echo json_encode(['success' => true, 'data' => $responseData, 'message' => 'Document uploaded successfully']);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
