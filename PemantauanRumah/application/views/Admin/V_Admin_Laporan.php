<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan | Formulir Kerjasama Perusahaan</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
</head>

<div class="text-center">
    <h1>Laporan</h1>
</div>

<div class="container">
    <form method="POST" action="cariLaporan" enctype="multipart/form-data" autocomplete="off">
        <div class="row">
            <p>Tahun : </p>
            <input type="text" id="datepicker" placeholder="Pilih Tahun.." class="col-sm-12 form-control border rounded" name="tahun" required/>
        </div><br>

        <div class="row">
            <p>Triwulan : </p>
            <select class="selectpicker form-control border rounded" id="inputTriwulan" name="triwulan" data-live-search="true" data-size="5" data-style="btn-transparant">
                <option hidden selected value="5">Pilih Triwulan...</option>
                <option data-tokens='1' value='1'>Triwulan I</option>
                <option data-tokens='2' value='2'>Triwulan II</option>
                <option data-tokens='3' value='3'>Triwulan III</option>
                <option data-tokens='4' value='4'>Triwulan IV</option>
                <option data-tokens='5' value='5'>All</option>
            </select><br>
        </div><br>
        <div class="text-center">
            <button type="submit" class="btn btn-info">Cari</button>
        </div>
    </form>
</div>

</div>
<!-- Penutup div wrapper -->
</div>
</div>

<script>
    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
</script>