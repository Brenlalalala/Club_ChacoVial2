<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf
    'orientation' => 'portrait',
    'defines' => [
        /**
         * The location of the DOMPDF font directory
         */
        "font_dir" => storage_path('fonts/'),

        /**
         * The location of the DOMPDF font cache directory
         */
        "font_cache" => storage_path('fonts/'),

        /**
         * The location of temporary directory.
         */
        "temp_dir" => sys_get_temp_dir(),

        /**
         * dompdf's "chroot"
         */
        "chroot" => realpath(base_path()),

        /**
         * Enable inline PHP
         */
        "enable_php" => false,

        /**
         * Enable inline Javascript
         */
        "enable_javascript" => false,

        /**
         * Enable remote file access
         */
        "enable_remote" => true,

        /**
         * The debug output log
         */
        "log_output_file" => null,

        /**
         * Default font family
         */
        "default_font" => "arial",

        /**
         * Default paper size
         */
        "default_paper_size" => "a4",

        /**
         * Default media type
         */
        "default_media_type" => "screen",

        /**
         * Image DPI setting
         */
        "dpi" => 96,

        /**
         * Enable font subsetting
         */
        "enable_font_subsetting" => false,

        /**
         * PDF Backend
         */
        "pdf_backend" => "CPDF",

        /**
         * Default Media Type
         */
        "default_media_type" => "screen",

        /**
         * Enable HTML5 Parsing
         */
        "enable_html5_parser" => true,
    ],
];