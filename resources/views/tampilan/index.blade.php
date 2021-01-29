@extends('tampilan.layouts.app')

@section('title')
    E-Voting Masuk
@endsection

@section('body')
    <div class="container">
        @if ($afterReg = Session::get('afterregis'))
            <div class="row">
                <div class="col">
                    <h2>Silahkan tunggu pesan konfirmasi dari Whatsapp untuk Verifikasi token anda,
                        data anda sedang team kami check.
                    </h2>
                    <h5>Token: {{ $afterReg }}</h5>
                </div>
            </div>
        @else
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
                                <input type="Token" class="form-control is-invalid" id="Token" name="token" aria-describedby="TokenHelp" placeholder="Enter Token">
                            @elseif ($openlink = Session::get('openlink'))
                                <input type="Token" class="form-control" id="Token" name="token" aria-describedby="TokenHelp" placeholder="Enter Token" value="{{ $openlink }}">
                            @else
                                <input type="Token" class="form-control" id="Token" name="token" aria-describedby="TokenHelp" placeholder="Enter Token">
                                <small id="TokenHelp" class="form-text text-muted">Masukan Token yang didapatkan dari mendaftarkan diri</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <h5 for="Password_NIM">Password</h5>
                            @if ($message = Session::get('errors'))
                                <input type="password" class="form-control is-invalid" id="Password_NIM" name="password" placeholder="Password">
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @else
                                <input type="password" class="form-control" id="Password_NIM" name="password" placeholder="Password" aria-describedby="NIM_Help">
                                <small id="NIM_Help" class="form-text text-muted">Masukan Password anda</small>
                            @endif

                        </div>
                        <button type="submit" class="btn btn-primary">Masuk</button>
                        <a href="{{ url('/register') }}" class="btn btn-warning">Register</a>
                    </form>
                </div>
            </div>
        @endif
        <div class="footer">
            <img class="img-footer" src="{{ asset('ft.png') }}" alt="Logo Fakultas Teknik"/>
            <img class="img-footer" src="{{ asset('dpm.png') }}" alt="Logo DPM"/>
            <img class="img-footer" src="{{ asset('e-vottry.png') }}" alt="Logo E-Voting"/>
            <br>
        </div>
    </div>
@endsection