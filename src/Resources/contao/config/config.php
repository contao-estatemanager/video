<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/video
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = array('ContaoEstateManager\\Video', 'AddonManager');

if(ContaoEstateManager\Video\AddonManager::valid()){
    // Add expose module
    $GLOBALS['FE_EXPOSE_MOD']['media']['video'] = '\\ContaoEstateManager\\Video\\ExposeModuleVideo';

    // Hooks
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('ContaoEstateManager\\Video\\Video', 'parseRealEstate');
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('ContaoEstateManager\\Video\\Video', 'addStatusToken');
    $GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = array('ContaoEstateManager\\Video\\Video', 'parseGallerySlide');
    $GLOBALS['TL_HOOKS']['compileExposeStatusToken'][] = array('ContaoEstateManager\\Video\\Video', 'addStatusToken');
}
