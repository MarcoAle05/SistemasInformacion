<?php
require_once __DIR__ . '/pdo.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, nombre, email FROM usuarios WHERE id = :id');
$stmt->execute(['id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    header('Location: index.php');
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nombre === '') {
        $errores[] = 'El nombre es obligatorio.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El email no es válido.';
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare('UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id');
        $stmt->execute([
            'nombre' => $nombre,
            'email' => $email,
            'id' => $id,
        ]);

        header('Location: index.php');
        exit;
    }

    $usuario['nombre'] = $nombre;
    $usuario['email'] = $email;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
</head>
<body>
    <h1>Editar usuario</h1>

    <?php if (!empty($errores)): ?>
        <ul style="color: red;">
            <?php foreach ($errores as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="edit.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $usuario['id']) ?>">
        <label>
            Nombre:
            <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>">
        </label>
        <br>
        <label>
            Email:
            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>">
        </label>
        <br>
        <button type="submit">Actualizar</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>
