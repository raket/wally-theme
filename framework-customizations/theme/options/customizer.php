<?php

$options = array(
    'color_theme_section' => array(
        'title' => __('Grafisk profil', 'wally'),
        'options' => array(

            'color_theme' => array(
                'type' => 'select',
                'value' => 'red',
                'label' => __('Välj grundfärg', 'wally'),
                'desc' => __('Det här bestämmer vilken färg som används i huvudsak på din sida', 'wally'),
                'help' => __('Du kan be din utvecklare att bygga in fler färgteman', 'wally'),
                'choices' => array(
                    'blue' => __('Blå', 'wally'),
                    'red' => __('Röd', 'wally'),
                    'green' => __('Grön', 'wally'),
                    'purple' => __('Lila', 'wally'),
                    'pink' => __('Rosa', 'wally'),
                    'cobalt' => __('Gråblå', 'wally'),
                ),
                /**
                 * Allow save not existing choices
                 * Useful when you use the select to populate it dynamically from js
                 */
                'no-validate' => false,
            ),
            'logo' => array(
                'type' => 'upload',
                'value' => array(),
                'label' => __('Logotyp', 'wally'),
                'desc' => __('Ladda upp företagslogotyp', 'wally'),
                'images_only' => true,
            )
        ),
    ),

    'typography_section' => array(
        'title' => __('Typografi', 'wally'),
        'options' => array(

            'heading_font' => array(
                'type' => 'select',
                'value' => 'roboto',
                'label' => __("Välj typsnitt för rubriker", 'wally'),
                'desc' => __("Det valda typsnittet kommer att användas för <b>rubriker</b> på hela sidan", 'wally'),
                'choices' => array(
                    'roboto' => 'Roboto',
                    'arial' => 'Arial',
                    'source-sans-pro' => 'Source Sans Pro',
                    'trebuchet-ms' => 'Trebuchet MS',
                    'verdana' => 'Verdana',
                    'creepster' => 'Creepster',
                ),
                'no-validate' => false,
            ),
            'body_font' => array(
                'type' => 'select',
                'value' => 'roboto',
                'label' => __('Välj typsnitt för brödtext', 'wally'),
                'desc' => __("Det valda typsnittet kommer att användas för <b>brödtext</b> på hela sidan", 'wally'),
                'choices' => array(
                    'roboto' => 'Roboto',
                    'arial' => 'Arial',
                    'source-sans-pro' => 'Source Sans Pro',
                    'trebuchet-ms' => 'Trebuchet MS',
                    'verdana' => 'Verdana'
                ),
                'no-validate' => false,
            ),
        ),
    ),


    'layout_section' => array(
        'title' => 'Layout',
        'options' => array(

            'sidebar_setting' => array(
                'type' => 'select',
                'value' => 'left',
                'label' => 'Placering av sidomeny',
                'desc' => 'Välj om sidomenyn ska synas till vänster eller höger om innehållet',
                'choices' => array(
                    'left' => 'Vänster om innehållet',
                    'right' => 'Höger om innehållet',
                ),
                'no-validate' => false,
            ),

            'image_height' => array(
                'type' => 'select',
                'value' => 'low-images',
                'label' => 'Bildhöjd',
                'desc' => 'Välj om en artikels utvalda bild ska ha en hög eller låg höjd',
                'choices' => array(
                    'low-images' => 'Låga artikelbilder',
                    'high-images' => 'Höga artikelbilder',
                ),
                'no-validate' => false,
            ),


            'header_height' => array(
                'type' => 'select',
                'value' => 'normal-header-height',
                'label' => 'Sidhuvudets höjd',
                'desc' => 'Välj om sidhuvudet ska vara högt eller lågt',
                'choices' => array(
                    'normal-header-height' => 'Normal höjd',
                    'high-header-height' => 'Extra hög höjd',
                ),
                'no-validate' => false,
            ),


            'appearance' => array(
                'type' => 'select',
                'value' => 'appearance-boxes',
                'label' => 'Innehållets utseende',
                'desc' => 'Välj om innehållet ska avskiljas i lådor, med linjer eller inte alls',
                'choices' => array(
                    'appearance-boxes' => 'Innehåll i lådor',
                    'appearance-border' => 'Avskilj med linje',
                    'appearance-flat' => 'Avskilj inte alls',
                ),
                'no-validate' => false,
            ),
        ),
    ),

);