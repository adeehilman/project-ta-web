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
            Meeting Room
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
            @php
            $listAktif = request()->routeIs('list') ? '#dc3545' : '';
            $groupAktif = request()->routeIs('grup') ? 'text-danger' : '';
             @endphp
            @if ($userRole == 1 || $userRole == 2 || $userRole == 3)
            <li>
                <div class="icon-links mt-2">
                <a href="javascript:void(0)" style="width: 70px; "><i class="bx bx-user fs-5" style="color:{{ $listAktif }}"></i>
                        <span class="link_name">Karyawan</span>
                </a>
                <a href="javascript:void(0)" style="width: 70px;">
                <i class="bx bxs-chevron-down arrow"></i>
                </a>
            </div>
            <ul class="sub_menu">
                <li><a class="{{ request()->routeIs('list') ? 'text-danger' : '' }}"
                    href="{{ route('list') }}">List Karyawan</a></li>
            </ul>
            </li>
            @endif
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


                            <span class="link_name" style="margin-left:27px; margin-top:2px;">Meeting Room</span>
                        </a>
                        <a href="javascript:void(0)">
                            <i class='bx bxs-chevron-down arrow'></i>
                        </a>
                    </div>
                @endif


                <ul class="sub_menu">

                    <li><a class="link_name" href="javascript:void(0)">Meeting Room</a></li>
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
            {!! $userRole == 2 ? '<li>
                <div class="icon-links">
                    <a href="javascript:void(0)" style="width:70px">
                        <i class="bx bx-layer fs-5" style="color: ' . (request()->routeIs('userauthorize') ? '#dc3545' : '#41443D') . '"></i>
                        <span class="link_name" style="margin-left:0px; margin-top:2px;">Master Data</span>
                    </a>
                    <a href="javascript:void(0)">
                        <i class="bx bxs-chevron-down arrow"></i>
                    </a>
                </div>
                <ul class="sub_menu">
                    <li><a class="link_name" href="javascript:void(0)">Master Data</a></li>
                    <li><a class="' . (request()->routeIs('userauthorize') ? 'text-danger' : '') . '" href="' . route('userauthorize') . '">User Authorize</a></li>
                </ul>
            </li>' : '' !!}
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
