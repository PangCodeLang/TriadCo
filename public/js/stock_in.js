document.addEventListener('DOMContentLoaded', function () {
    const itemsContainer = document.getElementById('items-container');
    const addItemButton = document.querySelector('.btn-add-item');

    let itemIndex = 1; // Start indexing for additional items

    // Add new item row
    itemsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-add-item')) {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3', 'item-row');
            newRow.innerHTML = `
                <div class="col-md-5">
                    <label for="item_id_${itemIndex}" class="form-label">Item</label>
                    <select class="form-control" id="item_id_${itemIndex}" name="items[${itemIndex}][item_id]" required>
                        <option value="" disabled selected>Select an item</option>
                        ${Array.from(document.querySelectorAll('#item_id_0 option'))
                            .map(option => option.outerHTML)
                            .join('')}
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="price_${itemIndex}" class="form-label">Price</label>
                    <input type="text" class="form-control" id="price_${itemIndex}" name="items[${itemIndex}][price]" readonly>
                </div>
                <div class="col-md-3">
                    <label for="quantity_${itemIndex}" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity_${itemIndex}" name="items[${itemIndex}][quantity]" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-item">-</button>
                </div>
            `;
            itemsContainer.appendChild(newRow);
            itemIndex++;
        }

        // Remove item row
        if (e.target.classList.contains('btn-remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });

    // Update price when an item is selected
    itemsContainer.addEventListener('change', function (e) {
        if (e.target.matches('[id^="item_id_"]')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const priceInput = e.target.closest('.item-row').querySelector('[id^="price_"]');
            priceInput.value = selectedOption.getAttribute('data-price') || '';
        }
    });
});