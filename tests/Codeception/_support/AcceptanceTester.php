<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Codeception;

use Codeception\Util\Fixtures;
use OxidEsales\Codeception\Page\Home;
use OxidEsales\Facts\Facts;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
final class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    use \Codeception\Lib\Actor\Shared\Retry;

    /**
     * Open shop first page.
     */
    public function openShop(): Home
    {
        $I        = $this;
        $homePage = new Home($I);
        $I->amOnPage($homePage->URL);

        return $homePage;
    }

    public function setGreetingModePersonal(): void
    {
        $I = $this;

        $I->getServiceFromContainer(ModuleSettings::class)
            ->saveGreetingMode(ModuleSettings::GREETING_MODE_PERSONAL);
    }

    public function setGreetingModeGeneric(): void
    {
        $I = $this;

        $I->getServiceFromContainer(ModuleSettings::class)
            ->saveGreetingMode(ModuleSettings::GREETING_MODE_GENERIC);
    }

    public function getDemoUserName(): string
    {
        return Fixtures::get('user')['email'];
    }

    public function getDemoUserPassword(): string
    {
        return Fixtures::get('user')['password'];
    }

    public function resetGreetingTracker(): void
    {
        $this->updateInDatabase(
            'oemt_tracker',
            ['oemtcount' => 0],
            []
        );
    }

    public function getShopUrl(): string
    {
        $facts = new Facts();

        return $facts->getShopUrl();
    }

    protected function getServiceFromContainer(string $serviceName)
    {
        return ContainerFactory::getInstance()
            ->getContainer()
            ->get($serviceName);
    }
}
