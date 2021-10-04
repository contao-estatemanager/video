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

namespace ContaoEstateManager\Video;

use Contao\BackendTemplate;
use ContaoEstateManager\ExposeModule;
use ContaoEstateManager\Translator;
use Patchwork\Utf8;

/**
 * Expose module "video".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ExposeModuleVideo extends ExposeModule
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'expose_mod_video';

    /**
     * Do not display the module if there are no real estates.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['video'][0]).' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        $strBuffer = parent::generate();

        return $this->isEmpty && (bool) $this->hideOnEmpty ? '' : $strBuffer;
    }

    /**
     * Generate the module.
     */
    protected function compile(): void
    {
        $arrLinks = Video::collectVideoLinks($this->realEstate->links, 1);

        if (null === $arrLinks)
        {
            $this->isEmpty = true;
        }
        else
        {
            // In current version is only one value supported
            $link = $arrLinks[0];

            // generate link with attributes
            $settings = [
                'autoplay' => 1, // ToDo: Determine, if field should be added to expose module
                'controls' => 1, // ToDo: Add field to expose module
                'fullscreen' => 1, // ToDo: Add field to expose module
            ];

            $link = Video::generateAttributeLink($link, $settings);

            // set template information
            $this->Template->link = $link;
        }

        $this->Template->label = Translator::translateExpose('button_video');
    }
}
