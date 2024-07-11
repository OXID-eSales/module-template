<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Controller\Admin;

use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Model\User;
use OxidEsales\Eshop\Application\Controller\Admin\AdminController;

class GreetingAdminController extends AdminController
{
    protected $_sThisTemplate = '@oe_moduletemplate/admin/user_greetings';

    public function render()
    {
        $oUser = oxNew(User::class);
        if ($oUser->load($this->getEditObjectId())) {
            $this->addTplParam(ModuleCore::OEMT_ADMIN_GREETING_TEMPLATE_VARNAME, $oUser->getPersonalGreeting());
        }

        return parent::render();
    }
}