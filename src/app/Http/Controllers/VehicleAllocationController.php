<?php

namespace App\Http\Controllers;

use App\Helpers\CalloutSheetFilter;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VehicleAllocationController extends Controller
{
    private string $callOutSheetURL = "";

     /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $spreadsheetData = $this->getCallOutSpreadsheet();

        return view(
            'vehicles.allocation',
            $spreadsheetData
        );
    }

    public function getCallOutSpreadsheet(): array
    {
        $filterSubset = new CalloutSheetFilter();

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadFilter($filterSubset);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);

        $users = $this->parseSQEPList($reader);
        $sarcall = $this->parseSarcallResponses($reader);

        $fullUserData = $users;

        foreach ($fullUserData as $userName => $user) {
            if (empty($sarcall[$userName])) {
                continue;
            }
            $fullUserData[$userName] = array_merge($fullUserData[$userName], $sarcall[$userName]);
        }

        return [
            'users' => $fullUserData,
            'vehicles' => [
                [
                    'name' => 'Mobile 1',
                    'seats' => [
                        1 => 'Unassigned',
                        2 => 'Unassigned',
                        3 => 'Unassigned',
                        4 => 'Unassigned',
                    ],
                ],
                [
                    'name' => 'Mobile 2',
                    'seats' => [
                        1 => 'Unassigned',
                        2 => 'Unassigned',
                        3 => 'Unassigned',
                        4 => 'Unassigned',
                    ],
                ],
                [
                    'name' => 'Mobile 3',
                    'seats' => [
                        1 => 'Unassigned',
                        2 => 'Unassigned',
                        3 => 'Unassigned',
                        4 => 'Unassigned',
                    ],
                ],
                [
                    'name' => 'Mobile 4',
                    'seats' => [
                        1 => 'Unassigned',
                        2 => 'Unassigned',
                        3 => 'Unassigned',
                        4 => 'Unassigned',
                    ],
                ]
            ]
        ];
    }

    private function containsOnlyNull($input)
    {
        return empty(array_filter($input, function ($a) { return $a !== null;}));
    }

    private function parseSQEPList(&$reader): array
    {
        $sheetHeaders = [];
        $reader->setLoadSheetsOnly(['SQEP List']);
        $spreadsheet = $reader->load(storage_path('app/callout.xlsx'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $fullData = [];

        foreach ($sheetData as $index => $data) {
            if ($this->containsOnlyNull($data)){
                continue;
            }

            if (empty($sheetHeaders)) {
                $sheetHeaders = array_values($data);
                continue;
            }
            $formattedData = array_combine($sheetHeaders, array_values($data));

            // blank column
            unset($formattedData['']);
            if (empty($formattedData['Full Name'])) {
                continue;
            }

            // Placeholder for Sarcall response data
            $formattedData['sarcall_eta'] = null;
            $formattedData['sarcall_response'] = null;
            $formattedData['sarcall_response_time'] = null;

            $fullData[trim($formattedData['Full Name'])] = $formattedData;

        }

        return $fullData;
    }

    private function parseSarcallResponses(&$reader)
    {
        $sheetHeaders = [];

        $reader->setLoadSheetsOnly(['Sarcall']);
        $spreadsheet = $reader->load(storage_path('app/callout.xlsx'));
        // $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $fullData = [];

        foreach ($sheetData as $index => $data) {
            if ($this->containsOnlyNull($data)){
                continue;
            }

            $fullData[$data[1]] = [
                'sarcall_eta' => $data[3],
                'sarcall_response' => $data[4],
                'sarcall_response_time' => $data[5],
            ];
        }

        return $fullData;
    }
}
