<?php
/**
 * @author     Peter Broghammer
 * @license    LGPL-3.0+
 *
 */
namespace Pbdkn\ContaoTinymcePluginFontawesomeBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Pbdkn\ContaoTinymcePluginFontawesomeBundle\PbdknContaoTinymcePluginFontawesomeBundle;

/**
 * Plugin for the Contao Manager.
 *
 * @author Peter Broghammer <https://github.com/pbd-kn>
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
//echo "PBD plugin getbundles PbdknContaoTinymcePluginFontawesomeBundle\n";    
        return [                  
            BundleConfig::create(PbdknContaoTinymcePluginFontawesomeBundle::class)
                ->setLoadAfter([
                    'Contao\CoreBundle\ContaoCoreBundle',
                    'Markocupic\ContaoTinymcePluginBuilderBundle\MarkocupicContaoTinymcePluginBuilderBundle'
                ]
                )
        ];
    }
}

