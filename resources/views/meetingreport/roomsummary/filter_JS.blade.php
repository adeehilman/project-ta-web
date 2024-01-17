{{-- 1 --}}

<script>
    // Temukan elemen input
    const monthFilterInput = document.getElementById('monthFilter');

    // Inisialisasi flatpickr
    flatpickr(monthFilterInput, {
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "F",
                altFormat: "F",
                theme: "light"
            })
        ],
        onReady: function() {
            // Setelah flatpickr siap, tambahkan opsi "All Month"
            const monthSelect = monthFilterInput.querySelector('.flatpickr-monthSelect-months');
            const allMonthOption = document.createElement('option');
            allMonthOption.value = '';
            allMonthOption.textContent = 'All Month';
            monthSelect.insertBefore(allMonthOption, monthSelect.firstChild);
        }
    });
</script>
