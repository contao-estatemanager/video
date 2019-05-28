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
    // Add field
    array_insert($GLOBALS['TL_DCA']['tl_module']['fields'], -1, array(
        'addVideo'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_module']['addVideo'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'realEstateVideoTemplate' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateVideoTemplate'],
            'default'                 => 'real_estate_video_default',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_module_estate_manager_video', 'getRealEstateVideoTemplates'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        )
    ));

    // Extend estate manager statusTokens field options
    array_insert($GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'], -1, array(
        'video'
    ));

    // Extend the default palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('video_legend', 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
        ->addField(array('addVideo'), 'video_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField(array('realEstateVideoTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('realEstateList', 'tl_module')
        ->applyToPalette('realEstateResultList', 'tl_module')
    ;
}

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_module_estate_manager_video extends Backend
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
     * Return all real estate list templates as array
     *
     * @return array
     */
    public function getRealEstateVideoTemplates()
    {
        return $this->getTemplateGroup('real_estate_video_');
    }
}