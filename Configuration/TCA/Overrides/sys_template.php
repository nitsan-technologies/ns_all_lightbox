<?php

defined('TYPO3_MODE') || defined('TYPO3') or die();

$extKey = 'ns_all_lightbox';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ns_all_lightbox',
    'Configuration/TypoScript',
    'All In One Lightbox/Modalbox
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ns_all_lightbox',
    'Configuration/TypoScript/VersionBelow9',
    'All In One Lightbox/Modalbox support for Below v9'
);
