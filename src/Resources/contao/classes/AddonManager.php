<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerVideoBundle;

use Oveleon\ContaoImmoManagerBundle\ImmoManager;

class AddonManager
{
    /**
     * Addon name
     * @var string
     */
    public static $name = 'Video';

    /**
     * Addon config key
     * @var string
     */
    public static $key  = 'addon_video_license';

    /**
     * Is initialized
     * @var boolean
     */
    public static $initialized  = false;

    /**
     * Is valid
     * @var boolean
     */
    public static $valid  = false;

    /**
     * Licenses
     * @var array
     */
    private static $licenses = [
        '799bb899fab62b11a1a9b4b19cfe899d',
        'c37a79658e0882ac11b3b42902a6420d',
        'c99e17e4d411f4edd9cb17f9c15fc6f0',
        'daa509f2a9c3cbb95ebe744f4fd01660',
        'dc005eda7281cb7a4b8f3f717704e0d0',
        '7f0dc9a20d85f0de9d131c8b869a4f77',
        'e68c484c2840e9e72255c00c2a2bcce5',
        'e2935456e22f3e37447ab985a703b770',
        'ab4e9edc6a58ecf7dde09d5e356aefa3',
        '7e4f53de1e37c597603a20ebfef88fb4',
        '3538e78edaf7186e32dcd1a3f9226af5',
        'e457aa62f76b790e1ec2d2acfec4c743',
        '021246c8563bd9ed566e072c6ab59d3f',
        'ff4f5cc2dbbd09a035644ec6f8a9088d',
        '2ecc457d704f9b1379cf11e2b784f160',
        '5baf7800954d9b223c620bbf1b434e2a',
        '9491d411cf019e7f5835e0165345a9ff',
        '16aa472a9df12039b086c3776b1a030a',
        'cdb59b2c16eb00da2032704eb7cf6c32',
        'ecc843a847d9de75fd5001f78056a8e5',
        'a49d82301356f9e638bd80a60aafec7c',
        'e5d3ea7cc436c48e594ed6bd6ca3de44',
        '613e8a4932bc3f74cfd23d0800819ed5',
        'bf01d7a0d7b22e2fd1120c3591109cb0',
        '39d912dd4f207278c2a6f8c849aa237f',
        '6b21cdd50c7fdf61a24d1e903d1d69e7',
        '625aaf307592fecf58b8dec9a77acb7f',
        '5ba4c8356fce6a9fb0926135b010ed8e',
        '61097d3d5095e352a9a45eb89c1689b6',
        'afe37849da40c39b3b2f665df07e3346',
        'dce294d0a0231c985968338fff81374b',
        '725d057e86f5a617ec26b1f4adb2bb18',
        'fd1f6c27e673fe24e3fd403de94e69d9',
        '0b4b1b003a11cd2ad4203ae73bd338cf',
        'd0c991fb1f0f1df53cc0ef482b7fc112',
        'dc44ec3ed2b571729de522324dec4eb2',
        'e799f23837f72ccb75b4a2fe506f4896',
        'fe28cde978f8ba082246c58710ffad88',
        '7fea5dc77df24e1af25da7fa6667c84a',
        'b7d3832e4443f291adf5117b557f7efd',
        '62be254a47afe041f211fde56f7df0ff',
        '3b4b78536e09cc41b0720cd90e672613',
        'cf15674ba7f3f77f853867fb1bc1ae74',
        'd8e600dc1b60ab8a5af088b44a273a13',
        '7623b6a64296f8a498e0e3c8e6ee61e1',
        '99512247a2ecd2b66e643ae120b2596b',
        '17b90163dff6691a119cffaba141701e',
        '2a0ef4d3673a2ad9485b7e9b4d2aed5b',
        'f977848fddebd6ea6a17e35770cc8d0e',
        'ae1a57dc5cfe2b752332e42e939986df'
    ];

    public static function getLicenses()
    {
        return static::$licenses;
    }

    public static function valid()
    {
        if(strpos(\Environment::get('requestUri'), '/contao/install') !== false)
        {
            return true;
        }

        if (static::$initialized === false)
        {
            static::$valid = ImmoManager::checkLicenses(\Config::get(static::$key), static::$licenses, static::$key);
            static::$initialized = true;
        }

        return static::$valid;
    }

}
