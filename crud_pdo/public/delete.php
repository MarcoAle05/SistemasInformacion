<?php
require_once __DIR__ . '/pdo.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM usuarios WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

header('Location: index.php');
exit;
