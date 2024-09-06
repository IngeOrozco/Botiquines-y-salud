<?php
function redirect($url, $return = true)
{
    echo "<script>window.win_func_redirect('" . $url . "', " . $return . ")</script>";
}

function pageError($data = NULL)
{
    require_once('app/views/interface/error.php');
}

function input_empty($value, $null = false)
{

    if ($null == false) {
        $value = trim($value);

        if (!empty($value)) {
            return $value;
        } else {
            return false;
        }
    } else {
        return $value;
    }

    return $value;
}
