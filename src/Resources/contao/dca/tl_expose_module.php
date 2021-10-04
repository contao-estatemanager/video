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
    // Add selector
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['__selector__'][] = 'addVideoPreviewImage';

    // Add palette
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['video'] = '{title_legend},name,headline,type;{settings_legend},text,hideOnEmpty;{template_legend:hide},customTpl,videoTemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

    // Add subpalette
    $GLOBALS['TL_DCA']['tl_expose_module']['subpalettes']['addVideoPreviewImage'] = 'videoPreviewImage';

    // Add fields
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoAutoplay'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['videoAutoplay'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12 clr'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoControls'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['videoControls'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoFullscreen'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['videoFullscreen'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['addVideoPreviewImage'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['addVideoPreviewImage'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12', 'submitOnChange' => true],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoPreviewImage'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['videoPreviewImage'],
        'exclude' => true,
        'inputType' => 'fileTree',
        'eval' => ['fieldType' => 'radio', 'filesOnly' => true, 'tl_class' => 'clr'],
        'sql' => 'binary(16) NULL',
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoTemplate'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['videoTemplate'],
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('expose_mod_video_'),
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(64) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoGalleryTemplate'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['videoGalleryTemplate'],
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('expose_mod_video_gallery_'),
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(64) NOT NULL default ''",
    ];

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['statusTokens']['options'][] = 'video';

    // Extend estate manager expose module gallery options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['galleryModules']['options'][] = 'video';

    // Extend the gallery palettes
    PaletteManipulator::create()
        ->addLegend('video_legend', 'image_legend', PaletteManipulator::POSITION_BEFORE)
        ->addField(['videoAutoplay', 'videoControls', 'videoFullscreen', 'addVideoPreviewImage'], 'video_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['videoGalleryTemplate'], 'template_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('gallery', 'tl_expose_module')
    ;
}
