<?php

if (!extension_loaded('apcu')) {
    $success = false;
    $message = 'APCu cache extension not loaded';
} if (apcu_clear_cache()) {
    $success = true;
    $message = 'APCu cache clear: success';
} else {
    $success = false;
    $message = 'APCu cache clear: failure';
}

die(json_encode(array('success' => $success, 'message' => $message)));