<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Greeting\Controller;

use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Extension\Model\User as TemplateModelUser;
use OxidEsales\ModuleTemplate\Greeting\Service\GreetingMessageServiceInterface;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use OxidEsales\ModuleTemplate\Tracker\Repository\TrackerRepositoryInterface;

/**
 * @extendable-class
 *
 * This is a brand new (module own) controller which extends from the
 * shop frontend controller class.
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class GreetingController extends FrontendController
{
    /**
     * Current view template
     *
     * @var string
     */
    protected $_sThisTemplate = '@oe_moduletemplate/templates/greetingtemplate';

    /**
     * Rendering method.
     *
     * @return mixed
     */
    public function render()
    {
        $template = parent::render();
        $moduleSettings = $this->getService(ModuleSettingsServiceInterface::class);
        $repository = $this->getService(TrackerRepositoryInterface::class);

        /** @var TemplateModelUser $user */
        $user = $this->getUser();

        if (is_a($user, EshopModelUser::class) && $moduleSettings->isPersonalGreetingMode()) {
            $greeting = $user->getPersonalGreeting();
            $tracker = $repository->getTrackerByUserId($user->getId());
            $counter = $tracker->getCount();
        }

        $this->addTplParam(ModuleCore::OEMT_GREETING_TEMPLATE_VARNAME, $greeting ?? '');
        $this->addTplParam(ModuleCore::OEMT_COUNTER_TEMPLATE_VARNAME, $counter ?? 0);

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
        $moduleSettings = $this->getService(ModuleSettingsServiceInterface::class);

        /** @var EshopModelUser $user */
        $user = $this->getUser();

        if (is_a($user, EshopModelUser::class) && $moduleSettings->isPersonalGreetingMode()) {
            $greetingService = $this->getService(GreetingMessageServiceInterface::class);
            $greetingService->saveGreeting($user);
        }
    }
}
