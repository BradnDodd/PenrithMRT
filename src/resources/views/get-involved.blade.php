@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Join The Team
        </div>
        <div class="col-md-6">
            <p>
                Penrith Mountain Rescue Team operates with approximately 40 on-call Team members and needs a steady influx of new members.
                We have one recruitment intake per year where recruits join as inductees. The inductees are assessed on the hill in various conditions and we then invite some to join the Team as probationary members.
                Probation lasts for a period of 1 year during which you will be involved in all aspects of Team activities.
            </p>
            <p>
                Download our application pack below:
            </p>
            <a href="{{ route('get-involved-download') }}">
                <button class="btn btn-primary">Penrith Mountain Rescue Team Application Pack</button>
            </a>
        </div>
    </div>
</div>
@endsection
