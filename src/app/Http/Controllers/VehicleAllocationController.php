<?php

namespace App\Http\Controllers;

use App\Enums\SarcallETAEnum;
use App\Helpers\CalloutSheetFilter;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VehicleAllocationController extends Controller
{
    private string $callOutSheetURL = "";

    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\View\View
     */
    public function show(): \Illuminate\View\View
    {
        $spreadsheetData = $this->getCallOutSpreadsheet();
        $filteredUsers = $this->filterUsersIntoRoles($spreadsheetData['users']);

        $availableVehicles = $this->getAvailableVehicles();
        $vehicleAllocation = $this->allocateMembersToVehicles($availableVehicles, $filteredUsers);

        $spreadsheetData['vehicles'] = $vehicleAllocation;
        $spreadsheetData['membersGoingDirect'] = $filteredUsers['direct'];
        $spreadsheetData = array_merge($spreadsheetData, $vehicleAllocation);

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
            if (!empty($fullUserData[$userName]) && $fullUserData[$userName]['sarcall_eta'] == SarcallETAEnum::NOT_AVAILABLE()) {
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

    private function containsOnlyNull($input): bool
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }

    private function parseSQEPList(&$reader): array
    {
        $sheetHeaders = [];
        $reader->setLoadSheetsOnly(['SQEP List']);
        $spreadsheet = $reader->load(storage_path('app/callout.xlsx'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $fullData = [];

        foreach ($sheetData as $index => $data) {
            if ($this->containsOnlyNull($data)) {
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
                $formattedValue = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', $formattedValue);
                $formattedData[$index] = trim($formattedValue);
            }

            // Remove the skill if it's expired
            $formattedData['CAS- Care'] = $this->checkSkillExpiry($formattedData['CAS- Care']);
            $formattedData['Driving'] = $this->checkSkillExpiry($formattedData['Driving']);

            // Placeholder for Sarcall response data
            $formattedData['sarcall_eta'] = SarcallETAEnum::NO_RESPONSE();
            $formattedData['sarcall_response'] = null;
            $formattedData['sarcall_response_time'] = null;

            $fullData[trim($formattedData['Full Name'])] = $formattedData;
        }

        return $fullData;
    }

    private function parseSarcallResponses(&$reader): array
    {
        $reader->setLoadSheetsOnly(['Sarcall']);
        $spreadsheet = $reader->load(storage_path('app/callout.xlsx'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $fullData = [];

        foreach ($sheetData as $index => $data) {
            if ($this->containsOnlyNull($data)) {
                continue;
            }
            $data = array_map('trim', $data);

            // Try to find a time out of their response
            preg_match("/([01]?[0-9]|2[0-3])[\.:]?[0-5][0-9](:[0-5][0-9])?([pm]?[am]?)/", $data['E'], $matches);
            $eta = SarcallETAEnum::tryFrom($data['D']);
            $eta = $eta ?? SarcallETAEnum::NO_RESPONSE();

            if (!empty($matches)) {
                $eta = strtotime($matches[0]);
                if (false !== $eta) {
                    $eta = date('H:i', $eta);
                }
            }

            $fullData[$data['B']] = [
                'sarcall_eta' => $eta,
                'sarcall_response' => $data['E'],
                'sarcall_response_time' => $data['F'],
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
        if (empty((string) $a['sarcall_eta']) && empty((string) $b['sarcall_eta'])) {
            return strcmp($a['Full Name'], $b['Full Name']);
        }

        $etaA = strtotime((string) $a['sarcall_eta']);
        $etaB = strtotime((string) $b['sarcall_eta']);

        if (
            false === $etaA
            || false == $etaB
        ) {
            if (empty((string) $b['sarcall_eta'])) {
                return -1;
            }

            if (empty((string) $a['sarcall_eta'])) {
                return 1;
            }
        }

        if ($a['sarcall_eta'] == SarcallETAEnum::NO_ETA() && $etaB != false) {
            return 1;
        }

        if ($b['sarcall_eta'] == SarcallETAEnum::NO_ETA() && $etaA != false) {
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
                    5 => '',
                ],
                'driver' => null,
                'casCarer' => null,
                'eta' => null,
            ],
            [
                'name' => 'Mobile 2',
                'seats' => [
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                    5 => '',
                ],
                'driver' => null,
                'casCarer' => null,
                'eta' => null,
            ],
            [
                'name' => 'Mobile 3',
                'seats' => [
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                    5 => '',
                ],
                'driver' => null,
                'casCarer' => null,
                'eta' => null,
            ],
            [
                'name' => 'Mobile 4',
                'seats' => [
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                    5 => '',
                ],
                'driver' => null,
                'casCarer' => null,
                'eta' => null,
            ]
        ];
    }

    private function filterUsersIntoRoles(array &$users): array
    {
        $membersGoingDirect = array_filter(
            $users,
            function ($value) {
                return str_contains($value['sarcall_response'], 'direct');
            }
        );

        $potentialDrivers = array_filter(
            $users,
            function ($value) use ($membersGoingDirect) {
                if (!empty($membersGoingDirect[$value['Full Name']])) {
                    return false;
                }

                return !empty($value['Driving']) && !str_contains($value['Driving'], 'Level 1');
            }
        );

        $potentialCasCarers = array_filter(
            $users,
            function ($value) use ($membersGoingDirect) {
                if (!empty($membersGoingDirect[$value['Full Name']])) {
                    return false;
                }

                return !empty($value['CAS- Care']);
            }
        );

        $remainingPassengers = array_filter(
            $users,
            function ($value) use ($membersGoingDirect) {
                if (!empty($membersGoingDirect[$value['Full Name']])) {
                    return false;
                }

                return empty($value['CAS- Care']) && empty($value['Driving']);
            }
        );

        return [
            'direct' => $membersGoingDirect,
            'drivers' => $potentialDrivers,
            'casCare' => $potentialCasCarers,
            'passengers' => $remainingPassengers,
        ];
    }

    /**
     * If a particular skill has expired then remove the skill from that member
     */
    private function checkSkillExpiry(string $skill): string
    {
        $formattedSkill = $skill;
        try {
            preg_match("/[Ee]xp (.*)?/", $skill, $matches);

            if (!empty($matches[1])) {
                $date = trim($matches[1]);
                $date = str_replace('/', '-', $date);
                $time = new \DateTime($date);

                $currentTime = Carbon::now();
                if ($time < $currentTime) {
                    $formattedSkill = '';
                }
            }
        } catch (\Exception) {
            // Do nothing
        }

        return $formattedSkill;
    }

    private function calculateVehicleETA(
        ?\DateTime $currentVehicleETA,
        string|SarcallETAEnum $passengerETA,
        bool $isDriver = false
    ): \DateTime|null {
        // One or more of our passengers doesn't have an ETA so we can't give the vehicle one
        if (null === $currentVehicleETA && !$isDriver) {
            return null;
        }

        if (
            in_array(
                $passengerETA,
                [
                    SarcallETAEnum::NO_ETA(),
                    SarcallETAEnum::NOT_AVAILABLE()
                ]
            )
        ) {
            return null;
        }

        $passengerETATs = strtotime($passengerETA);
        if ($isDriver && $currentVehicleETA === null) {
            return new \Datetime($passengerETA);
        }

        if ($passengerETATs > $currentVehicleETA->getTimestamp()) {
            $currentVehicleETA->setTimestamp($passengerETATs);
        }

        return $currentVehicleETA;
    }

    private function allocateMembersToVehicles(array $availableVehicles, array $filteredUsers): array
    {
        $vehicleAllocation = $availableVehicles;
        $vehiclesWithoutDrivers = count(array_filter($availableVehicles, function ($vehicle) {
            return empty($vehicle['driver']);
        }));
        $vehiclesWithoutCasCarers = count(array_filter($availableVehicles, function ($vehicle) {
            return empty($vehicle['casCarer']);
        }));

        foreach ($vehicleAllocation as $vehicleNumber => $vehicle) {
            foreach ($vehicle['seats'] as $seatNumber => $occupant) {
                if (!empty($occupant)) {
                    continue;
                }

                if (empty($vehicleAllocation[$vehicleNumber]['driver'])) {
                    $selectedDriver = reset($filteredUsers['drivers']);
                    if (!empty($selectedDriver)) {
                        $vehicleAllocation[$vehicleNumber]['driver'] = $selectedDriver;
                        $vehicleAllocation[$vehicleNumber]['seats'][$seatNumber] = $selectedDriver;
                        $vehicleAllocation[$vehicleNumber]['eta'] = $this->calculateVehicleETA(
                            $vehicleAllocation[$vehicleNumber]['eta'],
                            $selectedDriver['sarcall_eta'],
                            true
                        );

                        $vehiclesWithoutDrivers--;
                        unset($filteredUsers['drivers'][$selectedDriver['Full Name']]);
                        // If they are driving we don't also want them as a CAS carer
                        unset($filteredUsers['casCare'][$selectedDriver['Full Name']]);

                        // Seat has been assigned
                        continue 1;
                    }
                }

                if (empty($vehicleAllocation[$vehicleNumber]['casCarer'])) {
                    foreach ($filteredUsers['casCare'] as $selectedCasCarer) {
                        $vehicleAllocation[$vehicleNumber]['casCarer'] = $selectedCasCarer;
                        $vehicleAllocation[$vehicleNumber]['seats'][$seatNumber] = $selectedCasCarer;
                        // We can't leave without our driver who doesn't have an ETA so our entire vehicle doesn't have an ETA
                        $vehicleAllocation[$vehicleNumber]['eta'] = $this->calculateVehicleETA(
                            $vehicleAllocation[$vehicleNumber]['eta'],
                            $selectedCasCarer['sarcall_eta'],
                            false
                        );

                        $vehiclesWithoutCasCarers--;
                        unset($filteredUsers['drivers'][$selectedDriver['Full Name']]);
                        unset($filteredUsers['casCare'][$selectedCasCarer['Full Name']]);

                        // Seat has been assigned
                        continue 2;
                    }
                }

                $nextDriver = reset($filteredUsers['drivers']);
                $nextCasCarer = reset($filteredUsers['casCare']);
                $nextPassenger = reset($filteredUsers['passengers']);

                $possibleOccupants = [
                    $nextDriver,
                    $nextCasCarer,
                    $nextPassenger
                ];
                uasort($possibleOccupants, [$this, 'sortCalloutList']);

                foreach ($possibleOccupants as $possibleOccupant) {
                    // We won't have enough drivers for the remaning vehicles if we put this person as a passenger so skip them
                    if (
                        !empty($filteredUsers['drivers'][$possibleOccupant['Full Name']])
                        && $vehiclesWithoutDrivers >= count($filteredUsers['drivers'])
                    ) {
                        continue 1;
                    }

                    $vehicleAllocation[$vehicleNumber]['seats'][$seatNumber] = $possibleOccupant;
                    // We can't leave without our driver who doesn't have an ETA so our entire vehicle doesn't have an ETA
                    $vehicleAllocation[$vehicleNumber]['eta'] = $this->calculateVehicleETA(
                        $vehicleAllocation[$vehicleNumber]['eta'],
                        $possibleOccupant['sarcall_eta'],
                        false
                    );

                    unset($filteredUsers['drivers'][$possibleOccupant['Full Name']]);
                    unset($filteredUsers['casCare'][$possibleOccupant['Full Name']]);
                    unset($filteredUsers['passengers'][$possibleOccupant['Full Name']]);

                    // Seat has been assigned
                    continue 2;
                }
            }

            // Turn our ETA into a string for the template
            $vehicleAllocation[$vehicleNumber]['eta'] = $vehicleAllocation[$vehicleNumber]['eta'] instanceof \DateTime
                ? $vehicleAllocation[$vehicleNumber]['eta']->format('H:i')
                : '';
        }

        $remainingPassengers = array_merge($filteredUsers['passengers'], $filteredUsers['casCare'], $filteredUsers['drivers']);

        return [
            'vehicles'=> $vehicleAllocation,
            'remainingPassengers' => $remainingPassengers
        ];
    }
}
