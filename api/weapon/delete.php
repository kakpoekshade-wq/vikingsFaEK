<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

if (!methodIsAllowed('delete')) {
    returnError(405, 'Method not allowed');
}

if (isset($_GET['id'])) {
    $deleted = deleteWeapon($_GET['id']);
    if ($deleted == 1) {
        returnSuccess(204);
    } elseif ($deleted == 0) {
        returnError(404, 'Weapon not found');
    } else {
        returnError(500, 'Could not delete the weapon');
    }
} else {
    returnError(400, 'Missing parameter : id');
}