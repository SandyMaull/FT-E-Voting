@extends('tampilan.layouts.app')

@section('title')
    E-Voting Masuk
@endsection

@section('body')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Masuk Untuk Melanjutkan</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ url('/masuk2') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <h5 for="Token">Token</h5>
                        @if (Session::get('errors'))
                            <input type="Token" class="form-control is-invalid" id="Token" aria-describedby="TokenHelp" placeholder="Enter Token">
                        @else
                            <input type="Token" class="form-control" id="Token" aria-describedby="TokenHelp" placeholder="Enter Token">
                            <small id="TokenHelp" class="form-text text-muted">Masukan Token yang didapatkan dari mendaftarkan diri</small>
                        @endif
                    </div>
                    <div class="form-group">
                        <h5 for="Password_NIM">Password</h5>
                        @if ($message = Session::get('errors'))
                            <input type="password" class="form-control is-invalid" id="Password_NIM" placeholder="Password">
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @else
                            <input type="password" class="form-control" id="Password_NIM" placeholder="Password" aria-describedby="NIM_Help">
                            <small id="NIM_Help" class="form-text text-muted">Masukan 3 Angka NIM Terakhir anda</small>
                        @endif

                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                    <button type="submit" class="btn btn-warning">Register</button>
                </form>
            </div>
        </div>
        <div style="position:fixed; bottom:10px; text-align:center; left:0; right:0;" class="footer">
            <img src="{{ asset('bem.png') }}" alt="Logo BEM"/>
            <img src="{{ asset('dpm.png') }}" alt="Logo DPM"/>
            <img src="{{ asset('uts.png') }}" alt="Logo UTS"/>
            <br>
        </div>
    </div>
@endsection