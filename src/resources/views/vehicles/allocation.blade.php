<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PenrithMRT Vehicle Allocation</title>

        @vite(['resources/js/app.js'])
    </head>
    <body>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-8 text-center">
                    <div class="row">
                        <h3>Callout List</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Driving</th>
                                    <th>CAS Care</th>
                                    <th>ETA</th>
                                    <th>Sarcall Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $userName => $user)
                                    <tr>
                                        <td>
                                            {{ $userName }}
                                        </td>
                                        <td>
                                            {{ $user['Driving'] }}
                                        </td>
                                        <td>
                                            {{ $user['CAS- Care'] }}
                                        </td>
                                        <td>
                                            {{ $user['sarcall_eta'] }}
                                        </td>
                                        <td>
                                            {{ $user['sarcall_response'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <h3>Unavailable Team Members</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Driving</th>
                                    <th>CAS Care</th>
                                    <th>ETA</th>
                                    <th>Sarcall Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unavailableUsers as $userName => $user)
                                    <tr>
                                        <td>
                                            {{ $userName }}
                                        </td>
                                        <td>
                                            {{ $user['Driving'] }}
                                        </td>
                                        <td>
                                            {{ $user['CAS- Care'] }}
                                        </td>
                                        <td>
                                            {{ $user['sarcall_eta'] }}
                                        </td>
                                        <td>
                                            {{ $user['sarcall_response'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4">
                    <h3>Vehicle Allocation</h3>
                    <div class="row row-cols-1 row-cols-md-1 g-4">
                        @foreach ($vehicles as $vehicle)
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">{{ $vehicle['name'] }}</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach ($vehicle['seats'] as $seatNumber => $seatAllocation)
                                        <li class="list-group-item">
                                            @isset($seatAllocation['Full Name'])
                                                {{ $seatAllocation['Full Name'] }}
                                                @if ($seatAllocation['Full Name'] == $vehicle['driver']['Full Name'])
                                                    (Driver)
                                                @endif
                                                @if (!empty($seatAllocation['CAS- Care']))
                                                    (CAS Care)
                                                @endif
                                            @else
                                                Free Seat
                                            @endisset
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">Personal Vehicles</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach ($remainingPassengers as $remainingPassenger)
                                        <li class="list-group-item">
                                            {{ $remainingPassenger['Full Name'] }}
                                            @if ($remainingPassenger['Full Name'] == $vehicle['driver']['Full Name'])
                                                (Driver)
                                            @endif
                                            @if (!empty($remainingPassenger['CAS- Care']))
                                                (CAS Care)
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
