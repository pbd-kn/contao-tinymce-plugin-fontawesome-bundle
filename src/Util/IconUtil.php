<?php

declare(strict_types=1);

/*
 * This file is part of TinymcePluginFontawesomeBundle.
 *
 * Peter Broghammer
 */

namespace Pbdkn\ContaoTinymcePluginFontawesomeBundle\Util;

use Symfony\Component\Yaml\Yaml;

class IconUtil
{
    public function __construct(
        private readonly string $projectDir,                    // das ist Magic der Name $projectDir ist in /config/sevices.yaml beim Bind angegeben
        private readonly string $fontawesomeSourcePath,
        private readonly string $fontawesomeMetaFileVersion,       // bei php8 wird eine private Variable mit dem path initialisiet                                                                                                            
        private readonly array $fontawesomeStyles,
    ) {
    }

    public function getIconsAll(): array
    {
        $arrMatches = [];
        $strFile = file_get_contents($this->projectDir.'/'.$this->fontawesomeMetaFileVersion);

        $arrYaml = Yaml::parse($strFile);

        foreach ($arrYaml as $iconName => $arrItemProps) {
            if (!empty($arrItemProps['styles']) && \is_array($arrItemProps['styles'])) {
                foreach ($this->fontawesomeStyles as $style) {
                    $style = str_replace('fa-', '', $style);

                    if (\in_array($style, $arrItemProps['styles'], true)) {
                        $arrMatches[$iconName] = [
                            'id' => $iconName,
                            'faClass' => 'fa-'.$iconName,
                            'styles' => $arrItemProps['styles'],
                            'label' => $arrItemProps['label'],
                            'unicode' => $arrItemProps['unicode'],
                            'faStyles' => array_map(static fn ($faStyle) => 'fa-'.$faStyle, $arrItemProps['styles']),
                        ];
                        break;
                    }
                }
            }
        }
        //die(print_r($arrMatches,true));

        return $arrMatches;
    }
}
