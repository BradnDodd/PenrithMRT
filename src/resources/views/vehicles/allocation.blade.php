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
                <div class="col-6">
                    <table class="table text-center">
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
                <div class="col-6">
                    <div class="row row-cols-1 row-cols-md-1 g-4">
                        @foreach ($vehicles as $vehicle)
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">{{ $vehicle['name'] }}</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach ($vehicle['seats'] as $seatNumber => $seatName)
                                        <li class="list-group-item">{{ $seatNumber }} -> {{ $seatName }} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
