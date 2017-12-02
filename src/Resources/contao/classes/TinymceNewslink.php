<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.01.2017
 * Time: 21:36
 */

namespace Markocupic\ContaoTinymcePluginNewslinkBundle;


/**
 * Class TinymceNewslink
 * @package Markocupic\ContaoTinymcePluginNewslinkBundle
 */
class TinymceNewslink
{
    /**
     * Get all News items as json_encoded array
     * @author Marko Cupic
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

}
