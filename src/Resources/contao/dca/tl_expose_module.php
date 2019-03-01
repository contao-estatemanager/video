<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// Add a new selector field
$GLOBALS['TL_DCA']['tl_expose_module']['palettes']['__selector__'][] = 'addVideo';

// Add field to subpalettes
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['subpalettes'], 0, array
(
    'addVideo' => 'videoPosition'
));

// Add field
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['palettes'], -1, array
(
    'video'  => '{title_legend},name,headline,type;{settings_legend},text,hideOnEmpty;{template_legend:hide},customTpl,videoTemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID'
));

// Add fields
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['fields'], -1, array(
    'addVideo'  => array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['addVideo'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
        'sql'                       => "char(1) NOT NULL default '0'",
    ),
    'videoPosition' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['videoPosition'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options'                 => array('first_pos', 'second_pos', 'last_pos'),
        'eval'                    => array('tl_class'=>'w50'),
        'reference'               => &$GLOBALS['TL_LANG']['FMD'],
        'sql'                     => "varchar(16) NOT NULL default ''"
    ),
    'videoTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['videoTemplate'],
        'default'                 => 'expose_mod_video',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_expose_module_immo_manager_video', 'getVideoTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'videoGalleryTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['videoGalleryTemplate'],
        'default'                 => 'expose_mod_video_gallery_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_expose_module_immo_manager_video', 'getVideoGalleryTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
));

// Extend immo manager statusTokens field options
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['fields']['statusTokens']['options'], -1, array(
    'video'
));

// Extend the gallery palettes
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('video_legend', 'image_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addField(array('addVideo'), 'video_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField(array('videoGalleryTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('gallery', 'tl_expose_module')
;

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_expose_module_immo_manager_video extends \Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Return all video templates as array
     *
     * @return array
     */
    public function getVideoTemplates()
    {
        return $this->getTemplateGroup('expose_mod_video_');
    }

    /**
     * Return all gallery video templates as array
     *
     * @return array
     */
    public function getVideoGalleryTemplates()
    {
        return $this->getTemplateGroup('expose_mod_video_gallery_');
    }
}