<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = [
    'id'          => 'oe_moduletemplate',
    'title'       => 'OxidEsales Module Template (OETM)',
    'description' =>  '',
    'thumbnail'   => 'out/pictures/logo.png',
    'version'     => '0.0.1',
    'author'      => 'OXID eSales AG',
    'url'         => '',
    'email'       => '',
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\User::class => \OxidEsales\ModuleTemplate\Model\User::class
    ],
    'controllers' => [
    ],
    'templates'   => [
    ],
    'blocks'      => [
    ],
    'settings' => [
        /** Main */
        [
            'group'       => 'oemoduletemplate_main',
            'name'        => 'oemoduletemplate_GreetingMode',
            'type'        => 'select',
            'constraints' => 'generic|personal',
            'value'       => 'generic'
        ],
    ],
];
