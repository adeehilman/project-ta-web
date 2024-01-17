<style>
    .icon-button {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        color: #f6f6f6;
        background: #db5353;
        border: none;
        outline: none;
        border-radius: 50%;
    }

    .icon-button:hover {
        cursor: pointer;
    }

    .icon-button:active {
        background: #cccccc;
    }

    .icon-button__badge {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 18px;
        height: 18px;
        background: rgb(233, 223, 223);
        color: black;
        display: flex;
        font-weight: bold
        justify-content: center;
        align-items: center;
        font-size: 10px;
        border-radius: 50%;
    }
</style>

<header>
    <div class="navbars">
        <ul class="navbars-nav {{ Route::current()->getName() == 'login' ? 'ms-3' : '' }}">
            @if (Route::current()->getName() != 'login')
                <li class="navs-item">
                    <a class="navs-link">
                        <i class='bx bx-menu bar_menu'></i>
                    </a>
                </li>
            @endif
            <li class="navs-item">
                <img src="{{ asset('img/sn.png') }}" alt="sat logo" class="logo" />
            </li>
        </ul>
        <div class="navbars__title">
            MySatnusa Admin
        </div>

        {{-- navbar --}}
        @if (Route::current()->getName() != 'login')
            <ul class="navbars-nav navs-right">

                <button class="dropdowns-toggle bx bx-bell icon-button mt-3" data-toggle="notif-menu" style="margin-right: 20px">
                    <span class="icon-button__badge" style="padding: 5px" id="count_notif">0</span>
                </button>

                <ul id="notif-menu" class="dropdowns-menu" style="max-width: 500px; padding: 6px;">
                </ul>

                <li class="navs-item">
                    
                    <div class="avt dropdowns">


                        <span class="dropdowns-toggle mt-4" data-toggle="user-menu">{{ $userInfo->fullname }}</span>

                        <img class="dropdowns-toggle"
                            src="{{ $userInfo->img_user ? $userInfo->img_user : asset('img/user.png') }}"
                            alt="Sat Nusapersada" class="dropdowns-toggle" data-toggle="user-menu" /><br>
                        <span class="me-5 mb-2" style="float: right; font-size: 10px;">{{ $positionName }}</span>

                        <ul id="user-menu" class="dropdowns-menu">
                            <li class="dropdowns-menu-item">
                                <a href="{{ url('/auth/change-password') }}" class="dropdowns-menu-link">
                                    <div>
                                        <i class='bx bxs-cog'></i>
                                    </div>
                                    <span>Ganti Password</span>
                                </a>
                            </li>
                            <li class="dropdowns-menu-item">
                                <a href="{{ route('auth.logout') }}" class="dropdowns-menu-link">
                                    <div>
                                        <i class='bx bx-log-out'></i>
                                    </div>
                                    <span>Keluar</span>
                                </a>
                            </li>
                        </ul>

                       
                    </div>
                </li>
            </ul>
        @endif
        {{-- end navbar --}}
    </div>
</header>

