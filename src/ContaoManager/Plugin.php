<?php
/**
 * @author     Peter Broghammer
 * @package    Contao News Infinite Scroll Bundle Bundle
 * @license    LGPL-3.0+
 * @see           https://github.com/markocupic/contao-news-infinite-scroll-bundle
 *
 */

namespace PBDKN\ContaoTinymcePluginFontawesomeBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

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
        return [
            BundleConfig::create('PBDKN\ContaoTinymcePluginFontawesomeBundle\PBDContaoTinymcePluginFontawesomeBundle')
                ->setLoadAfter([
                    'Contao\CoreBundle\ContaoCoreBundle',
                    'Markocupic\ContaoTinymcePluginBuilderBundle\MarkocupicContaoTinymcePluginBuilderBundle'
                ])
        ];
    }
}
