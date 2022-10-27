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

use Contao\Controller;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoEstateManager\Video\AddonManager;

if (AddonManager::valid())
{
    // Add fields
    $GLOBALS['TL_DCA']['tl_module']['fields']['addVideo'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['addVideo'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['realEstateVideoTemplate'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['realEstateVideoTemplate'],
        'default' => 'real_estate_itemext_video_default',
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('real_estate_itemext_video_'),
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(64) NOT NULL default ''",
    ];

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'][] = 'video';

    // Extend the default palettes
    PaletteManipulator::create()
        ->addField(['addVideo'], 'item_extension_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['realEstateVideoTemplate'], 'template_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('realEstateList', 'tl_module')
        ->applyToPalette('realEstateResultList', 'tl_module')
    ;
}
