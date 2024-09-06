<?php
require_once('app/controllers/extras/Ctrll_aplicativo.php');

require_once('app/models/aplicacion/Md_producto.php');
require_once('app/models/aplicacion/Md_categoria.php');

class Ctrll_producto extends Ctrll_aplicativo
{
    function crud()
    {
        if (!empty($_SESSION['num_doc'])) {
            if (!empty($_GET['prd'])) {
                $objPrd = new Md_producto(['pk_id_prd' => $_GET['prd']]);
                $countPrd = $objPrd->search()->rowCount();

                if ($countPrd > 0) {
                    $rowPrd = $objPrd->search()->fetchAll(PDO::FETCH_ASSOC)[0];

                    if (!empty($rowPrd['img_prd'])) {
                        $rowImg = json_decode($rowPrd['img_prd']);

                        $countImg = count($rowImg);
                    }
                }
            }

            $objCtg = new Md_categoria();
            $countCtg = $objCtg->list()->rowCount();

            if ($countCtg > 0) {
                $listCtg = $objCtg->list()->fetchAll(PDO::FETCH_ASSOC);
            }

            require_once('app/views/pages/aplication/admin/forms/form_product.php');
        } else {
            pageError();
        }
    }

    function view()
    {
        $extra = !empty($_SESSION['num_doc']) ? true : NULL;

        $objPrd = new Md_producto(['fk_ctg_prd' => ($_GET['ctg'] ?? 1), 'extra' => $extra]);
        $countPrd = $objPrd->category()->rowCount();
        
        if ($countPrd > 0) {
            $listPrd = $objPrd->category()->fetchAll(PDO::FETCH_ASSOC);
        }

        require_once('app/views/pages/aplication/principal/contents/view_products.php');
    }

    function paperBin()
    {
        if (!empty($_SESSION['num_doc'])) {
            $class = 'Product';

            $objPrd = new Md_producto();
            $countPrd = $objPrd->paper()->rowCount();

            if ($countPrd > 0) {
                $funcPrd = $objPrd->paper()->fetchAll(PDO::FETCH_ASSOC);
            }

            require_once('app/views/pages/aplication/admin/contents/view_paperBin.php');
        } else {
            pageError();
        }
    }
}
