<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @isset($pageawal)
        <title>E-Voting</title>
    @endisset
    <title>
        @yield('title')
    </title>
    @yield('css')
</head>
<body>
    <div class="loading"></div>
    <div id="particles-js"></div>
    <div class="d-flex vh-100 wrap">
        <div class="d-flex w-100 justify-content-center align-self-center">
            <div class="row align-items-center mx-2">
                <div class="col-12 align-self-center">
                    @if ($message = Session::get('periode'))
                        <h1>{{$message}}</h1>
                        <div style="position:fixed; bottom:10px; text-align:center; left:0; right:0;" class="footer">
                            <img src="{{ asset('bem.png') }}" alt="Logo BEM"/>
                            <img src="{{ asset('dpm.png') }}" alt="Logo DPM"/>
                            <img src="{{ asset('uts.png') }}" alt="Logo UTS"/>
                            <br>
                            <small>Powered by Kuronekosan - Fakultas Teknik - Universitas Teknologi Sumbawa</small>
                        </div>
                    @else
                        @isset($pageawal)
                            <h3 id="demo"></h3>
                            <a type="button" id="button" class="btn btn-primary" href="{{ url('/masuk') }}">Lanjut</a>
                            <br><br>
                            <div style="position:fixed; bottom:10px; text-align:center; left:0; right:0;" class="footer">
                                <img src="{{ asset('bem.png') }}" alt="Logo BEM"/>
                                <img src="{{ asset('dpm.png') }}" alt="Logo DPM"/>
                                <img src="{{ asset('uts.png') }}" alt="Logo UTS"/>
                                <br>
                                <small>Powered by Kuronekosan - Fakultas Teknik - Universitas Teknologi Sumbawa</small>
                            </div>
                        @endisset
                        @yield('body')
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="{{asset('js/particles.js')}}"></script>
    <script src="{{asset('js/particle-app.js')}}"></script>
    @yield('script')
    @if (Session::get('periode'))
    @else
        @isset($pageawal)
            <script>
                $(window).load(function() {
                    // Animate loader off screen
                    $(".loading").fadeOut("slow");
                    SelamatDatang();
                    setTimeout(showStuff, 2000);
                });

                var i = 0;
                var txt = 'SELAMAT DATANG DI E-VOTING SYSTEM'; /* The text */
                var speed = 60; /* The speed/duration of the effect in milliseconds */
                function SelamatDatang() {
                    if (i < txt.length) {
                        document.getElementById("demo").innerHTML += txt.charAt(i);
                        i++;
                        setTimeout(SelamatDatang, speed);
                    }
                }
                function showStuff() {
                    // document.getElementsByClassName("button").style = "inline-block";
                    $('#button').delay(500).fadeIn(2200);
                }
            </script>
        @endisset
    @endif
    <script>
    //paste this code under the head tag or in a separate js file.
        // Wait for window load
        $(window).load(function() {
            // Animate loader off screen
            $(".loading").fadeOut("slow");
        });

    </script>
</body>
</html>
{{-- @isset($pageawal)
    {{$pageawal}}
@endisset --}}