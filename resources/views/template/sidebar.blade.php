<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- Brand Logo dark -->
    <a href="/" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ url('/') }}/assets/images/logo.svg" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ url('/') }}/assets/images/logo.svg" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo light -->
    <a href="/" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ url('/') }}/assets/images/logo-dark.svg" alt="light logo">
        </span>
        <span class="logo-sm">
            <img src="{{ url('/') }}/assets/images/logo-dark.svg" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="align-middle ri-checkbox-blank-circle-line"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="align-middle ri-close-fill"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="{{ url('/') }}/assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                    class="shadow-sm rounded-circle">
                <span class="mt-2 leftbar-user-name">Dominic Keller</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Home</li>

            <li class="side-nav-item">
                <a href="{{ route('home') }}" class="side-nav-link">
                    <i class="uil-home"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Transaksi dan Tagihan</li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebartagihan" aria-expanded="false" aria-controls="sidebartagihan"
                    class="side-nav-link">
                    <i class="uil-invoice"></i>
                    <span> Tagihan </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebartagihan">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ Route('daftarTagihan.index') }}">Daftar Tagihan</a>
                        </li>
                        <li>
                            <a href="{{ Route('tagihanSiswa.index') }}">Tagihan Siswa</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTransaksi" aria-expanded="false"
                    aria-controls="sidebarTransaksi" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span> Transaksi </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTransaksi">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('Transaksi.create') }}">Buat Transaksi</a>
                        </li>
                        <li>
                            <a href="{{ route('Transaksi.index') }}">Daftar Transaksi</a>
                        </li>

                    </ul>
                </div>
            </li>
            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPotongan" aria-expanded="false"
                    aria-controls="sidebarPotongan" class="side-nav-link">
                    <i class="ri-percent-line"></i>
                    <span> Potongan </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPotongan">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="crm-Buat Potongan.html">Buat Potongan</a>
                        </li>
                        <li>
                            <a href="crm-Daftar Potongan.html">Daftar Potongan</a>
                        </li>

                    </ul>
                </div>
            </li> --}}

            <li class="side-nav-item">
                <a href="apps-Metode Pembayaran.html" class="side-nav-link">
                    <i class="uil-sitemap"></i>
                    <span> Metode Pembayaran </span>
                </a>
            </li>
            <li class="side-nav-title">System</li>
            <li class="side-nav-item">
                <a href="{{ Route('user.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> User Management </span>
                </a>
            </li>

            <!-- Help Box -->
            <div class="text-center text-white help-box">
                <a href="javascript: void(0);" class="text-white float-end close-btn">
                    <i class="mdi mdi-close"></i>
                </a>
                <img src="{{ url('/') }}/assets/images/svg/help-icon.svg" height="90"
                    alt="Helper Icon Image" />
                <h5 class="mt-3">E School Palyment</h5>
                <p class="mb-3">Sistem Pembayaran Elektronik Untuk Sekolah dengan berbagai macam cara pembayran</p>
                <div class="rounded row bg-light d-flex align-items-center justify-items-center">
                    <p class="text-dark text-bold">Metode Pembayaran yang di dukung</p>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/bni_va.png" width="50px" alt=""
                            srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/briva-bri.jpg" width="50px"
                            alt="" srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/bca_va.png" width="50px" alt=""
                            srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/mandiri_va.png" width="50px"
                            alt="" srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/alfamart_logo_baru.png" width="50px"
                            alt="" srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/logo_indomaret.png" width="50px"
                            alt="" srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/gopay_logo.svg" width="50px"
                            alt="" srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/shopee_pay.svg" width="50px"
                            alt="" srcset="">
                    </div>
                    <div class="m-1 col-sm-4">
                        <img src="{{ url('/') }}/assets/images/payments/logo_qris.svg" width="50px"
                            alt="" srcset="">
                    </div>
                </div>
            </div>
            <!-- end Help Box -->


        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
