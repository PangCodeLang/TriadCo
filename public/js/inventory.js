document.addEventListener('DOMContentLoaded', function () {
    console.log('Inventory JavaScript loaded successfully.');

    // Toggle modal functionality
    function toggleModal(modalId, action = 'toggle') {
        const modal = document.getElementById(modalId);

        if (!modal) {
            console.error(`Modal with ID "${modalId}" not found.`);
            return;
        }

        if (action === 'open') {
            modal.classList.remove('hidden');
            modal.classList.add('show');
        } else if (action === 'close') {
            modal.classList.remove('show');
            modal.classList.add('hidden');
        }
    }

    // Example: Attach event listener to the "Add Item" button
    const addItemButton = document.querySelector('.btn-add-supplier');
    if (addItemButton) {
        addItemButton.addEventListener('click', function () {
            toggleModal('addItemModal', 'open');
        });
    }

    // Expose the toggleModal function globally
    window.toggleModal = toggleModal;
});