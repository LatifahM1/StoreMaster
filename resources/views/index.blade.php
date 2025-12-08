<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StoreMaster Dashboard</title>
    <link rel="stylesheet" href="{{ asset('dashboard.css') }}">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <h1>StoreMaster</h1>
        <div class="nav-actions">
            <span id="userEmail"></span>
            <a href="{{ url('/add') }}" class="btn">+ Add Product</a>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
    </nav>

    <div class="container">
        <h2>Products</h2>

        <!-- SEARCH -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search products by name or category...">
        </div>

        <!-- FILTERS & SORT -->
        <div class="filter-row">
            <select id="categoryFilter">
                <option value="">All Categories</option>
                <option value="Smartphones">Smartphones</option>
                <option value="Laptops">Laptops</option>
                <option value="Cameras">Cameras</option>
                <option value="Gaming">Gaming</option>
                <option value="Headphones">Headphones</option>
            </select>

            <select id="sortSelect">
                <option value="">Sort</option>
                <option value="price-asc">Price: Low → High</option>
                <option value="price-desc">Price: High → Low</option>
                <option value="name-asc">Name: A → Z</option>
                <option value="name-desc">Name: Z → A</option>
            </select>
        </div>

        <!-- PRODUCT GRID -->
        <div id="product-list" class="grid"></div>
    </div>

    <script src="{{ asset('app.js') }}"></script>
</body>
</html>