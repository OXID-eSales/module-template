<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Core;

use OxidEsales\Eshop\Core\Registry as EshopRegistry;

final class TmpCleaner
{
    /**
     * Clean temp folder content.
     */
    public static function clearTmp(): void
    {
        $compileDir = (string) EshopRegistry::getConfig()->getConfigParam('sCompileDir');

        if (is_dir($compileDir)) {
            self::clearDirectory($compileDir);
        }
    }

    /**
     * Clean temp folder content.
     *
     * @param mixed $directoryPath
     *
     * @return bool
     */
    private static function clearDirectory($directoryPath)
    {
        $directoryHandler = opendir($directoryPath);

        if (!empty($directoryHandler)) {
            while (false !== ($fileName = readdir($directoryHandler))) {
                $filePath = $directoryPath . DIRECTORY_SEPARATOR . $fileName;
                self::clear($fileName, $filePath);
            }
            closedir($directoryHandler);
        }

        return true;
    }

    /**
     * Check if resource could be deleted, then delete it's a file or
     * call recursive folder deletion if it's a directory.
     *
     * @param string $fileName
     * @param string $filePath
     */
    private static function clear($fileName, $filePath): void
    {
        if (in_array($fileName, ['.', '..', '.gitkeep', 'gitignore', '.htaccess'])) {
            return; //nothing to be done
        }
        if (is_dir($filePath)) {
            self::clearDirectory($filePath);
            return;
        }
        if (is_file($filePath) && is_writable($filePath)) {
            unlink($filePath);
        }
    }
}
