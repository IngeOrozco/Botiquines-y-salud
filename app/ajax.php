<?php
function list_ajax($folder)
{
    if (is_dir($folder)) {
        if ($dir = opendir($folder)) {
            while (($file = readdir($dir)) !== false) {
                if ($file != "." && $file != "..") {
                    $newFolder = $folder . $file . '/';
                    $ajaxName = 'Ajax_' . $_GET['ajax'];

                    if (is_dir($newFolder)) {
                        if (list_ajax($newFolder)) {
                            closedir($dir);
                            return true;
                        }
                    } else if ($ajaxName . '.php' == $file) {
                        require_once($folder . $file);

                        if (class_exists($ajaxName)) {
                            $ajax = new $ajaxName();

                            if ((!empty($ajax)) && method_exists($ajax, $_GET['func'])) {
                                try {
                                    $ajax->{$_GET['func']}();
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

if (!list_ajax('app/includes/')) {
    require_once("app/views/interface/error.php");
}
