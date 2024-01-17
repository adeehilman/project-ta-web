@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

    <div class="wrappers">
        <div class="wrapper_content">

            <div class="row me-3">
                <div class="col-sm-12">
                    <p class="h4 mt-2 mb-3">
                        <span><i class='bx bx-notepad me-1'></i></span>
                        Dashboard
                    </p>

                    <div class="row mb-3">
                        <div class="col-xl-4 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">

                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Karyawan Baru <span
                                                style="font-size: '20px'">(Bulan Ini)</span></h6>
                                        {{-- <div class="ms-auto">
                                            <select class="form-select form-select-sm">
                                                <option value="1" selected="">Minggu ini</option>
                                                <option value="2">Bulan ini</option>
                                            </select>
                                        </div> --}}
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h4 class="mb-3">
                                                <span class="counter-value"
                                                    data-target="500">{{ $dataTotalKaryawanBulanIni }}</span>
                                            </h4>
                                        </div>

                                        <div class="col-6">
                                            {{-- <div id="chart1" class="apex-charts mb-2"></div> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="180" height="74"
                                                viewBox="0 0 261 74" fill="none">
                                                <path
                                                    d="M2 72C2 72 39.2145 36.9009 57.9782 36.9009C76.7418 36.9009 95.8182 60.3003 107.389 60.3003C118.96 60.3003 142.415 20.8385 155.236 20.6402C168.058 20.4419 182.131 45.0312 192.138 44.8329C202.145 44.6346 260 2 260 2"
                                                    stroke="#1DB74E" stroke-width="3" />
                                                <circle cx="191.5" cy="44.5" r="4.5" fill="#1DB74E" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $persentaseKenaikanKaryawan }}
                                            %</span>
                                        <span class="ms-1 text-muted font-size-13">Dari Bulan lalu</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">

                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Pengguna Baru (Bulan Ini)</h6>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h4 class="mb-3">
                                                <span class="counter-value"
                                                    data-target="87">{{ $dataTotalPenggunaBaruBulanIni }}</span>
                                            </h4>
                                        </div>

                                        <div class="col-6">
                                            {{-- <div id="chart2" class="apex-charts mb-2"></div> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="180" height="74"
                                                viewBox="0 0 261 74" fill="none">
                                                <path
                                                    d="M2 72C2 72 39.2145 36.9009 57.9782 36.9009C76.7418 36.9009 95.8182 60.3003 107.389 60.3003C118.96 60.3003 142.415 20.8385 155.236 20.6402C168.058 20.4419 182.131 45.0312 192.138 44.8329C202.145 44.6346 260 2 260 2"
                                                    stroke="#1DB74E" stroke-width="3" />
                                                <circle cx="191.5" cy="44.5" r="4.5" fill="#1DB74E" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $persentaseKenaikanPengguna }}%</span>
                                        <span class="ms-1 text-muted font-size-13">Dari Bulan lalu</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Peminjam Laptop (Bulan Ini)</h6>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h4 class="mb-3">
                                                <span class="counter-value"
                                                    data-target="20">{{ $dataPeminjamLaptopBulanIni }}</span>
                                            </h4>
                                        </div>

                                        <div class="col-6">
                                            {{-- <div id="chart3" class="apex-charts mb-2"></div> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="180" height="74"
                                                viewBox="0 0 261 74" fill="none">
                                                <path
                                                    d="M2 72C2 72 39.2145 36.9009 57.9782 36.9009C76.7418 36.9009 95.8182 60.3003 107.389 60.3003C118.96 60.3003 142.415 20.8385 155.236 20.6402C168.058 20.4419 182.131 45.0312 192.138 44.8329C202.145 44.6346 260 2 260 2"
                                                    stroke="#1DB74E" stroke-width="3" />
                                                <circle cx="191.5" cy="44.5" r="4.5" fill="#1DB74E" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $persentaseKenaikanPeminjam }}
                                            %</span>
                                        <span class="ms-1 text-muted font-size-13">Dari Bulan lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        {{-- chart jumlah karyawan --}}
                        <div class="col-xl-4 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Jumlah Karyawan</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div id="chartDonutJumlahKaryawan" class="mb-2"></div>
                                        </div>
                                        <div class="col-6 my-auto" style="font-size: 13px">
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #3797D7"></i>
                                                <span> Laki laki <span
                                                        style="color: #3797D7">{{ $summaryJumlahKaryawan[0]->M }}</span>
                                                    {{ number_format((intVal($summaryJumlahKaryawan[0]->M) / intVal($summaryJumlahKaryawan[0]->TOTAL)) * 100) . '%' }}</span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #D74D58"></i>
                                                <span> Perempuan <span
                                                        style="color: #D74D58">{{ $summaryJumlahKaryawan[0]->F }}</span>
                                                    {{ number_format((intVal($summaryJumlahKaryawan[0]->F) / intVal($summaryJumlahKaryawan[0]->TOTAL)) * 100) . '%' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $dataTotalSummaryDalamSebulan[0]->TOTAL }}</span>
                                        <span class="ms-1 text-muted font-size-13">Karyawan baru dari Bulan ini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end chart jumlah karyawan --}}
                        {{-- chart rentang usia --}}
                        <div class="col-xl-4 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Rentang Usia</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div id="chartRentangUsia" class="mb-2"></div>
                                        </div>
                                        <div class="col-6 my-auto" style="font-size: 13px">
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #4AC571"></i>
                                                <span> 18-20 Tahun <span
                                                        style="color: #4AC571">{{ $dataRentangUsia[0]->umur_18_sampai_20 }}
                                                    </span>
                                                    <span>
                                                        @php
                                                            $pembilang = $dataRentangUsia[0]->umur_18_sampai_20;
                                                            $penyebut = $dataRentangUsia[0]->umur_18_sampai_20 + $dataRentangUsia[0]->umur_21_sampai_30 + $dataRentangUsia[0]->umur_31_sampai_40 + $dataRentangUsia[0]->umur_41_sampai_50 + $dataRentangUsia[0]->umur_51_sampai_60 + $dataRentangUsia[0]->umur_61_sampai_70;
                                                            $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                        @endphp
                                                        {{ $hasil_bagi }}%
                                                    </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #3797D7"></i>
                                                <span> 21-30 Tahun <span
                                                        style="color: #3797D7">{{ $dataRentangUsia[0]->umur_21_sampai_30 }}
                                                        <span>
                                                            @php
                                                                $pembilang = $dataRentangUsia[0]->umur_21_sampai_30;
                                                                $penyebut = $dataRentangUsia[0]->umur_18_sampai_20 + $dataRentangUsia[0]->umur_21_sampai_30 + $dataRentangUsia[0]->umur_31_sampai_40 + $dataRentangUsia[0]->umur_41_sampai_50 + $dataRentangUsia[0]->umur_51_sampai_60 + $dataRentangUsia[0]->umur_61_sampai_70 ;
                                                                $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                            @endphp
                                                            {{ $hasil_bagi }}%
                                                        </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #DE9137"></i>
                                                <span> 31-40 Tahun <span
                                                        style="color: #DE9137">{{ $dataRentangUsia[0]->umur_31_sampai_40 }}</span>
                                                    <span>
                                                        @php
                                                            $pembilang = $dataRentangUsia[0]->umur_31_sampai_40;
                                                            $penyebut = $dataRentangUsia[0]->umur_18_sampai_20 + $dataRentangUsia[0]->umur_21_sampai_30 + $dataRentangUsia[0]->umur_31_sampai_40 + $dataRentangUsia[0]->umur_41_sampai_50 + $dataRentangUsia[0]->umur_51_sampai_60 + $dataRentangUsia[0]->umur_61_sampai_70;
                                                            $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                        @endphp
                                                        {{ $hasil_bagi }}%
                                                    </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #CD202E"></i>
                                                <span> 41-50 Tahun <span
                                                        style="color: #CD202E">{{ $dataRentangUsia[0]->umur_41_sampai_50 }}</span>
                                                    <span>
                                                        @php
                                                            $pembilang = $dataRentangUsia[0]->umur_41_sampai_50;
                                                            $penyebut = $dataRentangUsia[0]->umur_18_sampai_20 + $dataRentangUsia[0]->umur_21_sampai_30 + $dataRentangUsia[0]->umur_31_sampai_40 + $dataRentangUsia[0]->umur_41_sampai_50 + $dataRentangUsia[0]->umur_51_sampai_60 + $dataRentangUsia[0]->umur_61_sampai_70;
                                                            $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                        @endphp
                                                        {{ $hasil_bagi }}%
                                                    </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #7D37D7"></i>
                                                <span> 51-60 Tahun <span
                                                        style="color: #7D37D7">{{ $dataRentangUsia[0]->umur_51_sampai_60 }}</span>
                                                    <span>
                                                        @php
                                                            $pembilang = $dataRentangUsia[0]->umur_51_sampai_60;
                                                            $penyebut = $dataRentangUsia[0]->umur_18_sampai_20 + $dataRentangUsia[0]->umur_21_sampai_30 + $dataRentangUsia[0]->umur_31_sampai_40 + $dataRentangUsia[0]->umur_41_sampai_50 + $dataRentangUsia[0]->umur_51_sampai_60 + $dataRentangUsia[0]->umur_61_sampai_70;
                                                            $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                        @endphp
                                                        {{ $hasil_bagi }}%
                                                    </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #7D37D7"></i>
                                                <span> 61-70 Tahun <span
                                                        style="color: #7D37D7">{{ $dataRentangUsia[0]->umur_61_sampai_70 }}</span>
                                                    <span>
                                                        @php
                                                            $pembilang = $dataRentangUsia[0]->umur_51_sampai_60;
                                                            $penyebut = $dataRentangUsia[0]->umur_18_sampai_20 + $dataRentangUsia[0]->umur_21_sampai_30 + $dataRentangUsia[0]->umur_31_sampai_40 + $dataRentangUsia[0]->umur_41_sampai_50 + $dataRentangUsia[0]->umur_51_sampai_60 + $dataRentangUsia[0]->umur_61_sampai_70;
                                                            $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                        @endphp
                                                        {{ $hasil_bagi }}%
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $dataTotalKaryawanBulanIni }}</span>
                                        <span class="ms-1 text-muted font-size-13">Karyawan baru dari Bulan lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end chart rentang usia --}}
                        {{-- chart rentang usia --}}
                        <div class="col-xl-4 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Perangkat Pengguna </h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div id="chartPerangkat" class="mb-2"></div>
                                        </div>
                                        {{-- {{ count($dataOS) }} --}}
                                        <div class="col-6 my-auto" style="font-size: 13px">
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #D74D58"></i>
                                                <span> Android <span style="color: #D74D58">{{ $dataOSAndroid }}</span>
                                                    <span>
                                                        @php
                                                            $pembilang = $dataOSAndroid;
                                                            $penyebut = $dataOSAndroid + $dataOSIOS + $dataOSUnknown;
                                                            $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                        @endphp
                                                        {{ $hasil_bagi }}%
                                                    </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #3797D7"></i>
                                                <span> IOS <span style="color: #3797D7">{{ $dataOSIOS }}</span>
                                                    <span>
                                                        @php
                                                            $pembilang = $dataOSIOS;
                                                            $penyebut = $dataOSAndroid + $dataOSIOS + $dataOSUnknown;
                                                            $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                        @endphp
                                                        {{ $hasil_bagi }}%
                                                    </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #EFE52B"></i>
                                                <span> Unknown OS <span style="color: #3797D7">{{ $dataOSUnknown }}</span>
                                                    <span>
                                                        <span>
                                                            @php
                                                                $pembilang = $dataOSUnknown;
                                                                $penyebut = $dataOSAndroid + $dataOSIOS + $dataOSUnknown;
                                                                $hasil_bagi = number_format(($pembilang / $penyebut) * 100);
                                                            @endphp
                                                            {{ $hasil_bagi }}%
                                                        </span>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $dataOSSebulan[0]->TOTAL }}</span>
                                        <span class="ms-1 text-muted font-size-13">Pengguna baru dari Bulan ini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end chart rentang usia --}}
                    </div>

                    <div class="row mb-3">
                        {{-- chart pengguna aplikasi --}}
                        <div class="col-xl-6 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Pengguna Aplikasi</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div id="chartPengguna" class="mb-2"></div>
                                        </div>
                                        <div class="col-6 my-auto" style="font-size: 13px">
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #D74D58"></i>
                                                <span> Terdaftar MMS <span
                                                        style="color: #D74D58">{{ $totalTerdaftarMMS }}</span>
                                                    {{ number_format((intval($totalTerdaftarMMS) / (intval($totalTidakTerdaftarMMS) + intval($totalTerdaftarMMS) + intval($totalPenggunaAplikasiMMS))) * 100) }}
                                                    %</span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #3797D7"></i>
                                                <span> Belum Terdaftar MMS <span
                                                        style="color: #3797D7">{{ $totalPenggunaAplikasiMMS }}</span>
                                                    {{ number_format((intval($totalPenggunaAplikasiMMS) / (intval($totalTidakTerdaftarMMS) + intval($totalTerdaftarMMS) + intval($totalPenggunaAplikasiMMS))) * 100) }}%</span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #EFE52B"></i>
                                                <span> Dalam proses pengecekan <span
                                                        style="color: #EFE52B">{{ $totalTidakTerdaftarMMS }}</span>
                                                    {{ number_format((intval($totalTidakTerdaftarMMS) / (intval($totalTidakTerdaftarMMS) + intval($totalTerdaftarMMS) + intval($totalPenggunaAplikasiMMS))) * 100) }}
                                                    %</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $dataTotalMMSSebulan[0]->TOTAL }}</span>
                                        <span class="ms-1 text-muted font-size-13">Pengguna baru di bulan ini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end chart pengguna aplikasi --}}
                        {{-- chart laptop --}}
                        <div class="col-xl-6 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h6 class="text-muted fw-bold me-2">Laptop</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div id="chartLaptop" class="mb-2"></div>
                                        </div>
                                        <div class="col-6 my-auto" style="font-size: 13px">
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #D74D58"></i>
                                                <span> Worker-Working Purpose (unlimited duration) </span><span
                                                    style="color: #D74D58">{{ $totalWorkerWorkingLMS }}</span>
                                                {{ number_format(($totalWorkerWorkingLMS / $totalWorkerWorkingLMS + $totalJangkaPanjangLMS + $totalJangkaPendekLMS) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #057DCD"></i>
                                                <span> Jangka Panjang (Durasi : > 1 Minggu) <span
                                                        style="color: #057DCD">{{ $totalJangkaPanjangLMS }}</span>
                                                    {{ number_format(($totalJangkaPanjangLMS / $totalWorkerWorkingLMS + $totalJangkaPanjangLMS + $totalJangkaPendekLMS) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="list__bullet">
                                                <i class="bx bxs-circle" style="color: #EFE52B"></i>
                                                <span> Jangka Pendek (Durasi : < 1 Minggu) <span style="color: #EFE52B">
                                                        {{ $totalJangkaPendekLMS }} </span>
                                                {{ number_format(($totalJangkaPendekLMS / $totalWorkerWorkingLMS + $totalJangkaPanjangLMS + $totalJangkaPendekLMS) * 100) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <i class="bx bx-line-chart text-success"></i>
                                        <span
                                            class="badge badge-soft-success text-success">{{ $dataTotalLMSSebulan[0]->TOTAL }}</span>
                                        <span class="ms-1 text-muted font-size-13">Peminjam Laptop terbaru bulan ini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end chart laptop --}}
                    </div>


                </div>

            </div>


        </div>
    </div>

@endsection

@section('script')

    <script>
        var options = {
            series: [{
                data: [2, 10, 18, 22, 36, 15, 47, 75, 65, 19, 14, 2, 47, 42, 15]
            }],
            chart: {
                type: 'line',
                height: 70,
                sparkline: {
                    enabled: true
                },
                // colors: ['#DCE6EC'],
                stroke: {
                    curve: "smooth",
                    width: 2
                },
                tooltip: {
                    fixed: {
                        enabled: !1
                    },
                    colors: ['#DCE6EC'],
                    x: {
                        show: !1
                    },
                    y: {
                        title: {
                            formatter: function(r) {
                                return ""
                            }
                        }
                    }
                },
                colors: ['#ff0000'],
            }
        };

        var optionsDonutJumlahKaryawan = {
            series: [parseInt('{{ $summaryJumlahKaryawan[0]->M }}'), parseInt('{{ $summaryJumlahKaryawan[0]->F }}')],
            labels: ['Laki-Laki', 'Perempuan'],
            chart: {
                type: 'donut',
                //   height: 200, 
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                width: 1
            },
            colors: ['#3797D7', '#D74D58'],
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                showAlways: true,
                                show: true
                            }
                        }
                    }
                }
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
            }
        };

        var optionsRentangUsia = {
            series: [{{ $dataRentangUsia[0]->umur_18_sampai_20 }}, {{ $dataRentangUsia[0]->umur_21_sampai_30 }},
                {{ $dataRentangUsia[0]->umur_31_sampai_40 }}, {{ $dataRentangUsia[0]->umur_41_sampai_50 }},
                {{ $dataRentangUsia[0]->umur_51_sampai_60 }},  {{ $dataRentangUsia[0]->umur_61_sampai_70 }}
            ],
            labels: ['18-20 Tahun', '21-30 Tahun', '31-40 Tahun', '41-50 Tahun', '51-60 Tahun', '61-70 Tahun'],
            chart: {
                type: 'donut',
                //   height: 200, 
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                width: 1
            },
            colors: ['#4AC571', '#3797D7', '#DE9137', '#CD202E', '#7D37D7'],
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                showAlways: true,
                                show: true
                            }
                        }
                    }
                }
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
            }
        };

        var optionsPerangkat = {
            series: [{{ $dataOSAndroid }}, {{ $dataOSIOS }}, {{ $dataOSUnknown }}],
            chart: {
                type: 'donut',
                //   height: 200, 
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                width: 1
            },
            colors: ['#3797D7', '#D74D58', '#EFE52B'],
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                showAlways: true,
                                show: true
                            }
                        }
                    }
                }
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
            }
        };


        var optionsPengguna = {
            series: [{{ $totalTerdaftarMMS }}, {{ $totalPenggunaAplikasiMMS }}, {{ $totalTidakTerdaftarMMS }}],
            labels: ['Terdaftar', 'Tidak Terdaftar', 'Proses Pengecekan'],
            chart: {
                type: 'donut',
                //   height: 200, 
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                width: 1
            },
            colors: ['#D74D58', '#3797D7', '#EFE52B'],
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                showAlways: true,
                                show: true
                            }
                        }
                    }
                }
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
            }
        };

        var optionsLaptop = {
            series: [{{ $totalWorkerWorkingLMS }}, {{ $totalJangkaPanjangLMS }}, {{ $totalJangkaPendekLMS }}],
            labels: ['Untlimated Duration', 'Jangka Panjang', 'Jangka Pendek'],
            chart: {
                type: 'donut',
                //   height: 200, 
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                width: 1
            },
            colors: ['#D74D58', '#057DCD', '#EFE52B'],
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                showAlways: true,
                                show: true
                            }
                        }
                    }
                }
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
            }
        };


        var chart1 = new ApexCharts(document.querySelector("#chart1"), options);
        var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
        var chart3 = new ApexCharts(document.querySelector("#chart3"), options);
        var chartDonutJumlahKaryawan = new ApexCharts(document.querySelector("#chartDonutJumlahKaryawan"),
            optionsDonutJumlahKaryawan);
        var chartRentangUsia = new ApexCharts(document.querySelector("#chartRentangUsia"), optionsRentangUsia);
        var chartPerangkat = new ApexCharts(document.querySelector("#chartPerangkat"), optionsPerangkat);
        var chartPengguna = new ApexCharts(document.querySelector("#chartPengguna"), optionsPengguna);
        var chartLaptop = new ApexCharts(document.querySelector("#chartLaptop"), optionsLaptop);
        chart1.render();
        chart2.render();
        chart3.render();
        chartDonutJumlahKaryawan.render();
        chartRentangUsia.render();
        chartPerangkat.render();
        chartPengguna.render();
        chartLaptop.render();

        function autoReload() {
            setTimeout(function() {
                location.reload();
            }, 30 * 60 * 1000); // 5 menit * 60 detik * 1000 milidetik
        }

        window.onload = function() {
            autoReload();
        };
    </script>

@endsection
