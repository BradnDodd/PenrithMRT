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
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->driving_level }}
                                    </td>
                                    <td>
                                        {{ $user->cas_care_level }}
                                    </td>
                                    <td>
                                        {{ $user->latestSarcallResponse->eta ?? ''}}
                                    </td>
                                    <td>
                                        {{ $user->latestSarcallResponse->response ?? ''}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
