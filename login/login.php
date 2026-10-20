<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<link href="style.css" rel="stylesheet">
<title>Liga de Futbol</title>
</head>
<body>
    <div class="login-box">

        <div class="izq">

            <div class="top">
                
            </div>

            <div class="contenido">
                <img src="../imagenes/Logo.png" alt="Logo">
                <h1><b>¡BIENVENIDO!</b></h1>
                <p>Inicia sesión para acceder a la administración de la liga de futbol.</p>
            </div>   

            <div class="footer">
                <p>© 2026 DATIX. Todos los derechos reservados.</p>
            </div>

        </div>

        <div class="der">
            
            <div class="iniciar">

                <h1><b>Iniciar Sesión<br>en el panel</b></h1>
                <p>¿Eres nuevo? Contacta con un administrador para obtener acceso.</p>

            </div>
        
            <form action="comprobanteLogin.php" method="post">

                <div class="campo">

                    <input type="text" id="username" name="username" required placeholder="Usuario">

                </div>    
                
                <div class="campo">

                    <input type="password" id="password" name="password" required placeholder="Contraseña">

                </div>   
                
                <div class="campo">

                    <input type="submit" value="Iniciar Sesión">
                    <p>¿Olvidaste tu contraseña? <a href="../admin/indexadmin.php">Haz clic aquí</a></p>

                </div>
                
            </form>
        </div>
        
    </div>    
</body>
</html>