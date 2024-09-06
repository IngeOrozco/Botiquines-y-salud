<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/package/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="public/sass/styles.css">
    <link rel="shortcut icon" href="public/images/fondos/icono.ico" type="image/x-icon">
    <script src="public/package/JQuery/jquery-3.6.3.min.js"></script>
    <script src="public/scripts/windows.js"></script>
    <title>Botiquines Salud y Bienestar</title>
</head>

<body>
    <div class="container">
        <div class="web">
            <?php
            require_once('app/views/custom/navbar/nav.php');
            require_once('app/enrutador.php')
            ?>
        </div>
        <?php
        if ($_GET['func'] != 'signIn') {
            require_once('app/views/custom/footer.php');
        }
        ?>
    </div>
</body>
<script src="public/scripts/ajax.js"></script>
<script src="public/scripts/script.js"></script>

</html>