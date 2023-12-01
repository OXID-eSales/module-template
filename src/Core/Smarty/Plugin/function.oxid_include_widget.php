<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\ModuleTemplate\Service\ExtendPluginExample;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: set params and render widget
 * The extend example adds a log entry
 * -------------------------------------------------------------
 *
 * @param array  $params params
 *
 * @return string
 */
function smarty_function_oxid_include_widget($params)
{
    return ContainerFactory::getInstance()
        ->getContainer()
        ->get(ExtendPluginExample::class)
        ->renderWidget($params);
}