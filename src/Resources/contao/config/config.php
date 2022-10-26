<?php

declare(strict_types=1);

/*
 * This file is part of Contao EstateManager.
 *
 * @see        https://www.contao-estatemanager.com/
 * @source     https://github.com/contao-estatemanager/video
 * @copyright  Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)
 * @license    https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = ['ContaoEstateManager\Video', 'AddonManager'];

use ContaoEstateManager\Video\AddonManager;
use ContaoEstateManager\Video\Video;

if (AddonManager::valid())
{
    // Add expose module
    $GLOBALS['FE_EXPOSE_MOD']['media']['video'] = 'ContaoEstateManager\Video\ExposeModuleVideo';

    // Hooks
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = [Video::class, 'parseRealEstate'];
    $GLOBALS['TL_HOOKS']['getStatusTokens'][] = [Video::class, 'addStatusToken'];
    $GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = [Video::class, 'parseGallerySlide'];
}
