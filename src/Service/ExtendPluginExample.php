<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\IncludeWidgetLogic as EshopIncludeWidgetLogic;

class ExtendPluginExample extends EshopIncludeWidgetLogic
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function renderWidget(array $params)
    {
        Registry::getLogger()->debug('Plugin extension example ' . serialize($params));

        return parent::renderWidget($params);
    }
}