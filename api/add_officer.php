<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/Officer.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['fullName'])) {
        throw new Exception('Invalid input data');
    }

    // Split fullName into first and last name (naive approach)
    $parts = explode(' ', $data['fullName'], 2);
    $firstName = $parts[0];
    $lastName = isset($parts[1]) ? $parts[1] : '';

    $officerData = [
        'StudentID' => $data['studentId'] ?? null,
        'FirstName' => $firstName,
        'LastName' => $lastName,
        'Age' => $data['age'] ? (int)$data['age'] : null,
        'ContactNumber' => $data['contact'] ?? null,
        'Course' => $data['course'] ?? null,
        'YearLevel' => $data['yearLevel'] ? (int)$data['yearLevel'] : null,
        'Position' => $data['position'] ?? null,
        'TermYear' => $data['termYear'] ?? null,
        'DateAssumed' => $data['dateAssumed'] ?: null,
        'AccessLevel' => $data['accessLevel'] ?? 'Viewer'
    ];

    $officerModel = new Officer();
    $newId = $officerModel->createOfficer($officerData);
    
    echo json_encode(['success' => true, 'id' => $newId, 'message' => 'Officer added successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
