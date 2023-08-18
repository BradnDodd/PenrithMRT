@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Stay Safe</h1>
    <h3>What To Do In An Emergency</h3>

    <div class="d-flex justify-content-center flex-wrap">
        <div style="max-width: 300px" class="text-center">
            <img class="w-100" src="{{ asset('gather-information.png')}} " />
            <h3>Gather Information</h3>
            <ul>
                <li>Location (grid reference if possible)</li>
                <li>Name, gender and age of casualty</li>
                <li>Nature of injuries</li>
                <li>Number of people in the party</li>
                <li>Your mobile phone number</li>
            </ul>
        </div>
        <div style="max-width: 300px" class="text-center">
            <img class="w-100" src="{{ asset('dial-999.png')}} " />
            <h3>Dial 999</h3>
            <p>Dial 999 or 112, then ask for 'Police', then 'Mountain Rescue'</p>
        </div>
        <div style="max-width: 300px" class="text-center">
            <img class="w-100" src="{{ asset('give-details.png')}} " />
            <h3>Give Details</h3>
            <p>Give all your prepared details of the incident</p>
        </div>
        <div style="max-width: 300px" class="text-center">
            <img class="w-100" src="{{ asset('stay-put.png')}} " />
            <h3>Stay Put</h3>
            <p>Do NOT change your position until contacted by the Rescue Team</p>
        </div>
    </div>
    <h3>Before You Go Out</h3>
    <div class="row align-items-stretch">
        <div class="col-md-4">
            <div class="card h-100 bg-transparent border-0">
                <div class="card-body d-flex flex-column">
                    <a class="d-block mt-auto" target="_blank" href="https://www.outdooractive.com/en/routeplanner/">
                        <img class="card-img" src="{{ asset('outdoor-active.png')}} " />
                        <h3 class="card-title text-center">Plan Your Route</h3>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 bg-transparent border-0">
                <div class="card-body d-flex flex-column">
                    <a class="d-block mt-auto" target="_blank" href="https://www.mwis.org.uk/">
                        <img class="card-img" src="{{ asset('mwis.png')}} " />
                        <h3 class="card-title text-center">Check The Weather</h3>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 bg-transparent border-0">
                <div class="card-body d-flex flex-column">
                    <a class="d-block mt-auto" target="_blank" href="https://www.adventuresmart.uk/">
                        <img class="card-img" src="{{ asset('adventure-smart.png')}} " />
                        <h3 class="card-title text-center">Be Prepared</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-stretch text-center mt-5">
        <h3>With Thanks to</h3>
        <div class="col-md-4">
            <a class="" target="_blank" href="https://www.ledlenser.co.uk/">
                <img class="card-img" src="{{ asset('ledlenser.jpg')}} " />
            </a>
        </div>
        <div class="col-md-4">
            <a class="" target="_blank" href="https://www.petzl.com/GB/en">
                <img class="card-img" src="{{ asset('petzl.jpg')}} " />
            </a>
        </div>
        <div class="col-md-4">
            <a class="" target="_blank" href="https://lyon.co.uk/">
                <img class="card-img" src="{{ asset('lyon.jpg')}} " />
            </a>
    </div>
</div>
@endsection
