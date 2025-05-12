<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - TriadCo')</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="{{ asset('css/system.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @yield('head')
</head>

<body class="{{ session('first_login') ? 'fade-in' : '' }}">
    @php
        session()->forget('first_login');
        $user = Auth::user();
        $profilePicture = $user->name === 'Admin' ? 'TCAdminProfile.png' : 'default-profile.jpg';
    @endphp

    <div class="sidebar" id="sidebar">
        <h2>TriadCo. System</h2>
        <center>
            <ul>
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-activity"></i> Dashboard</a></li>
                @endif
                <li><a href="{{ route('stock_in.index') }}" class="nav-link"><i class="bi bi-dropbox"></i> Stock-In</a></li>
                <li><a href="{{ route('inventory.index') }}" class="nav-link"><i class="bi bi-inboxes-fill"></i> Inventory</a></li>
                <li><a href="{{ route('rooms.index') }}" class="nav-link"><i class="bi bi-door-open-fill"></i> Rooms</a></li>
                <li><a href="{{ route('suppliers.index') }}" class="nav-link"><i class="bi bi-person-fill-down"></i> Suppliers</a></li>
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('reports.index') }}" class="nav-link"><i class="bi bi-list-columns"></i> Reports</a></li>
                @endif
            </ul>
        </center>
        <div class="sidebar-logo">
            <img src="{{ asset('images/TCLogo2.png') }}" alt="TriadCo Logo 2">
        </div>
    </div>

    <div class="header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1>Triad Corporations Hotel Set-Up</h1>
        <div class="user-profile">
            <span>Welcome, {{ $user->name }}!</span>
            <div class="profile-picture" onclick="toggleDropdown()">
                <img src="{{ Auth::user()->role === 'employee' ? asset('images/TCEmployeeProfile.png') : asset('images/' . $profilePicture) }}" alt="Profile Picture">            </div>
            <div class="dropdown-menu hidden" id="dropdownMenu">
                <button class="dropdown-item" onclick="toggleModal('viewProfileModal')">View Profile</button>
                
                @if(Auth::user()->role === 'admin')
                <button class="dropdown-item" onclick="window.location.href='{{ route('employees.index') }}'">View Employees</button>   
                    <button class="dropdown-item" onclick="toggleModal('createEmployeeModal')">Register Employee</button>             
                @endif
                <form action="{{ route('logout') }}" method="GET" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn dropdown-item">Log-Out</button>
                </form>
            </div>
            <div class="modal hidden" id="viewProfileModal">
                <div class="modal-content">
                    <h2>Profile</h2>
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst(Auth::user()->role) }}</p>
                    <button class="close-btn" onclick="toggleModal('viewProfileModal')">Close</button>
                </div>
            </div>
            @if(Auth::user()->role === 'admin')
            <div class="modal hidden" id="createEmployeeModal">
                <div class="modal-content fade-in">
                    <h2>Register Employee</h2>
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" style="font-family: 'system-font'; padding: 20px;">
                        @csrf
                        <h3 style="margin-bottom: 10px;">Account Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password:</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <h3 style="margin-top: 20px; margin-bottom: 10px;">Employee Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group" style="width: 100%;">
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" required style="width: 100%;">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_number">Contact Number:</label>
                                <input type="text" id="contact_number" name="contact_number" required>
                            </div>
                            <div class="form-group">
                                <label for="sss_number">SSS Number:</label>
                                <input type="text" id="sss_number" name="sss_number" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group" style="width: 100%;">
                                <label for="profile_picture">Upload Profile Picture:</label>
                                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="width: 100%;">
                            </div>
                        </div>

                        <div class="form-actions" style="text-align: center; margin-top: 20px;">
                            <button type="submit" class="btn-primary">Register Employee</button>
                            <button type="button" class="btn-secondary" onclick="toggleModal('createEmployeeModal', 'close')">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="main-content">
        @yield('content') 
    </div>

    <div class="footer">
        <p>&copy; 2025 TriadCo. All rights reserved.</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                setTimeout(() => {
                    sidebar.style.transform = 'translateX(0)'; 
                    sidebar.classList.add('sidebar-animation'); 
                }, 10); 
            } else {
                sidebar.classList.remove('sidebar-animation');
                sidebar.style.transform = 'translateX(-100%)';
                setTimeout(() => {
                    sidebar.classList.add('hidden'); 
                }, 300); 
            }
        }
    
        function toggleDropdown() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            
            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
                setTimeout(() => {
                    dropdownMenu.classList.add('dropdown-animation');
                }, 10); 
            } else {
                dropdownMenu.classList.remove('dropdown-animation');
                setTimeout(() => {
                    dropdownMenu.classList.add('hidden');
                }, 300);
            }
        }
        
        function toggleModal(modalId, action = 'toggle') {
            const modal = document.getElementById(modalId);

            if (action === 'open') {
                modal.classList.remove('hidden');
                modal.classList.add('show');
            } else if (action === 'close') {
                const modalContent = modal.querySelector('.modal-content');
                modalContent.classList.add('fade-out');

                setTimeout(() => {
                    modal.classList.remove('show');
                    modal.classList.add('hidden');
                    modalContent.classList.remove('fade-out');
                }, 500);
            } else {
                if (modal.classList.contains('hidden')) {
                    toggleModal(modalId, 'open');
                } else {
                    toggleModal(modalId, 'close');
                }
            }
        }

        function toggleAssignItemsModal(roomId) {
            const modal = document.getElementById('assignItemsModal');
            const form = document.getElementById('assign-items-form');

            // Update the form action with the room ID
            form.action = `/rooms/${roomId}/assign`;

            // Remove the 'hidden' class to display the modal
            modal.classList.remove('hidden');
            modal.classList.add('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const itemsContainer = document.getElementById('items-container');
            let rowIndex = 1;

            // Add Row
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-add-row')) {
                e.preventDefault();

                const newRow = document.createElement('div');
                newRow.classList.add('item-row');
                newRow.innerHTML = `
                    <label for="item_id_${rowIndex}" class="assign-item-form-label">Item:</label>
                    <select name="items[${rowIndex}][item_id]" id="item_id_${rowIndex}" class="form-select item-select" required>
                        <option value="" disabled selected>Select Item</option>
                        ${[...document.querySelectorAll('#item_id_0 option')].map(option => option.outerHTML).join('')}
                    </select>
                    <label for="quantity_${rowIndex}" class="assign-item-form-label">Qty:</label>
                    <input type="number" name="items[${rowIndex}][quantity]" id="quantity_${rowIndex}" class="form-control quantity-input" min="1" placeholder="Qty" required disabled>
                    <button type="button" class="btn btn-square btn-remove-row">-</button>
                `;
                itemsContainer.appendChild(newRow);
                rowIndex++;
            }
        });

        // Remove Row
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-remove-row')) {
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

        function openReturnItemModal(itemId, maxQuantity) {
            document.getElementById('return_item_id').value = itemId;
            document.getElementById('return_quantity').max = maxQuantity;
            toggleModal('returnItemModal', 'open');
        }

        function openStockOutModal(itemId, itemName, maxQuantity) {
            const form = document.getElementById('stockOutForm');
            form.action = `/inventory/stock-out/${itemId}`;

            document.getElementById('stock_out_item_id').value = itemId;
            document.getElementById('stock_out_item_name').value = itemName;
            const quantityInput = document.getElementById('stock_out_quantity');
            quantityInput.value = 1; 
            quantityInput.max = maxQuantity; 

            toggleModal('stockOutModal', 'open');
        }
        
    </script>
</body>

</html>