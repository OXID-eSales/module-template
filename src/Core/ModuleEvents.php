<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Core;

/**
 * Class defines what module does on Shop events.
 */
final class ModuleEvents
{
    /**
     * Execute action on activate event
     */
    public static function onActivate(): void
    {
        // execute some calculations or actions on module activation.
        // think twice before putting anything here, maybe it can be solved differently?
    }

    /**
     * Execute action on deactivate event
     */
    public static function onDeactivate(): void
    {
        // execute some calculations or actions on module deactivation.
        // think twice before putting anything here, maybe it can be solved differently?
    }
}
