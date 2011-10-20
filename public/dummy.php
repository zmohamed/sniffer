<?php
@ini_set('zend_monitor.enable', 0);
if (isset($_GET['debugger_connect']) && $_GET['debugger_connect'] == 1) {
    if (function_exists('debugger_connect')) {
        debugger_connect();
        exit();
    } else {
        echo "No connector is installed.";
    }
}
?>
