<?php
// File: /upgrade/upgrade-1.1.0.php

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_1_0($module){
    // do your thing here
    $module->author = "Amadeo";
    return true;
}