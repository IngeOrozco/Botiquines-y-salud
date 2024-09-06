<?php
require_once('app/includes/extras/Ajax_aplicativo.php');
require_once('app/models/aplicacion/Md_producto.php');
require_once('app/models/aplicacion/Md_categoria.php');

class Ajax_producto extends Ajax_aplicativo
{
    function crud()
    {
        try {
            if (isset($_POST['btn-prd-add']) || isset($_POST['btn-prd-mod']) || isset($_POST['btn-prd-del'])) {
                $fk_ctg_prd = input_empty($_POST['fk_ctg_prd'] ?? NULL, true);

                if (!isset($_POST['btn-prd-add'])) {
                    $pk_id_prd = input_empty($_POST['pk_id_prd']);

                    $objPrd = new Md_producto(['pk_id_prd' => $pk_id_prd]);
                    $rowPrd = $objPrd->search()->fetchAll(PDO::FETCH_ASSOC)[0];
                }

                if (isset($_POST['btn-prd-add']) || isset($_POST['btn-prd-mod'])) {
                    $nom_prd = input_empty($_POST['nom_prd']);
                    $des_prd = input_empty($_POST['des_prd'], true);
                    $fk_etd_prd = input_empty($_POST['fk_etd_prd'], true);

                    if (!$nom_prd) {
                        throw new Exception('¡El campo del nombre es obligatorio!');
                    }
                    if (strlen($nom_prd) > 200) {
                        throw new Exception('¡Máximo de caractares permitidos en el nombre es de 200!');
                    }

                    if (strlen($des_prd) > 500) {
                        throw new Exception('¡Máximo de caractares permitidos en la descripción es de 500!');
                    }

                    if (!empty($fk_ctg_prd)) {
                        $objCtg = new Md_categoria(['pk_id_ctg' => $fk_ctg_prd]);

                        if (empty($objCtg->exist())) {
                            throw new Exception('¡No se encuentra la sección seleccionada!');
                        }
                    }

                    $uploadDirectory = 'public/uploads/producto/';

                    if (isset($_POST['btn-prd-mod'])) {
                        if (isset($_POST['save_img'])) {
                            $save_img = $_POST['save_img'];

                            if (!empty($rowPrd['img_prd'])) {
                                $func_img_prd = json_decode($rowPrd['img_prd']);

                                if (!$save_img) {
                                    $save_img = array();
                                }

                                foreach ($func_img_prd as $img) {
                                    if (!in_array($img, $save_img)) {
                                        if (file_exists($uploadDirectory . $img)) {
                                            unlink($uploadDirectory . $img);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if (isset($_FILES['img_prd'])) {
                        $countFile = count($_FILES['img_prd']['name']);

                        $img_prd = array();

                        for ($i = 0; $i < $countFile; $i++) {
                            $file = $_FILES['img_prd'];

                            $imageFileType = strtolower(pathinfo($file['name'][$i], PATHINFO_EXTENSION));
                            $allowedExtensions = array('jpg', 'jpeg', 'png');

                            if (!in_array($imageFileType, $allowedExtensions)) {
                                throw new Exception('El archivo <b>' . $file['name'][$i] . '</b> no es una imagen válida.');
                                continue;
                            }

                            if ($file['size'][$i] > 1.5 * 1024 * 1024) {
                                throw new Exception('El archivo <b>' . $file['name'][$i] . '</b> es demasiado grande (más de 1.5MB)');
                                continue;
                            }

                            $newFileName = date('ymd') . '-' . (uniqid() . '.' . $imageFileType);

                            $img_prd[] = $newFileName;
                        }

                        $json_img = json_encode($img_prd);
                    }

                    if (isset($_POST['save_img'])) {
                        if (!empty($save_img)) {
                            if (!empty($img_prd)) {
                                $json_img = json_encode(array_merge($save_img, $img_prd));
                            } else {
                                $json_img = json_encode($save_img);
                            }
                        }
                    }

                    $arrayData = [
                        'dCrt_prd' => date('Y-m-d H:i:s'),
                        'nom_prd' => $nom_prd,
                        'des_prd' => $des_prd ?? NULL,
                        'img_prd' => $json_img ?? NULL,
                        'fk_ctg_prd' => $fk_ctg_prd ?? 1,
                        'fk_etd_prd' => $fk_etd_prd ?? 1,
                        'pk_id_prd' => $pk_id_prd ?? NULL
                    ];

                    $objPrd = new Md_producto($arrayData);

                    if (isset($_POST['btn-prd-add'])) {
                        $objPrd->insert();
                    } else if (isset($_POST['btn-prd-mod'])) {
                        $objPrd->update();
                    }

                    if (isset($_FILES['img_prd'])) {
                        for ($i = 0; $i < $countFile; $i++) {
                            $file = $_FILES['img_prd'];
                            $uploadFilePath = $uploadDirectory . $img_prd[$i];

                            if (!move_uploaded_file($file['tmp_name'][$i], $uploadFilePath)) {
                                throw new Exception('Error al subir el archivo <b>' . $file['name'][$i] . '</b>');
                            }
                        }
                    }
                } else if (isset($_POST['btn-prd-del'])) {
                    $objPrd->trash();
                }

                redirect('?ctrll=producto&&func=view&&ctg=' . $fk_ctg_prd);
            } else {
                throw new Exception('¡Al parecer algo va mal!');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function eliminar()
    {
        if (!isset($_POST['btn-prd-rts'])) {
            if (isset($_POST['btn-prd-del'])) {
                $html = '<p>¿Estás seguro de eliminar los productos seleccionados permanentemente? No los podrás recuperar nuevamente.</p><br>';
            } else {
                $html = '<p>¿Estás seguro de mover este producto a la papelera? Será visible solo para los administradores.</p><br>';
            }

            $html .= '<div class="buttons">
                        <button class="red" name="btn-prd-del">Aceptar</button>
                        <button type="button" class="gray" data-ajax="remove" data-redirect=".confirmar">Cancelar</button>
                    </div>';
        } else {
            $html = '<p>¿Estás seguro de restaurar los productos seleccionados? Los productos restaurados serán de manera inactiva, por lo cual si desea que sea visible para los usuaios, debe activarlas.</p><br>
                    <div class="buttons">
                        <button class="blue" name="btn-prd-rts">Aceptar</button>
                        <button type="button" class="gray" data-ajax="remove" data-redirect=".confirmar">Cancelar</button>
                    </div>';
        }

        echo "<br>$html";
    }

    function paperBin()
    {
        if (!empty($_SESSION['num_doc'])) {
            try {
                if (isset($_POST['btn-prd-rts']) || isset($_POST['btn-prd-del'])) {
                    if (isset($_POST['bin'])) {
                        $pk_id_prd = [];

                        foreach ($_POST['bin'] as $key => $value) {
                            $pk_id_prd[] = $key;
                        }

                        $pk_id_prd = implode(',', $pk_id_prd);

                        $objPrd = new Md_producto(['pk_id_prd' => $pk_id_prd]);

                        if (isset($_POST['btn-prd-rts'])) {
                            $objPrd->restore();
                        } else if (isset($_POST['btn-prd-del'])) {
                            $funcPrd = $objPrd->search()->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($funcPrd as $rowPrd) {
                                if (!empty($rowPrd['img_prd'])) {
                                    $img_prd = json_decode($rowPrd['img_prd']);

                                    foreach ($img_prd as $img) {
                                        $link = 'public/uploads/producto/' . $img;

                                        if (file_exists($link)) {
                                            unlink($link);
                                        }
                                    }
                                }
                            }

                            $objPrd->delete();
                        }

                        redirect('?ctrll=categoria&&func=view');
                    }
                } else {
                    throw new Exception('¡Al parecer algo va mal!');
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    function buscar()
    {
        $objPrd = new Md_producto(['fk_ctg_prd' => $_GET['ctg'], 'nom_prd' => $_POST['search']]);
        $listPrd = $objPrd->like()->fetchAll(PDO::FETCH_ASSOC);

        require_once('app/views/pages/aplication/principal/components/contents/products.php');
    }
}
