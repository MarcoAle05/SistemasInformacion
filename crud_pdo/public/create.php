<?php
require_once __DIR__ . '/pdo.php';

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
        $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)');
        $stmt->execute([
            'nombre' => $nombre,
            'email' => $email,
        ]);

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear usuario</title>
</head>
<body>
    <h1>Crear usuario</h1>

    <?php if (!empty($errores)): ?>
        <ul style="color: red;">
            <?php foreach ($errores as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="create.php">
        <label>
            Nombre:
            <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
        </label>
        <br>
        <label>
            Email:
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </label>
        <br>
        <button type="submit">Guardar</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>
