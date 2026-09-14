<?php
require_once __DIR__ . '/pdo.php';

$stmt = $pdo->query('SELECT id, nombre, email, created_at FROM usuarios ORDER BY id DESC');
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD PDO - Usuarios</title>
</head>
<body>
    <h1>Usuarios</h1>
    <a href="create.php">Crear nuevo usuario</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars((string) $usuario['id']) ?></td>
                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['created_at']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= urlencode((string) $usuario['id']) ?>">Editar</a>
                        |
                        <a href="delete.php?id=<?= urlencode((string) $usuario['id']) ?>" onclick="return confirm('¿Eliminar este usuario?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="5">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
