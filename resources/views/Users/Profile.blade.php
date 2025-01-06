@extends("template.main")

@section("content")
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">E SCH Pay</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                        <h4 class="page-title">{{ $title }}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-sm-12">
                    <!-- Profile -->
                    <div class="card bg-primary">
                        <div class="card-body profile-user-box">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-lg">
                                                <img src="https://ui-avatars.com/api/?name={{ $name }}&background=eef2f7&size=512&bold=true"
                                                    alt="" class="rounded-circle img-thumbnail">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <h4 class="mt-1 mb-1 text-white">{{ $name }}</h4>
                                                <p class="font-13 text-white-50"> {{ $kelas_id == "Administrator" ?
                                                    "Administrator" : $Kelas->first()->kelas }}</p>

                                                <ul class="mb-0 list-inline text-light">
                                                    <li class="list-inline-item me-3">
                                                        <h5 class="mb-1 text-white">{{$kelas_id == "Administrator" ?
                                                            "Administrator" : Number::currency($Tagihan->sum("nominal"),
                                                            'IDR')
                                                            }}
                                                        </h5>
                                                        <p class="mb-0 font-13 text-white-50">Total Tagihan</p>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <h5 class="mb-1 text-white">{{$kelas_id == "Administrator" ?
                                                            "Administrator" :
                                                            Number::currency(($Transaksi->sum("total") -
                                                            $Transaksi->sum("total")),
                                                            'IDR')
                                                            }}</h5>
                                                        <p class="mb-0 font-13 text-white-50">Terbayar</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="col-sm-4">
                                    <form action="{{ route('user.destroy',$id) }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                            <a data-bs-toggle="modal" href="#updateUser" class="btn btn-light">
                                                <i class="mdi mdi-account-edit me-1"></i>
                                            </a>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="uil-trash me-1"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div> <!-- end col-->
                            </div> <!-- end row -->

                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="updateUser" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="updateUserlTitleId"
                                aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable modal-dialog-centered"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateUserlTitleId">
                                                Edit User Data {{ $name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form class="row g-3 needs-validation"
                                                action="{{ Route('user.update',$id) }}" method="POST">

                                                @csrf
                                                @method("PUT")

                                                <div class="col-md-4">
                                                    <label for="nisn" class="form-label">nisn</label>
                                                    <input type="text" class="form-control" value="{{ $nisn }}"
                                                        id="nisn" placeholder="nisn" name="nisn">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                                    <input type="text" class="form-control" value="{{ $name }}"
                                                        id="nama" placeholder="Nama Lengkap" name="name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="jk" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select" id="jk" name="jk">
                                                        <option value="L">Laki - Laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nomerHP" class="form-label">Nomer HP</label>
                                                    <input type="number" class="form-control" value="{{ $nomerHP }}"
                                                        id="nomerHP" name="nomerHP">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                                                    <input type="text" class="form-control" value="{{ $tempatLahir }}"
                                                        id="tempatLahir" name="tempatLahir">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" value="{{ $tanggalLahir }}"
                                                        id="tanggalLahir" name="tanggalLahir">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="{{ $email }}"
                                                        id="email" name="email" placeholder="E-Mail">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="kelas" class="form-label">Kelas</label>
                                                    <select name="kelas_id" id="kelas" class="form-control select2"
                                                        data-toggle="select2" placeholder="Kelas">
                                                        <option value="isAdmin" {{ $kelas_id=="administrator"
                                                            ? "selected" : "" }}>Administrator</option>
                                                        @forelse (App\Models\Kelas::all() as $value )
                                                        <option value="{{ $value->rombongan_belajar_id }}" {{ $value->
                                                            rombongan_belajar_id == $kelas_id ? "selected" : "" }} >{{
                                                            $value->kelas }}</option>
                                                        @empty
                                                        <option value="null">Kelas Belum ada</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="Password" class="form-label">Password</label>
                                                    <input type="Password" class="form-control" id="Password"
                                                        name="password" placeholder="password">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <textarea name="alamat" id="alamat" cols="30" rows="10"
                                                        placeholder="Alamat"
                                                        class="form-control">{{ $alamat }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end card-body/ profile-user-box-->
                    </div>
                    <!--end profile/ card -->
                </div> <!-- end col-->
            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-xl-4">
                    <!-- Personal-Information -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Seller Information</h4>
                            <div class="text-start">
                                <p class="text-muted"><strong>Nama :</strong> <span class="ms-2">{{$name}}</span>
                                </p>

                                <p class="text-muted"><strong>Nomer HP :</strong><span class="ms-2">{{$nomerHP}}</span>
                                </p>

                                <p class="text-muted"><strong>Email :</strong> <span class="ms-2">{{ $email }}</span>
                                </p>

                                <p class="text-muted"><strong>Alamat :</strong> <span class="ms-2">{{ $alamat }}</span>
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- Personal-Information -->

                    @if ($kelas_id != "Administrator")
                    <!-- Total Tagihan number box-->
                    <div class="card text-white bg-info overflow-hidden">
                        <div class="card-body">
                            <div class="toll-free-box text-center">
                                <h4> <i class="uli-invoice"></i> Total Tagihan : {{
                                    Number::currency($Tagihan->sum("nominal")) }}
                                </h4>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <!-- End Total Tagihan number box-->
                    @endif

                </div> <!-- end col-->
                @if ($kelas_id != "Administrator")
                <div class="col-xl-8">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card tilebox-one">
                                <div class="card-body">
                                    <i class="uil-invoice float-end text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-0">Tagihan</h6>
                                    <h5 class="m-b-20 ">{{ Number::currency($Tagihan->sum("nominal"),"idr") }}</h5>
                                </div> <!-- end card-body-->
                            </div>
                            <!--end card-->
                        </div><!-- end col -->

                        <div class="col-sm-4">
                            <div class="card tilebox-one">
                                <div class="card-body">
                                    <i class="uil-bill float-end text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-0">Terbayar</h6>
                                    <h5 class="m-b-20 ">{{ Number::currency($Transaksi->sum("total"),"IDR") }}</h5>
                                </div> <!-- end card-body-->
                            </div>
                            <!--end card-->
                        </div><!-- end col -->

                        <div class="col-sm-4">
                            <div class="card tilebox-one">
                                <div class="card-body">
                                    <i class="uil-money-insert float-end text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-0">Sisa Tagihan</h6>
                                    <h5 class="m-b-20 ">{{ Number::currency(($Tagihan->sum("nominal") -
                                        $Transaksi->sum("total")),"IDR") }}</h5>
                                </div> <!-- end card-body-->
                            </div>
                            <!--end card-->
                        </div><!-- end col -->

                    </div>
                    <!-- end row -->


                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Riwayat Transaksi</h4>

                            <div class="table-responsive">
                                <table class="table table-hover table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Jenis</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($Tagihan->get() as $item)
                                        <tr>
                                            <td>{{ $item->jenis }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->total }}</td>
                                            <td><span class="badge bg-primary">{{ $item->status }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-bold text-center">Belum Ada Transaksi</td>
                                        </tr>
                                        @endforelse
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <!-- end table responsive-->
                        </div> <!-- end col-->
                    </div> <!-- end row-->

                </div>
                <!-- end col -->
                @endif

            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <script>
                        document.write(new Date().getFullYear())

                    </script> © SCH Palyment - Ksoft
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

</div>
@endsection

@section("pluginsCSS")
<!-- Select2 css -->
<link href="{{ url('/') }}/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("pluginsJS")
<!--  Select2 Js -->
<script src="{{ url('/') }}/assets/vendor/select2/js/select2.min.js"></script>
@endsection
