<?php

/**
 * @package     omeka
 * @subpackage  neatline-RecordImport
 * @copyright   2018 King's College London
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */
class NeatlineRecordImport_IndexController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $form = new NeatlineRecordImport_Form_Import;

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $db = get_db();

                $itemId = $form->getValue('item');
                $item = $db->getTable('NeatlineExhibit')->find($itemId);

                if ($form->getElement('deleteexisting')->isChecked()) {
                    $item->deleteChildRecords();
                }

                $rows = $this->_readData($_FILES["file"]["tmp_name"]);
                foreach ($rows as $row) {
                    $this->_createRecord($item, $row);
                }

                // Flash success.
                $this->_helper->flashMessenger(
                    __('The records were successfully imported!'), 'success'
                );

                // Redirect to browse.
                $this->_redirect('/neatline/editor/' . $itemId);
            }
        }

        $this->view->form = $form;
    }

    private function _createRecord($exhibit, $data)
    {
        $record = new NeatlineRecord;
        $record->exhibit_id = $exhibit->id;
        foreach($data as $field => $value) {
            $record->$field = $value;
        }

        if (!isset($data["coverage"]) && (isset($data["lat"]) && isset($data["lon"]))) {
            list($lon, $lat) = $this->_degreesToMetres([$data["lon"], $data["lat"]]);
            $record->coverage = "POINT($lon $lat)";
        }

        $record->save();
    }

    private function _readData($file) {
        $csv = array_map('str_getcsv', file($file));
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv); # remove column header
        return $csv;
    }

    private function _degreesToMetres($lon_lat)
    {
        $half_circumference = 20037508.34;

        $x = $lon_lat[0] * $half_circumference / 180;
        $y = log(tan((90 + $lon_lat[1]) * pi() / 360)) / (pi() / 180);
        $y = $y * $half_circumference / 180;
        return array($x, $y);
    }

}
