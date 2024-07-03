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

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
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

        .profile-icon {
            color: white;
            cursor: pointer;
        }

        .dropdown-menu {
            width: 250px;
        }

        .dropdown-header {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>

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






    <div class="">

        <div class="row">

            <div class="col-6">
                <div class="card-header h4 panel-header font-weight-600">
                    Route History
                </div>
                <table>
                    @csrf
                    @foreach ($routes as $group => $coordinates)
                        <b>
                            <p>Route {{ $group }}</p>
                        </b>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coordinates as $coordinate)
                                    <tr>
                                        <td>{{ $coordinate->latitude }}</td>
                                        <td>{{ $coordinate->longitude }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type ="button" class="btn btn-primary"
                            onclick="handleButtonClick({{ $group }})">View

                        </button>

                        <script>
                            // Store the coordinates in a JavaScript variable
                            //REMEMBER THAT THE LEAFLET USES LONG-LAT PAIR INSTEAD OF LATLONG PAIR. 
                            //INTERCHANGING THE ORDER WILL GIVE US THE LONG-LAT PAIR AS AN ARRAY. 
                            //LONG-LAT ARRAY
                            var group{{ $group }}Coordinates = [
                                @foreach ($coordinates as $coordinate)
                                    [{{ $coordinate->longitude }}, {{ $coordinate->latitude }}],
                                @endforeach
                            ];
                            var group{{ $group }}Profile = "{{ $coordinates->first()->profile }}";
                        </script>
                    @endforeach
                </table>

            </div>
            <div class="col-6">
                {{-- <div class="card-header h4 panel-header font-weight-600">
                    Map
                </div> --}}
                <div class="card w-100 h-100">
                    <div id="map" class="h-100 w-100 min-vh-100">

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var map = L.map('map').setView([45.9432, 24.9668], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let routeLayers = new L.LayerGroup();
        routeLayers.addTo(map);

        function handleButtonClick(group) {
            let coordinates;
            let profile = 'driving-car';

            // Get the coordinates array based on the group number

            switch (group) {
                @foreach ($routes as $group => $coordinates)
                    case {{ $group }}:
                        coordinates = group{{ $group }}Coordinates;
                    profile = group{{ $group }}Profile;

                    break;
                @endforeach
            }

            console.log(profile);

            if (coordinates && coordinates.length > 0) {
                //interchange lat long
                map.setView([coordinates[0][1], coordinates[0][0]], 13);
            }

            // Example: Log the coordinates to the console
            console.log('Coordinates for Group ' + group + ':', coordinates);



            const data = {
                coordinates: coordinates,
                profile: profile
            };




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

                //attatch the marker again. the data now comes from coordinates

                for (let i = 0; i < coordinates.length; i++) {
                    let popup = L.popup()
                        .setContent('Lat: ' + coordinates[i][1].toString().substring(0, 8) +
                            '<br>' + 'Long: ' +
                            coordinates[i][0].toString().substring(0, 8));

                    let marker = L.marker([coordinates[i][1], coordinates[i][0]]).bindPopup(popup);
                    routeLayers.addLayer(marker);
                }

                //then we will attach the response geojson as a polyline. 
                let polyLine = L.geoJSON(data);
                routeLayers.addLayer(polyLine);

            }, function(response) {
                console.log(response);
                $('.server-error').removeClass('d-none');

            });


        }
    </script>



</body>

</html>
