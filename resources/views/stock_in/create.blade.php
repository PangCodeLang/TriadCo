@extends('dashboard')

@section('title', 'Add Stock-In - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addItemButton = document.getElementById('add-item-button');
            const itemsContainer = document.getElementById('items-container');
            const totalPriceField = document.getElementById('total-price');

            function calculateTotalPrice() {
                let total = 0;
                document.querySelectorAll('.item-row').forEach(row => {
                    const price = parseFloat(row.querySelector('.item-price').value) || 0;
                    const quantity = parseInt(row.querySelector('.item-quantity').value) || 0;
                    total += price * quantity;
                });
                totalPriceField.value = total.toFixed(2);
            }

            addItemButton.addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.classList.add('item-row', 'd-flex', 'gap-3', 'mb-3');
                newRow.innerHTML = `
                    <input type="text" name="items[][name]" class="form-control item-name" placeholder="Item Name" required>
                    <input type="number" name="items[][price]" class="form-control item-price" placeholder="Price" step="0.01" required>
                    <input type="number" name="items[][quantity]" class="form-control item-quantity" placeholder="Quantity" required>
                `;
                itemsContainer.appendChild(newRow);

                // Recalculate total price when new inputs are added
                newRow.querySelectorAll('input').forEach(input => {
                    input.addEventListener('input', calculateTotalPrice);
                });
            });

            // Recalculate total price on input change
            itemsContainer.addEventListener('input', calculateTotalPrice);
        });
    </script>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5 text-primary">Add Stock-In</h2>
    <div class="supplier-modal-content mx-auto">
        <div class="supplier-modal-header">
            Add Stock-In
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('stock_in.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="form-control form-input" required>
                    <option value="" disabled selected>Select a supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div id="items-container" class="mb-3">
                <div class="item-row d-flex gap-3 mb-3">
                    <input type="text" name="items[][name]" class="form-control item-name" placeholder="Item Name" required>
                    <input type="number" name="items[][price]" class="form-control item-price" placeholder="Price" step="0.01" required>
                    <input type="number" name="items[][quantity]" class="form-control item-quantity" placeholder="Quantity" required>
                </div>
            </div>
            <button type="button" id="add-item-button" class="btn btn-secondary mb-3">Add Another Item</button>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <label for="total-price" class="form-label">Total Price</label>
                    <input type="text" id="total-price" class="form-control" readonly>
                </div>
                <div>
                    <label for="stock_in_date" class="form-label">Stock-In Date</label>
                    <input type="date" name="stock_in_date" id="stock_in_date" class="form-control form-input" required>
                </div>
            </div>
            <div class="button-row mt-4">
                <button type="submit" class="btn-add">Add Stock-In</button>
                <a href="{{ route('stock_in.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection