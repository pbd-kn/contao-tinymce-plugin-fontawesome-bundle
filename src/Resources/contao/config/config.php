<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('Markocupic\ContaoTinymcePluginNewslinkBundle\TinymceNewslink', 'movePluginFiles');

// This plugin requires https://github.com/markocupic/contao-tinymce-plugin-builder-bundle
if ($GLOBALS['TL_CONFIG']['useRTE'])
{
    // Add stylesheet
    $GLOBALS['TL_CSS'][] = 'bundles/markocupiccontaotinymcepluginnewslink/css/newslink.css|static';

    // Add a plugin to the tinymce editor
    $GLOBALS['TINYMCE']['SETTINGS']['PLUGINS'][] = 'newslink';

    // Add a button to the toolbar in tinymce editor
    $GLOBALS['TINYMCE']['SETTINGS']['TOOLBAR'][] = 'newslink';


    // Add a content_css in tinymce editor

    // Add a new config row to the tinymce.init method (json_encoded array from a PHP class)
    $GLOBALS['TINYMCE']['SETTINGS']['CONFIG_ROW']['newslink_news_data'] = json_encode(Markocupic\ContaoTinymcePluginNewslinkBundle\TinymceNewslink::getContaoNewsArchivesAsJSON());

    // Add a new config row to the tinymce.init method (use the loadLanguageFile-hook)
    $GLOBALS['TL_HOOKS']['loadLanguageFile'][] = array('Markocupic\ContaoTinymcePluginNewslinkBundle\TinymceNewslink', 'loadLanguageData');
}
