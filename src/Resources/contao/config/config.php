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

if (AddonManager::valid())
{
    // Add expose module
    $GLOBALS['CEM_FE_EXPOSE_MOD']['media']['video'] = 'ContaoEstateManager\Video\ExposeModuleVideo';

    // Hooks
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = ['ContaoEstateManager\Video\Video', 'parseRealEstate'];
    $GLOBALS['TL_HOOKS']['getStatusTokens'][] = ['ContaoEstateManager\Video\Video', 'addStatusToken'];
    $GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = ['ContaoEstateManager\Video\Video', 'parseGallerySlide'];

    $GLOBALS['TL_HOOKS']['cemModulePreparation'][] = ['ContaoEstateManager\Video\Video', 'extendModulePreparation'];
}
