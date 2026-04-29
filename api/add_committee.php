<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/Committee.php';

if (!isset($_SESSION['officer_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['firstName']) || !isset($data['lastName'])) {
        throw new Exception('Invalid input data. First name and last name are required.');
    }

    $committeeData = [
        'OfficerID' => $_SESSION['officer_id'],
        'FirstName' => $data['firstName'],
        'LastName' => $data['lastName'],
        'Age' => $data['age'] ? (int)$data['age'] : null,
        'Course' => $data['course'] ?? null,
        'YearLevel' => $data['yearLevel'] ? (int)$data['yearLevel'] : null,
        'ContactNumber' => $data['contactNumber'] ?? null,
        'SchoolEmail' => $data['schoolEmail'] ?? null,
        'CommitteeType' => $data['committeeType'] ?? 'General',
        'TermYear' => $data['termYear'] ?? null
    ];

    $committeeModel = new Committee();
    $newId = $committeeModel->createCommittee($committeeData);
    
    echo json_encode(['success' => true, 'id' => $newId, 'message' => 'Committee member added successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
