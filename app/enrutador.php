<?php
function list_controllers($folder)
{
    if (is_dir($folder)) {
        if ($dir = opendir($folder)) {
            while (($file = readdir($dir)) !== false) {
                if ($file != "." && $file != "..") {
                    $newFolder = $folder . $file . '/';
                    $ctrllName = 'Ctrll_' . $_GET['ctrll'];

                    if (is_dir($newFolder)) {
                        if (list_controllers($newFolder)) {
                            closedir($dir);
                            return true;
                        }
                    } else if ($ctrllName . '.php' == $file) {
                        require_once($folder . $file);

                        if (class_exists($ctrllName)) {
                            $ctrll = new $ctrllName();

                            if ((!empty($ctrll)) && method_exists($ctrll, $_GET['func'])) {
                                try {
                                    $ctrll->{$_GET['func']}();
                                    return true;
                                } catch (Error $e) {
                                    return false;
                                }
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }

                        closedir($dir);
                    }
                }
            }
            closedir($dir);
        }
    }
    return false;
}

if (!list_controllers('app/controllers/')) {
    require_once("app/views/interface/error.php");
}
