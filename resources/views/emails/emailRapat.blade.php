<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Booking Ruang Rapat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- DataTables -->
    <link href="{{asset('plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('plugins/bootstrap-sweetalert/sweet-alert.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">






    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css">
    <!-- <link href="css/style.css" rel="stylesheet" type="text/css"> -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" /> -->


</head>

<body class="fixed-left">
    <div class="jumbotron">
        <h1 class="display-4">Booking Ruang Rapat</h1>
        <!-- <img src="{{((asset('images/logopt.png'))) }}" width="30"> -->
        <?php
        $img_url = env('APP_URL') . "/public/images/logopt.png";
        ?>

        <!-- <img src="/public/images/logopt.png" alt="LogoPDAM"> -->
        <div class="row"> <img src="{{$message->embed(asset('images/logopt.png'))}}">
        </div>
        <center>
            <p class="lead">Permohonan Rapat Baru Diterima</p>
            <hr class="my-4">
            <p>Harap Segera Cek</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="http://localhost:8000/permohonan_rapat" role="button">Learn more</a>
                <button> tes </button>
            </p>
        </center>

    </div>



</body>

</html>