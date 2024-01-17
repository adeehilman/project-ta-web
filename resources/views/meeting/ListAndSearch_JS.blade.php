{{-- 1 --}}



<script>
    $(document).ready(function() {
        var selectParticipanEdit = $('#selectParticipanEdit');

        function updateSelectedParticipantCount() {
            var selectedCount = selectParticipanEdit.val() ? selectParticipanEdit.val().length : 0;
            $('#selectedParticipantCount').text(selectedCount + ' Participant Selected');
        }

        selectParticipanEdit.on('change', updateSelectedParticipantCount);

        // Inisialisasi jumlah yang dipilih saat halaman dimuat
        updateSelectedParticipantCount();


    });

    $(document).ready(function() {
        var selectRoomExport = $('#selectRoom2');

        function updateSelectedRoomCount() {
            var selectedCount = selectRoomExport.val() ? selectRoomExport.val().length : 0;
            $('#selectedRoomCountExport').text(selectedCount + ' Room Selected');
        }

        selectRoomExport.on('change', updateSelectedRoomCount);

        // Inisialisasi jumlah yang dipilih saat halaman dimuat
        updateSelectedRoomCount();
    });




    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    // get list Model
    const getListMeetingRoom = (
        fStatus = "",
        fNow = ""
    ) => {

        const filter = '{{ $filterData }}'

        if (filter) {
            fStatus = "1"
        }

        const now = '{{ $filterDataNow }}'

        if (now) {
            fNow = "1"
        }
        const txtSearch = $('#txSearch').val().toUpperCase();
        const filtertime = $('input[name="timeFilter"]:checked').val();
        const selectRoom = $('#selectRoom').val();

        $.ajax({
                url: "{{ route('/meeting/getList') }}",
                method: "GET",
                data: {
                    txSearch: txtSearch,
                    filtertime,
                    selectRoom,
                    fStatus,
                    fNow
                },
                beforeSend: () => {
                    $('#containerMeeting').html(loadSpin)
                    console.log(selectRoom)
                }
            })
            .done(res => {
                $('#containerMeeting').html(res)
                $('#tableMeeting').DataTable({
                    searching: false,
                    lengthChange: false,
                    order: [], // Menghilangkan pengurutan default
                    columnDefs: [{
                            targets: 'sortable',
                            orderable: false
                        } // Mengaktifkan pengurutan pada kolom-kolom yang memiliki kelas "sortable"
                    ],
                });
            })
    }
    getListMeetingRoom();

    // insialisasi search ketika diketik
    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
            getListMeetingRoom();
        }
    })

    const btnReset = $('#btnReset');

    btnReset.click(e => {
        e.preventDefault();

        // $('input[name="timeFilter"]').prop('checked', false);

        $('#selectStatus').val('');
        $('#selectRoom').val([]).trigger('change');
        // modalFormExport.modal('show');
        $('#txSearch').val('');
        $('#err-selectRoomFilter').addClass('d-none');
        $('#err-filtertime').addClass('d-none');
        getListMeetingRoom();
    });

    // //UPPERCASE ALL INPUT EDIT
    // $('#modelNumberAdd').keyup(function(e) {
    //     var inputText = $(this).val().toUpperCase();
    //     $(this).val(inputText)
    // })

    // $('#modelDetailAdd').keyup(function(e) {
    //     var inputText = $(this).val().toUpperCase();
    //     $(this).val(inputText)
    // })
    // $('#modelNameAdd').keyup(function(e) {
    //     var inputText = $(this).val().toUpperCase();
    //     $(this).val(inputText)
    // })

    // //UPPERCASE ALL INPUT EDIT
    // $('#modelNumberEdit').keyup(function(e) {
    //     var inputText = $(this).val().toUpperCase();
    //     $(this).val(inputText)
    // })

    // $('#modelDetail').keyup(function(e) {
    //     var inputText = $(this).val().toUpperCase();
    //     $(this).val(inputText)
    // })
    // $('#modelNameEdit').keyup(function(e) {
    //     var inputText = $(this).val().toUpperCase();
    //     $(this).val(inputText)
    // })
</script>
<!-- JavaScript untuk menghitung jumlah yang dipilih secara real-time -->
<script>
    $(document).ready(function() {
        var selectRoom = $('#selectRoom');

        function updateSelectedRoomCount() {
            var selectedCount = selectRoom.val() ? selectRoom.val().length : 0;
            $('#selectedRoomCount').text(selectedCount + ' Room Selected');
        }

        selectRoom.on('change', updateSelectedRoomCount);

        updateSelectedRoomCount(); // Inisialisasi jumlah yang dipilih saat halaman dimuat
    });
</script>
