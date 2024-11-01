<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://argob.github.io/poncho/poncho.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/cuerpo.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo.ico" />
    <title>Reestablecer contraseña</title>
</head>
<body>
    <nav class="navbar navbar-expand-md ">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.html">
                <img class="colect" src="img/image(2).png" alt="Logo" style="text-align: center;">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-md-3" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-primary btn-success" href="../index.html">
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" id="resetForm">
        <h2>Reestablecer Contraseña</h2>
        <form id="form-reestablecer">
          <input type="hidden" id="reset-token" value="<?php echo $_GET['token']; ?>"> <!-- Token desde la URL -->
          <div class="form-group">
            <label for="new-password">Nueva Contraseña</label>
            <input type="password" class="form-control" id="new-password" required>
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="confirm-password" required>
          </div>
          <button type="button" class="btn btn-primary" id="btn-reestablecer">Reestablecer</button>
        </form>
      </div>
      

    <footer class="pie">
    
        <hr>
        <div class="section">
          <div>
            <h2>Patrocinadores</h2>
            <a href="https://www.tecnica1lacosta.edu.ar/">EEST N°1</a>
            <a href="https://www.cos.org.ar/">Cooperativa COS</a>
            <a href="https://www.cesop.com.ar/">Cooperativa CESOP</a>
            <a href="https://www.cosyclastoninasltda.com.ar/">Cooperativa COSYC</a>
            <a href="https://lacosta.gob.ar/">Municipalidad De La Costa</a>
            <!-- Agrega más enlaces de patrocinadores según sea necesario -->
          </div>
          <div>
            <h2>Contacto</h2>
            <p>Dirección: Calle Principal, Ciudad, País</p>
            <p>Teléfono: +123456789</p>
            <p>Email: info@example.com</p>
          </div>
          <div>
            <h2>Enlaces útiles</h2>
            <a href="index.html">Inicio</a>
            <a href="#">Acerca de nosotros</a>
            <a href="#">Servicios</a>
            <a href="#">Contacto</a>
            <!-- Agrega más enlaces útiles según sea necesario -->
          </div>
        </div>
        <br>
        <div class="logo">
          <a href=""><img style="width: 170px;" src="img/image(2).png" alt="Logo de miTrasporte"></a>
        </div>
        <div class="derechos">
    
          <p>© 2024 Departamento de Programación | Todos los derechos reservados</p>
    
          <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
        </div>
    </footer> 

    <script>
      function togglePasswordVisibility(passwordFieldId) {
        var passwordField = document.getElementById(passwordFieldId);
        var toggleIcon = document.getElementById('toggle-icon-' + passwordFieldId);

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.src = "https://img.icons8.com/ios-glyphs/30/000000/invisible.png";
        } else {
            passwordField.type = "password";
            toggleIcon.src = "https://img.icons8.com/ios-glyphs/30/000000/visible.png";
        }
      }

    </script>
    <script src="js/jquery.js"></script>
    <script src="js/recover_pass.js"></script>
</body>
</html>