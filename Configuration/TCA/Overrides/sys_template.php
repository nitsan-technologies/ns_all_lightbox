<?php
defined('TYPO3_MODE') or die();

$extKey = 'ns_all_lightbox';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', '[NITSAN] All In One Lightbox/Modalbox');