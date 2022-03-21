<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Controller;

use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Model\User as TemplateModelUser;
use OxidEsales\ModuleTemplate\Service\GreetingMessage;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;

/**
 * This is a brand new (module own) controller which extends from the
 * shop frontend controller class.
 */
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
        $template       = parent::render();
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);

        $this->_aViewData[ModuleCore::OETM_GREETING_TEMPLATE_VARNAME] = '';

        /** @var TemplateModelUser $user */
        $user = $this->getUser();

        if (is_a($user, EshopModelUser::class) && $moduleSettings->isPersonalGreetingMode()) {
            //this way information is transported to the template layer, add to _aViewData array and
            //use as [{$oetm_greeting}] in the (smarty) template
            $this->_aViewData[ModuleCore::OETM_GREETING_TEMPLATE_VARNAME] = $user->getPersonalGreeting();
        }

        return $template;
    }

    /**
     * NOTE: every public method in the controller will become part of the public API.
     *       A controller public method can be called via browser by cl=<controllerkey>&fnc=<methodname>.
     *       Take care not to accidentally expose methods that should not be part of the API.
     *       Leave the business logic to the service layer.
     */
    public function updateGreeting(): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);

        /** @var EshopModelUser $user */
        $user = $this->getUser();

        if (!is_a($user, EshopModelUser::class) || !$moduleSettings->isPersonalGreetingMode()) {
            return;
        }

        $greetingService = $this->getServiceFromContainer(GreetingMessage::class);
        $greetingService->saveOetmGreeting($user);
    }
}
