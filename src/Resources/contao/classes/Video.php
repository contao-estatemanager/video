<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 * @author    Daniele Sciannimanica <daniele@oveleon.de>
 */

namespace Oveleon\ContaoImmoManagerVideoBundle;

use Oveleon\ContaoImmoManagerBundle\Translator;

class Video
{
    /**
     * Parse real estate template and add video extension
     *
     * @param $objTemplate
     * @param $realEstate
     * @param $context
     */
    public function parseRealEstate(&$objTemplate, $realEstate, $context)
    {
        if (!!$context->addVideo)
        {
            $arrLinks = static::collectVideoLinks($realEstate->links, 1);

            if(!count($arrLinks))
            {
                return;
            }

            // create Template
            $objVideoTemplate = new \FrontendTemplate($context->realEstateVideoTemplate);

            // In current version is only one value supported
            $link = $arrLinks[0];

            // set template information
            $objVideoTemplate->link = $link;
            $objVideoTemplate->label = Translator::translateLabel('button_video');

            $objTemplate->arrExtensions = array_merge($objTemplate->arrExtensions, [$objVideoTemplate->parse()]);
        }
    }

    /**
     * Parse video gallery template and add them to slides
     *
     * @param $objTemplate
     * @param $arrSlides
     * @param $realEstate
     * @param $context
     */
    public function parseGallerySlides($objTemplate, &$arrSlides, $realEstate, $context)
    {
        if (!!$context->addVideo)
        {
            $arrLinks = static::collectVideoLinks($realEstate->links, 1);

            if(!count($arrLinks))
            {
                return;
            }

            // create Template
            $objVideoGalleryTemplate = new \FrontendTemplate($context->videoGalleryTemplate);

            // In current version is only one value supported
            $link = $arrLinks[0];

            // set template information
            $objVideoGalleryTemplate->link = $link;

            $index = 0;

            switch($context->videoPosition)
            {
                case 'second_pos':
                    $index = 1;
                    break;

                case 'last_pos':
                    $index = count($arrSlides);
                    break;
            }

            \array_insert($arrSlides, $index, array(
                $objVideoGalleryTemplate->parse()
            ));
        }
    }

    /**
     * Add status token for video objects
     *
     * @param $objTemplate
     * @param $realEstate
     * @param $context
     */
    public function addStatusToken(&$objTemplate, $realEstate, $context)
    {
        $tokens = \StringUtil::deserialize($context->statusTokens);

        if(!$tokens){
            return;
        }

        $arrLinks = static::collectVideoLinks($realEstate->links, 1);

        if (in_array('video', $tokens) && count($arrLinks))
        {
            $objTemplate->arrStatusTokens = array_merge(
                $objTemplate->arrStatusTokens,
                array
                (
                    array(
                        'value' => Translator::translateValue('videoObject'),
                        'class' => 'video'
                    )
                )
            );
        }
    }

    /**
     * Return video links as array
     *
     * Supported vendors:
     * - youtube
     * - vimeo
     *
     * @param $links
     * @param null $max
     *
     * @return array
     */
    public static function collectVideoLinks($links, $max=null)
    {
        $arrLinks = array();

        $index = 1;

        if(!$links)
        {
            return $arrLinks;
        }

        foreach ($links as $link)
        {
            if(preg_match('/vimeo(?:\.com|\.de)|youtu(?:\.be|be\.com|be\.de|\.de)/', $link) === 1)
            {
                $arrLinks[] = $link;

                if ($max !== null && $max === $index++){
                    break;
                }
            }
        }

        return $arrLinks;
    }
}