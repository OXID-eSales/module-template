<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Controller;

use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;
use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;

final class GreetingController extends FrontendController
{
    use ServiceContainer;

    /**
     * Current view template
     *
     * @var string
     */
    protected $_sThisTemplate = 'oe_moduletemplate.tpl';

    /**
     * Rendering method.
     *
     * @return mixed
     */
    public function render()
    {
        $template = parent::render();

        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);
        $this->_aViewData['oetm_greeting'] = '';

        if (($user = $this->getUser()) && $moduleSettings->isPersonalGreetingMode()) {
            //this way information is transported to the template layer
            $this->_aViewData['oetm_greeting'] = $user->getPersonalGreeting();
        }

        return $template;
    }


    /**
     * Add information to template.
     *
     * @return int
     */
    public function updateGreeting(): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);

        if (!($user = $this->getUser()) || !$moduleSettings->isPersonalGreetingMode()) {
            return;
        }

        $greeting = EshopRegistry::getRequest()->getRequestParameter('oetm_greeting');
        /** EshopModelUser $user */
        $user->setPersonalGreeting((string) substr($greeting, 0, 253)); //in real life add some validation
    }
}