@if (Route::current()->getName() != 'login')
    <div class="sidebar closes">
        <ul class="nav-links">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class='bx bxs-dashboard fs-5 text-muted'></i>
                    <span class="link_name {{ request()->routeIs('dashboard') ? 'text-danger' : '' }}">Dashboard</span>
                </a>
                <ul class="sub_menu blank">
                    <li><a class="link_name {{ request()->routeIs('dashboard') ? 'text-danger' : '' }}"
                            href="{{ route('dashboard') }}">Dashboard</a></li>
                </ul>
            </li>
            @php
                $listAktif = request()->routeIs('list') ? 'text-danger' : '';
                $groupAktif = request()->routeIs('grup') ? 'text-danger' : '';
            @endphp
            {!! $userRole == 63 || $userRole == 64
                ? '<li>
                                                                                                                                                    <div class="icon-links">
                                                                                                                                                        <a href="javascript:void(0)">
                                                                                                                                                            <i class="bx bx-user fs-5 text-muted"></i>
                                                                                                                                                            <span class="link_name">Karyawan</span>
                                                                                                                                                        </a>
                                                                                                                                                        <a href="javascript:void(0)">
                                                                                                                                                            <i class="bx bxs-chevron-down arrow"></i>
                                                                                                                                                        </a>
                                                                                                                                                    </div>
                                                                                                                                                    <ul class="sub_menu">
                                                                                                                                                        <li><a class="' .
                    $listAktif .
                    '" href="' .
                    route('list') .
                    '">List Karyawan</a></li>
                                                                                                                                                        <li><a class="' .
                    $groupAktif .
                    '" href="' .
                    route('grup') .
                    '">Grup Karyawan</a></li>
                                                                                                                                                    </ul>
                                                                                                                                                </li>'
                : '' !!}
            {{-- <li>
                <div class="icon-links">
                    <a href="javascript:void(0)">
                        <i class='bx bx-user fs-5 text-muted'></i>
                        <span class="link_name">Karyawan</span>
                    </a>
                    <a href="javascript:void(0)">
                        <i class='bx bxs-chevron-down arrow'></i>
                    </a>
                </div>
                <ul class="sub_menu">
                    <li><a class="link_name {{ request()->routeIs('#') ? 'text-danger' : '' }}"
                            href="#">Karyawan</a></li>
                    <li><a class="{{ request()->routeIs('list') ? 'text-danger' : '' }}"
                            href="{{ route('list') }}">List Karyawan</a></li>
                    <li><a class="{{ request()->routeIs('grup') ? 'text-danger' : '' }}"
                            href="{{ route('grup') }}">Grup Karyawan</a></li> --}}
            {{-- <li><a class="{{ request()->routeIs('pkb') ? 'text-danger' : '' }}"
                            href="{{ route('pkb') }}">Grup PKB</a></li> --}}
            {{-- </ul>
            </li> --}}
            <li>
                @php
                    $mmsAktif = request()->routeIs('mms') ? 'text-danger' : '';
                @endphp
                <div class="icon-links">
                    <a href="javascript:void(0)">
                        <i class='bx bx-devices fs-5 {{ $mmsAktif }}'></i>
                        <span class="link_name">Device Manager</span>
                    </a>
                    <a href="javascript:void(0)">
                        <i class='bx bxs-chevron-down arrow'></i>
                    </a>
                </div>
                <ul class="sub_menu">

                    <li><a class="link_name" href="javascript:void(0)">Device Manager</a></li>
                    {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66
                        ? '<li><a class="' .
                            $mmsAktif .
                            '"
                                                                                                                                                                                                                                                        href="' .
                            route('mms') .
                            '">Mobile Management System</a></li>'
                        : '' !!}
                    {{-- <li><a class="{{ request()->routeIs('mms') ? 'text-danger' : '' }}"
                            href="{{ route('mms') }}">Mobile Management System</a></li> --}}
                    {{-- @php
                        $lmsAktif = request()->routeIs('lms') ? 'text-danger' : '';
                    @endphp
                    {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66 || $userRole == 67 ? 
                    '<li><a class="' . $lmsAktif . '"
                            href="' . route('lms') . '">Laptop Management System</a></li>' : 
                    '' !!} --}}
                    <li><a class="{{ request()->routeIs('lms') ? 'text-danger' : '' }}"
                            href="{{ route('lms') }}">Laptop Management System</a></li>
                    @php
                        $lpbAktif = request()->routeIs('lpb') ? 'text-danger' : '';
                    @endphp
                    {!! $userRole == 63 || $userRole == 64
                        ? '<li><a class="' .
                            $lpbAktif .
                            '"
                                                                                                                                                                                                                                                        href="' .
                            route('lpb') .
                            '">Perangkat Bermasalah</a></li>'
                        : '' !!}
                    {{-- <li><a class="{{ request()->routeIs('lpb') ? 'text-danger' : '' }}"
                            href="{{ route('lpb') }}">Perangkat Bermasalah</a></li> --}}
                </ul>
            </li>
            @php
                $pemberitahuanAktif = request()->routeIs('pemberitahuan') ? 'text-danger' : '';
            @endphp
            {!! $userRole == 63 || $userRole == 64
                ? '<li>
                                                                                                                                                    <a href="' .
                    route('pemberitahuan') .
                    '">
                                                                                                                                                        <i class="bx bx-bell fs-5 text-muted"></i>
                                                                                                                                                        <span class="link_name ' .
                    $pemberitahuanAktif .
                    '">Pemberitahuan</span>
                                                                                                                                                    </a>
                                                                                                                                                    <ul class="sub_menu blank">
                                                                                                                                                        <li>
                                                                                                                                                            <a class="link_name ' .
                    $pemberitahuanAktif .
                    '" href="' .
                    route('pemberitahuan') .
                    '">Pemberitahuan</a>
                                                                                                                                                        </li>
                                                                                                                                                    </ul>
                                                                                                                                                </li>'
                : '' !!}
            {{-- <li>
                <a href="{{ route('pemberitahuan') }}">
                    <i class='bx bx-bell fs-5 text-muted'></i>
                    <span
                        class="link_name {{ request()->routeIs('pemberitahuan') ? 'text-danger' : '' }}">Pemberitahuan</span>
                </a>
                <ul class="sub_menu blank">
                    <li><a class="link_name {{ request()->routeIs('pemberitahuan') ? 'text-danger' : '' }}"
                            href="{{ route('pemberitahuan') }}">Pemberitahuan</a></li>
                </ul>
            </li> --}}
            @php
                $kritikAktif = request()->routeIs('kritik') ? 'text-danger' : '';
            @endphp
            {!! $userRole == 63 || $userRole == 64
                ? '<li>
                                                                                                                                                    <a href="' .
                    route('kritik') .
                    '">
                                                                                                                                                        <i class="bx bx-message-error fs-5 text-muted"></i>
                                                                                                                                                        <span class="link_name ' .
                    $kritikAktif .
                    '">Kritik dan
                                                                                                                                                            Saran</span>
                                                                                                                                                    </a>
                                                                                                                                                    <ul class="sub_menu blank">
                                                                                                                                                        <li>
                                                                                                                                                            <a class="link_name ' .
                    $kritikAktif .
                    '" href="' .
                    route('kritik') .
                    '">Kritik dan
                                                                                                                                                            Saran</a>
                                                                                                                                                        </li>
                                                                                                                                                    </ul>
                                                                                                                                                </li>'
                : '' !!}
            {{-- <li>
                <a href="{{ route('kritik') }}">
                    <i class='bx bx-message-error fs-5 text-muted'></i>
                    <span class="link_name {{ request()->routeIs('kritik') ? 'text-danger' : '' }}">Kritik dan
                        Saran</span>
                </a>
                <ul class="sub_menu blank">
                    <li><a class="link_name {{ request()->routeIs('kritik') ? 'text-danger' : '' }}"
                            href="{{ route('kritik') }}">Kritik dan Saran</a></li>
                </ul>
            </li> --}}
            @php
                $lokerAktif = request()->routeIs('loker') ? 'text-danger' : '';
            @endphp
            {!! $userRole == 63 || $userRole == 64
                ? '<li>
                                                                                                                                                    <a href="' .
                    route('loker') .
                    '">
                                                                                                                                                        <i class="bx bx-briefcase-alt-2 fs-5 text-muted"></i>
                                                                                                                                                        <span class="link_name ' .
                    $lokerAktif .
                    '">Lowongan Kerjaa</span>
                                                                                                                                                    </a>
                                                                                                                                                    <ul class="sub_menu blank">
                                                                                                                                                        <li>
                                                                                                                                                            <a class="link_name ' .
                    $lokerAktif .
                    '" href="' .
                    route('loker') .
                    '">Lowongan Kerjaa</a>
                                                                                                                                                        </li>
                                                                                                                                                    </ul>
                                                                                                                                                </li>'
                : '' !!}

            {{-- <li>
                <a href="{{ route('loker') }}">
                    <i class='bx bx-briefcase-alt-2 fs-5 text-muted'></i>
                    <span class="link_name {{ request()->routeIs('loker') ? 'text-danger' : '' }}">Lowongan
                        Kerja</span>
                </a>
                <ul class="sub_menu blank">
                    <li>
                        <a class="link_name {{ request()->routeIs('loker') ? 'text-danger' : '' }}"
                            href="{{ route('loker') }}">Lowongan Kerja</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li>
                <a href="{{ route('peran') }}">
                    <i class='bx bx-group fs-5 text-muted'></i>
                    <span class="link_name {{ request()->routeIs('peran') ? 'text-danger' : '' }}">Peran
                        Pengguna</span>
                </a>
                <ul class="sub_menu blank">
                    <li><a class="link_name {{ request()->routeIs('peran') ? 'text-danger' : '' }}"
                            href="{{ route('peran') }}">Peran Pengguna</a></li>
                </ul>
            </li> --}}
            {{-- <li>
                <a href="{{ route('pengaduan') }}">
                    <i class='bx bx-user-voice fs-5 text-muted'></i>
                    <span class="link_name">Pengaduan Pelanggaran</span>
                </a>
                <ul class="sub_menu blank">
                    <li><a class="link_name" href="#">Pengaduan Pelanggaran</a></li>
                </ul>
            </li> --}}
            {{-- <div class="sidebar-footer" style="margin-top: 530px">
                <p class="fs-6 fw-bold fst-italic text-danger text-center">Powered By DOT</p>
                <p class="fs-6 text-danger text-center">v.1.0.0</p>
            </div> --}}
        </ul>
    </div>
