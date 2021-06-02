<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Viewing</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <h1 class="text-center mt-5">
            Status Pemantauan Rumah
        </h1>
        <div class="text-center mb-5">
            <h5>
                Status Sensor :
            </h5>
            <span id="statusSensing">N/A</span>
        </div>
    </header>

    <content>
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Temperatur Udara</h5>
                            <h7 class="text text-info"><span id="temperature_loc"></span></h7>
                            <hr>
                            <span id="temperature" class="sensing-value"><strong>N/A</strong></span> °C
                            <br>
                            <span id="temperature_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_temperature">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelembaban Udara</h5>
                            <h7 class="text text-info"><span id="humidity_loc"></span></h7>
                            <hr>
                            <span id="humidity" class="sensing-value"><strong>N/A</strong></span> RH
                            <br>
                            <span id="humidity_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_humidity">N/A</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas LPG</h5>
                            <h7 class="text text-info"><span id="lpg_loc"></span></h7>
                            <hr>
                            <span id="lpg" class="sensing-value"><strong>N/A</strong></span> PPM
                            <br>
                            <span id="lpg_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_lpg">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas Karbon</h5>
                            <h7 class="text text-info"><span id="carbon_loc"></span></h7>
                            <hr>
                            <span id="carbon" class="sensing-value"><strong>N/A</strong></span> PPM
                            <br>
                            <span id="carbon_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_carbon">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Asap</h5>
                            <h7 class="text text-info"><span id="smoke_loc"></span></h7>
                            <hr>
                            <span id="smoke" class="sensing-value"><strong>N/A</strong></span> PPM
                            <br>
                            <span id="smoke_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_smoke">N/A</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center mt-4">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">pH Air</h5>
                            <h7 class="text text-info"><span id="ph_loc"></span></h7>
                            <hr>
                            <span id="ph" class="sensing-value"><strong>N/A</strong></span>
                            <br>
                            <span id="ph_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_ph">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kekeruhan Air</h5>
                            <h7 class="text text-info"><span id="turbidity_loc"></span></h7>
                            <hr>
                            <span id="turbidity" class="sensing-value"><strong>N/A</strong></span> NTU
                            <br>
                            <span id="turbidity_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_turbidity">N/A</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </content>
</body>

</html>

