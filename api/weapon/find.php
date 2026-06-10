<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

if (!methodIsAllowed('read')) {
    returnError(405, 'Method not allowed');
}

$type= '';
$limit = 10;
$offset = 0;
if (isset($_GET['type'])) {
    $type = trim($_GET['type']);
}
if (isset($_GET['limit'])) {
    $limit = intval($_GET['limit']);
    if ($limit < 1) {
        returnError(400, 'Limit must be a positive and non zero number');
    }
}
if (isset($_GET['offset'])) {
    $offset = intval($_GET['offset']);
    if ($offset < 0) {
        returnError(400, 'Offset must be a positive number');
    }
}

$weapons = findAllWeapons($type, $limit, $offset);
returnSuccess(200, $weapons);