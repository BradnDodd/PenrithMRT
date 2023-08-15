@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <img class="p5" height="auto" width="90%" alt="{{ config('app.name', 'Laravel') }}" src="{{ asset('homepage_1.jpg') }}"/>
                </div>
                <div class="col-md-5">
                    <h1>Donate</h1>
                    <p>
                        The Team is entirely funded by donations and all members are unpaid volunteers, willing to respond any day of the year in any weather.<br><br>
                        The operational members of the Team commit to a rigorous program of training throughout the year, covering casualty care, off-road and 'blue-light' driving, radio communications, search management and Swiftwater rescue. We respond to on average 60+ callouts a year and are on call 365 days per year, 24 hours per day.
                    </p>
                    <a class="btn btn-dark btn-lg" href="{{ route('donate') }}">Donate</a>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h1>Get Involved</h1>
                    <p>
                        Want to get involved with Penrith Mountain Rescue Team?<br><br>
                        You can join our Operational Team, attending callouts and monthly training, or you get involved with our Friends group who are non-operational Team members who do fundraising, organising events and occasionally getting involved in Team training as ‘Casualties’.
                    </p>
                    <a class="btn btn-dark btn-lg" href="{{ route('get-involved') }}">Learn more</a>
                </div>
                <div class="col-md-5">
                    <img class="p5" height="auto" width="90%" alt="{{ config('app.name', 'Laravel') }}" src="{{ asset('homepage_1.jpg') }}"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
