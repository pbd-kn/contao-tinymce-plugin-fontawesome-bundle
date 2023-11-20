<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */
namespace Pbdkn\ContaoTinymcePluginFontawesomeBundle;
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('Pbdkn\ContaoTinymcePluginFontawesomeBundle\TinymceFontawesome', 'initMe');

// This plugin requires https://github.com/markocupic/contao-tinymce-plugin-builder-bundle
//if (isset($GLOBALS['TL_CONFIG']['useRTE'])) {
if ($GLOBALS['TL_CONFIG']['useRTE'])
{

    // Add stylesheet
    $GLOBALS['TL_CSS'][] = 'bundles/contaotinymcepluginfontawesome/css/mce-panel.css|static';

    // Add a plugin to the tinymce editor
    $GLOBALS['TINYMCE']['SETTINGS']['PLUGINS'][] = 'fontawesome';

    // Add a button to the toolbar in tinymce editor
    $GLOBALS['TINYMCE']['SETTINGS']['TOOLBAR'][] = 'fontawesome';
    $GLOBALS['TINYMCE']['SETTINGS']['EXTENDED_VALID_ELEMENTS'][] = 'button';
    $GLOBALS['TINYMCE']['SETTINGS']['EXTENDED_VALID_ELEMENTS'][] = 'i[*]';

    //$GLOBALS['TINYMCE']['SETTINGS']['CONTENT_CSS'][] = 'assets/font-awesome/webfonts/all.min.css';
    $GLOBALS['TINYMCE']['SETTINGS']['CONTENT_CSS'][] = TinymceFontawesome::getFontawesomeCssBase() . 'css/all.min.css' ;
    //$GLOBALS['TINYMCE']['SETTINGS']['CONTENT_CSS'][] = 'assets/tinymce4/js/plugins/fontawesome/css/all.min.css';

    //$GLOBALS['TINYMCE']['SETTINGS']['CONFIG_ROW']['font_awesome_path'] = "'assets/font-awesome/webfonts/all.min.css'";   // variable for plugin
    $GLOBALS['TINYMCE']['SETTINGS']['CONFIG_ROW']['font_awesome_metafile_version'] = "'".TinymceFontawesome::getFontawesomeMetaVersion()."'";   // variable for plugin
    $GLOBALS['TINYMCE']['SETTINGS']['CONFIG_ROW']['font_awesome_metafile_data'] = json_encode(TinymceFontawesome::getFontawesomeMetaData());   // variable for plugin
  
}
//}
