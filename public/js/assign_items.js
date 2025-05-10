document.addEventListener('DOMContentLoaded', () => {
    const itemsContainer = document.getElementById('items-container');
    let rowIndex = 1;

    // Function to toggle the Assign Items Modal
    window.toggleAssignItemsModal = (roomId) => {
        // Update the form action with the room ID
        assignItemsForm.action = `/rooms/${roomId}/assign`;

        // Open the modal
        assignItemsModal.classList.remove('hidden');
    };

    // Add Row
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('add-row-btn')) {
            e.preventDefault();

            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3', 'align-items-center', 'item-row');
            newRow.innerHTML = `
                <div class="col-md-5">
                    <label for="item_id_${rowIndex}" class="form-label">Item:</label>
                    <select name="items[${rowIndex}][item_id]" id="item_id_${rowIndex}" class="form-select" required>
                        <option value="" disabled selected>Select Item from Inventory</option>
                        ${[...document.querySelectorAll('#item_id_0 option')].map(option => option.outerHTML).join('')}
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="quantity_${rowIndex}" class="form-label">Quantity:</label>
                    <input type="number" name="items[${rowIndex}][quantity]" id="quantity_${rowIndex}" class="form-control quantity-input" min="1" placeholder="Enter quantity" required disabled>
                    <small class="text-danger d-none no-stock-message">No Stocks Available</small>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-sm btn-danger remove-row-btn">-</button>
                </div>
            `;
            itemsContainer.appendChild(newRow);
            rowIndex++;
        }
    });

    // Remove Row
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-row-btn')) {
            e.preventDefault();
            e.target.closest('.item-row').remove();
        }
    });

    // Enable Quantity Input Based on Stock
    document.addEventListener('change', (e) => {
        if (e.target.tagName === 'SELECT' && e.target.classList.contains('form-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            const quantityInput = e.target.closest('.item-row').querySelector('.quantity-input');
            const noStockMessage = e.target.closest('.item-row').querySelector('.no-stock-message');

            if (stock > 0) {
                quantityInput.disabled = false;
                quantityInput.max = stock;
                noStockMessage.classList.add('d-none');
            } else {
                quantityInput.disabled = true;
                quantityInput.value = '';
                noStockMessage.classList.remove('d-none');
            }
        }
    });
});