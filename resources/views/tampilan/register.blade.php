@extends('tampilan.layouts.app')

@section('title')
    E-Voting Register
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('body')
    <div class="container" style="margin-bottom: 55px">
        <div class="row">
            <div class="col">
                <h1>Register User</h1>
            </div>
        </div>
        <form action="{{ url('/register_post') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col col-lg-6 col-sm-12">
                    @csrf
                    <div class="form-group">
                        <h5 for="Nama">Nama</h5>
                        <input type="text" class="form-control" name="nama" id="Nama" aria-describedby="NamaHelp" placeholder="Enter Nama" required>
                        <small id="NamaHelp" class="form-text text-muted">Masukan Nama Lengkap</small>
                    </div>
                    <div class="form-group">
                        <h5 for="NIM">NIM</h5>
                        <input type="text" class="form-control" name="nim" id="NIM" placeholder="NIM" aria-describedby="NIM_Help" required>
                        <small id="NIM_Help" class="form-text text-muted">Masukan NIM</small>
                    </div>
                    <div class="form-group">
                        <h5 for="PRODI">Program Studi</h5>
                        <select class="form-control" name="prodi" id="PRODI" aria-describedby="PRODI_Help" required>
                            <option selected="selected" value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Sipil">Teknik Sipil</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                            <option value="Teknik Metalurgi">Teknik Metalurgi</option>
                            <option value="Teknik Industri">Teknik Industri</option>
                        </select>
                        <small id="PRODI_Help" class="form-text text-muted">Masukan Program Studi</small>
                    </div>
                </div>
                <div class="col col-lg-6 col-sm-12">
                    <div class="form-group">
                        <h5 for="Password">Password</h5>
                        <input type="password" class="form-control" name="password" id="Password" placeholder="Password" aria-describedby="Password_Help" required>
                        <small id="Password_Help" class="form-text text-muted">Masukan Password</small>
                    </div>
                    <div class="form-group">
                        <h5 for="NoTelp">No.Whatsapp</h5>
                        <input type="text" class="form-control" name="telp" id="NoTelp" placeholder="No.Whatsapp" aria-describedby="NoTelp_Help" required>
                        <small id="NoTelp_Help" class="form-text text-muted">Untuk verifikasi Token, format pengisian: 6282260879023</small>
                    </div>
                    <div class="form-group" style="display: inline-block">
                        <h5 for="SiakadFoto">Foto Siakad</h5>
                        <button id="upload_button" style="display: none; border: 0px; background: #FFF; border-radius: 5px; color: #495057; padding: 5px;">Pilih Gambar</button>
                        <input type="file" class="form-control-file form-control-sm" name="siakadfoto" data-role="file" id="SiakadFoto" placeholder="Foto Siakad" aria-describedby="SiakadFoto_Help" accept="image/png,image/x-png,image/jpg,image/jpeg">
                        <small id="SiakadFoto_Help" class="form-text text-muted">Masukan Screenshot KRS Siakad Semester Ini (Max: 2MB)</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="footer">
            <img class="img-footer" src="{{ asset('ft.png') }}" alt="Logo Fakultas Teknik"/>
            <img class="img-footer" src="{{ asset('dpm.png') }}" alt="Logo DPM"/>
            <img class="img-footer" src="{{ asset('e-vottry.png') }}" alt="Logo E-Voting"/>
            <br>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin_asset/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @if (session('status') == 'sukses')
    <script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    
        Toast.fire({
          icon: 'success',
          title: '{{session('message')}}'
        })
            
        
      });
    
    </script>
    @endif
    @if (session('status') == 'error')
    <script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    
        Toast.fire({
          icon: 'error',
          title: '{{session('message')}}'
        })
            
        
      });
      
    
    </script>
    @endif
    @if ($errors->count() > 0)
        @foreach ($errors->all() as $error)
        <script type="text/javascript">
            var error = '{{ $error }}';
            $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: error
            });
            });
        </script>
        @endforeach
    @endif
    <script>
        var button = document.getElementById('upload_button');
        var input  = document.getElementById('SiakadFoto');

        // Making input invisible, but leaving shown fo graceful degradation
        input.style.display = 'none';
        button.style.display = 'initial';

        button.addEventListener('click', function (e) {
            e.preventDefault();
            
            input.click();
        });

        input.addEventListener('change', function () {
            // var value = this.value;
            button.innerText = 'image terpilih';
            // console.log(value); 
        });
    </script>
@endsection