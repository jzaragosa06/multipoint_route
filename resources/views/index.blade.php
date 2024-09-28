# Copyright (c) [Year] [Author Name]
# Licensed under the MIT License. See the LICENSE file for more details.

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            height: 700px;
            width: 900px;
        }

        .navbar {
            /* background-color: #006666; */
            background-color: rgba(119, 136, 153, 0.742);

        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: white;
            font-weight: bold;
        }

        .content {
            display: flex;
            height: calc(100vh - 56px);
            /* Full height minus navbar height */
        }

        .center-card {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;

        }

        .dropdown-menu {
            width: 250px;
        }

        .dropdown-header {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>


</head>

<body>
    <nav class = "navbar navbar-expand-lg navbar-dark">
        <a class = "navbar-brand" href="/index">ROUTE PLANNER</a>
        <div class = "collapse navbar-collapse">
            <ul class = "navbar-nav ml-auto">

                <li class = "nav-item">
                    <a class = "nav-link" href="/history">History</a>
                </li>
                <li class = "nav-item">
                    <a class = "nav-link" href="#"> About</a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="profileDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="las la-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <h5 class="dropdown-header">Profile</h5>
                        <div class="dropdown-item">Name: {{ session('name') }}</div>
                        <div class="dropdown-item">Email: {{ session('email') }}</div>
                        <div class="dropdown-item">UserID: {{ session('userid') }}</div>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
    <div class="content">

        <div class="container-fluid m-0 p-0">
            <div class="row no-gutters">
                <div class="col-5" style="overflow-y: auto; height: 100vh">
                    <div class="card border-0">
                        <div class="card-header h4 panel-header font-weight-600">
                            Route
                        </div>
                        <div class="card-body">

                            <div class="font-weight-600 h5">
                                Chose the waypoints :
                            </div>

                            <form class="form" method="" action="">
                                @csrf

                                <div class="coords-list-container">
                                    <div class="py-3 point-pair-container">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-2">
                                                <span class="la la-map-marker la-2x"></span>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-group row">
                                                    <div class="col-4 small">
                                                        Latitude :
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" class="form-control form-control-sm"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row pb-0 mb-0">
                                                    <div class="col-4 small">
                                                        Longitude :
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" class="form-control form-control-sm"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <button type="button"
                                                    class="btn btn-light remove-coords-btn
                                                                    d-none">
                                                    <span class="la la-close la-lg"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="py-3 point-pair-container">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-2">
                                                <span class="la la-map-marker la-2x"></span>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-group row">
                                                    <div class="col-4 small">
                                                        Latitude :
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" class="form-control form-control-sm"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row pb-0 mb-0">
                                                    <div class="col-4 small">
                                                        Longitude :
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" class="form-control form-control-sm"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <button type="button"
                                                    class="btn btn-light remove-coords-btn
                                                                    d-none">
                                                    <span class="la la-close la-lg"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-2 text-right">
                                    <button type="button" class="btn btn-secondary" id="new-coordinates-pair-button">
                                        <span class="la la-plus la-lg"></span>
                                    </button>
                                </div>

                                <div class="py-3 small">
                                    <div class="form-group row pb-0 mb-0">
                                        <div class="col-2"></div>
                                        <div class="col-4">
                                            Walking/Car ? :
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="custom-control custom-radio
                                                             d-inline-flex align-items-center">
                                                <input type="radio" id="radio-mers" name="tip-deplasare"
                                                    class="custom-control-input" value="foot-walking">
                                                <label class="custom-control-label" for="radio-mers">
                                                    Walking
                                                </label>
                                            </div>
                                            <div
                                                class="custom-control custom-radio
                                                             d-inline-flex align-items-center ml-3">
                                                <input type="radio" id="radio-masina" name="tip-deplasare"
                                                    class="custom-control-input" value="driving-car" checked="">
                                                <label class="custom-control-label" for="radio-masina">
                                                    Car
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-2 text-right">
                                    <button type="reset" class="btn btn-light ml-2">
                                        Reset
                                    </button>
                                    <button type="button" class="btn btn-primary ml-2 submit-btn">
                                        Search Route
                                    </button>
                                    <div class="d-flex justify-content-center mt-3">
                                        <div class="spinner-border" role="status" id="loadingSpinner">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>

                                </div>

                                <div class="py-2 alert alert-danger invalid-input d-none">
                                    One or more fields are not valid. <br>
                                    Check if you filled the waypoints properly. <br>
                                    Each waypoint must have the latitude and longitude set. <br>
                                    You must set at least 2 waypoints <br>
                                    The waypoints must be unique, every waypoint must represent different map
                                    coordinates.
                                    <br>
                                    Latitude must have values between -90 and 90.
                                    <br>
                                    Longitude must have values between -180 and 180.
                                    <br>
                                </div>

                                <div class="py-2 alert alert-danger server-error d-none">
                                    System error. Please try again.
                                </div>

                            </form>



                            <hr>

                            <div class="font-weight-600 h5 my-4">
                                Route details :
                            </div>

                            <div class="route-result-container mb-3">



                            </div>
                            <div class="save-result-container mb-3">

                                <div class="py-2 text-right">

                                    <button type="button" class="btn btn-primary ml-2 save-btn">
                                        Save Route
                                    </button>


                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-7">

                    <div class="card-header h4 panel-header font-weight-600">
                        Map
                    </div>
                    <div class="card w-100 h-100">
                        <div id="map" class="h-100 w-100 min-vh-100">

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!--
        <div class="right-pane"></div> -->
    </div>

    <script>
        $(document).ready(function() {
            var map = L.map('map').setView([45.9432, 24.9668], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            //hide save button 
            $('.save-btn').hide();


            // that alone (above) gives us a map layer. it will render route, but we cannot add a route polyline later on. 
            // we need to add a layer where we can add a route later on. 
            //practically, this is not a layer solely for the route. 
            //this is a object of group of layer. 

            let routeLayers = new L.LayerGroup();
            routeLayers.addTo(map);


            //for loading indicator
            const loadingSpinner = document.getElementById('loadingSpinner');
            loadingSpinner.style.display = 'none';
            //--------------------

            function addPointPairContainer() {
                let elToClone = $('.point-pair-container').first().clone();

                // Reset the input
                elToClone.find('input').each(function(index, el) {
                    $(el).val('');
                });
                elToClone.find('.remove-coords-btn').removeClass('d-none');

                $('<hr>').appendTo('.coords-list-container');
                elToClone.appendTo('.coords-list-container');
            }

            //adding an additional container for stops.
            $('form').on('click', '#new-coordinates-pair-button', function() {

                addPointPairContainer();

            });



            //add marker
            //basically, it is not only abutton or an element we can associate with an onclick function
            //we can associate it with an object
            //map object 
            //the argument contains the coordinates.
            map.on('click', function(ev) {
                let popup = L.popup()
                    .setContent('Lat: ' + ev.latlng.lat.toString().substring(0, 8) +
                        '<br>' + 'Long: ' + ev.latlng.lng.toString().substring(0, 8));

                let marker = L.marker(ev.latlng).bindPopup(popup).openPopup();

                routeLayers.addLayer(marker);

                //this is for adding the coordinates to the input field
                //the idea is to look for the input empty input field. 
                //iterate throguh each pair container and look for the empty field


                //assume first that there is no empty field
                let emptyField = true;
                $('.point-pair-container').each(function(pointIndex, pointEl) {
                    if ($(pointEl).find('input').get(0).value.trim() === '' && $(pointEl).find(
                            'input').get(1).value.trim() === '') {

                        $(pointEl).find('input').get(0).value = ev.latlng.lat;
                        $(pointEl).find('input').get(1).value = ev.latlng.lng;
                        emptyField = false;
                        return false;

                    }
                });


                //but at the same time, we need to take into account the case 
                //wherein there is no empty field and we need to dynamically add the fields. 
                if (emptyField == true) {
                    //if there are no available fields, add
                    addPointPairContainer();
                    $('.point-pair-container').last().find('input').get(0).value = ev.latlng.lat;
                    $('.point-pair-container').last().find('input').get(1).value = ev.latlng.lng;



                }




            });


            //handle remove coordinates pair
            //the remove coordinates button is only available tot he last coordinate pair input container. 
            //and it is available only when the cointainer are > 2



            // Handle remove coordinates pair
            $('form').on('click', '.remove-coords-btn', function(event) {
                let $container = $(this).closest('.point-pair-container');
                let inputLat = parseFloat($container.find('input').eq(0).val());
                let innputLng = parseFloat($container.find('input').eq(1).val());


                //each layer in object routelayer corresponts to a marker. iterate trough each layer
                //fetch the lat lang and compare
                routeLayers.eachLayer(function(layer) {
                    if (layer instanceof L.Marker) {
                        let latlng = layer.getLatLng();
                        if (latlng.lat === inputLat && latlng.lng === innputLng) {
                            routeLayers.removeLayer(layer);
                        }
                    }
                });

                $container.prev('hr').remove();
                $container.remove();


            });

            //reset form
            $('form').on('click', 'button[type=reset]', function() {
                $('.save-btn').hide();

                $('.point-pair-container').each(function(index, el) {
                    //the start and end point-pair-container are the index 0 and 1 res. 
                    if (index == 1 || index == 0) {

                    } else {
                        $(el).prev('hr').remove();
                        $(el).remove();
                    }



                    $('.invalid-input').addClass('d-none');
                    $('.server-error').addClass('d-none');

                    $('.route-result-container').empty();
                    routeLayers.clearLayers();


                });
            });



            function validateLatitude(lat) {
                if (Number(lat) !== lat || lat > 90 || lat < -90) {
                    throw 'Invalid latitude supplied.';
                }
            }

            function validateLongitude(long) {
                if (Number(long) !== long || long > 180 || long < -180) {
                    throw 'Invalid longitude supplied.';
                }
            }



            $('form').on('click', '.submit-btn', function(event) {
                loadingSpinner.style.display = 'block';

                routeLayers.clearLayers();

                let coords = [];
                let profile = $('input[name="tip-deplasare"]:checked').val().trim();

                try {
                    $('.point-pair-container').each(function(coordsIndex, coordsEl) {
                        if ($(coordsEl).find('input').get(0).value.trim() === '' &&
                            $(coordsEl).find('input').get(1).value.trim() === '') {
                            return;
                        }

                        let lat = parseFloat($(coordsEl).find('input').get(0).value);
                        let long = parseFloat($(coordsEl).find('input').get(1).value);

                        validateLatitude(lat);
                        validateLongitude(long);

                        // Check if segment is unique
                        for (let i = 0; i < coords.length; i++) {
                            if (coords[i][0] === long && coords[i][1] === lat) {
                                throw 'All segments should be unique.';
                            }
                        }

                        coords.push([long, lat]);
                    });
                } catch (e) {
                    console.log(e);
                }

                if (coords.length < 2) {
                    $('.invalid-input').removeClass('d-none');
                    return;
                }

                console.log(coords);

                const data = {
                    coordinates: coords,
                    profile: profile
                };

                function formatDuration(seconds) {
                    let formattedDuration = '';
                    let delta = Math.abs(seconds);

                    // Get days
                    let days = Math.floor(delta / 86400);
                    delta -= days * 86400;

                    if (days !== 0) {
                        formattedDuration += days.toString() + ' days';
                    }

                    // Get hours
                    let hours = Math.floor(delta / 3600) % 24;
                    delta -= hours * 3600;

                    if (hours !== 0) {
                        formattedDuration += ' ' + hours.toString() + ' hours';
                    }

                    // Get minutes
                    var minutes = Math.floor(delta / 60) % 60;
                    delta -= minutes * 60;

                    if (minutes !== 0) {
                        formattedDuration += ' ' + minutes.toString() + ' minutes ';
                    }

                    formattedDuration += Math.floor(delta).toString() + ' seconds ';

                    return formattedDuration;
                }

                function formatDistance(meters) {
                    if (meters < 1000) {
                        return meters.toString() + ' meters';
                    } else {
                        let km = meters / 1000;
                        return km.toFixed(3).toString() + ' km';
                    }
                }

                /**
                 * Create the DOM element that shows the general distance/duration
                 * 
                 * @param {Object} data The result data from the ajax request
                 * @returns {string}
                 */
                function buildDistanceDurationEl(data) {
                    return `
                                <div>
                                    <span>
                                        Time/Distance whole route : 
                                    </span> <br>
                                    <span class="la la-clock la-lg"></span>
                                    <span class="font-weight-600">
                                        ${formatDuration(data.features[0].properties.summary.duration)}
                                    </span>
                                    <span class="la la-ruler-horizontal la-lg ml-3"></span>
                                    <span class="font-weight-600">
                                        ${formatDistance(data.features[0].properties.summary.distance)}
                                    </span>
                                </div>`;
                }

                /**
                 * Creates the DOM element that shows a segment's details
                 * 
                 * @param {boolean} hasBgLight If the container should have a light bg
                 * @param {Array} fromCoords The start coordinates same format as they were
                 *                           sent to the server
                 * @param {Array} toCoords The end coordinates same format as they were
                 *                         sent to the server
                 * @param {number} numSegment The segment number/order
                 * @param {Object} segment The segment from the ajax result
                 * @returns {string}
                 */

                function buildSegmentEl(hasBgLight, fromCoords, toCoords, numSegment, segment) {
                    return `
                            <div class="row no-gutters py-3 ${hasBgLight ? 'bg-light' : ''} border-bottom">
                                <div class="col-2 text-center my-auto">
                                    <span class="la la-map-marker la-2x"></span>
                                </div>
                                <div class="col-10">
                                    <div class="mb-2">
                                        <span class="h5 m-0 p-0">Segment ${numSegment} :</span> <br><br>
                                        <span class="font-weight-bold">From:</span>
                                        <span class="font-weight-600">
                                            ${fromCoords[1].toString().substring(0, 8)}
                                        </span> (lat)
                                        <span class="font-weight-600">
                                            ${fromCoords[0].toString().substring(0, 8)}
                                        </span> (long) <br>
                                        <span class="font-weight-bold">To:</span>
                                        <span class="font-weight-600">
                                            ${toCoords[1].toString().substring(0, 8)}
                                        </span> (lat)
                                        <span class="font-weight-600">
                                            ${toCoords[0].toString().substring(0, 8)}
                                        </span> (long)
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-weight-bold">Time:</span> 
                                        <span class="la la-clock la-lg"></span>
                                        <span class="font-weight-600">
                                            ${formatDuration(segment.duration)}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-weight-bold">Distance:</span> 
                                        <span class="la la-ruler-horizontal la-lg ml-3"></span>
                                        <span class="font-weight-600">
                                            ${formatDistance(segment.distance)}
                                        </span>
                                    </div>
                                    <div class="mt-3 h5 p-0 mb-0">
                                        Steps:
                                    </div>
                                    ${Object.keys(segment.steps).map(function (key) {
                                    return `
                                                                                                                                                                                                                                                                                                                            <div class="pl-3">
                                                                                                                                                                                                                                                                                                                                <div class="font-weight-600">
                                                                                                                                                                                                                                                                                                                                    ${key + '.'} ${segment.steps[key].instruction}
                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                <span class="la la-clock la-lg"></span>
                                                                                                                                                                                                                                                                                                                                <span>${formatDuration(segment.steps[key].duration)}</span> - 
                                                                                                                                                                                                                                                                                                                                <span class="la la-ruler-horizontal la-lg ml-3"></span>
                                                                                                                                                                                                                                                                                                                                <span>${formatDistance(segment.steps[key].distance)}</span>
                                                                                                                                                                                                                                                                                                                            </div>`;
                                    }).join("")}
                                </div>
                            </div>`;
                }


                /**
                 * Create the DOM element that shows the general distance/duration
                 * 
                 * @param {Object} data The result data from the ajax request
                 * @returns {undefined} 
                 */


                function attachResultToDOM(data) {
                    let resultString = '';

                    resultString += buildDistanceDurationEl(data);

                    for (let i = 0; i < data.features[0].properties.segments.length; i++) {
                        resultString += buildSegmentEl(
                            i % 2 === 0 ? false : true,
                            data.metadata.query.coordinates[i],
                            data.metadata.query.coordinates[i + 1],
                            i + 1,
                            data.features[0].properties.segments[i]);
                    }

                    $('.route-result-container').empty();
                    $('.route-result-container').append(resultString);
                }

                //we need to make a request to the server, but indirectly. 
                //we will send a request to a route. the controller function for that route will send 
                //request to an api and get a response. 
                //we will then return the response to this page. 

                //for this one we will use ajax to send a request. 
                //we will do this by sending data via a route
                //be sure to include the jquery cdn.


                // Make the API call to the proxy server
                $.ajax('/proxy', {
                    contentType: 'application/json',
                    dataType: 'json',
                    method: 'POST',
                    data: JSON.stringify(data),
                    processData: false
                }).then(function(data) {

                    //practically the data contain the response. in this case, a polyline because the 
                    //directions/driving-car/geojson api returns a route for multiple waypoints. 
                    //this response (geojson) can be rendered into the map as a poly line. 

                    //attatch the marker again. the data now comes from coords

                    for (let i = 0; i < coords.length; i++) {
                        let popup = L.popup()
                            .setContent('Lat: ' + coords[i][1].toString().substring(0, 8) +
                                '<br>' + 'Long: ' +
                                coords[i][0].toString().substring(0, 8));

                        let marker = L.marker([coords[i][1], coords[i][0]]).bindPopup(popup);
                        routeLayers.addLayer(marker);
                    }

                    //then we will attach the response geojson as a polyline. 

                    let polyLine = L.geoJSON(data);
                    routeLayers.addLayer(polyLine);
                    attachResultToDOM(data);

                    loadingSpinner.style.display = 'none';

                    // Show save button if there is content in the route-result-container
                    if ($('.route-result-container').children().length > 0) {
                        $('.save-btn').show();
                    } else {
                        $('.save-btn').hide();
                    }

                }, function(response) {
                    console.log(response);
                    $('.server-error').removeClass('d-none');
                    loadingSpinner.style.display = 'none';

                });

            });

            //event for saving the coordinates to the database. we're adding an onclick event.
            $('.save-btn').click(function() {
                //we need to extrac the coordinates
                let coordinates = [];
                let profile = $('input[name="tip-deplasare"]:checked').val().trim();

                //we need to iterate through each point-pair-container 
                // and select the input 1 for lat and input 2 for lng. 
                $('.point-pair-container').each(function() {
                    let lat = $(this).find('input').eq(0).val().trim();
                    let lng = $(this).find('input').eq(1).val().trim();

                    //we need to take into account the case when the container is empty of values. 
                    if (lat !== '' && lng !== '') {
                        //we can add this to the coordinates. 
                        coordinates.push({
                            lat: lat,
                            lng: lng
                        });
                    }

                });

                //then make a request. 
                $.ajax({
                    url: '/save-location',
                    type: 'POST',
                    data: {
                        profile: profile,
                        coordinates: coordinates,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token

                    },
                    success: function(response) {
                        alert('route saved successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred while saving the route.');
                    }

                });
            });










        });
    </script>




</body>

</html>
