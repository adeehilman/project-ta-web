<script>
// open modal Detail
    $(document).on('click', '.btnDetail', function(e) {
        e.preventDefault();
        var RoomId = $(this).data('id');
        const modalFormDetail = $('#modalDetailRoom');

        modalFormDetail.modal('show');

        // Ajax request
        $.ajax({
            url: "{{ route('/Room/detail') }}",
            method: "GET",
            data: {
                RoomId: RoomId
            },
            beforeSend: () => {
                
            },
            success: function(response) {
                const dataRoom = response.dataRoomId;


                $("#detailRoomName").text(dataRoom.room_name);
                $("#detailSelectFloor").text(dataRoom.floor);
                $("#detailCapacityRoom").text(dataRoom.capacity);
                $("#detailDept").text(dataRoom.dept);


                // // untuk data yang ada di database

                // $("#detailImage1").attr('src', dataRoom.roomimage_1);
                // $("#detailImage2").attr('src', dataRoom.roomimage_2);
                // $("#detailImage3").attr('src', dataRoom.roomimage_3);

                // untuk data yang ada di folder lokal 

                $("#detailImage1").attr('src', '{{ asset('RoomMeetingFoto/') }}' + '/' + dataRoom.roomimage_1);
                $("#detailImage2").attr('src', '{{ asset('RoomMeetingFoto/') }}' + '/' + dataRoom.roomimage_2);
                $("#detailImage3").attr('src', '{{ asset('RoomMeetingFoto/') }}' + '/' + dataRoom.roomimage_3);

                $('#detailId').val(response.dataRoomId.id)


            },
            error: function(err) {
                
            }
        });
    });

    // Saat membuka modal edit dari modal detail
    $('#btnEditDetail').click((e) => {
        e.preventDefault();

        var RoomId = $('#detailId').val();
        const modalFormEdit = $('#modalEditRoom');

        modalFormEdit.modal('show');

        // Ajax request
        $.ajax({
            url: "{{ route('/Room/edit') }}",
            method: "GET",
            data: {
                RoomId: RoomId
            },
            beforeSend: () => {
                
            },
            success: function(response) {
                const dataRoom = response.dataRoomId;

                $("#editRoomName").val(dataRoom.room_name);
                $("#editSelectFloor").val(dataRoom.floor).trigger('change.select2');
                $("#editCapacityRoom").val(dataRoom.capacity);
                // $("#editImage1").text(dataRoom.roomimage_1);
                // $("#editImage2").val(dataRoom.roomimage_2);
                // $("#editImage3").val(dataRoom.roomimage_3);

                $(".image1trigger").val(dataRoom.roomimage_1)
                $(".image2trigger").val(dataRoom.roomimage_2)
                $(".image3trigger").val(dataRoom.roomimage_3)

                $('#editId').val(RoomId)

                $('#modalDetailRoom').modal('hide');

                


            },
            error: function(err) {
                
            }
        });
        // const room_name = $("#detailRoomName").text();
        // const floor = $("#detailSelectFloor").text();
        // const capacity = $("#detailCapacityRoom").text();

        // const imgName1 = $('roomimage_1').val();
        // const imgName2 = $('roomimage_2').val();
        // const imgName3 = $('roomimage_3').val();

        // // Mengisi nilai-nilai dalam modal edit dengan data dari modal detail
        // $("#editRoomName").val(room_name);
        // $("#editSelectFloor").val(floor).trigger('change.select2');
        // $("#editCapacityRoom").val(capacity);

        // $("#editImage1").val(imgName1)
        // $("#editImage2").val(imgName2)
        // $("#editImage3").val(imgName3)

        // $('#modalDetailRoom').modal('hide');
        // $('#modalEditRoom').modal('show');
    });
    

</script>
