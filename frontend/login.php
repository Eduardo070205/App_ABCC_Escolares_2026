<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body>

    <div class="container">

        <h1>Login</h1>

        <form action="../backend/scripts/validar_usuario.php" method="POST">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="caja_usuario">Email address</label>
                <input type="text" id="caja_usuario" name="caja_usuario" class="form-control" />
                
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="caja_password">Password</label>
                <input type="password" id="caja_password" name="caja_password" class="form-control" />
                
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">

                <div class="col">
                    <p>¿No tienes cuenta? <a href="registrar_usuario.php">Regitrarme como nuevo</a></p>

                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign in</button>

        
        </form>

    </div>



</body>

</html>