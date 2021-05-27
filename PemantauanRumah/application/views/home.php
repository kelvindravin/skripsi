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
                Status Sensing : 
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
                            <hr>
                            <span id="temperature" class="sensing-value"><strong>N/A</strong></span> °C
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_temperature">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelembaban Udara</h5>
                            <hr>
                            <span id="humidity" class="sensing-value"><strong>N/A</strong></span> RH
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_humidity">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">pH Air</h5>
                            <hr>
                            <span id="ph" class="sensing-value"><strong>N/A</strong></span>
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_ph">N/A</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center mt-4">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas LPG</h5>
                            <hr>
                            <span id="lpg" class="sensing-value"><strong>N/A</strong></span> PPM
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_lpg">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas Karbon</h5>
                            <hr>
                            <span id="carbon" class="sensing-value"><strong>N/A</strong></span> PPM
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_carbon">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Asap</h5>
                            <hr>
                            <span id="smoke" class="sensing-value"><strong>N/A</strong></span> PPM
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_smoke">N/A</span>
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
    
    function warningEmail(co,smoke,lpg){
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
                    if(data.newLPG > 200){
                        count_lpg++;
                    }else{
                        count_lpg = 0;
                    }
                    
                    if(data.newSmoke >= 100){
                        count_smoke++;
                    }else{
                        count_smoke = 0;
                    }
                    
                    if(data.newCO >= 30){
                        count_carbon++;
                    }else{
                        count_carbon = 0;
                    }
                    
                    //console.log(count_lpg);
                    //console.log(count_smoke);
                    //console.log(count_carbon);
                    
                    // if sensor keep detects the same warning every 5 minutes (sends email every 5 min)
                    // sense every 5 seconds, so 60 sensing takes approx 60 x 5 sec = 300 sec
                    if(count_lpg >= 60 || count_smoke >= 60 || count_carbon >= 60){
                        last_lpg = data.newLPG;
                        last_smoke = data.newSmoke;
                        last_carbon = data.newCO;
                        
                        warningEmail(last_carbon,last_smoke,last_lpg);
                    }
                    
                    // replace all values and refresh the display
                    document.getElementById("temperature").innerHTML = data.newTemperature;
                    document.getElementById("monitoring_time_temperature").innerHTML = data.timestampTemperature;
                    
                    document.getElementById("humidity").innerHTML = data.newHumidity;
                    document.getElementById("monitoring_time_humidity").innerHTML = data.timestampHumidity;
                    
                    document.getElementById("ph").innerHTML = data.newPh;
                    document.getElementById("monitoring_time_ph").innerHTML = data.timestampPh;
                    
                    document.getElementById("lpg").innerHTML = data.newLPG;
                    document.getElementById("monitoring_time_lpg").innerHTML = data.timestampLPG;
                    
                    document.getElementById("carbon").innerHTML = data.newCO;
                    document.getElementById("monitoring_time_carbon").innerHTML = data.timestampCO;
                    
                    document.getElementById("smoke").innerHTML = data.newSmoke;
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
                    if((difference/1000) >= 300){
                        document.getElementById("statusSensing").innerHTML = "<span class=\"badge badge-danger\">Offline</span>"
                    }else{
                        document.getElementById("statusSensing").innerHTML = "<span class=\"badge badge-success\">Online</span>"
                    }
                }
            });
        }, 5000);
    })
</script>
