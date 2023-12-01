<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\TwigExtensions;

use OxidEsales\ModuleTemplate\Service\NewPluginExample;
use Twig\Extension\AbstractExtension;
use Twig\TokenParser\TokenParserInterface;
use Twig\TwigFunction;

class ExampleExtension extends AbstractExtension
{
    public function __construct(private NewPluginExample $pluginExample)
    {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [new TwigFunction('plugin_example', [$this, 'showExample'], ['is_safe' => ['html']])];
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function showExample()
    {
        return $this->pluginExample->doSomething();
    }
}
