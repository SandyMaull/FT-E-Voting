@extends('tampilan.layouts.app')

@section('title')
    E-Voting Beranda
@endsection

@section('body')
    {{-- <a class="dropdown-item" href="{{ route('logoutvoters') }}"
    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logoutvoters') }}" method="POST" class="d-none">
    @csrf
    </form> --}}
    <div class="row text-center">
        <div class="col">
            <h2>Pemilihan Ketua BEM dan DPM Fakultas Teknik</h2>
        </div>
    </div>
    <br>
    @foreach ($tim as $tm)
        <div class="row text-center">
            <div class="col-12">
                <h2>{{ $tm->nama_tim }}</h2>
            </div>
            @foreach ($kandidat->where('tim_id', $tm->id) as $kand)
                <div class="col">
                    <h5>{{ $kand->nama }}</h5>
                    <img id="KandidatImage" src="{{ asset('image/kecil/'. $kand->image) }}"  alt="">
                    <p>Visi: {{ $kand->visi }}</p>
                    <p>Misi: {{ $kand->misi }}</p>
                </div>
            @endforeach
        </div>
        <br>
    @endforeach
@endsection