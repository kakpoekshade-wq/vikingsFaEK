<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';

if (!methodIsAllowed('patch')) {
    returnError(405, 'Method not allowed');
}

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$data = getBody();

if (!array_key_exists('weaponId', $data)) {
    returnError(412, 'Mandatory parameter : weaponId (use null to remove weapon)');
}

$weaponId = null;
if ($data['weaponId'] !== null) {
    $weapon = findOneWeapon($data['weaponId']);
    if (!$weapon) {
        returnError(404, 'Weapon not found');
    }
    $weaponId = intval($data['weaponId']);
}

$viking = findOneViking($_GET['id']);
if (!$viking) {
    returnError(404, 'Viking not found');
}

$updated = updateVikingWeapon($_GET['id'], $weaponId);
if ($updated !== null) {
    returnSuccess(204);
} else {
    returnError(500, 'Could not update the viking weapon');
}
