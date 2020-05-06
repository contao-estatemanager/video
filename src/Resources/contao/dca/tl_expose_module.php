<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/video
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */
if(ContaoEstateManager\Video\AddonManager::valid()){
    // Add selector
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['__selector__'][] = 'addVideoPreviewImage';

    // Add palette
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['video'] = '{title_legend},name,headline,type;{settings_legend},text,hideOnEmpty;{template_legend:hide},customTpl,videoTemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

    // Add subpalette
    $GLOBALS['TL_DCA']['tl_expose_module']['subpalettes']['addVideoPreviewImage'] = 'videoPreviewImage';

    // Add fields
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoAutoplay'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['videoAutoplay'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12 clr'),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoControls'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['videoControls'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12'),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoFullscreen'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['videoFullscreen'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12'),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['addVideoPreviewImage'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['addVideoPreviewImage'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoPreviewImage'] = array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['videoPreviewImage'],
        'exclude'                 => true,
        'inputType'               => 'fileTree',
        'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'tl_class'=>'clr'),
        'sql'                     => "binary(16) NULL"
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoTemplate'] = array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['videoTemplate'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => function (){
            return Contao\Controller::getTemplateGroup('expose_mod_video_');
        },
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['videoGalleryTemplate'] = array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['videoGalleryTemplate'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => function (){
            return Contao\Controller::getTemplateGroup('expose_mod_video_gallery_');
        },
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    );

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['statusTokens']['options'][] = 'video';

    // Extend estate manager expose module gallery options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['galleryModules']['options'][] = 'video';

    // Extend the gallery palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('video_legend', 'image_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
        ->addField(array('videoAutoplay','videoControls','videoFullscreen','addVideoPreviewImage'), 'video_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField(array('videoGalleryTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('gallery', 'tl_expose_module')
    ;
}
