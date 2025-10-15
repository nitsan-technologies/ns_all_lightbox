<?php

defined('TYPO3') or die();

$extKey = 'ns_all_lightbox';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ns_all_lightbox',
    'Configuration/TypoScript',
    'All In One Lightbox/Modalbox'
);
