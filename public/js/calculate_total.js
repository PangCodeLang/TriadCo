document.getElementById('item_id').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    document.getElementById('price').value = price;
    calculateTotalPrice();
});

document.getElementById('quantity').addEventListener('input', calculateTotalPrice);

function calculateTotalPrice() {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const quantity = parseInt(document.getElementById('quantity').value) || 0;
    document.getElementById('total_price').value = (price * quantity).toFixed(2);
}