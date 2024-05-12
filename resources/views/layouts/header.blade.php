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
        font-weight: bold justify-content: center;
        align-items: center;
        font-size: 10px;
        border-radius: 50%;
    }

    .avatar {
        position: relative;
        display: inline-block;
        margin-right: 10px;
    }

    .avatar img.participant-img {
        border-radius: 50%;
        width: 70px;
        /* Sesuaikan dengan ukuran gambar Anda */
        height: 70px;
        /* Sesuaikan dengan ukuran gambar Anda */
    }

    .status {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 30px;
        /* Sesuaikan dengan ukuran lingkaran status */
        height: 30px;
        /* Sesuaikan dengan ukuran lingkaran status */
        background-color: #43b581;
        /* Warna hijau Discord */
        border-radius: 50%;
        border: 2px solid #fff;
        /* Tepi putih untuk memberi efek outline */
    }

    .status i {
        color: white;
        /* Warna ikon putih */
        font-size: 24px;
        /* Sesuaikan ukuran ikon */
    }

    .fc-col-header-cell-cushion {
        color: gray;
        text-transform: uppercase;
        float: left;
        text-decoration: none;
        font-weight: light;
        margin: 10px;
        /* Ganti dengan warna yang Anda inginkan */
    }

    .fc-col-header-cell-cushion .fc-day-sun {
        color: white !important;
    }


    th .fc-day-sun {
        background-color: #d74d58;
    }

    th .fc-day-sun a {
        color: white !important;
    }

    *[aria-label="Sunday"] {
        color: white !important;
    }


    #calendar {
        min-height: 100vh;
    }

    .fc-event-title {
        font-weight: bold;
    }

    /* .fc-scrollgrid-sync-inner a {
        color: white !important;
    } */

    td .fc-day-sun {
        background-color: #FAE9EA;
    }



    .fc-daygrid-day-number {
        /* Menggeser teks ke kiri */
        color: gray;
        text-transform: uppercase;
        text-decoration: none;
        font-size: 30px;
        font-weight: bold;
        pointer-events: none;
        font-family: 'Roboto';
    }

    .fc-daygrid-day-top {
        justify-content: start;
        margin: 10px;
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

                <button class="dropdowns-toggle bx bx-bell icon-button mt-3" data-toggle="notif-menu"
                    style="margin-right: 20px">
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
                                    <span>Change Password</span>
                                </a>
                            </li>
                            <li class="dropdowns-menu-item">
                                <a href="{{ route('auth.logout') }}" class="dropdowns-menu-link">
                                    <div>
                                        <i class='bx bx-log-out'></i>
                                    </div>
                                    <span>Log out</span>
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



            {!! $userRole !== 1 && $userRole !== 3
                ? '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a style="width:70px" href="' .
                    route('dashboard') .
                    '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <i class="bx bxs-dashboard fs-5 ' .
                    $dashboardAktif .
                    '"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <span class="link_name ' .
                    (request()->routeIs('dashboard') ? 'text-danger' : '') .
                    '">Dashboard</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <ul class="sub_menu blank">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a class="link_name ' .
                    (request()->routeIs('dashboard') ? 'text-danger' : '') .
                    '" href="' .
                    route('dashboard') .
                    '">Dashboard</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                '
                : '' !!}
            @php
                $listAktif = request()->routeIs('list') ? 'text-danger' : '';
                $groupAktif = request()->routeIs('grup') ? 'text-danger' : '';
            @endphp
            {!! $userRole == 63 || $userRole == 64 || $userRole == 1 || $userRole == 3
                ? '<li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="icon-links mt-2">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="javascript:void(0)" style="width: 70px; ">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <i class="bx bx-user fs-5 ' .
                    $listAktif .
                    ' ' .
                    $groupAktif .
                    '"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <span class="link_name">Karyawan</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="javascript:void(0)" style="width: 70px;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="bx bxs-chevron-down arrow"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="sub_menu">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <a class="' .
                    $listAktif .
                    '" href="' .
                    route('list') .
                    '">List Karyawan</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </li>' .
                    ($userRole == 63 || $userRole == 64
                        ? '<li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a class="' .
                            $groupAktif .
                            '" href="' .
                            route('grup') .
                            '">Grup Karyawan</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li>'
                        : '') .
                    '
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

            @if (in_array($userRole, [63, 64]))
                <li>
                    @php
                        $updateemployeedataAktif = request()->routeIs('dataProcess') ? '#dc3545' : (request()->routeIs('dataReport') ? '#dc3545' : '#41443D');
                    @endphp


                    {{-- @if (in_array($userRole, [84, 85])) --}}
                    <div class="icon-links">
                        <a href="{{ route('dataProcess') }}" style="width:70px">

                        <span class="mt-1" style="margin-left:30px;">
                            <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="Group">
                                    <rect id="Rectangle 131" x="0.75" y="0.75" width="16.5" height="20.5" rx="1.25" stroke="{{ $updateemployeedataAktif }}" stroke-width="1.5"/>
                                    <g id="Group 166">
                                        <path id="Vector" d="M3.84635 15.9696C4.59525 15.9696 6.67716 15.9696 6.67716 15.9696C6.67716 15.9696 8.75869 15.9696 9.508 15.9696C10.2565 15.9696 10.5964 14.8632 10.1631 14.0813C9.83682 13.4919 9.30216 12.8238 8.43205 12.4443C7.93403 12.7985 7.32901 13.0068 6.67716 13.0068C6.02456 13.0068 5.42032 12.7985 4.92226 12.4443C4.05183 12.8238 3.51749 13.4919 3.19085 14.0813C2.75799 14.8632 3.09746 15.9696 3.84635 15.9696Z" fill="{{ $updateemployeedataAktif }}"/>
                                        <path id="Vector_2" d="M6.67746 12.2664C7.95626 12.2664 8.9923 11.2143 8.9923 9.91516V9.35191C8.9923 8.05281 7.95631 7 6.67746 7C5.39867 7 4.3623 8.05281 4.3623 9.35191V9.91516C4.3623 11.2143 5.39867 12.2664 6.67746 12.2664Z" fill="{{ $updateemployeedataAktif }}"/>
                                    </g>
                                    <path id="Vector_3" d="M14.025 13.3076V9.82113C13.6092 9.99197 13.1639 10.0794 12.7144 10.0785C12.2648 10.0795 11.8194 9.99202 11.4035 9.82113L11.4035 13.3076C11.4035 13.5796 11.4035 13.7159 11.42 13.8493C11.4394 14.0068 11.4759 14.1617 11.5289 14.3113C11.5739 14.4378 11.6349 14.5597 11.7566 14.8029L12.3979 16.0863C12.4272 16.1452 12.4723 16.1947 12.5282 16.2293C12.5841 16.2639 12.6485 16.2822 12.7142 16.2822C12.7799 16.2822 12.8444 16.2639 12.9002 16.2293C12.9561 16.1947 13.0012 16.1452 13.0305 16.0863L13.6719 14.8029C13.7937 14.5595 13.8545 14.4378 13.8996 14.3113C13.9526 14.1616 13.9891 14.0067 14.0085 13.8493C14.025 13.7159 14.025 13.5796 14.025 13.3076ZM14.025 8.85381C14.025 8.50618 13.8869 8.17279 13.641 7.92697C13.3952 7.68116 13.0618 7.54307 12.7142 7.54307C12.3666 7.54307 12.0332 7.68116 11.7874 7.92698C11.5416 8.17279 11.4035 8.50618 11.4035 8.85381V9.27194L11.4386 9.28915C11.8364 9.48092 12.2726 9.57989 12.7142 9.57859C13.1691 9.57993 13.6179 9.47492 14.025 9.27194L14.025 8.85381Z" fill="{{ $updateemployeedataAktif }}"/>
                                </g>
                            </svg>
                        </span>



                        <span class="link_name" style="margin-left:0px; margin-top:2px; margin-left:27px;">Update Employee Data</span>
                        </a>
                        <a href="javascript:void(0)">
                            <i class='bx bxs-chevron-down arrow'></i>
                        </a>
                    </div>
                    {{-- @endif --}}

                    <ul class="sub_menu">


                        <li>
                            <a class="link_name {{ (request()->routeIs('dataProcess') || request()->routeIs('dataReport') || request()->routeIs('dataNotice')) ? 'text-danger' : '' }}">Pengkinian Data</a>
                        </li>
                        {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 3 || $userRole == 1
                        ? ' <li>
                            <a class="{{ $updateemployeedataAktif }}" href="' . route('dataProcess') .'">Proses Pengkinian Data</a>
                            <a class="{{ $updateemployeedataAktif }}" href="' . route('dataReport') .'">Laporan Pengkinian Data</a>
                            <a class="{{ $updateemployeedataAktif }}" href="' . route('dataNotice') .'">Pengumuman Pengkinian Data</a>

                            </li>
                          '
                        : '' !!}

                        @php
                            $updateemployeedataAktif = request()->routeIs('meetingSummary') ? 'text-danger' : '';
                        @endphp





                    </ul>


                </li>
            @endif

            <li>
                @php
                    $mmsAktif = request()->routeIs('mms') ? 'text-danger' : '';
                    $lmsAktif = request()->routeIs('lms') ? 'text-danger' : '';
                    $lpbAktif = request()->routeIs('lpb') ? 'text-danger' : '';
                @endphp
                {!! $userRole !== 1 && $userRole !== 3
                    ? '<div class="icon-links mt-2">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="javascript:void(0)" style="width: 70px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="bx bx-devices fs-5 ' .
                        $mmsAktif .
                        ' ' .
                        $lmsAktif .
                        ' ' .
                        $lpbAktif .
                        '"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <span class="link_name">Device Manager</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="javascript:void(0)">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="bx bxs-chevron-down arrow"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>'
                    : '' !!}
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
                    @php
                        $lmsAktif = request()->routeIs('lms') ? 'text-danger' : '';
                    @endphp
                    {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66 || $userRole == 67
                        ? '<li><a class="' .
                            $lmsAktif .
                            '"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        href="' .
                            route('lms') .
                            '">Laptop Management System</a></li>'
                        : '' !!}
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a style="width:70px; margin-top: 10px;" href="' .
                    route('pemberitahuan') .
                    '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="bx bx-bell fs-5 ' .
                    $pemberitahuanAktif .
                    '"></i>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a style="width:70px" href="' .
                    route('kritik') .
                    '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="bx bx-message-error fs-5 ' .
                    $kritikAktif .
                    '"></i>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a style="width:70px" href="' .
                    route('loker') .
                    '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="bx bx-briefcase-alt-2 fs-5 ' .
                    $lokerAktif .
                    '" ></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="link_name ' .
                    $lokerAktif .
                    '">Lowongan Kerja</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <ul class="sub_menu blank">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a class="link_name ' .
                    $lokerAktif .
                    '" href="' .
                    route('loker') .
                    '">Lowongan Kerja</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li>'
                : '' !!}

            <li>
                @php
                    $meetingAktif = request()->routeIs('room') ? '#dc3545' : (request()->routeIs('meeting') ? '#dc3545' : '#41443D');
                @endphp

                @if (in_array($userRole, [1, 3]))
                    <div class="icon-links">
                        <a href="javascript:void(0)" style="width:70px">
                            <span class="mt-2" style="margin-left:27px;">
                                <svg width="24" font-weight="bold" height="24" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.25294 17.6601H23.747M16 17.6601V29.2806M9.91302 14.8933V9.91302H8.61595C7.87891 9.91303 7.16282 10.1583 6.58053 10.6101C5.99824 11.062 5.58285 11.6947 5.39982 12.4087L3.27271 20.7035V20.9802H11.0197V22.6403C11.0197 24.3004 11.0197 25.4071 11.8498 27.0672C11.8498 27.0672 12.6798 28.7273 13.7865 28.7273M22.0869 14.8933V9.91302H23.384C24.121 9.91303 24.8371 10.1583 25.4194 10.6101C26.0017 11.062 26.4171 11.6947 26.6001 12.4087L28.7273 20.7035V20.9802H20.9802V22.6403C20.9802 24.3004 20.9802 25.4071 20.1502 27.0672C20.1502 27.0672 19.3201 28.7273 18.2134 28.7273M9.74701 7.69958C9.74701 7.69958 7.97626 6.59286 7.97626 5.20946C7.97626 4.69639 8.18008 4.20433 8.54288 3.84153C8.90568 3.47874 9.39773 3.27492 9.91081 3.27492C10.4239 3.27492 10.9159 3.47874 11.2787 3.84153C11.6415 4.20433 11.8454 4.69639 11.8454 5.20946C11.8454 6.59286 10.079 7.69958 10.079 7.69958H9.74701ZM22.2529 7.69958C22.2529 7.69958 24.0237 6.59286 24.0237 5.20946C24.0237 4.6958 23.8196 4.20318 23.4564 3.83997C23.0932 3.47676 22.6006 3.27271 22.0869 3.27271C21.0178 3.27271 20.1546 4.14037 20.1546 5.20946C20.1546 6.59286 21.9209 7.69958 21.9209 7.69958H22.2529Z"
                                        stroke="{{ $meetingAktif }}" stroke="black" stroke-width="1.5" />
                                </svg>
                            </span>

                            <!-- <i class='bx bx-devices fs-5 {{ $mmsAktif }}'></i> -->
                            <span class="link_name" style="margin-left:27px; margin-top:2px;">Meeting Room</span>
                        </a>
                        <a href="javascript:void(0)">
                            <i class='bx bxs-chevron-down arrow'></i>
                        </a>
                    </div>
                @endif

                <ul class="sub_menu">

                    <li><a class="link_name" href="javascript:void(0)">Meeting Room</a></li>

                    {{-- {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66 || $userRole == 84
                        ? '<li><a class="' .
                            $meetingAktif .
                            '"
                                                                                                                                                                                                                                                                                                    href="' .
                            route('meeting') .
                            '">List Meeting</a></li>'
                        : '' !!} --}}
                    <li><a class="{{ request()->routeIs('meeting') ? 'text-danger' : '' }}"
                            href="{{ route('meeting') }}">List Meeting</a></li>
                    @php
                        $meetingAktif = request()->routeIs('room') ? 'text-danger' : '';
                    @endphp

                    @if (in_array($userRole, [1, 3]))
                        <li>
                            <a class="{{ request()->routeIs('room') ? 'text-danger' : '' }}"
                                href="{{ route('room') }}">List Room</a>
                        </li>
                    @endif

                </ul>


            </li>

            {{-- <li>
                @php
                    $meetingAktif = request()->routeIs('room') ? '#dc3545' : (request()->routeIs('meeting') ? '#dc3545' : '#41443D');
                @endphp

                @if (in_array($userRole, [84, 85]))
                    <div class="icon-links">
                        <a href="javascript:void(0)" style="width:70px">
                            <i class='bx bx-menu-alt-left'></i>
                            <!-- <i class='bx bx-devices fs-5 {{ $mmsAktif }}'></i> -->
                            <span class="link_name" style="margin-left:27px; margin-top:2px;">Meeting Room</span>
                        </a>
                        <a href="javascript:void(0)">
                            <i class='bx bxs-chevron-down arrow'></i>
                        </a>
                    </div>
                @endif

                <ul class="sub_menu">


                    <li><a class="{{ request()->routeIs('meetingSummary') ? 'text-danger' : '' }}"
                            href="{{ route('meetingSummary') }}">Meeting Summary</a></li>

                </ul>


            </li> --}}
            <li>
                @php
                    $reportAktif = request()->routeIs('meetingSummary') ? '#dc3545' : (request()->routeIs('roomsummary') ? '#dc3545' : (request()->routeIs('meetingDetailSummary') ? '#dc3545' : (request()->routeIs('/meetingsummary/detailSummary') ? '#dc3545' : (request()->routeIs('/roomsummary/detailSummary') ? '#dc3545' : '#41443D'))));
                @endphp

                @if (in_array($userRole, [1, 3]))
                    <div class="icon-links">
                        <a href="javascript:void(0)" style="width:70px">
                            <i class="bx bx-file fs-5" style="color: {{ $reportAktif }}"></i>

                            <span class="link_name" style="margin-left:0px; margin-top:2px;">Meeting Report</span>
                        </a>
                        <a href="javascript:void(0)">
                            <i class='bx bxs-chevron-down arrow'></i>
                        </a>
                    </div>
                @endif

                <ul class="sub_menu">

                    <li><a class="link_name" href="javascript:void(0)">Meeting Report</a></li>

                    {{-- {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66 || $userRole == 84
                        ? '<li><a class="' .
                            $meetingAktif .
                            '"
                                                                                                                                                                                                                                                                                                    href="' .
                            route('meeting') .
                            '">List Meeting</a></li>'
                        : '' !!} --}}
                    <li><a class="{{ (request()->routeIs('meetingSummary') ? 'text-danger' : request()->routeIs('/meetingsummary/detailSummary')) ? 'text-danger' : '' }}"
                            href="{{ route('meetingSummary') }}">Meeting Summary</a></li>
                    @php
                        $reportAktif = request()->routeIs('meetingSummary') ? 'text-danger' : '';
                    @endphp

                    @if (in_array($userRole, [1, 3]))
                        <li>
                            <a class="{{ (request()->routeIs('roomsummary') ? 'text-danger' : request()->routeIs('/roomsummary/detailSummary')) ? 'text-danger' : '' }}"
                                href="{{ route('roomsummary') }}">Room Summary</a>
                        </li>
                    @endif

                </ul>


            </li>
            @if (in_array($userRole, [63, 64]))
                <li>
                    @php
                        $reportAktif = request()->routeIs('calendar') ? '#dc3545' : (request()->routeIs('roomsummary') ? '#dc3545' : (request()->routeIs('meetingDetailSummary') ? '#dc3545' : (request()->routeIs('/meetingsummary/detailSummary') ? '#dc3545' : (request()->routeIs('/roomsummary/detailSummary') ? '#dc3545' : '#41443D'))));
                    @endphp

                    {{-- @if (in_array($userRole, [84, 85])) --}}
                    <div class="icon-links">
                        <a href="javascript:void(0)" style="width:70px">
                            <i class="bx bx-calendar fs-5" style="color: {{ $reportAktif }}"></i>

                            <span class="link_name" style="margin-left:0px; margin-top:2px;">Calendar</span>
                        </a>
                        <a href="javascript:void(0)">
                            <i class='bx bxs-chevron-down arrow'></i>
                        </a>
                    </div>
                    {{-- @endif --}}

                    <ul class="sub_menu">



                        {{-- {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66 || $userRole == 84
                        ? '<li><a class="' .
                            $meetingAktif .
                            '"
                                                                                                                                                                                                                                                                                                    href="' .
                            route('meeting') .
                            '">List Meeting</a></li>'
                        : '' !!} --}}
                        <li><a class="{{ (request()->routeIs('calendar') ? 'text-danger' : request()->routeIs('/calendar/detailSummary')) ? 'text-danger' : '' }}"
                                href="{{ route('calendar') }}">Calendar</a></li>
                        @php
                            $reportAktif = request()->routeIs('meetingSummary') ? 'text-danger' : '';
                        @endphp





                    </ul>


                </li>
            @endif
            <li>
                @php
                    $userAktif = request()->routeIs('user') ? '#dc3545' : (request()->routeIs('userrole') ? '#dc3545' : '#555851');
                @endphp
                {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66
                    ? '<div class="icon-links mt-2">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="javascript:void(0)" style="width:70px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <span class="mt-3" style="margin-left:27px;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <svg width="30" height="30" viewBox="0 0 32 32" fill="' .
                        $userAktif .
                        '" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <path d="M20 2H8a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-6 2.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM19 15H9v-.25C9 12.901 11.254 11 14 11s5 1.901 5 3.75V15z"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        stroke="{{ $userAktif }}" stroke-width="1" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <path d="M4 8H2v12c0 1.103.897 2 2 2h12v-2H4V8z"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        stroke="{{ $userAktif }}" stroke-width="1" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </svg>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <span class="link_name" style="margin-left:22px; ">User Account</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="javascript:void(0)">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="bx bxs-chevron-down arrow"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>'
                    : '' !!}
                <ul class="sub_menu mt-4">

                    <li>
                        <a class="link_name" href="javascript:void(0)">User Account</a>
                    </li>




                </ul>
            </li>
            @if (in_array($userRole, [63, 64]))
                <li>
                    @php
                        $internAktif = request()->routeIs('internship') ? '#dc3545' : (request()->routeIs('/internship/detailInternship') ? '#dc3545' : '#555851');
                    @endphp


                    {{-- @if (in_array($userRole, [84, 85])) --}}
                    <div class="icon-links">
                        <a href="{{ route('internship') }}" style="width:70px">

                            <span class="mt-2" style="margin-left:27px;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="users-check">
                                        <path id="Icon"
                                            d="M16 18L18 20L22 16M12 15H8C6.13623 15 5.20435 15 4.46927 15.3045C3.48915 15.7105 2.71046 16.4892 2.30448 17.4693C2 18.2044 2 19.1362 2 21M15.5 3.29076C16.9659 3.88415 18 5.32131 18 7C18 8.67869 16.9659 10.1159 15.5 10.7092M13.5 7C13.5 9.20914 11.7091 11 9.5 11C7.29086 11 5.5 9.20914 5.5 7C5.5 4.79086 7.29086 3 9.5 3C11.7091 3 13.5 4.79086 13.5 7Z"
                                            stroke="{{ $internAktif }}" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </g>
                                </svg>
                            </span>


                            <span class="link_name"
                                style="margin-left:0px; margin-top:2px; margin-left:27px;">Internship
                                Attendance</span>
                        </a>
                        <a href="javascript:void(0)">
                            <i class='bx bxs-chevron-down arrow'></i>
                        </a>
                    </div>
                    {{-- @endif --}}

                    <ul class="sub_menu">


                        <li>
                            <a class="link_name {{ (request()->routeIs('internship') ? 'text-danger' : request()->routeIs('/internship/detailInternship')) ? 'text-danger' : '' }}" href="{{ route('internship') }}">Internship Attendance</a>
                        </li>
                        {{-- {!! $userRole == 63 || $userRole == 64 || $userRole == 65 || $userRole == 66 || $userRole == 84
                        ? '<li><a class="' .
                            $meetingAktif .
                            '"
                                                                                                                                                                                                                                                                                                    href="' .
                            route('meeting') .
                            '">List Meeting</a></li>'
                        : '' !!} --}}

                        @php
                            $internAktif = request()->routeIs('meetingSummary') ? 'text-danger' : '';
                        @endphp





                    </ul>


                </li>
            @endif



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

            const waiting_meeting = res.data.status_wait_meeting_2
            const meeting_berlangsung = res.data.status_meeting_now_2

            $('#notif-menu').empty();
            $('#count_notif').empty();


            if (roles == 1) {
                $('#count_notif').append(res.jumlah_count)
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">
                    <a style="text-decoration:none; color:black" href="{{ route('meeting') }}${waiting_meeting > 0 ? '?filter=true' : ''}">Waiting Meeting Hari Ini  (${waiting_meeting})</a>
                    </li>`
                );
                $('#notif-menu').append(
                    `<li class="dropdowns-menu-item mb-2" style="color: black">
                    <a style="text-decoration:none; color:black" href="{{ route('meeting') }}${meeting_berlangsung > 0 ? '?now=true' : ''}">Meeting Sedang Berlangsung  (${meeting_berlangsung})</a>
                    </li>`
                );
            }

        });
</script>
