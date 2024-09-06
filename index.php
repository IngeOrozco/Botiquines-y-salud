<?php
require_once('app/helpers/help_funciones.php');

date_default_timezone_set('America/Bogota');

if (!isset($_SESSION)) {
    session_start();
}

if (empty($_GET['func']) || (empty($_GET['ajax']) && empty($_GET['ctrll']))) {
    header('location: ?ctrll=paginas&&func=inicio');
} else {
    if (empty($_GET['ajax']) && !empty($_GET['ctrll'])) {
        require_once('app/views/custom/base.php');
    } else {
        require_once('app/ajax.php');
    }
}
