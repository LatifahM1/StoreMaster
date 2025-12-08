<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - StoreMaster</title>
    <link rel="stylesheet" href="{{ asset('dashboard.css') }}">
    <style>
        /* أنماط إضافية لصفحة التفاصيل */
        .product-detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .product-detail-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .product-header {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .product-content {
            padding: 30px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        @media (min-width: 768px) {
            .product-content {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        .product-image-container {
            text-align: center;
        }
        
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .product-info h2 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .product-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .product-category {
            background: #4CAF50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        
        .product-price {
            font-size: 28px;
            font-weight: bold;
            color: #2196F3;
        }
        
        .product-description {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .product-description h3 {
            margin-bottom: 10px;
            color: #555;
        }
        
        .product-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-edit {
            background: #FF9800;
            color: white;
        }
        
        .btn-delete {
            background: #f44336;
            color: white;
        }
        
        .btn-back {
            background: #607D8B;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .error-container {
            text-align: center;
            padding: 50px 20px;
        }
        
        .error-container h2 {
            color: #f44336;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <h1>StoreMaster</h1>
        <div class="nav-actions">
            <a href="/index" class="btn-back">← Back to Dashboard</a>
        </div>
    </nav>

    <div class="product-detail-container">
        <!-- Loading State -->
        <div id="loading" class="loading-container">
            <div class="loading-spinner"></div>
            <p style="margin-left: 15px;">Loading product details...</p>
        </div>

        <!-- Product Details will be loaded here -->
        <div id="product-details" style="display: none;"></div>
    </div>

    <!-- تحميل JavaScript -->
    <script>
        // التحقق من وجود product_id
        const productId = "{{ $product_id }}";
        
        if (!productId) {
            document.getElementById('loading').innerHTML = `
                <div class="error-container">
                    <h2>Product ID Missing</h2>
                    <p>No product ID specified in URL.</p>
                    <a href="/index" class="btn">Back to Dashboard</a>
                </div>
            `;
        }
    </script>
    
    <script src="{{ asset('app.js') }}"></script>
    
    <script>
        // كود JavaScript لتحميل تفاصيل المنتج
        document.addEventListener('DOMContentLoaded', function() {
            const productId = "{{ $product_id }}";
            
            if (!productId) {
                return;
            }
            
            // دالة لتحميل تفاصيل المنتج
            async function loadProductDetails() {
                try {
                    const token = localStorage.getItem('token');
                    
                    const response = await fetch(`/api/products/${productId}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        const product = await response.json();
                        displayProductDetails(product);
                    } else {
                        throw new Error('Failed to load product');
                    }
                } catch (error) {
                    console.error('Error loading product:', error);
                    showError('Failed to load product details');
                }
            }
            
            function displayProductDetails(product) {
                const productDetails = document.getElementById('product-details');
                const loading = document.getElementById('loading');
                
                productDetails.innerHTML = `
                    <div class="product-detail-card">
                        <div class="product-header">
                            <h1>Product Details</h1>
                        </div>
                        <div class="product-content">
                            <div class="product-image-container">
                                <img src="${product.image_url || 'https://via.placeholder.com/400x300'}" 
                                     alt="${product.name}" 
                                     class="product-image"
                                     onerror="this.src='https://via.placeholder.com/400x300'">
                            </div>
                            <div class="product-info">
                                <h2>${product.name || 'Unnamed Product'}</h2>
                                
                                <div class="product-meta">
                                    <span class="product-category">${product.category || 'Uncategorized'}</span>
                                    <span class="product-price">${product.price || 0} SAR</span>
                                </div>
                                
                                <div class="product-description">
                                    <h3>Description</h3>
                                    <p>${product.description || 'No description available'}</p>
                                </div>
                                
                                <div class="product-actions">
                                    <a href="/edit?id=${product.id}" class="btn btn-edit">Edit Product</a>
                                    <button onclick="confirmDelete(${product.id})" class="btn btn-delete">Delete Product</button>
                                    <a href="/index" class="btn btn-back">Back to Dashboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // إخفاء مؤشر التحميل وإظهار التفاصيل
                loading.style.display = 'none';
                productDetails.style.display = 'block';
            }
            
            function showError(message) {
                const loading = document.getElementById('loading');
                loading.innerHTML = `
                    <div class="error-container">
                        <h2>Error</h2>
                        <p>${message}</p>
                        <a href="/index" class="btn">Back to Dashboard</a>
                    </div>
                `;
            }
            
            // تحميل تفاصيل المنتج
            loadProductDetails();
        });
        
        // دالة confirmDelete من app.js
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                deleteProduct(id);
            }
        }
        
        async function deleteProduct(id) {
            try {
                const token = localStorage.getItem('token');
                
                const response = await fetch(`/api/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    alert('Product deleted successfully!');
                    window.location.href = '/index';
                } else {
                    throw new Error('Failed to delete product');
                }
            } catch (error) {
                console.error('Error deleting product:', error);
                alert('Error deleting product. Please try again.');
            }
        }
        
        // دالة showToast بسيطة
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 25px;
                background: ${type === 'error' ? '#f44336' : '#4CAF50'};
                color: white;
                border-radius: 5px;
                z-index: 1000;
                animation: slideIn 0.3s ease;
            `;
            
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
            
            // إضافة أنيميشن
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }
    </script>
</body>
</html>