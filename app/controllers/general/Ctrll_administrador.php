<?php
require_once('app/controllers/extras/Ctrll_aplicativo.php');
require_once('app/models/general/Md_administrador.php');

class Ctrll_administrador extends Ctrll_aplicativo
{
    function view()
    {
        if (!empty($_SESSION['num_doc'])) {
            $objAdm = new Md_administrador();
            $countAdm = $objAdm->view()->rowCount();

            if ($countAdm > 0) {
                $listAdm = $objAdm->view()->fetchAll(PDO::FETCH_ASSOC);
            }

            require_once('app/views/pages/general/admin/contents/view_admin.php');
        } else {
            pageError();
        }
    }

    function crud()
    {
        if (!empty($_SESSION['num_doc'])) {
            if (!empty($_GET['adm'])) {
                $objAdm = new Md_administrador(['pk_id_adm' => $_GET['adm']]);
                $countAdm = $objAdm->search()->rowCount();
    
                if ($countAdm > 0) {
                    $rowAdm = $objAdm->search()->fetchAll(PDO::FETCH_ASSOC)[0];
                }
            }

            require_once('app/views/pages/general/admin/forms/form_admin.php');
        } else {
            pageError();
        }
    }

    function paperBin()
    {
        if (!empty($_SESSION['num_doc'])) {
            $class = 'Admin';

            $objAdm = new Md_administrador();
            $countAdm = $objAdm->paper()->rowCount();

            if ($countAdm > 0) {
                $funcAdm = $objAdm->paper()->fetchAll(PDO::FETCH_ASSOC);
            }

            require_once('app/views/pages/aplication/admin/contents/view_paperBin.php');
        } else {
            pageError();
        }
    }
}
