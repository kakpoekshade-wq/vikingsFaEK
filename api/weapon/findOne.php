<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

if (!methodIsAllowed('read')) {
    returnError(405, 'Method not allowed');
}

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$weapon = findOneWeapon($_GET['id']);
if (!$weapon) {
    returnError(404, 'Weapon not found');
}
returnSuccess(200, $weapon);
