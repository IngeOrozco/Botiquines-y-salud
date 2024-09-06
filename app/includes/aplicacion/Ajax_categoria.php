<?php
require_once('app/includes/extras/Ajax_aplicativo.php');
require_once('app/models/aplicacion/Md_categoria.php');
require_once('app/models/aplicacion/Md_producto.php');

class Ajax_categoria extends Ajax_aplicativo
{
    function crud()
    {
        if (!empty($_SESSION['num_doc'])) {
            try {
                if (isset($_POST['btn-ctg-add']) || isset($_POST['btn-ctg-mod']) || isset($_POST['btn-ctg-del'])) {
                    if (!isset($_POST['btn-ctg-add'])) {
                        $pk_id_ctg = input_empty($_POST['pk_id_ctg']);

                        $objCtg = new Md_categoria(['pk_id_ctg' => $pk_id_ctg]);
                        $rowCtg = $objCtg->search()->fetchAll(PDO::FETCH_ASSOC)[0];
                    }

                    if (isset($_POST['btn-ctg-add']) || isset($_POST['btn-ctg-mod'])) {
                        $nom_ctg = input_empty($_POST['nom_ctg']);
                        $des_ctg = input_empty($_POST['des_ctg'], true);
                        $fk_etd_ctg = input_empty($_POST['fk_etd_ctg'], true);

                        if ($nom_ctg) {
                            if (strlen($nom_ctg) > 200) {
                                throw new Exception('¡Máximo de caractares permitidos en el nombre es de 200!');
                            }
                        } else {
                            throw new Exception('¡El campo del nombre es obligatorio!');
                        }

                        if (strlen($des_ctg) > 500) {
                            throw new Exception('¡Máximo de caractares permitidos en la descripción es de 500!');
                        }

                        $uploadDirectory = 'public/uploads/categoria/';

                        if (!empty($_FILES['img_ctg']['name'])) {
                            $file = $_FILES['img_ctg'];

                            $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                            $allowedExtensions = array('jpg', 'jpeg', 'png');

                            if (!in_array($imageFileType, $allowedExtensions)) {
                                throw new Exception('El archivo <b>' . $file['name'] . '</b> no es una imagen válida.');
                            }

                            if ($file['size'] > 1.5 * 1024 * 1024) {
                                throw new Exception('El archivo <b>' . $file['name'] . '</b> es demasiado grande (más de 1.5MB)');
                            }

                            if (isset($_POST['btn-ctg-add'])) {
                                $newFileName = date('ymd') . '-' . (uniqid() . '.' . $imageFileType);

                                $img_ctg = $newFileName;
                            } else if (isset($_POST['btn-ctg-mod'])) {
                                if (!empty($rowCtg['img_ctg'])) {
                                    $img_ctg = pathinfo($rowCtg['img_ctg']);
                                    $img_ctg = $img_ctg['filename'] . '.' . $imageFileType;
                                } else {
                                    $newFileName = date('ymd') . '-' . (uniqid() . '.' . $imageFileType);

                                    $img_ctg = $newFileName;
                                }
                            }
                        }

                        $arrayData = [
                            'nom_ctg' => $nom_ctg,
                            'des_ctg' => $des_ctg ?? NULL,
                            'img_ctg' => $img_ctg ?? NULL,
                            'fk_etd_ctg' => $fk_etd_ctg ?? 1,
                            'pk_id_ctg' => $pk_id_ctg ?? NULL
                        ];

                        $objCtg = new Md_categoria($arrayData);

                        if (isset($_POST['btn-ctg-add'])) {
                            $objCtg->insert();
                        } else if (isset($_POST['btn-ctg-mod'])) {
                            $objCtg->update();
                        }

                        if (!empty($_FILES['img_ctg']['name'])) {
                            $file = $_FILES['img_ctg'];

                            if (!empty($rowCtg['img_ctg'])) {
                                $uploadFilePath = $uploadDirectory . $img_ctg;

                                rename($uploadDirectory . $rowCtg['img_ctg'], $uploadFilePath);
                            } else {
                                $uploadFilePath = $uploadDirectory . $img_ctg;
                            }

                            if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                                throw new Exception('Error al subir el archivo <b>' . $file['name'] . '</b>');
                            }
                        } else {
                            if (isset($_POST['btn-ctg-mod']) && !empty($rowCtg['img_ctg'])) {
                                if (file_exists($uploadDirectory . $rowCtg['img_ctg'])) {
                                    unlink($uploadDirectory . $rowCtg['img_ctg']);
                                }
                            }
                        }
                    } else if (isset($_POST['btn-ctg-del'])) {
                        $objCtg->trash();
                    }

                    redirect('?ctrll=categoria&&func=view');
                } else {
                    throw new Exception('¡Al parecer algo va mal!');
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    function eliminar()
    {
        if (!isset($_POST['btn-ctg-rts'])) {
            if (isset($_POST['btn-ctg-del'])) {
                $html = '<p>¿Estás seguro de eliminar las categorias seleccionadas permanentemente? Se eliminarán con los productos registrados dentro de la misma.</p>';
            } else {
                $html = '<p>¿Estás seguro de mover esta categoria a la papelera? Será visible solo para los administradores.</p>';
            }
            
            $html .= '<div class="buttons">
                        <button type="button" class="gray" data-ajax="remove" data-redirect=".confirmar">Cancelar</button>
                        <button class="red" name="btn-ctg-del">Aceptar</button>
                    </div>';
        } else {
            $html = '<p>¿Estás seguro de restaurar las categorias seleccionadas? Las categorias restauradas serán de manera inactiva, por lo cual si desea que sea visible para los usuaios, debe activarlas.</p>
                    <div class="buttons">
                        <button type="button" class="gray" data-ajax="remove" data-redirect=".confirmar">Cancelar</button>
                        <button class="blue" name="btn-ctg-rts">Aceptar</button>
                    </div>';
        }

        echo $html;
    }

    function paperBin()
    {
        if (!empty($_SESSION['num_doc'])) {
            try {
                if (isset($_POST['btn-ctg-rts']) || isset($_POST['btn-ctg-del'])) {
                    if (isset($_POST['bin'])) {
                        $pk_id_ctg = [];

                        foreach ($_POST['bin'] as $key => $value) {
                            $pk_id_ctg[] = $key;
                        }

                        $pk_id_ctg = implode(',', $pk_id_ctg);

                        $objCtg = new Md_categoria(['pk_id_ctg' => $pk_id_ctg]);

                        if (isset($_POST['btn-ctg-rts'])) {
                            $objCtg->restore();
                        } else if (isset($_POST['btn-ctg-del'])) {
                            $objPrd = new Md_producto(['fk_ctg_prd' => $pk_id_ctg]);
                            $countPrd = $objPrd->category()->rowCount();

                            if ($countPrd > 0) {
                                $funcPrd = $objPrd->category()->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($funcPrd as $rowPrd) {
                                    if (!empty($rowPrd['img_prd'])) {
                                        $img_ctg = json_decode($rowPrd['img_prd']);

                                        foreach ($img_ctg as $img) {
                                            $link = 'public/uploads/producto/' . $img;

                                            if (file_exists($link)) {
                                                unlink($link);
                                            }
                                        }
                                    }
                                }
                            }

                            $funcCtg = $objCtg->search()->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($funcCtg as $rowCtg) {
                                if (!empty($rowCtg['img_ctg'])) {
                                    $link = 'public/uploads/categoria/' . $rowCtg['img_ctg'];

                                    if (file_exists($link)) {
                                        unlink($link);
                                    }
                                }
                            }

                            $objPrd->delete();
                            $objCtg->delete();
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
}
