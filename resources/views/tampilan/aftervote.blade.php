@extends('tampilan.layouts.app2')

@section('title')
    E-Voting Selesai
@endsection

@section('body')
    <form id="logout-form" action="{{ route('logoutvoters') }}" method="POST" class="d-none">
        @csrf
    </form>
    <div class="d-flex vh-100 wrap">
        <div class="d-flex w-100 justify-content-center align-self-center">
            <div class="row align-items-center mx-2">
                <div class="col-12 align-self-center">
                    @if (Session::get('pageakhir'))
                        <h3>Terimakasih telah memilih, Semoga pemimpin yang nantinya akan terpilih dapat amanah.</h3>
                        <q cite="https://www.imdb.com/title/tt0062622/quotes/qt0396921">The ignorance of one voter in a democracy impairs the security of all.</q> - John F Kennedy
                        <br><br><p><small>halaman ini akan ter-redirect ke halaman awal stelah 7 detik...</small></p>
                    @else
                        <h1>ACCESS DENIED!!</h1>
                        <br><br><p><small>halaman ini akan ter-redirect ke halaman login stelah 3 detik...</small></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    @if (Session::get('pageakhir'))
        <script>
            setTimeout(function() {
                document.getElementById('logout-form').submit();
            }, 7000);
        </script>
    @else
        <script>
            setTimeout(function() {
                document.getElementById('logout-form').submit();
            }, 3000);
        </script>    
    @endif
@endsection