@endif


<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script>
    var roles = @json(isset($userRole) ? $userRole : null);

    $.ajax({
            url: '{{ route('api.notifikasi') }}',
            method: 'GET',
            data: {
                roles: roles
            },
            beforeSend: () => {

            }
        })
        .done(res => {
            const waiting_peninjauan_mms = res.data.status_mms_2
            const waiting_peninjauan_lms = res.data.status_lms_2

            const waiting_approval_mms = res.data.status_mms_4
            const waiting_approval_lms = res.data.status_lms_4


            const kritik_saran_waiting_respon = res.data.status_kritiksaran_2
            const kritik_saran_all = res.data.status_kritiksaran_not_4


            $('#notif-menu').empty();
            $('#count_notif').empty();
            if (roles == 63) {
                $('#count_notif').append(res.jumlah_count)
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">
                        <a>MMS Menunggu Peninjauan (${waiting_peninjauan_mms})</a>    
                    </li>`
                );
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">LMS Menunggu Peninjauan (${waiting_peninjauan_lms})</li>`
                );
                // $('#notif-menu').append(
                //     `<li class="dropdowns-menu-item" mb-2 style="color: black">Kritik Saran Menunggu Respon (${kritik_saran_waiting_respon})</li>`
                // );
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item " style="color: black">Kritik Saran Belum Selesai (${kritik_saran_all})</li>`
                );
            }

            if (roles == 64) {
                $('#count_notif').append(res.jumlah_count)
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">MMS Menunggu Approval (${waiting_approval_mms})</li>`
                );
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">LMS Menunggu Approval (${waiting_approval_lms})</li>`
                );
                // $('#notif-menu').append(
                //     `<li class="dropdowns-menu-item" mb-2 style="color: black">Kritik Saran Waiting Respon (${kritik_saran_waiting_respon})</li>`
                // );
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item" style="color: black">Kritik Saran Belum Selesai (${kritik_saran_all})</li>`
                );
            }

            if (roles == 65) {
                $('#count_notif').append(res.jumlah_count)
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">MMS Menunggu Peninjauan (${waiting_peninjauan_mms})</li>`
                );
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">LMS Menunggu Approval (${waiting_peninjauan_lms})</li>`
                );
            }


            if (roles == 66) {
                $('#count_notif').append(res.jumlah_count)
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">MMS Menunggu Approval (${waiting_approval_mms})</li>`
                );
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">LMS Menunggu Approval (${waiting_approval_lms})</li>`
                );
            }

            if (roles == 67) {
                $('#count_notif').append(res.jumlah_count)
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">LMS Menunggu Approval (${waiting_peninjauan_lms})</li>`
                );
            }

        });
</script>
