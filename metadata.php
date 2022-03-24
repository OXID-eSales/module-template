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
    'title'       => 'OxidEsales Module Template (OETM)',
    'description' =>  '',
    'thumbnail'   => 'out/pictures/logo.png',
    'version'     => '0.0.1',
    'author'      => 'OXID eSales AG',
    'url'         => '',
    'email'       => '',
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\User::class => \OxidEsales\ModuleTemplate\Model\User::class,
        \OxidEsales\Eshop\Application\Controller\StartController::class => \OxidEsales\ModuleTemplate\Controller\StartController::class
    ],
    'controllers' => [
        'oetmgreeting' => \OxidEsales\ModuleTemplate\Controller\GreetingController::class
    ],
    'templates'   => [
        'greetingtemplate.tpl' => 'oe/moduletemplate/views/templates/greetingtemplate.tpl',
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
            'file' => 'views/blocks/oetm_start_welcome_text.tpl'
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
    ],
];
