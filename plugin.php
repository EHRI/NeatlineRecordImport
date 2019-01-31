<?php

/**
 * @package     omeka
 * @subpackage  neatline-RecordImport
 * @copyright   2018 King's College London
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

if (!defined('NL_RECORD_DIR')) {
    define('NL_RECORD_DIR', dirname(__FILE__));
}

// Plugin
require_once NL_RECORD_DIR . '/NeatlineRecordImportPlugin.php';

// Forms
require_once NL_RECORD_DIR . '/forms/NeatlineRecordImport_Form_Import.php';

$nfimport = new NeatlineRecordImportPlugin();
$nfimport->setUp();
