<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerVideoBundle;

use Oveleon\ContaoImmoManagerBundle\ExposeModule;
use Oveleon\ContaoImmoManagerBundle\Translator;

/**
 * Expose module "video".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ExposeModuleVideo extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_video';

    /**
     * Do not display the module if there are no real etates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['video'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $strBuffer = parent::generate();
        return $this->isEmpty && !!$this->hideOnEmpty ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $arrLinks = Video::collectVideoLinks($this->realEstate->links, 1);

        if(!count($arrLinks))
        {
            $this->isEmpty = true;
        }

        // In current version is only one value supported
        $link = $arrLinks[0];

        // set template information
        $this->Template->link = $link;
        $this->Template->label = Translator::translateExpose('button_video');
    }
}