<?php

return [

    /**
     * If you want to use UUID
     * set this parameter to true
     */

    'use_uuid' => true,

    /**
     * Specify the uuid version to use
     * Available versions are 1,4
     * for more informations see https://uuid.ramsey.dev/en/latest/rfc4122.html#
     */
    'uuid_version' => 4,

    /**
     * If you want to use a customized models.
     * You schould extend package model in oyur custom model
     */
    'ability_model' => \Silber\Bouncer\Database\Ability::class,
    
    'role_model' => \Silber\Bouncer\Database\Role::class

];
