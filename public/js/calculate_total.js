document.addEventListener('DOMContentLoaded', function () {
    // Elements for the modal
    const itemSelect = document.getElementById('item_id'); // Item dropdown in the modal
    const priceInput = document.getElementById('price'); // Price dropdown in the modal
    const quantityInput = document.getElementById('quantity'); // Quantity input in the modal
    const totalPriceInput = document.getElementById('total_price'); // Total price field in the modal
    const totalPriceLabel = document.getElementById('total_price_label'); // Total price label in the modal

    // Update price when an item is selected
    if (itemSelect) {
        itemSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            priceInput.value = price ? parseFloat(price).toFixed(2) : ''; // Set price or clear field
            calculateTotalPrice();
        });
    }

    // Update total price when quantity changes
    if (quantityInput) {
        quantityInput.addEventListener('input', calculateTotalPrice);
    }

    // Function to calculate and update the total price
    function calculateTotalPrice() {
        const price = parseFloat(priceInput.value) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const totalPrice = (price * quantity).toFixed(2);

        // Update the total price input field
        totalPriceInput.value = totalPrice || '';

        // Update the total price label
        totalPriceLabel.textContent = `Total Price: ${totalPrice || '0.00'}`;
    }
});