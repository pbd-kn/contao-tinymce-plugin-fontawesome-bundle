<?php

namespace Pbdkn\ContaoTinymcePluginFontawesomeBundle;
//namespace Pbdkn\ContaoTinymcePluginFontawesomeBundle\Resources\contao\classes;
/* !! Achtung dies ist nur wirksam wenn in composer.json unter autoload
 *     "classmap": [
      "src/Resources/contao"
    ],
    steht sonst funktioniert das autoloading u.U. nicht richtig
*/    


use Contao\Config;
use Pbdkn\ContaoTinymcePluginFontawesomeBundle\DependencyInjection\Configuration;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
/**
 * Class TinymceFontawesome
 * @package Pbdkn\ContaoTinymcePluginFontawesomeBundle
 */
class TinymceFontawesome
{
        private string $projectDir;
        private string $fontawesomeSourcePath;
        private string $fontawesomeMetaFileVersion;                                                                                                             
        private array $fontawesomeStyles;
        private string $fontAweversion='';
    protected ?LoggerInterface $customLogger = null;
        

    public function __construct(
    ) {
        $rootKey=Configuration::ROOT_KEY;
        $container = \Contao\System::getContainer();

        // Rufe die Parameter aus dem Container ab
        $this->projectDir = $container->getParameter('kernel.project_dir');
        $this->fontawesomeSourcePath = $container->getParameter($rootKey.'.fontawesome_source_path');
        $this->fontawesomeMetaFileVersion = $container->getParameter($rootKey.'.fontawesome_meta_file_version');
        $this->fontawesomeStyles = $container->getParameter($rootKey.'.fontawesome_styles');
        $logPath = $container->getParameter('kernel.project_dir').'/var/logs/TinymceFontawesome.log';
        $this->customLogger = $container->get('monolog.logger.contao');
        $streamHandler = new StreamHandler($logPath, Logger::DEBUG);
        $this->customLogger->pushHandler($streamHandler);
        $this->customLogger->debug('PBD Konstruktor TinyFontawesome');
        $this->customLogger->debug('PBD Konstruktor TinyFontawesome fontawesomeSourcePath '.$this->fontawesomeSourcePath);
        $this->customLogger->debug('PBD Konstruktor TinyFontawesome fontawesomeMetaFileVersion '.$this->fontawesomeMetaFileVersion);
//        $this->customLogger->debug('PBD Konstruktor TinyFontawesome fontawesomeMetaFileVersion '.$this->fontawesomeMetaFileVersion);

    }
    /**
     * @author Peter Broghammer
     * @return string
     */
    public static function getFontawesomeMetaVersion() {
        $container = \System::getContainer();           // wg. static-function
        // Den Parameter aus dem Container abrufen
        $fontawesome_meta_file_version = $container->getParameter('pbdkn_contao_tinymce_plugin_fontawesome.fontawesome_meta_file_version');

        return $fontawesome_meta_file_version;
    }
 
    /**
     * @author Peter Broghammer
     * @return string
     */
    public static function getFontawesomeCssFile() {
        return 'assets/font-awesome/webfonts/all.min.css'; // wurde durch movePluginFiles dahin kopiert wg. webspace
    }


    /**
     * Initialize System Hook
     * Runonce
     * Copy plugin sources to assets/tinymce4/js/plugins/fontawesome
     */
    public function initMe()
    {
        $this->movePluginFiles();        
    }
    /**
     * Initialize System Hook
     * Runonce
     * Copy plugin sources to assets/tinymce4/js/plugins/fontawesome
     */
    public function movePluginFiles()
    {
        $oFiles = \Files::getInstance();
        $this->customLogger->debug('PBD TinyFontawesome movePluginFiles');
        $this->customLogger->debug('PBD TinyFontawesome movePluginFiles !!!!!!!!!!!!! wird zum Test immer ausgefuehrt');

        //if (!is_file(TL_ROOT . '/vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome/copied.txt'))
        //{
            $fontawesomeSourcePath = $this->fontawesomeSourcePath;
            $versionPattern = '/\/v(\d+)\.(\d+)\.(\d+)\//';
            $fontAweversion=0;
            $matches=array();
            $res = preg_match($versionPattern, $fontawesomeSourcePath, $matches);
            if ($res) {
              if (isset($matches[1])) {
                $fontAweversion=$matches[1];              
              }
            }
            $this->customLogger->debug("PBD TinyFontawesome movePluginFiles Version $fontAweversion");
        
            $this->customLogger->debug('PBD TinyFontawesome movePluginFiles rcopy("vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome", "assets/tinymce4/js/plugins/fontawesome"');
            $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome', 'assets/tinymce4/js/plugins/fontawesome');
            switch ($fontAweversion) {
              case 4:
                $this->customLogger->debug("PBD TinyFontawesome movePluginFiles Version switch 4");
                $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/fontawesome/css/fontawesome-free-4.7.0-web/', 'assets/font-awesome/webfonts/');
                break;
              case 5:
                $this->customLogger->debug("PBD TinyFontawesome movePluginFiles Version switch 5");
                $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/fontawesome/css/fontawesome-free-5.12.0-web/', 'assets/font-awesome/webfonts/');
                break;
              case 6:
                $this->customLogger->debug("PBD TinyFontawesome movePluginFiles Version switch 6");
                $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/fontawesome/css/fontawesome-free-6.4.0-web/', 'assets/font-awesome/webfonts/');
                break;
              default:
                $this->customLogger->debug("PBD TinyFontawesome movePluginFiles Version switch default");
                $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/fontawesome/css/fontawesome-free-6.4.0-web/', 'assets/font-awesome/webfonts/');
                break;
            }            
            $objFile = new \File('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome/copied.txt', true);
            $objFile->append('Plugin files "assets/tinymce4/js/plugins/fontawesome/*" already copied to the assets directory in "assets/tinymce4/js/plugins/fontawesome".');
            $objFile->close();
            $this->customLogger->debug('PBD TinyFontawesome movePluginFiles kopiert');
        //} else {
            $this->customLogger->debug('PBD TinyFontawesome movePluginFiles wurde schon kopiert. Siehe vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome/copied.txt');
        //}

    }

}