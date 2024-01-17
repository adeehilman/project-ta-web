<script>
    $(document).on('click', '.btnDetailnotice', function(e) {

        const id = $(this).data('id');
        const description = $(this).data('description');
        const startdate = $(this).data('startdate');
        const enddate = $(this).data('enddate');
        const status = $(this).data('status');

        if (status === 'Berlangsung') {
            $('#btndelete').hide();
            $('#btnedit').show();
        } else if (status === 'Selesai') {
            $('#btndelete').hide();
            $('#btnedit').hide();
        } else {
            $('#btndelete').show();
            $('#btnedit').show();
        }

        $('#decriptionnotice').text(description);
        $('#startdatenotice').text(startdate);
        $('#enddatenotice').text(enddate);
        $('#statusnotice').text(status);

        $('#btndelete').attr('data-id', id);
        $('#btnedit').attr('data-id', id);
        $('#btnedit').attr('data-description', description);
        $('#btnedit').attr('data-startdate', startdate);
        $('#btnedit').attr('data-enddate', enddate);
        $('#btnedit').attr('data-status', status);

        
        $('#modalDetailnotice').modal('show');
    });
</script>