<?php

/**
 * Extension Manager/Repository config file for ext "jlc_template".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'JLC Template',
    'description' => 'Sitepackage for TYPO3 from CodeBomb-Websolutions',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '10.2.0-11.9.99',
            'fluid_styled_content' => '10.2.0-10.4.99',
            'rte_ckeditor' => '10.2.0-10.4.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Cbw\\CbwTemplate\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Benjamin Bomberg',
    'author_email' => 'benjamin.bomberg@codebomb-websolutions.de',
    'author_company' => 'CodeBomb-Websolutions',
    'version' => '1.0.2',
];
