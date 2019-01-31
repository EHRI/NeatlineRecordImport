<?php

/**
 * @package     omeka
 * @subpackage  neatline-RecordImport
 * @copyright   2018 King's College London
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */
class NeatlineRecordImport_Form_Import extends Omeka_Form {

    public function init() {

        parent::init();

        $this->setMethod('post');
        $this->setAttrib('id', 'record-import-form');

        // The pick an item drop-down select:
        $this->addElement('select', 'item', array(
            "required" => true,
            'label' => __('Neatline Exhibit'),
            'description' => __('Select the Neatline Exhibit that you want to import geo into.'),
            'multiOptions' => $this->getItemsForSelect(),
        ));

        $this->addElement('file', 'file', array(
            'label' => __('CSV File'),
            'description' => __('The file containing CSV data, including headers.'),
            'required' => true,
        ));

        // The submit button:

        $this->addElement('submit', 'submit', array(
            'label' => __('Import Feature')
        ));

        $this->addDisplayGroup(
            array('item', 'geo', 'zoom', 'lon', 'lat', 'layer'),
            'recordimport_info'
        );

        $this->addDisplayGroup(array('submit'), 'recordimport_submit');
    }

    private function getItemsForSelect() {
        $options = array("" => "");
        foreach (get_db()->getTable("NeatlineExhibit")->findAll() as $item) {
            $options[$item->id] = $item->title;
        }
        return $options;
    }
}