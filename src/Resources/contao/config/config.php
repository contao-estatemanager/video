<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// Add expose module
array_insert($GLOBALS['FE_EXPOSE_MOD']['media'], -1, array
(
    'video' => '\\Oveleon\\ContaoImmoManagerVideoBundle\\ExposeModuleVideo',
));

// HOOKS
$GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('Oveleon\\ContaoImmoManagerVideoBundle\\Video', 'parseRealEstate');
$GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('Oveleon\\ContaoImmoManagerVideoBundle\\Video', 'addStatusToken');
$GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = array('Oveleon\\ContaoImmoManagerVideoBundle\\Video', 'parseGallerySlide');
$GLOBALS['TL_HOOKS']['compileExposeStatusToken'][] = array('Oveleon\\ContaoImmoManagerVideoBundle\\Video', 'addStatusToken');
