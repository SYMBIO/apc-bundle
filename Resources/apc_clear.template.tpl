<?php

if (!extension_loaded('apc')) {
    $success = false;
    $message = 'APC cache extension not loaded';
} if (apc_clear_cache('user') && apc_clear_cache('system')) {
    $success = true;
    $message = 'APC cache clear: success';
} else {
    $success = false;
    $message = 'APC cache clear: failure';
}

die(json_encode(array('success' => $success, 'message' => $message)));