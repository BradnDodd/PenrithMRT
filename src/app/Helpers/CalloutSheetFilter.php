<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class CalloutSheetFilter implements IReadFilter
{
    public function readCell($columnAddress, $row, $worksheetName = '')
    {
        if ($row >= 2 && $row <= 43) {
            if (in_array($columnAddress, range('A', 'O'))) {
                return true;
            }
        }

        return false;
    }
}