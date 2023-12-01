# contao-tinymce-plugin-fontawesome-bundle

# Font Awesome tinyMce Contao Backend Widget
![Backend](docs/images/backend.png)

## Abhängigkeiten
markocupic/contao-tinymce-plugin-builder-bundle  Version >
## Funktion

## Installation

## Konfiguration
Die Konfiguration wird in `config/config.yaml` gemacht.
Sind keine Einträge vorhanden, so wir die Defaulteinstellung installiert.
Die Icons stehen im FE automatisch zu Verfügung. es ist kein <script> Eintrag im Header notwendig.

## Version 6 (default)
```yaml
pbdkn_contao_tinymce_plugin_fontawesome:
    # get sourcepath for fontawesome 
    # default
    fontawesome_source_path: 'https://use.fontawesome.com/releases/v6.4.2/js/all.js'
    # Version of the metafile
    # default
    fontawesome_meta_file_version: '6.4.2'
```
## Version 5
```yaml
pbdkn_contao_tinymce_plugin_fontawesome:
    # get sourcepath for fontawesome 
    fontawesome_source_path: 'https://use.fontawesome.com/releases/v5.12.0/js/all.js'
    # Version of the metafile
    fontawesome_meta_file_version: '5.12.0'
```

Soll nach der Installation die fontaweversion gewechselt werden, so ist die Datei 
vendor/pbd-kn/contao-tinymce-plugin-fontawesome-bundle/src/Resources/tinymce4/js/plugins/fontawesome/copied.txt
zu löschen und den Cache erneuern, 
oder das Bundle neu zu installieren.

 
