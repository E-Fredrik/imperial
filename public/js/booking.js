(function(){
    function formatPrice(val){
        if (val === null || val === undefined || val === '') return '';
        return new Intl.NumberFormat().format(Number(val));
    }

    document.addEventListener('DOMContentLoaded', function () {
        const roomSelect = document.getElementById('room_id');
        const rentDisplay = document.getElementById('monthly_rent_display');
        if (!roomSelect || !rentDisplay) return;

        function updateRent(){
            const opt = roomSelect.options[roomSelect.selectedIndex];
            const price = opt ? opt.dataset.price : '';
            rentDisplay.value = price ? formatPrice(price) : '';
        }

        roomSelect.addEventListener('change', updateRent);
        updateRent();
    });
})();