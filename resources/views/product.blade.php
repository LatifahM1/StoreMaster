<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>

    {{-- Dashboard Theme --}}
    <link rel="stylesheet" href="{{ asset('dashboard.css') }}">
    <style>
        .loading {
            text-align: center;
            padding: 50px;
            color: white;
        }
        .error-message {
            background: #e74a3b;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 50px auto;
            max-width: 500px;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>

    <script>
        // PAGE PROTECTION
        const token = localStorage.getItem("token");
        if (!token) window.location.href = "/login";

        // Get product ID from URL
        const productId = new URLSearchParams(window.location.search).get("id");
    </script>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <h1>Product Details</h1>

        <div class="nav-actions">
            <a href="{{ url('/index') }}" class="btn-add">← Back to Dashboard</a>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
    </nav>

    <!-- DETAILS LAYOUT -->
    <div id="details-content">
        <div class="loading">
            <h3>Loading product details...</h3>
        </div>
    </div>

    <script>
        // دالة لحذف المنتج
        async function deleteProduct(id) {
            if (!confirm('Are you sure you want to delete this product?')) {
                return;
            }
            
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                
                if (response.ok) {
                    showToast('Product deleted successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '/index';
                    }, 1500);
                } else {
                    const error = await response.json();
                    showToast(error.message || 'Failed to delete product', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Server error, please try again', 'error');
            }
        }

        // دالة لتحميل تفاصيل المنتج
        async function loadProductDetails() {
            if (!productId) {
                document.getElementById('details-content').innerHTML = `
                    <div class="error-message">
                        <h3>Product ID not found!</h3>
                        <a href="/index" class="btn-secondary">Go Back</a>
                    </div>
                `;
                return;
            }
            
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                
                if (!response.ok) {
                    throw new Error('Failed to load product');
                }
                
                const product = await response.json();
                
                // عرض تفاصيل المنتج
                document.getElementById('details-content').innerHTML = `
                    <div class="details-wrapper">
                        <img id="p-img" class="details-img" 
                             src="${product.image_url || 'https://via.placeholder.com/300x200'}" 
                             alt="${product.name}"
                             onerror="this.src='https://via.placeholder.com/300x200'">
                        
                        <div class="details-info">
                            <h2 id="p-name">${product.name || 'No Name'}</h2>
                            
                            <p><strong>Category:</strong> <span id="p-category">${product.category || 'Uncategorized'}</span></p>
                            <p><strong>Price:</strong> <span id="p-price">${product.price || 0} SAR</span></p>
                            <p><strong>Description:</strong></p>
                            <p id="p-description">${product.description || 'No description available'}</p>
                            
                            <div class="actions">
                                <a href="/edit?id=${product.id}" class="btn-edit">Edit Product</a>
                                <button onclick="deleteProduct(${product.id})" class="btn-delete">Delete Product</button>
                            </div>
                        </div>
                    </div>
                `;
                
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('details-content').innerHTML = `
                    <div class="error-message">
                        <h3>Error loading product details</h3>
                        <p>${error.message}</p>
                        <a href="/index" class="btn-secondary">Go Back to Dashboard</a>
                    </div>
                `;
            }
        }

        // دالة Toast
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.style.opacity = '1', 10);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // دالة تسجيل الخروج
        function logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }

        // تحميل تفاصيل المنتج عند فتح الصفحة
        document.addEventListener('DOMContentLoaded', loadProductDetails);
    </script>
</body>
</html>