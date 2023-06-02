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
    'version'     => '2.0.0',
    'author'      => 'OXID eSales AG',
    'url'         => '',
    'email'       => '',
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\User::class => \OxidEsales\ModuleTemplate\Model\User::class,
        \OxidEsales\Eshop\Application\Controller\StartController::class => \OxidEsales\ModuleTemplate\Controller\StartController::class
    ],
    'controllers' => [
        'oemtgreeting' => \OxidEsales\ModuleTemplate\Controller\GreetingController::class
    ],
    'templates'   => [
        '@oe_moduletemplate/templates/greetingtemplate.tpl' => 'views/smarty/templates/greetingtemplate.tpl',
    ],
    'events' => [
        'onActivate' => '\OxidEsales\ModuleTemplate\Core\ModuleEvents::onActivate',
        'onDeactivate' => '\OxidEsales\ModuleTemplate\Core\ModuleEvents::onDeactivate'
    ],
    'blocks'      => [
        [
            //It is possible to replace blocks by theme, to do so add 'theme' => '<theme_name>' key/value in here
            'template' => 'page/shop/start.tpl',
            'block' => 'start_welcome_text',
            'file' => 'views/smarty/blocks/oemt_start_welcome_text.tpl'
        ]
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
