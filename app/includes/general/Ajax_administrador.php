<?php
require_once('app/includes/extras/Ajax_aplicativo.php');
require_once('app/models/general/Md_administrador.php');

class Ajax_administrador extends Ajax_aplicativo
{
    function validate()
    {
        if (empty($_SESSION['num_doc'])) {
            try {
                if (isset($_POST['btn-adm-in'])) {
                    $usu_adm = input_empty($_POST['usu_adm']);
                    $pass_adm = input_empty($_POST['pass_adm']);

                    if ($usu_adm) {
                        if (!preg_match('/^@[A-Za-z0-9_.-]{6,}+/', $usu_adm)) {
                            if (!filter_var($usu_adm, FILTER_VALIDATE_EMAIL)) {
                                throw new Exception('parece que algo está incorrecto con el usuario o correo');
                            }
                        }
                    }

                    if ($pass_adm) {
                        if (
                            !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $pass_adm)
                        ) {
                            throw new Exception('recuerda que la contraseña debe tener al menos 8 caracteres');
                        }
                    }

                    if ($usu_adm && $pass_adm) {
                        $obj_adm = new Md_administrador(['usu_adm' => $usu_adm]);
                        $cnt_adm = $obj_adm->func_cns_singIn()->rowCount();

                        if ($cnt_adm > 0) {
                            $func_row_adm = $obj_adm->func_cns_singIn()->fetchAll(PDO::FETCH_ASSOC);
                            $count = 0;

                            foreach ($func_row_adm as $row_adm) {
                                if (password_verify($pass_adm, $row_adm['pass_adm'])) {
                                    $count = 1;
                                    break;
                                }
                            }

                            if ($count != 0) {
                                $_SESSION['num_doc'] = $row_adm['pk_id_adm'];

                                redirect('?ctrll=paginas&&func=inicio', 'false');
                            } else {
                                throw new Exception('parece que el usuario/correo y/o contraseña están incorrectos');
                            }
                        } else {
                            throw new Exception('parece que el usuario/correo y/o contraseña están incorrectos');
                        }
                    } else {
                        throw new Exception('todos los campos deben ser diligenciados');
                    }
                } else {
                    throw new Exception('algo ocurrió mal');
                }
            } catch (Exception $e) {
                echo '¡Ups, ' . $e->getMessage() . '!';
            }
        }
    }

    function crud()
    {
        if (!empty($_SESSION['num_doc'])) {
            try {
                if (isset($_POST['btn-adm-add']) || isset($_POST['btn-adm-mod']) || isset($_POST['btn-adm-del'])) {
                    if (!isset($_POST['btn-adm-add'])) {
                        $pk_id_adm = input_empty($_POST['pk_id_adm']);
                    }

                    if (isset($_POST['btn-adm-add']) || isset($_POST['btn-adm-mod'])) {
                        $nom_adm = input_empty($_POST['nom_adm']);
                        $ape_adm = input_empty($_POST['ape_adm']);
                        $usu_adm = input_empty($_POST['usu_adm']);
                        $ema_adm = input_empty($_POST['ema_adm']);

                        if ($nom_adm) {
                            if (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $nom_adm)) {
                                throw new Exception('nombre no válido');
                            }
                        } else {
                            throw new Exception('el campo de nombre es obligatorio');
                        }

                        if ($ape_adm) {
                            if (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $ape_adm)) {
                                throw new Exception('apellido no válido');
                            }
                        } else {
                            throw new Exception('el campo de apellido es obligatorio');
                        }

                        if ($usu_adm) {
                            if (!preg_match('/^@[A-Za-z0-9_.-]{6,}+/', $usu_adm)) {
                                throw new Exception('el usuario debe contener al menos 6 caracteres e iniciar con @, <b>ejemplo: @usuario123 </b>');
                            }
                        } else {
                            throw new Exception('el campo de usuario es obligatorio');
                        }

                        if ($ema_adm) {
                            if (!filter_var($ema_adm, FILTER_VALIDATE_EMAIL)) {
                                throw new Exception('parece que algo está incorrecto con el correo');
                            }
                        } else {
                            throw new Exception('el campo de correo es obligatorio');
                        }

                        if (isset($_POST['btn-adm-add'])) {
                            $pass_adm = input_empty($_POST['pass_adm']);
                            $pass_vrf = input_empty($_POST['pass_vrf']);
                            
                            if ($pass_adm && $pass_vrf) {
                                if ($pass_adm != $pass_vrf) {
                                    throw new Exception('las contraseñas no coinciden');
                                }

                                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $pass_adm)) {
                                    throw new Exception('la contraseña debe contener al menos 8 caracteres, mayúscula, minúscula, un número y carácter especial');
                                }
                            } else {
                                throw new Exception('el campo de contraseña es obligatorio');
                            }

                            $objAdm = new Md_administrador(['usu_adm' => $usu_adm, 'ema_adm' => $ema_adm, 'pass_adm' => $pass_adm]);
                        } else if (isset($_POST['btn-adm-mod'])) {
                            $fk_etd_adm = input_empty($_POST['fk_etd_adm'], true);

                            $objAdm = new Md_administrador(['pk_id_adm' => $pk_id_adm, 'usu_adm' => $usu_adm, 'ema_adm' => $ema_adm]);
                        }
                        
                        $countAdm = $objAdm->exist()->rowCount();

                        if ($countAdm > 0) {
                            $rowAdm = $objAdm->exist()->fetchAll(PDO::FETCH_ASSOC)[0];

                            if ($rowAdm['coincidence'] == 'both') {
                                throw new Exception('el usuaio y correo ya están en uso');
                            } else if ($rowAdm['coincidence'] == 'usu_adm') {
                                throw new Exception('el usuaio ya está en uso');
                            } else if ($rowAdm['coincidence'] == 'ema_adm') {
                                throw new Exception('el correo ya está en uso');
                            }
                        } else {
                            if (isset($_POST['btn-adm-add'])) {
                                $pass_adm = password_hash($pass_adm, PASSWORD_DEFAULT);

                                $objAdm = new Md_administrador(['nom_adm' => $nom_adm, 'ape_adm' => $ape_adm, 'usu_adm' => $usu_adm, 'ema_adm' => $ema_adm, 'pass_adm' => $pass_adm]);
                                $objAdm->insert();

                                redirect('?ctrll=administrador&&func=view');
                            } else if (isset($_POST['btn-adm-mod'])) {
                                $objAdm = new Md_administrador(['pk_id_adm' => $pk_id_adm, 'nom_adm' => $nom_adm, 'ape_adm' => $ape_adm, 'usu_adm' => $usu_adm, 'ema_adm' => $ema_adm, 'fk_etd_adm' => $fk_etd_adm ?? 0]);
                                $objAdm->update();
                            }
                        }
                    } else if (isset($_POST['btn-adm-del'])) {
                        $objAdm = new Md_administrador(['pk_id_adm' => $pk_id_adm]);
                        $objAdm->trash();
                    }

                    redirect('?ctrll=administrador&&func=view');
                } else {
                    throw new Exception('algo ocurrió mal');
                }
            } catch (Exception $e) {
                echo '¡Ups, ' . $e->getMessage() . '!';
            }
        }
    }

    function eliminar()
    {
        if (!empty($_SESSION['num_doc'])) {
            if (!isset($_POST['btn-adm-rts'])) {
                if (isset($_POST['btn-adm-del'])) {
                    $html = '<p>¿Estás seguro de eliminar permanentemente los administradores seleccionados? No los podrás volver a recuperar.</p>';
                } else {
                    $html = '<p>¿Estás seguro/a de mover el administrador a la papelera? No se mostrará a los demás administradores.</p>';
                }
                
                $html .= '<div class="buttons">
                            <button type="button" class="gray" data-ajax="remove" data-redirect=".confirmar">Cancelar</button>
                            <button class="red" name="btn-adm-del">Aceptar</button>
                        </div>';
            } else {
                $html = '<p>¿Estás seguro de restaurar los administradores seleccionados? Los administradores restauradas serán de manera inactiva, por lo cual si desea que funcione de manera normal, debe activarlos.</p>
                        <div class="buttons">
                            <button type="button" class="gray" data-ajax="remove" data-redirect=".confirmar">Cancelar</button>
                            <button class="blue" name="btn-adm-rts">Aceptar</button>
                        </div>';
            }

            echo $html;
        }
    }

    function paperBin()
    {
        if (!empty($_SESSION['num_doc'])) {
            try {
                if (isset($_POST['btn-adm-rts']) || isset($_POST['btn-adm-del'])) {
                    if (isset($_POST['bin'])) {
                        $pk_id_adm = [];
                        
                        foreach ($_POST['bin'] as $key => $value) {
                            $pk_id_adm[] = $key;
                        }
                        
                        $pk_id_adm = implode(',', $pk_id_adm);

                        $objAdm = new Md_administrador(['pk_id_adm' => $pk_id_adm]);

                        if (isset($_POST['btn-adm-rts'])) {
                            $objAdm->restore();
                        } else if (isset($_POST['btn-adm-del'])) {
                            $objAdm->delete();
                        }

                        redirect('?ctrll=administrador&&func=view');
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
