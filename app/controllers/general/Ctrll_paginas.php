<?php
require_once('app/models/aplicacion/Md_categoria.php');
require_once('app/controllers/extras/Ctrll_aplicativo.php');

class Ctrll_paginas extends Ctrll_aplicativo {
    function inicio () {
        $objCtg = new Md_categoria();
        $countCtg = $objCtg->view()->rowCount();

        if ($countCtg > 0) {
            $listCtg = $objCtg->view()->fetchAll(PDO::FETCH_ASSOC);
        }

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