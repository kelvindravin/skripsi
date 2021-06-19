<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Viewing</title>
</head>

<body class="d-flex flex-column min-vh-100 main-body">
    <content class="main-body">
        <h1 class="text-center mt-1 py-2 text text-light bg bg-dark t">
            Status Pemantauan Kondisi Parameter Rumah
        </h1>
        <div class="container-fluid mb-1">
            <?php 
                $colCount = 0;
                foreach ($readings as $value) {
                    if($colCount == 0){
                        echo '<div class="row text-center d-flex align-items-center justify-content-center">'; 
                        $colCount++;
                    }
                    
                    echo '
                                
                            <div class="card mx-1 my-1">
                                <div class="card-body">
                                    <h5 class="card-title">'. $value->identitasSensor .'</h5>
                                    <h7 class="text text-info"><span id="'. $value->identitasSensor .'_loc"></span></h7>
                                    <hr>
                                    <span id="'. $value->identitasSensor .'" class="sensing-value"><strong>N/A</strong></span> '. $value->satuan .'
                                    <br>
                                    <span id="'. $value->identitasSensor .'_warning"></span>
                                    <hr>
                                    Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_'. $value->identitasSensor .'">N/A</span>
                                </div>
                            </div>
                            
                            ';
                        
                    $colCount++;
                    
                    if($colCount > 4){
                        $colCount = 0;
                        echo '</div>'; 
                    }
                }
            ?>
            </div>
        </div>
    </content>
</body>

</html>

<!-- Realtime Update Script -->
<script>
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
                    console.log(data);
                    for (const value of data){
                        var lokasi = value.lokasiNode;
                        var waktu = value.waktu;
                        var nilai = value.nilaiPengukuran;
                        var satuan = value.satuan;
                        var ambangBatasAtas = value.ambangBatasAtas;
                        var ambangBatasBawah = value.ambangBatasBawah;
                        var warningAmbangAtas = value.warningAmbangAtas;
                        var warningAmbangBawah = value.warningAmbangBawah;
                        var identitas = value.identitasSensor;
                        
                        document.getElementById(identitas).innerHTML = nilai;//nilai
                        document.getElementById(identitas + "_loc").innerHTML = lokasi;//lokasi
                        document.getElementById("monitoring_time_" + identitas).innerHTML = waktu;//waktuPemeriksaan
                        
                        //warning check
                        var span_safe = "<span class=\"badge badge-success\">"
                        var span_warning = "<span class=\"badge badge-danger\">"
                        var span_close = "</span>";
                        
                        if (ambangBatasAtas < nilai){ 
                            document.getElementById(identitas + "_warning").innerHTML = span_warning.concat(warningAmbangAtas,span_close);//warning ambang batas atas
                        }else if(nilai < ambangBatasAtas && nilai >= ambangBatasBawah){
                            document.getElementById(identitas + "_warning").innerHTML = span_safe.concat("Parameter terpantau aman!",span_close);//safe 
                        }else if(nilai < ambangBatasBawah){
                            document.getElementById(identitas + "_warning").innerHTML = span_warning.concat(warningAmbangBawah,span_close);//warning ambang batas bawah
                        }else{
                            document.getElementById(identitas + "_warning").innerHTML = "-";//neutral 
                        }
                        
                        //currentTimeCheck for sensor activity
                        // replace all values and refresh the display, and check if the diff between current time and sensing time 
                        // divided by 1000 (to make it in seconds)
                        // is more than 5 minutes (if > 5 minutes, then the sensor will be marked as N/A)
                        
                        var currentTime = Date.now();
                        var checkTime = (new Date(waktu) / 1000 ) + "000";

                        if((currentTime - checkTime) / 1000 > 300){
                            document.getElementById(identitas).innerHTML = "N/A";//nilai
                            document.getElementById(identitas + "_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";//offline tag
                        }
                    }
                }
            });
            
        }, 1000);
    })
</script>
