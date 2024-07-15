<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'          => 'oe_moduletemplate',
    'title'       => 'OxidEsales Module Template (OEMT)',
    'description' =>  '',
    'thumbnail'   => 'pictures/logo.png',
    'version'     => '3.0.0',
    'author'      => 'OXID eSales AG',
    'url'         => '',
    'email'       => '',
    'extend'      => [
        \OxidEsales\Eshop\Application\Controller\StartController::class => \OxidEsales\ModuleTemplate\Extension\Controller\StartController::class,
        \OxidEsales\Eshop\Application\Model\Basket::class => \OxidEsales\ModuleTemplate\Extension\Model\Basket::class,
        \OxidEsales\Eshop\Application\Model\User::class => \OxidEsales\ModuleTemplate\Extension\Model\User::class,
    ],
    'controllers' => [
        'oemtgreeting' => \OxidEsales\ModuleTemplate\Greeting\Controller\GreetingController::class,
        'oemt_admin_greeting' => \OxidEsales\ModuleTemplate\Greeting\Controller\Admin\GreetingAdminController::class,
    ],
    'events' => [
        'onActivate' => '\OxidEsales\ModuleTemplate\Core\ModuleEvents::onActivate',
        'onDeactivate' => '\OxidEsales\ModuleTemplate\Core\ModuleEvents::onDeactivate'
    ],
    'settings' => [
        //TODO: add help texts for settings to explain possibilities and point out which ones only serve as example
        /** Main */
        [
            'group'       => 'oemoduletemplate_main',
            'name'        => 'oemoduletemplate_GreetingMode',
            'type'        => 'select',
            'constraints' => 'generic|personal',
            'value'       => 'generic'
        ],
        [
            'group' => 'oemoduletemplate_main',
            'name'  => 'oemoduletemplate_BrandName',
            'type'  => 'str',
            'value' => 'Testshop'
        ],
        [
            'group' => 'oemoduletemplate_main',
            'name'  => 'oemoduletemplate_LoggerEnabled',
            'type'  => 'bool',
            'value' => false
        ],
        [
            'group' => 'oemoduletemplate_main',
            'name'  => 'oemoduletemplate_Timeout',
            'type'  => 'num',
            'value' => 30
            //'value' => 30.5
        ],
        [
            'group' => 'oemoduletemplate_main',
            'name'  => 'oemoduletemplate_Categories',
            'type'  => 'arr',
            'value' => ['Sales', 'Manufacturers']
        ],
        [
            'group' => 'oemoduletemplate_main',
            'name'  => 'oemoduletemplate_Channels',
            'type'  => 'aarr',
            'value' => ['1' => 'de', '2' => 'en']
        ],
        [
            'group'    => 'oemoduletemplate_main',
            'name'     => 'oemoduletemplate_Password',
            'type'     => 'password',
            'value'    => 'changeMe',
            'position' => 3
        ]
    ],
];
