<?php
require_once('app/controllers/extras/Ctrll_aplicativo.php');
require_once('app/models/aplicacion/Md_categoria.php');

class Ctrll_categoria extends Ctrll_aplicativo
{
    function view()
    {
        $extra = !empty($_SESSION['num_doc']) ? true : NULL;

        $objCtg = new Md_categoria(['extra' => $extra]);
        $countCtg = $objCtg->view()->rowCount();

        if ($countCtg > 0) {
            $listCtg = $objCtg->view()->fetchAll(PDO::FETCH_ASSOC);
        }

        require_once('app/views/pages/aplication/principal/contents/view_category.php');
    }

    function crud()
    {
        if (!empty($_SESSION['num_doc'])) {
            if (!empty($_GET['ctg'])) {
                $objCtg = new Md_categoria(['pk_id_ctg' => $_GET['ctg']]);
                $countCtg = $objCtg->search()->rowCount();

                if ($countCtg > 0) {
                    $rowCtg = $objCtg->search()->fetchAll(PDO::FETCH_ASSOC)[0];
                }
            }

            require_once('app/views/pages/aplication/admin/forms/form_category.php');
        } else {
            pageError();
        }
    }

    function paperBin()
    {
        if (!empty($_SESSION['num_doc'])) {
            $class = 'Category';

            $objCtg = new Md_categoria();
            $countCtg = $objCtg->paper()->rowCount();

            if ($countCtg > 0) {
                $funcCtg = $objCtg->paper()->fetchAll(PDO::FETCH_ASSOC);
            }

            require_once('app/views/pages/aplication/admin/contents/view_paperBin.php');
        } else {
            pageError();
        }
    }
}
