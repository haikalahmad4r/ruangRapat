<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/icons.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <style>
        html,
        body {
            height: 100%;
        }

        * {
            box-sizing: border-box;
        }

        .bg-image {
            background-image: url("images/background.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
    </style>


</head>


<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="bg-image">
        .
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-30">
                        <span class=""><img src="images/logopt.png" alt="logo" height="100"></span>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>Sign Up</b></h4>


                    <form method="POST" action="{{ route('register') }}" class="form-horizontal m-t-20">
                        @csrf

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Divisi">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="User ID">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="emailbaru" type="email" class="form-control @error('email') is-invalid @enderror" name="emailbaru" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <?php

                        use App\Models\RuangRapat;
                        use App\Models\Divisi;


                        $ruangRapat = RuangRapat::all();
                        $divisi = Divisi::all();
                        ?>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="">Pilih Role</label>

                                <select name="role" id="role" class="form-control" onchange="showDiv(this)">
                                    <!-- onchange, atribute js ketika ada perubahan event,maka menjalankan fungsi showdiv -->
                                    <option value="2">Super Admin</option>
                                    <option value=" 1">Admin</option>
                                    <option value="3">User</option>
                                    <option value="4">Tamu</option>
                                </select>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <select name="adminRuangan" id="adminRuangan" class="kondisi form-control" style="display:none ;">
                                    <!-- style :none, : untuk menyembukian inputan select -->
                                    <!-- id tidak boleh bentrok -->
                                    @foreach($ruangRapat as $r)
                                    <option value="{{$r->id}}">{{$r->nama}}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <select name="divisiRapat" id="divisiRapat" class="kondisi form-control" style="display:none ;">
                                    <!-- id tidak boleh bentrok -->
                                    <option value="">Pilih Divisi</option>
                                    @foreach($divisi as $d)
                                    <option value="{{$d->id}}">{{$d->nama}}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script text="type/javascript">
        //Fungsi untuk membuat select hidden
        function showDiv(select) {
            if (select.value == 1) {
                document.getElementById('adminRuangan').style.display = "block";
                // block :menampilkan id terkait
                document.getElementById('divisiRapat').style.display = "none";
                // none : menyembukan id terkait
            } else if (select.value == 3) {
                document.getElementById('adminRuangan').style.display = "none";
                document.getElementById('divisiRapat').style.display = "block";

            } else {
                document.getElementById('adminRuangan').style.display = "none";
                document.getElementById('divisiRapat').style.display = "none";
                // get element by id : menampilkan elemen berdasarkan id nya
            }
        }
    </script>




    <!-- jQuery  -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.min.js"></script>
    <script src="js/detect.js"></script>
    <script src="js/fastclick.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script src="js/waves.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>

    <script src="js/app.js"></script>

</body>

</html>


<!-- 

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 -->