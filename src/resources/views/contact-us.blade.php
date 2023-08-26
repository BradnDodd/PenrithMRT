@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <h1>Contact</h1>
        <p>
            Our Team will get back to you as soon as they can. If you have a message for a specific Team member, please include this in your message.
            <br>Please use the form below to contact Penrith Mountain Rescue.
            <br>* Required Fields
        </p>
    </div>
    <div class="row">
        <div class="col-md-6">
            @if(session('message'))
                <div class='alert alert-success'>
                    {{ session('message') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" method="POST" action="/contact">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="Name">Name:* </label>
                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:* </label>
                    <input type="text" class="form-control" id="email" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:* </label>
                    <textarea type="text" class="form-control" id="message" placeholder="Enter your message here" name="message" required> </textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" value="Send">Send</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <p>
                Penrith Mountain Rescue Team<br> Isobella Carlton House<br> Tynefield Drive<br> Penrith
                <br> CA11 8JA<br>
            </p>
            <p>
                Press and Media<br>
                <a href="mailto: secretary@penrithmrt.org.uk">Secretary@penrithmrt.org.uk</a>
            </p>
        </div>
    </div>
</div>
@endsection