<!-- Realtime Update Script -->
<script>
    var count_lpg = 0;
    var count_smoke = 0;
    var count_carbon = 0;

    var last_lpg = 0;
    var last_smoke = 0;
    var last_carbon = 0;

    function warningEmail(co, smoke, lpg) {
        // sending warning email via SMTP
        //console.log("sending to email!");
        $.ajax({
            url: "<?= site_url('warning') ?>",
            method: "POST",
            data: {
                co: last_carbon,
                smoke: last_smoke,
                lpg: last_lpg
            }
        });

        count_lpg = 0;
        count_smoke = 0;
        count_carbon = 0;
    }

    $(document).ready(function() {
        setInterval(function() {
            // realtime update from server
            $.ajax({
                url: "<?= site_url('C_Home/getRealtimeUpdate') ?>",
                type: "POST",
                dataType: "json",
                data: {},
                success: function(data) {
                    // counting violation of detection for parameters
                    if (data.newLPG > 100) {
                        count_lpg++;
                        document.getElementById("lpg_warning").innerHTML = "<span class=\"badge badge-danger\">Kadar gas LPG sudah melebihi batas normal</span>";
                    } else {
                        count_lpg = 0;
                        document.getElementById("lpg_warning").innerHTML = "";
                    }

                    if (data.newSmoke >= 100) {
                        count_smoke++;
                        document.getElementById("smoke_warning").innerHTML = "<span class=\"badge badge-danger\">Kadar asap sudah melebihi batas normal</span>";
                    } else {
                        count_smoke = 0;
                        document.getElementById("smoke_warning").innerHTML = "";
                    }

                    if (data.newCO >= 25) {
                        count_carbon++;
                        document.getElementById("carbon_warning").innerHTML = "<span class=\"badge badge-danger\">Kadar gas karbon sudah melebihi batas normal</span>";
                    } else {
                        count_carbon = 0;
                        document.getElementById("carbon_warning").innerHTML = "";
                    }

                    if (data.newTemperature > 25) {
                        document.getElementById("temperature_warning").innerHTML = "<span class=\"badge badge-warning\">Suhu ruangan diatas suhu normal ruangan</span>";
                    } else {
                        document.getElementById("temperature_warning").innerHTML = "<span class=\"badge badge-success\">Suhu ruangan normal</span>";
                    }

                    if (data.newHumidity > 70) {
                        document.getElementById("humidity_warning").innerHTML = "<span class=\"badge badge-danger\">Humiditas ruangan diatas angka maksimum</span>";
                    } else if (data.newHumidity < 20) {
                        ocument.getElementById("humidity_warning").innerHTML = "<span class=\"badge badge-danger\">Humiditas ruangan dibawah angka minimum</span>";
                    } else {
                        document.getElementById("humidity_warning").innerHTML = "<span class=\"badge badge-success\">Humiditas ruangan normal</span>";
                    }

                    if (data.newPh < 7) {
                        document.getElementById("ph_warning").innerHTML = "<span class=\"badge badge-warning\">pH air terlalu asam</span>";
                    } else if (data.newPh > 8) {
                        document.getElementById("ph_warning").innerHTML = "<span class=\"badge badge-warning\">pH air terlalu basa</span>";
                    } else {
                        document.getElementById("ph_warning").innerHTML = "<span class=\"badge badge-success\">pH air netral</span>";
                    }

                    if (data.newTurbidity > 0) {
                        document.getElementById("turbidity_warning").innerHTML = "<span class=\"badge badge-warning\">Air terpantau keruh</span>";
                    } else {
                        document.getElementById("turbidity_warning").innerHTML = "<span class=\"badge badge-success\">Air terpantau jernih</span>";
                    }

                    //console.log(count_lpg);
                    //console.log(count_smoke);
                    //console.log(count_carbon);

                    // if sensor keep detects the same warning every 5 minutes (sends email every 5 min)
                    // sense every 5 seconds, so 60 sensing takes approx 60 x 5 sec = 300 sec
                    if (count_lpg >= 60 || count_smoke >= 60 || count_carbon >= 60) {
                        last_lpg = data.newLPG;
                        last_smoke = data.newSmoke;
                        last_carbon = data.newCO;

                        warningEmail(last_carbon, last_smoke, last_lpg);
                    }

                    // replace all values and refresh the display
                    document.getElementById("temperature").innerHTML = data.newTemperature;
                    document.getElementById("temperature_loc").innerHTML = data.newTemperatureLoc;
                    document.getElementById("monitoring_time_temperature").innerHTML = data.timestampTemperature;

                    document.getElementById("humidity").innerHTML = data.newHumidity;
                    document.getElementById("humidity_loc").innerHTML = data.newHumidityLoc;
                    document.getElementById("monitoring_time_humidity").innerHTML = data.timestampHumidity;

                    document.getElementById("ph").innerHTML = data.newPh;
                    document.getElementById("ph_loc").innerHTML = data.newPhLoc;
                    document.getElementById("monitoring_time_ph").innerHTML = data.timestampPh;

                    document.getElementById("turbidity").innerHTML = data.newTurbidity;
                    document.getElementById("turbidity_loc").innerHTML = data.newTurbidityLoc;
                    document.getElementById("monitoring_time_turbidity").innerHTML = data.timestampTurbidity;

                    document.getElementById("lpg").innerHTML = data.newLPG;
                    document.getElementById("lpg_loc").innerHTML = data.newLPGLoc;
                    document.getElementById("monitoring_time_lpg").innerHTML = data.timestampLPG;

                    document.getElementById("carbon").innerHTML = data.newCO;
                    document.getElementById("carbon_loc").innerHTML = data.newCOLoc;
                    document.getElementById("monitoring_time_carbon").innerHTML = data.timestampCO;

                    document.getElementById("smoke").innerHTML = data.newSmoke;
                    document.getElementById("smoke_loc").innerHTML = data.newSmokeLoc;
                    document.getElementById("monitoring_time_smoke").innerHTML = data.timestampSmoke;
                }
            });

            // checking sensing status
            $.ajax({
                url: "<?= site_url('C_Home/getSensingStatus') ?>",
                type: "POST",
                dataType: "json",
                data: {},
                success: function(status) {
                    // finding difference between now and last timestamp
                    var last_timestamp = new Date(status.sensingStatus);
                    var last_timestamp_seconds = (last_timestamp.getTime() / 1000) + "000";
                    var curr_timestamp = Date.now();
                    var difference = curr_timestamp - last_timestamp_seconds;

                    //printing offline if the time diff is more than 5 minutes
                    if ((difference / 1000) >= 300) {
                        document.getElementById("statusSensing").innerHTML = "<span class=\"badge badge-danger\">Offline</span>"
                    } else {
                        document.getElementById("statusSensing").innerHTML = "<span class=\"badge badge-success\">Online</span>"
                    }
                }
            });
        }, 5000);
    })
</script>