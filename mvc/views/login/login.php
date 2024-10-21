<?php
class LoginViews
{
    public function render($data = [])
    {
        // Aquí va el HTML y el formulario de inicio de sesión
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <title>TAMTO</title>
            <link rel="stylesheet" href="style.css"> <!-- Asegúrate de incluir tu propio archivo de estilo si es necesario -->

            <script src="https://kit.fontawesome.com/e80ca12edd.js" crossorigin="anonymous"></script>
        </head>

        <body>
            <section>

                <div class="contenedor">


                    <div class="formulario">
                        <form action="home.php?c=login&a=loginView" method="post">
                            <h2>Iniciar Sesión</h2><br>
                            <?php if (isset($data['error'])): ?>
                                <p style="color: red;"><?php echo $data['error']; ?></p>
                            <?php endif; ?>
                            <!-- Cambia el atributo action al archivo PHP que procesará el inicio de sesión -->
                            <div class="input-contenedor">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" id="usuario" name="usuario" required>
                                <label for="username">Usuario:</label>
                            </div><br>
                            <div class="input-contenedor">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" id="password" name="password" required>
                                <label for="password">Contraseña:</label><br>
                            </div>
                            <div><br>
                                <button type="submit" class="rounded-button">Iniciar Sesión</button>
                            </div>
                        </form>

                    </div>

                </div>
            </section>


            <!-- Bootstrap JS y Popper.js (Necesarios para el funcionamiento de algunos componentes de Bootstrap) -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
        </body>

        </html>
        <?php

    }

}
?>