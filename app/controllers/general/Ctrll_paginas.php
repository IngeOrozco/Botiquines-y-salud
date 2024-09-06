<?php
require_once('app/controllers/extras/Ctrll_aplicativo.php');

class Ctrll_paginas extends Ctrll_aplicativo {
    function inicio () {
        require_once('app/views/pages/general/inicio.php');
    }

    function nosotros () {
        require_once('app/views/pages/general/principal/contents/nosotros.php');
    }
    
    function signIn () {
        if (empty($_SESSION['num_doc'])) {
            require_once('app/views/pages/general/principal/forms/signIn.php');
        } else {
            pageError();
        }
    }
    
    function signOut () {
        if (!empty($_SESSION['num_doc'])) {
            session_destroy();
            redirect('?ctrll=paginas&&func=inicio');
        } else {
            pageError();
        }
    }

    function paperBin () {
        if (!empty($_SESSION['num_doc'])) {
            require_once('app/views/pages/aplication/admin/contents/view_paperBin.php');
        } else {
            pageError();
        }
    }
}