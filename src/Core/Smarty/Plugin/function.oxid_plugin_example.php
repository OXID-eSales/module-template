<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\ModuleTemplate\Service\NewPluginExample;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: set params and render widget
 * Use [{oxid_include_dynamic file="..."}] instead of include
 * -------------------------------------------------------------
 *
 * @param array  $params params
 *
 * @return string
 */
function smarty_function_oxid_plugin_example($params)
{
    return ContainerFactory::getInstance()
        ->getContainer()
        ->get(NewPluginExample::class)
        ->renderWidget($params);
}