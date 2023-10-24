<?php


namespace Pbdkn\ContaoTinymcePluginFontawesomeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


/**
 * Class PbdknContaoTinymcePluginFontawesomeExtension
 * @package Pbdkn\ContaoTinymcePluginFontawesomeBundle
 */
class PbdknContaoTinymcePluginFontawesomeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
//echo "PBD function load in PBDContaoTinymcePluginFontawesomeExtension locatordir1 ".__DIR__."/../../config\n";
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config')
        );
        $loader->load('services.yaml');
echo "PBD function load services.yaml PBDContaoTinymcePluginFontawesomeExtension ".realpath(__DIR__.'/../../config/services.yaml')."\n";


        $rootKey = $this->getAlias();
        // Auf diesen Parameternamen kann in services.yaml zugegriffen werden
        $container->setParameter($rootKey.'.fontawesome_meta_file_version', $config['fontawesome_meta_file_version']);
        $container->setParameter($rootKey.'.fontawesome_source_path', $config['fontawesome_source_path']);

        $container->setParameter($rootKey.'.fontawesome_styles', $config['fontawesome_styles']);
        $myfontawesomeMetaFileVersion = $container->getParameter($rootKey.'.fontawesome_meta_file_version');
echo "PBD extension PBDContaoTinymcePluginFontawesomeExtension parameter gesetzt fontawesome_meta_file_version $myfontawesomeMetaFileVersion\n";

// Rufe den ParameterBag ab
/*
$parameterBag = $container->getParameterBag();

// Rufe alle Parameter der Erweiterung ab
$allParameters = $parameterBag->all();

// Gib alle Parameter aus
var_dump($allParameters);

*/
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('parameters.yml');
        $loader->load('listener.yml');
        $loader->load('services.yml');
echo "PBD extension PBDContaoTinymcePluginFontawesomeExtension ende\n";
    }


    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        // Default root key 
        return Configuration::ROOT_KEY;
    }
}