<?php

class Elite_Vafnote_Model_Import extends Ne8Vehicle_Import_Abstract
{

    function import()
    {
        $this->getFieldPositions();
        while ($row = $this->getReader()->getRow())
        {
            $this->importRow($row);
        }
    }

    function importRow($row)
    {
        $code = $this->getFieldValue('code', $row);
        $message = $this->getFieldValue('message', $row);

        $finder = new Elite_Vafnote_Model_Finder();
        $finder->insert($code, $message);
    }

}