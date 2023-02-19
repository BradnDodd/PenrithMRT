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
        // Remove people who are going direct from allocation
        $membersGoingDirect = array_filter(
            $spreadsheetData['users'],
            function($value){
                return str_contains($value['sarcall_response'], 'direct');
            }
        );

        $potentialDrivers = array_filter(
            $spreadsheetData['users'],
            function($value) use ($membersGoingDirect){
                if (!empty($membersGoingDirect[$value['Full Name']])) {
                    return false;
                }

                return !empty($value['Driving']);
            }
        );

        $potentialCasCarers = array_filter(
            $spreadsheetData['users'],
            function($value) use ($membersGoingDirect){
                if (!empty($membersGoingDirect[$value['Full Name']])) {
                    return false;
                }

                return !empty($value['CAS- Care']);
            }
        );
        $availableVehicles = $this->getAvailableVehicles();
        $vehicleAllocation = $availableVehicles;

        // Assign all our drivers and CAS carers first
        foreach ($availableVehicles as $vehicleNumber => $vehicle) {
            // Assign a driver to this vehicle and remove them from the pool of potential drivers
            if (empty($vehicle['driver'])) {
                $selectedDriver = reset($potentialDrivers);
                if (!empty($selectedDriver)) {
                    $vehicleAllocation[$vehicleNumber]['driver'] = $selectedDriver;
                    $vehicleAllocation[$vehicleNumber]['seats'][1] = $selectedDriver;
                    unset($potentialDrivers[$selectedDriver['Full Name']]);
                    // If they are driving we don't also want them as a CAS carer
                    unset($potentialCasCarers[$selectedDriver['Full Name']]);
                }
            }

            if (empty($vehicle['casCarer'])) {
                foreach ($potentialCasCarers as $selectedCasCarer) {
                    // If the next vehicle doesn't have a driver yet, don't assign a CasCarer who can also drive
                    if (
                        empty($availableVehicles[$vehicleNumber + 1]['driver'])
                        && !empty($selectedCasCarer['Driving'])
                    ) {
                        continue 1;
                    }

                    $vehicleAllocation[$vehicleNumber]['casCarer'] = $selectedCasCarer;
                    $vehicleAllocation[$vehicleNumber]['seats'][2] = $selectedCasCarer;
                    unset($potentialCasCarers[$selectedCasCarer['Full Name']]);

                    break 1;
                }
            }
        }

        $remainingPassengers = array_merge($potentialDrivers, $potentialCasCarers);
        // Fill remaining seats
        foreach ($vehicleAllocation as $vehicleNumber => $vehicle) {
            foreach ($vehicle['seats'] as $seatNumber => $seatAllocation) {
                // Seat is already filled or we don't have a driver
                if (!empty($seatAllocation) || $seatNumber == 1) {
                    continue;
                }

                $selectedPassenger = reset($remainingPassengers);

                // No more people to allocate seats to
                if (empty($selectedPassenger)) {
                    break 2;
                }
                $vehicleAllocation[$vehicleNumber]['seats'][$seatNumber] = $selectedPassenger;
                unset($remainingPassengers[$selectedPassenger['Full Name']]);
            }
        }

        $spreadsheetData['vehicles'] = $vehicleAllocation;
        $spreadsheetData['remainingPassengers'] = array_merge($membersGoingDirect, $remainingPassengers);
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


            foreach ($formattedData as $index => $value) {
                // Dodgey way of trying to remove special characters from the spreadsheets
                $formattedValue = mb_convert_encoding($value, "UTF-8", "Windows-1252");
                $formattedValue = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $formattedValue);
                $formattedData[$index] = $formattedValue;
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

            // Try to find a time out of their response
            preg_match("/([01]?[0-9]|2[0-3])[\.:]?[0-5][0-9](:[0-5][0-9])?([pm]?[am]?)/", trim($data['E']), $matches);
            $eta = 'No ETA';
            if (!empty($matches)) {
                $eta = strtotime($matches[0]);
                if (false !== $eta) {
                   $eta = date('H:i' , $eta);
                }
            }

            $fullData[trim($data['B'])] = [
                'sarcall_eta' => trim($data['D']) === 'Not Available'
                    ? 'Not Available'
                    : $eta,
                'sarcall_response' => trim($data['E']),
                'sarcall_response_time' => trim($data['F']),
            ];
        }

        return $fullData;
    }

    /**
     * Sort by earliest ETA expected,
     * then ones who have responded to sarcall alpbetically,
     * then the remaining users alphabeticall
     */
    private function sortCalloutList($a, $b)
    {
        if (empty($a['sarcall_eta']) && empty($b['sarcall_eta'])) {
            return strcmp($a['Full Name'], $b['Full Name']);
        }

        $etaA = strtotime($a['sarcall_eta']);
        $etaB = strtotime($b['sarcall_eta']);

        if (
            false === $etaA
            || false == $etaB
        ) {
            if (empty($b['sarcall_eta'])) {
                return -1;
            }

            if (empty($a['sarcall_eta'])) {
                return 1;
            }
        }

        if ($a['sarcall_eta'] == 'No ETA' && $etaB != false) {
            return 1;
        }

        if ($b['sarcall_eta'] == 'No ETA' && $etaA != false) {
            return -1;
        }

        return $etaA <=> $etaB;
    }

    private function getAvailableVehicles(): array
    {
        return [
            [
                'name' => 'Mobile 1',
                'seats' => [
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                ],
                'driver' => null,
                'casCarer' => null,
            ],
            [
                'name' => 'Mobile 2',
                'seats' => [
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                ],
                'driver' => null,
                'casCarer' => null,
            ],
            [
                'name' => 'Mobile 3',
                'seats' => [
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                ],
                'driver' => null,
                'casCarer' => null,
            ],
            [
                'name' => 'Mobile 4',
                'seats' => [
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                ],
                'driver' => null,
                'casCarer' => null,
            ]
        ];
    }
}
