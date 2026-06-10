<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/weapon/service.php';

if (!methodIsAllowed('create')) {
    returnError(405, 'Method not allowed');
}

$data = getBody();

if (validateMandatoryParams($data, ['type', 'damage'])) {
    verifyWeapon($data);

    $newWeaponId = createWeapon($data['type'], $data['damage']);
    if (!$newWeaponId) {
        returnError(500, 'Could not create the weapon');
    }
    returnSuccess(201, ['id' => $newWeaponId]);
} else {
    returnError(412, 'Mandatory parameters : type, damage');
}