<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Controller\Admin;

use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\ModuleTemplate\Model\User as TemplateModelUser;
use OxidEsales\ModuleTemplate\Service\UserServiceInterface;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;

class GreetingAdminController extends AdminController
{
    use ServiceContainer;

    protected $_sThisTemplate = '@oe_moduletemplate/admin/user_greetings';

    public function render()
    {
        $userService = $this->getServiceFromContainer(UserServiceInterface::class);
        if ($this->getEditObjectId()) {
            /** @var TemplateModelUser $oUser */
            $oUser = $userService->getUserById($this->getEditObjectId());
            $this->addTplParam(ModuleCore::OEMT_ADMIN_GREETING_TEMPLATE_VARNAME, $oUser->getPersonalGreeting());
        }

        return parent::render();
    }
}
