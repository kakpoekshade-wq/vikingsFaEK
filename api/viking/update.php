<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/viking/service.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';

if (!methodIsAllowed('update')) {
    returnError(405, 'Method not allowed');
}

$data = getBody();

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$id = intval($_GET['id']);

if (validateMandatoryParams($data, ['name', 'health', 'attack', 'defense'])) {
    verifyViking($data);
    if (isset($data['weaponId']) && $data['weaponId'] !== null) {
    $weapon = findOneWeapon($data['weaponId']);
    if (!$weapon) {
        returnError(404, 'Weapon not found');
    }
    $weaponId = intval($data['weaponId']);
} else {
    $weaponId = null;
}

    $updated = updateViking($id, $data['name'], $data['health'], $data['attack'], $data['defense'], $weaponId);
    if ($updated == 1) {
        returnSuccess(204);
    } elseif ($updated == 0) {
        returnError(404, 'Viking not found');
    } else {
        returnError(500, 'Could not update the viking');
    }
} else {
    returnError(412, 'Mandatory parameters : name, health, attack, defense');
}