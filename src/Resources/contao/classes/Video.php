<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/video
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\Video;

use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\StringUtil;
use ContaoEstateManager\Translator;

class Video
{
    /**
     * Parse real estate template and add video extension
     *
     * @param $objTemplate
     * @param $realEstate
     * @param $context
     */
    public function parseRealEstate(&$objTemplate, $realEstate, $context): void
    {
        if (!!$context->addVideo)
        {
            $arrLinks = static::collectVideoLinks($realEstate->links, 1);

            if($arrLinks === null)
            {
                return;
            }

            // create Template
            $objVideoTemplate = new FrontendTemplate($context->realEstateVideoTemplate);

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
     * @param $module
     * @param $arrSlides
     * @param $realEstate
     * @param $context
     */
    public function parseGallerySlide($objTemplate, $module, &$arrSlides, $realEstate, $context): void
    {
        if ($module === 'video')
        {
            $arrLinks = static::collectVideoLinks($realEstate->links);

            if($arrLinks === null)
            {
                return;
            }

            foreach ($arrLinks as $link){
                // create Template
                $objVideoGalleryTemplate = new FrontendTemplate($context->videoGalleryTemplate);

                // get video type
                $videoType = static::getVideoType($link);

                // generate link with attributes
                $settings = array(
                    'autoplay'   => $context->addVideoPreviewImage || $context->videoAutoplay ? 1 : 0,
                    'controls'   => !!$context->videoControls ? 1 : 0,
                    'fullscreen' => !!$context->videoFullscreen ? 1 : 0,
                );

                $link = static::generateAttributeLink($link, $settings, $videoType);

                // set template information
                $objVideoGalleryTemplate->class = $videoType;
                $objVideoGalleryTemplate->link = $link;
                $objVideoGalleryTemplate->autoplay = $settings['autoplay'];
                $objVideoGalleryTemplate->fullscreen = !!$context->videoFullscreen;
                $objVideoGalleryTemplate->addImage = false;
                $objVideoGalleryTemplate->playerWidth = 100;
                $objVideoGalleryTemplate->playerHeight = 100;

                // get player size by image size
                $customImageSize = false;

                if ($context->imgSize != '')
                {
                    $size = StringUtil::deserialize($context->imgSize);

                    if ($size[0] > 0 || $size[1] > 0 || is_numeric($size[2]))
                    {
                        $customImageSize = true;
                        $objVideoGalleryTemplate->playerWidth = $size[0];
                        $objVideoGalleryTemplate->playerHeight = $size[1];
                    }
                }

                // add preview image
                if(!!$context->addVideoPreviewImage)
                {
                    if($context->videoPreviewImage)
                    {
                        // add own preview image
                        $fileId = $context->videoPreviewImage;
                    }
                    else
                    {
                        // add main image from real estate
                        $fileId = $realEstate->getMainImageUuid();
                    }

                    if($fileId)
                    {
                        $objModel = FilesModel::findByUuid($fileId);

                        // Add an image
                        if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
                        {
                            $arrImage = array();

                            // Override the default image size
                            if($customImageSize)
                            {
                                $arrImage['size'] = $context->imgSize;
                            }

                            $arrImage['singleSRC'] = $objModel->path;
                            $context->addImageToTemplate($objVideoGalleryTemplate, $arrImage, null, null, $objModel);

                            $objVideoGalleryTemplate->addImage = true;
                        }
                    }
                }

                // add new slide
                $arrSlides[] = $objVideoGalleryTemplate->parse();
            }
        }
    }

    /**
     * Add status token for video objects
     *
     * @param $validStatusToken
     * @param $arrStatusTokens
     * @param $context
     */
    public function addStatusToken($validStatusToken, &$arrStatusTokens, $context): void
    {
        $arrLinks = static::collectVideoLinks($context->links, 1);

        if (null !== $arrLinks && in_array('video', $validStatusToken))
        {
            $arrStatusTokens[] = array(
                'value' => Translator::translateValue('videoObject'),
                'class' => 'video'
            );
        }
    }

    /**
     * Return video links as array
     *
     * @param $links
     * @param null $max
     *
     * @return null|array
     */
    public static function collectVideoLinks($links, $max=null): ?array
    {
        $arrLinks = null;

        $index = 1;

        if(!$links)
        {
            return $arrLinks;
        }

        foreach ($links as $link)
        {
            if(static::getVideoType($link))
            {
                $arrLinks[] = $link;

                if ($max !== null && $max === $index++){
                    break;
                }
            }
        }

        return $arrLinks;
    }

    /**
     * Return video type as string
     *
     * Supported vendors:
     * - youtube
     * - vimeo
     *
     * @param $link
     *
     * @return string|null
     */
    public static function getVideoType($link): ?string
    {
        // youtube
        if(preg_match('/youtu(?:\.be|be\.com|be\.de|\.de)/', $link) === 1)
        {
            return 'youtube';
        }

        // vimeo
        elseif(preg_match('/vimeo(?:\.com|\.de)/', $link) === 1)
        {
            return 'vimeo';
        }

        return null;
    }

    /**
     * Generate a valid link with attributes
     *
     * @param $videoType
     * @param $settings
     * @param $link
     *
     * @return string
     */
    public static function generateAttributeLink($link, $settings, $videoType=null): string
    {
        if($videoType===null)
        {
            $videoType = static::getVideoType($link);
        }

        $defaultParams = array();
        $arrSettings = array();
        $parsedLink = '';

        // parse and cleaning up the link
        $link = StringUtil::restoreBasicEntities($link);
        $link = StringUtil::decodeEntities($link);

        switch($videoType)
        {
            case 'youtube':
                // default parameters
                $defaultParams = array(
                    'modestbranding' => 1,
                    'enablejsapi'    => 1,
                    'showinfo'       => 0,
                    'version'        => 3,
                    'rel'            => 0
                );

                // user settings
                $arrSettings = array(
                    'autoplay' => $settings['autoplay'],
                    'controls' => $settings['controls'],
                    'fs'       => $settings['fullscreen'],
                );

                $matches = array();

                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $matches))
                {
                    $parsedLink = 'https://www.youtube.com/embed/' . $matches[1];
                }
                break;

            case 'vimeo':
                // default parameters
                $defaultParams = array(
                    'api'         => 1,
                    'transparent' => 0,
                    'muted'       => $settings['autoplay'], // need muted option for allow autoplay
                );

                // user settings
                $arrSettings = array(
                    'autoplay' => $settings['autoplay'],
                );

                $matches = array();

                if (preg_match('%vimeo\.com/(?:channels/(?:\w+/)?|groups/(?:[^/]+)/videos/|album/(?:\d+)/video/)?(\d+)(?:$|/|\?)%i', $link, $matches))
                {
                    $parsedLink = 'https://player.vimeo.com/video/' . $matches[1];
                }
                break;
        }

        $arrLink = parse_url( $link );
        parse_str($arrLink['query'], $query);

        // merge params
        $param = array_merge($query, $arrSettings, $defaultParams);

        if($parsedLink)
        {
            return $parsedLink . '?' . http_build_query($param);
        }

        // create link with parameters as fallback
        return $arrLink['scheme'] . '://' . $arrLink['host'] . $arrLink['path'] . '?' . http_build_query($param);
    }
}
