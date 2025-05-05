    document.addEventListener('DOMContentLoaded', function () {
        const itemSelect = document.getElementById('item_id');
        const priceInput = document.getElementById('price');
        const quantityInput = document.getElementById('quantity');
        const totalPriceInput = document.getElementById('total_price');

        // Update price when an item is selected
        itemSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            priceInput.value = price ? parseFloat(price).toFixed(2) : ''; // Set price or clear field
            calculateTotalPrice();
        });

        // Update total price when quantity changes
        quantityInput.addEventListener('input', calculateTotalPrice);

        function calculateTotalPrice() {
            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            totalPriceInput.value = (price * quantity).toFixed(2) || ''; // Set total price or clear field
        }
    });