<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Greeting\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Language as EshopLanguage;
use OxidEsales\Eshop\Core\Request as EshopRequest;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Extension\Model\User as TemplateModelUser;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;

readonly class GreetingMessageService implements GreetingMessageServiceInterface
{
    public function __construct(
        private ModuleSettingsServiceInterface $moduleSettings,
        private EshopRequest $shopRequest,
        private EshopLanguage $shopLanguage,
    ) {
    }

    public function getGreeting(?EshopModelUser $user = null): string
    {
        $result = ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST;

        if (ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL == $this->moduleSettings->getGreetingMode()) {
            $result = $this->getUserGreeting($user);
        }

        return $this->translate($result);
    }

    /**
     * @todo: logic should be extracted to separate class that handles calls to shop translation mechanism
     */
    private function translate(string $toTranslate): string
    {
        $result = $toTranslate ? $this->shopLanguage->translateString($toTranslate) : '';
        return is_array($result) ? (string)array_pop($result) : $result;
    }

    /**
     * @todo: why do we save the user movel here, we have repository :/ extract there.
     * @todo: type hinting is too general. You dont have setPersonalGreeting in this general User.
     */
    public function saveGreeting(EshopModelUser $user): bool
    {
        /** @var TemplateModelUser $user */
        $user->setPersonalGreeting($this->getRequestOemtGreeting());

        return (bool)$user->save();
    }

    /**
     * @todo: missplaced responsibility, extract to some Request class
     */
    private function getRequestOemtGreeting(): string
    {
        $input = (string)$this->shopRequest->getRequestParameter(ModuleCore::OEMT_GREETING_TEMPLATE_VARNAME);

        //in real life add some input validation
        return substr($input, 0, 253);
    }

    /**
     * @todo: can be simplified by correctly type hinting, also use-cases should be double-checked
     */
    private function getUserGreeting(?EshopModelUser $user = null): string
    {
        if (is_object($user)) {
            /** @var TemplateModelUser $user */
            $result = $user->getPersonalGreeting();
        }

        return $result ?? '';
    }
}
