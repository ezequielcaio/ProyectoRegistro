<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $ideas = json_decode(file_get_contents('registrar.json'), true);

    if ($data['action'] === 'add') {
        $ideas[] = $data['idea'];
    } elseif ($data['action'] === 'delete') {
        array_splice($ideas, $data['index'], 1);
    } elseif ($data['action'] === 'edit') {
        $ideas[$data['index']] = $data['idea'];
    }

    file_put_contents('registrar.json', json_encode($ideas, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
}
?>

