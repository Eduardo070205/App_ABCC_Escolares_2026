<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Registrar usuario</title>
</head>

<body>
    <main class="container mt-4">
        <h1>Registrar usuario</h1>

        <?php if (!empty($_SESSION['exito'])): ?>
            <div class="alert alert-success">Usuario registrado correctamente.</div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error_vacios'])): ?>
            <div class="alert alert-danger">Completa todos los campos.</div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error_pass'])): ?>
            <div class="alert alert-danger">Las contraseñas no coinciden.</div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error_existente'])): ?>
            <div class="alert alert-danger">No se pudo registrar el usuario.</div>
        <?php endif; ?>
        <form action="../backend/scripts/procesar_alta_usuario.php" method="POST">
            <div class="mb-3">
                <label for="caja_usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="caja_usuario" name="caja_usuario"
                    placeholder="Ingresa tu usuario" autocomplete="username"
                    value="<?php echo htmlspecialchars($_SESSION['user'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (!empty($_SESSION['error_vacios']) && empty($_SESSION['user'])): ?>
                    <div class="text-danger small mt-1">*Debes ingresar un usuario.</div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="caja_password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="caja_password" name="caja_password"
                    placeholder="Ingresa tu contraseña" autocomplete="new-password"
                    value="<?php echo htmlspecialchars($_SESSION['pass'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (!empty($_SESSION['error_vacios']) && empty($_SESSION['pass'])): ?>
                    <div class="text-danger small mt-1">*Debes ingresar una contraseña.</div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="caja_confirmar_password" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="caja_confirmar_password" name="caja_confirmar_password"
                    placeholder="Repite tu contraseña" autocomplete="new-password"
                    value="<?php echo htmlspecialchars($_SESSION['confirmPass'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (!empty($_SESSION['error_vacios']) && empty($_SESSION['confirmPass'])): ?>
                    <div class="text-danger small mt-1">*Debes confirmar la contraseña.</div>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error_pass'])): ?>
                    <div class="text-danger small mt-1">*Las contraseñas no coinciden.</div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Registrar usuario</button>
            <a href="login.php" class="btn btn-secondary">Volver al inicio de sesión</a>
        </form>
    </main>
</body>

</html>
<?php
    unset($_SESSION['error_vacios'], $_SESSION['error_pass'], $_SESSION['error_existente'], $_SESSION['exito']);
    unset($_SESSION['user'], $_SESSION['pass'], $_SESSION['confirmPass']);
?>
