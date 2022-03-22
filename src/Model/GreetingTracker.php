<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Model;

use OxidEsales\Eshop\Core\Model\BaseModel;

/**
 * @extendable-class
 * This is no shop extension.
 * This is a model class based on shop's BaseModel.
 */
class GreetingTracker extends BaseModel
{
    protected $_sCoreTable = 'oetm_tracker';

    protected $_sClassName = 'oetmtracker';

    protected $_blUseLazyLoading = true;

    public function countUp(): void
    {
        $this->assign(
            [
                'oetmcount' => $this->getCount() + 1,
            ]
        );
        $this->save();
    }

    public function getCount(): int
    {
        return (int) $this->getFieldData('oetmcount');
    }
}
