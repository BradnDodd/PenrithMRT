@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5 bg-white">
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
                <h3>
                    <div class="row">
                        <div class="col-8">Vehicle Allocation</div>
                        <div class="col-2">{{ \Carbon\Carbon::now()->toTimeString() }}</div>
                    </div>
                </h3>
                <div class="row row-cols-1 row-cols-md-1 g-4">
                    @foreach ($vehicles as $vehicle)
                    <div class="col">
                        <div class="card">
                            <h5 class="card-header">
                                <div class="row">
                                    <div class="col-6">{{ $vehicle['name'] }}</div>
                                    <div class="col-4"><p class="etaString">Est. Departure Time: </p><p class="etaValue">@if(empty($vehicle['eta'])) No ETA @else {{ $vehicle['eta'] }} @endif</p></div>
                                </div>
                            </h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($vehicle['seats'] as $seatNumber => $seatAllocation)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-6">
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
                                            </div>
                                            <div class="col-4">
                                                {{ $seatAllocation['sarcall_eta'] }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                    <div class="col">
                        <div class="card">
                            <h5 class="card-header">Direct</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($membersGoingDirect as $direct)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-6">
                                                {{ $direct['Full Name'] }}
                                                @if ($direct['Full Name'] == $vehicle['driver']['Full Name'])
                                                    (Driver)
                                                @endif
                                                @if (!empty($direct['CAS- Care']))
                                                    (CAS Care)
                                                @endif
                                            </div>
                                            <div class="col-4">
                                                {{ $direct['sarcall_eta'] }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <h5 class="card-header">Personal Vehicles</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($remainingPassengers as $remainingPassenger)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-6">
                                                {{ $remainingPassenger['Full Name'] }}
                                                @if ($remainingPassenger['Full Name'] == $vehicle['driver']['Full Name'])
                                                    (Driver)
                                                @endif
                                                @if (!empty($remainingPassenger['CAS- Care']))
                                                    (CAS Care)
                                                @endif
                                            </div>
                                            <div class="col-4">
                                                {{ $remainingPassenger['sarcall_eta'] }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
