<?php

/**
 * @package     omeka
 * @subpackage  neatline-RecordImport
 * @copyright   2018 King's College London
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */
class NeatlineRecordImportPlugin extends Omeka_Plugin_AbstractPlugin
{
    const ID = 'recordimport';

    protected $_hooks = array(
        'define_routes'
    );

    protected $_filters = array(
        'admin_navigation_main'
    );

    /**
     * Register admin navigation menu
     *
     * @param array $args Contains routes
     */
    public function hookDefineRoutes($args)
    {
        $args['router']->addConfig(new Zend_Config_Ini(NL_RECORD_DIR . '/routes.ini'));
    }

    /**
     * Register admin navigation menu
     *
     * @param array $tabs Array of tabs
     * @return array Returns modified array with Neatline Record Import tab
     */
    public function filterAdminNavigationMain($tabs)
    {
        $tabs[] = array('label' => 'Neatline Record Import', 'uri' => url('record-import'));
        return $tabs;
    }
}
