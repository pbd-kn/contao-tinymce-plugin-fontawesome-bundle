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
use Contao\CoreBundle\Monolog\ContaoContext;

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
        private bool $debug = false;
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
        $this->customLogger = $container->get('monolog.logger.contao');
        if ($container->getParameter('kernel.debug')) {
          $this->debug=true;
          $logPath = $container->getParameter('kernel.project_dir').'/var/logs/TinymceFontawesome.log';
          $streamHandler = new StreamHandler($logPath, Logger::INFO);
          $this->customLogger->pushHandler($streamHandler);
          $this->debugMe('PBD Konstruktor TinyFontawesome');
          $this->debugMe('PBD Konstruktor TinyFontawesome fontawesomeSourcePath '.$this->fontawesomeSourcePath);
          $this->debugMe('PBD Konstruktor TinyFontawesome fontawesomeMetaFileVersion '.$this->fontawesomeMetaFileVersion);
         }
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
     * Get metaData array
     */
    public static function getFontawesomeMetaData(): array
    {
\System::log("PBD getFontawesomeMetaData ", __METHOD__, TL_GENERAL);

        $container = \System::getContainer();           // wg. static-function
        // Den Parameter aus dem Container abrufen
        $fontawesome_meta_file_version = $container->getParameter('pbdkn_contao_tinymce_plugin_fontawesome.fontawesome_meta_file_version');
        $metaData=[];
        $objFile = new \File('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/fontawesome/css/fontawesome-free-6.4.0-web/metadata/icons.json');
        $json=$objFile->getContent();                // meta-jsonfile lesen 
        //$objFile->close();
        \System::log("PBD getFontawesomeMetaData len metadata ".strlen($json), __METHOD__, TL_GENERAL);
        // aufbereiten json Fil fontawesome version 6
        $retArray=[];
        $metaData=json_decode($json, true);
        \System::log("PBD getFontawesomeMetaData count ".count($metaData), __METHOD__, TL_GENERAL);
        foreach ($metaData as $k=>$v) {
          $icArray=[];
          $icArray['id']=$k;                    //  id
          $icArray['label']=$v['label'];           //  angezeigter name
          $icArray['unicode']=$v['unicode'];       //  code
          $icArray['family']=$v['free'];
          $icArray['styles']=$v['styles'];         //  wird als family ausgewertet
          $v['search']['terms'][]='all';
          $icArray['search']=$v['search']['terms'];//  ergibt die categorien wird um all erweitert
/*
        \System::log("PBD getFontawesomeMetaData metaData[$k]: $v", __METHOD__, TL_GENERAL);
          foreach ($v as $k1=>$v1) {
            \System::log("PBD getFontawesomeMetaData v[$k1]: $v1", __METHOD__, TL_GENERAL);
          }
*/
          $retArray[]=$icArray;
        }

        return $retArray;

    }
 
    /**
     * @author Peter Broghammer
     * @return string
     */
    public static function getFontawesomeCssBase() {
        return 'assets/font-awesome/'; // wurde durch movePluginFiles dahin kopiert wg. webspace
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
        $this->debugMe('PBD TinyFontawesome call movePluginFiles');
        //if (!is_file(TL_ROOT . '/vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome/copied.txt'))
        //{
            $this->debugMe('PBD TinyFontawesome movePluginFiles ausgefuehrt');
            $oFiles = \Files::getInstance();
            // Copy fontawe Plugin
            $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome', 'assets/tinymce4/js/plugins/fontawesome');
            $fontawesomeSourcePath = $this->fontawesomeSourcePath;
            $versionPattern = '/\/v(\d+)\.(\d+)\.(\d+)\//';
            $fontAweversion=6;   // default
            $matches=array();
            $res = preg_match($versionPattern, $fontawesomeSourcePath, $matches);
            if ($res) {
              if (isset($matches[1])) {
                $fontAweversion=$matches[1];              
              }
            }
            $this->debugMe("PBD TinyFontawesome movePluginFiles Version $fontAweversion");        
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
                $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/fontawesome/css/fontawesome-free-6.4.0-web/', 'assets/font-awesome/');
                break;
              default:
                $this->customLogger->debug("PBD TinyFontawesome movePluginFiles Version switch default");
                $oFiles->rcopy('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/fontawesome/css/fontawesome-free-6.4.0-web/', 'assets/font-awesome/webfonts/');
                break;
            }            

            $objFile = new \File('vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome/copied.txt', true);
            $objFile->append('Plugin files "assets/tinymce4/js/plugins/fontawesome/*" already copied to the assets directory in "assets/tinymce4/js/plugins/fontawesome".');
            $objFile->close();
            $this->debugMe('PBD TinyFontawesome movePluginFiles kopiert');
        //} else {
            $this->debugMe('PBD TinyFontawesome movePluginFiles wurde schon kopiert. Siehe vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome/copied.txt');
        //}

    }
    function debugMe($txt) {
        if ($this->debug) {
          $this->customLogger->info($txt);
        }
    }
}
