<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.01.2017
 * Time: 21:36
 */

namespace PBDKN\ContaoTinymcePluginFontawesomeBundle;


/**
 * Class TinymceNewslink
 * @package Markocupic\ContaoTinymcePluginNewslinkBundle
 */
class TinymceNewslink
{
    /**
     * Get all News items as json_encoded array
     * @author Marko Cupic
     * @author Peter Broghammer
     * @return string
     */
    public static function getContaoNewsArchivesAsJSON()
    {
        $arrNews = array();
        $arrArchives = array();
        $oArchive = \Database::getInstance()->execute("SELECT * FROM tl_news_archive");
        while ($oArchive->next())
        {
            $oNews = \Database::getInstance()->prepare("SELECT * FROM tl_news WHERE pid=?")->execute($oArchive->id);
            while ($oNews->next())
            {
                if ($oNews->published)
                {
                    $arrNews['archive_' . $oArchive->id][] = array('value' => $oNews->id, 'text' => htmlspecialchars(html_entity_decode($oNews->headline)));
                }
            }
            // Do not list archive, if there is no item
            if (isset($arrNews['archive_' . $oArchive->id]))
            {
                $arrArchives[] = array('value' => $oArchive->id, 'text' => htmlspecialchars(html_entity_decode(strtoupper($oArchive->title))));
            }
        }
        
        return array('archives' => $arrArchives, 'news' => $arrNews);
    }


    /**
     * loadLanguageData-Hook
     * @param $strName
     * @param $strLanguage
     */
    public function loadLanguageData($strName, $strLanguage)
    {
        if ($strName == 'default')
        {
            $GLOBALS['TINYMCE']['SETTINGS']['CONFIG_ROW']['newslink_language_data'] = json_encode($GLOBALS['TL_LANG']['TINYMCE']['NEWSLINK']);
        }

    }

    /**
     * Initialize System Hook
     * Runonce
     * Copy plugin sources to assets/tinymce4/js/plugins/newslink
     */
    public function movePluginFiles()
    {
        $oFiles = \Files::getInstance();
        if (!is_file(TL_ROOT . '/vendor/markocupic/contao-tinymce-plugin-newslink-bundle/src/Resources/tinymce4/js/plugins/newslink/copied.txt'))
        {
            $oFiles->rcopy('vendor/markocupic/contao-tinymce-plugin-newslink-bundle/src/Resources/tinymce4/js/plugins/newslink', 'assets/tinymce4/js/plugins/newslink');
            $objFile = new \File('vendor/markocupic/contao-tinymce-plugin-newslink-bundle/src/Resources/tinymce4/js/plugins/newslink/copied.txt', true);
            $objFile->append('Plugin files "assets/tinymce4/js/plugins/newslink/plugin.min.js" already copied to the assets directory in "assets/tinymce4/js/plugins/newslink".');
            $objFile->close();
        }

    }

}
