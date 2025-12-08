<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - StoreMaster</title>

    <link rel="stylesheet" href="{{ asset('dashboard.css') }}">
    <style>
        .image-options {
            margin: 15px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .sample-images {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .sample-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .sample-image:hover {
            border-color: #4e73df;
        }
        .image-help {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>

    <script>
        const token = localStorage.getItem("token");
        if (!token) window.location.href = "/login";
        
        // جلب معرف المنتج من الرابط
        const productId = new URLSearchParams(window.location.search).get("id");
    </script>
</head>

<body>

    <div class="page-card">
        <h2>Edit Product</h2>

        <form id="editForm">
            <label>Name *</label>
            <input type="text" id="name" required>

            <label>Category *</label>
            <input type="text" id="category" required>

            <label>Price (SAR) *</label>
            <input type="number" id="price" required min="0" step="0.01">

            <label>Description</label>
            <textarea id="description"></textarea>

            <label>Image URL</label>
            <input type="text" id="image_url">
            <div class="image-help">Use short image URLs (max 500 characters)</div>

            <!-- Sample Images -->
            <div class="image-options">
                <strong>Sample Images (Click to use):</strong>
                <div class="sample-images">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" 
                         class="sample-image" 
                         onclick="setImageUrl(this.src)"
                         alt="Shoes">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e" 
                         class="sample-image" 
                         onclick="setImageUrl(this.src)"
                         alt="Headphones">
                    <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f" 
                         class="sample-image" 
                         onclick="setImageUrl(this.src)"
                         alt="Camera">
                    <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12" 
                         class="sample-image" 
                         onclick="setImageUrl(this.src)"
                         alt="Smartwatch">
                    <img src="https://via.placeholder.com/300x200" 
                         class="sample-image" 
                         onclick="setImageUrl(this.src)"
                         alt="Placeholder">
                </div>
            </div>

            <button type="submit" class="btn-main">Update Product</button>
        </form>

        <div class="back">
            <a href="/index">← Back to Dashboard</a>
        </div>
    </div>

    <script>
        // دالة لتعيين رابط الصورة
        function setImageUrl(url) {
            document.getElementById('image_url').value = url;
            showToast('Image selected!', 'success');
        }

        // دالة لتصغير روابط Google الطويلة
        function fixGoogleImageUrl(url) {
            if (!url || !url.includes('google.com/imgres')) {
                return url;
            }
            
            const urlObj = new URL(url);
            const imgUrl = urlObj.searchParams.get('imgurl');
            
            if (imgUrl) {
                return decodeURIComponent(imgUrl);
            }
            
            return 'https://via.placeholder.com/300x200';
        }

        // دالة للتحقق من طول رابط الصورة
        function validateImageUrl(url) {
            if (url && url.length > 500) {
                showToast('Image URL is too long! Please use a shorter link.', 'error');
                return false;
            }
            return true;
        }

        // تحميل بيانات المنتج الحالية
        async function loadProduct() {
            if (!productId) {
                showToast('Product ID not found', 'error');
                return;
            }
            
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                
                if (!response.ok) {
                    throw new Error('Failed to load product');
                }
                
                const product = await response.json();
                
                // تعبئة النموذج بالبيانات
                document.getElementById('name').value = product.name || '';
                document.getElementById('category').value = product.category || '';
                document.getElementById('price').value = product.price || '';
                document.getElementById('description').value = product.description || '';
                document.getElementById('image_url').value = product.image_url || '';
                
            } catch (error) {
                console.error('Error loading product:', error);
                showToast('Failed to load product data', 'error');
            }
        }

        // معالج تحديث المنتج
        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!productId) {
                showToast('Product ID missing', 'error');
                return;
            }
            
            const btn = this.querySelector('button');
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Updating...';
            
            // إصلاح رابط الصورة
            let imageUrl = document.getElementById('image_url').value.trim();
            imageUrl = fixGoogleImageUrl(imageUrl);
            
            // التحقق من طول الرابط
            if (!validateImageUrl(imageUrl)) {
                btn.disabled = false;
                btn.textContent = originalText;
                return;
            }
            
            const product = {
                name: document.getElementById('name').value.trim(),
                category: document.getElementById('category').value.trim(),
                price: parseFloat(document.getElementById('price').value) || 0,
                description: document.getElementById('description').value.trim(),
                image_url: imageUrl || 'https://via.placeholder.com/300x200'
            };
            
            // التحقق من الحقول المطلوبة
            if (!product.name || !product.category || product.price <= 0) {
                showToast('Please fill all required fields correctly', 'warning');
                btn.disabled = false;
                btn.textContent = originalText;
                return;
            }
            
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    },
                    body: JSON.stringify(product)
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    showToast('Product updated successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '/index';
                    }, 1500);
                } else {
                    showToast(result.message || 'Error updating product', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Server error, please try again', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = originalText;
            }
        });
        
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

        // تحميل بيانات المنتج عند فتح الصفحة
        document.addEventListener('DOMContentLoaded', loadProduct);
    </script>
</body>
</html>