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
        $unavailableUsers = [];

        foreach ($fullUserData as $userName => $user) {
            if (empty($sarcall[$userName])) {
                continue;
            }
            $fullUserData[$userName] = array_merge($fullUserData[$userName], $sarcall[$userName]);

            // Separate unavailable team members from the main call out list
            if (!empty($fullUserData[$userName]) && $fullUserData[$userName]['sarcall_eta'] == 'Not Available' ) {
                $unavailableUsers[$userName] = $fullUserData[$userName];
                unset($fullUserData[$userName]);
            }
        }

        uasort($fullUserData, [$this, 'sortCalloutList']);

        return [
            'users' => $fullUserData,
            'unavailableUsers' => $unavailableUsers,
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
        $reader->setLoadSheetsOnly(['Sarcall']);
        $spreadsheet = $reader->load(storage_path('app/callout.xlsx'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $fullData = [];

        foreach ($sheetData as $index => $data) {
            if ($this->containsOnlyNull($data)){
                continue;
            }

            $fullData[trim($data['B'])] = [
                'sarcall_eta' => trim($data['D']),
                'sarcall_response' => trim($data['E']),
                'sarcall_response_time' => trim($data['F']),
            ];
        }

        return $fullData;
    }

    private function sortCalloutList($a, $b)
    {
        $eta = strcmp($b["sarcall_eta"], $a["sarcall_eta"]);
        if (!empty($eta)) {
            return $eta;
        }

        return strcmp($a['Full Name'], $b['Full Name']);
    }
}
