@extends('layouts.app')
@section('title', 'Pengkinian Data Report')


@section('content')

    <div class="wrappers">
        <div class="wrapper_content">

            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h4 mt-6">
                        Pengkinian Data Report
                    </p>
                </div>

                          {{--  --}}
                          <div class="col-sm-12 mt-2 d-flex justify-content-between">
                            <div class="d-flex gap-3">
                                {{-- Search --}}
                                <input id="txSearch" type="text" style="width: 250px;" class="form-control rounded-3" placeholder="Cari...">
                        
                                {{-- filter --}}
                                <select class="form-select" id="editworkarea"> <!-- Sesuaikan dengan lebar yang diinginkan -->
                                    <option value="" selected>Semua Departemen</option>
                                    @foreach ($listdept as $r)
                                        <option value="{{$r->dept_name}}">{{$r->dept_name}}</option>
                                    @endforeach
                                </select>
                        
                                <button id="monthEvent" class="btn btn-light form-control" style="border: 1px solid #e9ecef; width: 150px;"> <!-- Sesuaikan dengan lebar yang diinginkan -->
                                    <span id="calendarTitle" class="fs-6"></span>
                                </button>
                        
                                <button type="button" class="btn btn-outline-secondary" id="resetButton" style="width: 100px;">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class='bx bx-refresh bx-rotate-90 fs-4'></i>
                                        Reset
                                    </div>
                                </button>
                            </div>
                            {{-- Button Export --}}
                        <form method="POST" action="{{ route('exportreport') }}">
                            @csrf
                            <input type="hidden" name="searchexportpengkinianreport" id='searchexportpengkinianreport'>
                            <input type="hidden" name="dateexportpengkinianreport" id='dateexportpengkinianreport'>
                            <input type="hidden" name="deptexportpengkinianreport" id='deptexportpengkinianreport'>
                            <button type="submit" class="btn btn-outline-danger ml-auto me-2">
                                Export
                            </button>
                        </form>  
                    </div>
                </div>

                <div class="text-end col-sm-9 d-flex mt-2 mb-2 rounded-3">
                </div>

                <div id="containerReportPengkinian" class="col-sm-12 mt-1">
                    {{-- <table id="tablereportpengkinian" class="table table-responsive table-hover" style="font-size: 16px">
                        <thead>
                            <tr class="table-danger ">
                                <th scope="col">Employee name</th>
                                <th scope="col">Employee No</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Line Code</th>
                                <th scope="col">Data Updated</th>
                                <th scope="col">Created On</th>
                                <th scope="col">Updatetd On</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <td>Abdurrahman</td>
                                <td>123</td>
                                <td>Dot</td>
                                <td>DR11-A2</td>
                                <td>Agana</td>
                                <td>12 Desember 2023</td>
                                <td>12 Desember 2023</td>
                                <td>
                                    <span style="background-color: #1DB74E; color: #ffffff; border-radius: 5px; padding: 5px;">Completed</span>
                                </td>
                                <td>
                                    <a class="btn btnDetailDriver" onclick="redirectToDetailPengkiniandata()" data-bs-toggle="modal">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M23.0136 11.7722C22.9817 11.6991 22.2017 9.96938 20.4599 8.2275C18.8436 6.61313 16.0667 4.6875 11.9999 4.6875C7.93299 4.6875 5.15611 6.61313 3.53986 8.2275C1.79799 9.96938 1.01799 11.6962 0.986113 11.7722C0.954062 11.8442 0.9375 11.9221 0.9375 12.0009C0.9375 12.0798 0.954062 12.1577 0.986113 12.2297C1.01799 12.3019 1.79799 14.0316 3.53986 15.7734C5.15611 17.3878 7.93299 19.3125 11.9999 19.3125C16.0667 19.3125 18.8436 17.3878 20.4599 15.7734C22.2017 14.0316 22.9817 12.3047 23.0136 12.2297C23.0457 12.1577 23.0622 12.0798 23.0622 12.0009C23.0622 11.9221 23.0457 11.8442 23.0136 11.7722ZM11.9999 18.1875C9.05799 18.1875 6.48924 17.1169 4.36393 15.0066C3.473 14.1211 2.71908 13.1078 2.12705 12C2.71891 10.8924 3.47285 9.87932 4.36393 8.99438C6.48924 6.88313 9.05799 5.8125 11.9999 5.8125C14.9417 5.8125 17.5105 6.88313 19.6358 8.99438C20.5269 9.87932 21.2808 10.8924 21.8727 12C21.2755 13.1447 18.2811 18.1875 11.9999 18.1875ZM11.9999 7.6875C11.1469 7.6875 10.3132 7.94042 9.60397 8.41429C8.89478 8.88815 8.34204 9.56167 8.01563 10.3497C7.68923 11.1377 7.60383 12.0048 7.77023 12.8413C7.93663 13.6779 8.34735 14.4463 8.95047 15.0494C9.55358 15.6525 10.322 16.0632 11.1585 16.2296C11.9951 16.396 12.8622 16.3106 13.6502 15.9842C14.4382 15.6578 15.1117 15.1051 15.5856 14.3959C16.0594 13.6867 16.3124 12.8529 16.3124 12C16.3109 10.8567 15.856 9.76067 15.0476 8.95225C14.2392 8.14382 13.1432 7.68899 11.9999 7.6875ZM11.9999 15.1875C11.3694 15.1875 10.7532 15.0006 10.229 14.6503C9.7048 14.3001 9.29625 13.8022 9.055 13.2198C8.81374 12.6374 8.75062 11.9965 8.87361 11.3781C8.9966 10.7598 9.30018 10.1919 9.74596 9.7461C10.1917 9.30032 10.7597 8.99674 11.378 8.87375C11.9963 8.75076 12.6372 8.81388 13.2197 9.05513C13.8021 9.29639 14.2999 9.70494 14.6502 10.2291C15.0004 10.7533 15.1874 11.3696 15.1874 12C15.1874 12.8454 14.8515 13.6561 14.2538 14.2539C13.656 14.8517 12.8452 15.1875 11.9999 15.1875Z" fill="#60625D"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <tr class="align-middle">
                                <td>Alex Sirait</td>
                                <td>123243</td>
                                <td>Dot</td>
                                <td>DR11-A2</td>
                                <td>Surat pindah</td>
                                <td>12 Desember 2023</td>
                                <td>12 Desember 2023</td>
                                <td>
                                    <span style="background-color: #d44444; color: #ffffff; border-radius: 5px; padding: 5px;">Reject</span>
                                </td>
                                <td>
                                    <a class="btn btnDetailDriver" onclick="redirectToDetailPengkiniandata()" data-bs-toggle="modal">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M23.0136 11.7722C22.9817 11.6991 22.2017 9.96938 20.4599 8.2275C18.8436 6.61313 16.0667 4.6875 11.9999 4.6875C7.93299 4.6875 5.15611 6.61313 3.53986 8.2275C1.79799 9.96938 1.01799 11.6962 0.986113 11.7722C0.954062 11.8442 0.9375 11.9221 0.9375 12.0009C0.9375 12.0798 0.954062 12.1577 0.986113 12.2297C1.01799 12.3019 1.79799 14.0316 3.53986 15.7734C5.15611 17.3878 7.93299 19.3125 11.9999 19.3125C16.0667 19.3125 18.8436 17.3878 20.4599 15.7734C22.2017 14.0316 22.9817 12.3047 23.0136 12.2297C23.0457 12.1577 23.0622 12.0798 23.0622 12.0009C23.0622 11.9221 23.0457 11.8442 23.0136 11.7722ZM11.9999 18.1875C9.05799 18.1875 6.48924 17.1169 4.36393 15.0066C3.473 14.1211 2.71908 13.1078 2.12705 12C2.71891 10.8924 3.47285 9.87932 4.36393 8.99438C6.48924 6.88313 9.05799 5.8125 11.9999 5.8125C14.9417 5.8125 17.5105 6.88313 19.6358 8.99438C20.5269 9.87932 21.2808 10.8924 21.8727 12C21.2755 13.1447 18.2811 18.1875 11.9999 18.1875ZM11.9999 7.6875C11.1469 7.6875 10.3132 7.94042 9.60397 8.41429C8.89478 8.88815 8.34204 9.56167 8.01563 10.3497C7.68923 11.1377 7.60383 12.0048 7.77023 12.8413C7.93663 13.6779 8.34735 14.4463 8.95047 15.0494C9.55358 15.6525 10.322 16.0632 11.1585 16.2296C11.9951 16.396 12.8622 16.3106 13.6502 15.9842C14.4382 15.6578 15.1117 15.1051 15.5856 14.3959C16.0594 13.6867 16.3124 12.8529 16.3124 12C16.3109 10.8567 15.856 9.76067 15.0476 8.95225C14.2392 8.14382 13.1432 7.68899 11.9999 7.6875ZM11.9999 15.1875C11.3694 15.1875 10.7532 15.0006 10.229 14.6503C9.7048 14.3001 9.29625 13.8022 9.055 13.2198C8.81374 12.6374 8.75062 11.9965 8.87361 11.3781C8.9966 10.7598 9.30018 10.1919 9.74596 9.7461C10.1917 9.30032 10.7597 8.99674 11.378 8.87375C11.9963 8.75076 12.6372 8.81388 13.2197 9.05513C13.8021 9.29639 14.2999 9.70494 14.6502 10.2291C15.0004 10.7533 15.1874 11.3696 15.1874 12C15.1874 12.8454 14.8515 13.6561 14.2538 14.2539C13.656 14.8517 12.8452 15.1875 11.9999 15.1875Z" fill="#60625D"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script>

const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

            $('#editworkarea').select2({
                theme: "bootstrap-5",
                width: '250px'
            });

            let selectdept;
            let result = '';


            const getlistpengkinian = () => {
            const txSearch = $('#txSearch').val();
            $.ajax({
                    url: "{{ route('getlisreport') }}",
                    method: "GET",
                    data: {
                        txSearch: txSearch,
                        filter: result,
                        dept: selectdept
                    },
                    beforeSend: () => {
                        $('#containerReportPengkinian').html(loadSpin)
                    }
                })
                .done(res => {
                    $('#containerReportPengkinian').html(res)
                    $('#tablereportpengkinian').DataTable({
                        searching: false,
                        lengthChange: false,
                        "bSort": true,
                        "aaSorting": [],
                        pageLength: 10,
                        "lengthChange": false,
                        responsive: true,
                        language: { search: "" }
                    });
                })
            }

            $('#editworkarea').on('change', function() {
                selectdept = $(this).val();
                deptexportpengkinianreport.value = selectdept
                getlistpengkinian();
            });

          
            //Resetbutton
            $('#resetButton').on('click', function(){
                // Merestart (refresh) halaman
                location.reload(); // atau window.location.reload();
            });
            

            // insialisasi search ketika diketik
            $('#txSearch').keyup(function(e) {
                var inputText = $(this).val();
                if (inputText.length >= 2 || inputText.length == 0) {
                    getlistpengkinian();
                }

                searchexportpengkinianreport.value = inputText
            })

            $(document).ready(function () {
                // Pemicu perubahan pada elemen dengan ID 'editworkarea'
                $("#editworkarea").trigger('change');
            });



            function redirectToDetailPengkiniandata(id) {
                window.location.href = `{{ route('dataProcessdetail', ['id' => ':id']) }}`.replace(':id', id);
            }

            
        document.addEventListener('DOMContentLoaded', function () {
            const monthFilterInput = document.getElementById('monthEvent');
            const calendarTitle = document.getElementById('calendarTitle');

            const flatpickrInstance = flatpickr(monthFilterInput, {
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "M Y",
                        altFormat: "M Y",
                        theme: "light"
                    })
                ],
                onChange: function (selectedDates, dateStr, instance) {
                    const selectedDate = selectedDates[0];
                    const selectedMonth = instance.formatDate(selectedDate, "M Y");
                    calendarTitle.textContent = selectedMonth;
                }
            });

            // Inisialisasi tanggal hari ini
            const today = new Date();
            const initialMonth = flatpickrInstance.formatDate(today, "M Y");

            // Tampilkan bulan dan tahun pada button berdasarkan bulan dan tanggal hari ini
            calendarTitle.textContent = initialMonth;

        monthFilterInput.addEventListener('change', function () {
            const selectedMonth = monthFilterInput.value;
            console.log('Bulan yang dipilih:', selectedMonth);

        

            if (selectedMonth) {
            const parts = selectedMonth.split(" ");

            // Create a Date object with the month and year from the text
            const date = new Date(Date.parse(`${parts[0]} 1, ${parts[1]}`));

            // Get the year
            const year = date.getFullYear();

            // Get the month in two-digit format (e.g., "05" for May)
            const month = (date.getMonth() + 1).toString().padStart(2, '0');

            // Result in the "YYYY-MM" format
            result = `${year}-${month}`;
            }

            dateexportpengkinianreport.value = result;

            console.log(result);
              
            getlistpengkinian();

        });

            
        });

       
</script>

@endsection
