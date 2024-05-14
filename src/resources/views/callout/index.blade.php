@push('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/OrdnanceSurvey/os-api-branding@0.3.1/os-api-branding.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
    <script src="https://unpkg.com/@maplibre/maplibre-gl-leaflet@0.0.19/leaflet-maplibre-gl.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/OrdnanceSurvey/os-api-branding@0.3.1/os-api-branding.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css" />
    <style>
        #map {
            position: relative;
            height: 600px;
            width: 100%;
          }
          img.searchIcon { filter: hue-rotate(120deg); }
          img.assistIcon { filter: hue-rotate(90deg); }
          img.rescueIcon { filter: hue-rotate(270deg); }

    </style>

    <script>
        const apiKey = env('OSMAPS_API_KEY');

        // Initialize the map.
        const mapOptions = {
            minZoom: 7,
            maxZoom: 19,
            center: [ 54.658369,-2.744988 ],
            zoom: 14,
            maxBounds: [
                [ 49.528423, -10.76418 ],
                [ 61.331151, 1.9134116 ]
            ],
            attributionControl: false
        };

        jQuery(document).ready(function(e) {
            const map = L.map('map', mapOptions);

            // Load and display vector tile layer on the map.
            const gl = L.maplibreGL({
                style: 'https://raw.githubusercontent.com/OrdnanceSurvey/OS-Vector-Tile-API-Stylesheets/master/OS_VTS_3857_Outdoor.json',
                transformRequest: (url, resourceType) => {
                    if( resourceType !== 'Style' && url.startsWith('https://api.os.uk') ) {
                        url = new URL(url);
                        if(! url.searchParams.has('key') ) url.searchParams.append('key', apiKey);
                        if(! url.searchParams.has('srs') ) url.searchParams.append('srs', 3857);
                        return {
                            url: new Request(url).url
                        }
                    }
                }
            }).addTo(map)
            @foreach($allCallouts as $callout)
                var marker = L.marker([ {{ $callout->location_latitude }}, {{ $callout->location_longitude }}], {title: "{{ $callout->title }}"}).addTo(map).bindPopup("{{ $callout->description }}");
                marker._icon.classList.add("{{$callout->type}}Icon");
            @endforeach
        });

    </script>
@endpush
@extends('layouts.app')
@section('title', 'CALLOUTS')
@section('content')
<div class="container">
    <h1>Callouts</h1>
    <div id="map"></div>
        @if(count($callouts) > 0)
        <div class="flex-wrap d-flex justify-content-center">
            @foreach($callouts as $callout)
                <div style="max-width: 300px" class="text-center">
                    <img class="w-100" src="{{ asset('stay-put.png')}} " />
                    <h3>{{ $callout->start_time->format('M Y') }} {{ $callout->location }}</h3>
                    <p>{{ $callout->title }}</p>
                    <a href="/callouts/{{ $callout->id }}">Read More</a>
                </div>
            @endforeach
        </div>
        {{ $callouts->withQueryString()->links('pagination::bootstrap-5') }}
        @else
            <p>No callouts found</p>
        @endif
</div>
@endsection
