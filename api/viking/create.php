<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/viking/service.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';

if (!methodIsAllowed('create')) {
    returnError(405, 'Method not allowed');
}

$data = getBody();

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

    $newVikingId = createViking($data['name'], $data['health'], $data['attack'], $data['defense'], $weaponId);
    if (!$newVikingId) {
        returnError(500, 'Could not create the viking');
    }
    returnSuccess(201, ['id' => $newVikingId]);
} else {
    returnError(412, 'Mandatory parameters : name, health, attack, defense');
}

