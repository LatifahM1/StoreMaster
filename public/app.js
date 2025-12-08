/* ================================================================
   BASE URL & ENDPOINTS
================================================================ */

// في بداية app.js أضف:
const BASE_URL = "http://127.0.0.1:8000";
const API_BASE = `${BASE_URL}/api`;  // للتسجيل والدخول
const PRODUCTS_URL = `${BASE_URL}/api/products`;  // للمنتجات
const API_URL = PRODUCTS_URL; // ← هذه الخطوة الحاسمة!

/* ================================================================
   AUTH HEADERS HELPER
================================================================ */

function getAuthHeaders() {
    const token = localStorage.getItem("token");
    const headers = {
        "Content-Type": "application/json",
        "Accept": "application/json"
    };
    
    if (token) {
        headers["Authorization"] = `Bearer ${token}`;
    }
    
    return headers;
}

/* ================================================================
   PAGE PROTECTION (حماية الصفحات)
================================================================ */

const PROTECTED_ROUTES = ["/index", "/add", "/edit", "/product", "/dashboard"];
const currentPath = window.location.pathname;

if (PROTECTED_ROUTES.some(route => currentPath.includes(route))) {
    const token = localStorage.getItem("token");
    if (!token) {
        window.location.href = "/login";
    }
}

/* ================================================================
   TOAST NOTIFICATIONS
================================================================ */

function showToast(message, type = "success") {
    const toast = document.createElement("div");
    toast.classList.add("toast");

    if (type === "error") toast.classList.add("toast-error");
    if (type === "warning") toast.classList.add("toast-warning");

    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => (toast.style.opacity = "1"), 50);

    setTimeout(() => {
        toast.style.opacity = "0";
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}

/* ================================================================
   LOGIN
================================================================ */

const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = {
            email: document.getElementById("login_email").value.trim(),
            password: document.getElementById("login_password").value.trim()
        };

        try {
            const res = await fetch(`${API_BASE}/login`, {
                method: "POST",
                headers: getAuthHeaders(),
                body: JSON.stringify(data)
            });

            const result = await res.json();

            if (res.ok) {
                if (result.token) {
                    localStorage.setItem("token", result.token);
                }
                localStorage.setItem("user", data.email);

                showToast(result.message || "Welcome back!");
                window.location.href = "/index";
            } else {
                showToast(result.message || "Invalid credentials", "error");
            }
        } catch (err) {
            console.error(err);
            showToast("Server error, try again later", "error");
        }
    });
}

/* ================================================================
   LOGOUT + SHOW USER
================================================================ */

function logout() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    window.location.href = "/login";
}

const loggedUser = localStorage.getItem("user");
if (loggedUser && document.getElementById("userEmail")) {
    document.getElementById("userEmail").innerText = "Welcome, " + loggedUser;
}

/* ================================================================
   LOAD PRODUCTS (SEARCH + FILTER + SORT)
================================================================ */

async function loadProducts(search = "", category = "", sort = "") {
    try {
        const response = await fetch(PRODUCTS_URL, {
            headers: getAuthHeaders()
        });

        let products = await response.json();

        // SEARCH
        if (search.trim()) {
            products = products.filter(p =>
                p.name?.toLowerCase().includes(search.toLowerCase()) ||
                p.category?.toLowerCase().includes(search.toLowerCase())
            );
        }

        // FILTER
        if (category.trim()) {
            products = products.filter(p => 
                p.category?.toLowerCase() === category.toLowerCase()
            );
        }

        // SORT
        switch (sort) {
            case "price-asc": 
                products.sort((a, b) => (a.price || 0) - (b.price || 0)); 
                break;
            case "price-desc": 
                products.sort((a, b) => (b.price || 0) - (a.price || 0)); 
                break;
            case "name-asc": 
                products.sort((a, b) => (a.name || "").localeCompare(b.name || "")); 
                break;
            case "name-desc": 
                products.sort((a, b) => (b.name || "").localeCompare(a.name || "")); 
                break;
        }

        renderProducts(products);
    } catch (err) {
        console.error(err);
        showToast("Failed to load products", "error");
    }
}

/* ================================================================
   RENDER PRODUCTS
================================================================ */

function renderProducts(products) {
    const list = document.getElementById("product-list");
    if (!list) return;

    list.innerHTML = "";

    if (!products || products.length === 0) {
        list.innerHTML = `
            <div class="empty-state">
                <p>No products found. Add your first product!</p>
            </div>
        `;
        return;
    }

    products.forEach(p => {
        list.innerHTML += `
            <div class="card-prod" onclick="viewDetails(${p.id})">
                <img src="${p.image_url || 'https://via.placeholder.com/300x200'}" 
                     alt="${p.name || 'Product'}"
                     onerror="this.src='https://via.placeholder.com/300x200'">
                <h3>${p.name || 'Unnamed Product'}</h3>
                <p>${p.category || 'Uncategorized'}</p>
                <p class="price">${p.price || 0} SAR</p>

                <div class="actions">
                    <button class="btn-edit" onclick="event.stopPropagation(); editProduct(${p.id})">Edit</button>
                    <button class="btn-delete" onclick="event.stopPropagation(); confirmDelete(${p.id})">Delete</button>
                </div>
            </div>
        `;
    });
}

/* ================================================================
   NAVIGATION HELPERS
================================================================ */

function viewDetails(id) {
    window.location.href = `/product?id=${id}`;
}

function editProduct(id) {
    window.location.href = `/edit?id=${id}`;
}

/* ================================================================
   DELETE PRODUCT (POPUP + TOAST)
================================================================ */

function confirmDelete(id) {
    const overlay = document.createElement("div");
    overlay.classList.add("popup-overlay");

    const box = document.createElement("div");
    box.classList.add("popup-box");

    box.innerHTML = `
        <h3>Are you sure?</h3>
        <p>This action cannot be undone.</p>
        <div class="popup-actions">
            <button class="popup-delete">Yes, Delete</button>
            <button class="popup-cancel">Cancel</button>
        </div>
    `;

    overlay.appendChild(box);
    document.body.appendChild(overlay);

    box.querySelector(".popup-cancel").onclick = () => overlay.remove();

    box.querySelector(".popup-delete").onclick = async () => {
        await deleteProduct(id);
        overlay.remove();
    };
}

async function deleteProduct(id) {
    try {
        const response = await fetch(`${PRODUCTS_URL}/${id}`, {
            method: "DELETE",
            headers: getAuthHeaders()
        });

        if (response.ok) {
            showToast("Product deleted successfully!");
            setTimeout(() => (window.location.href = "/index"), 800);
        } else {
            const error = await response.json();
            showToast(error.message || "Failed to delete product", "error");
        }
    } catch {
        showToast("Server connection error", "error");
    }
}

/* ================================================================
   ADD PRODUCT - الإصلاح هنا!
================================================================ */

const addForm = document.getElementById("addForm");

if (addForm) {
    addForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const btn = addForm.querySelector("button");
        btn.disabled = true;
        btn.innerText = "Adding...";

        const product = {
            name: document.getElementById("name").value.trim(),
            category: document.getElementById("category").value.trim(),
            price: Number(document.getElementById("price").value) || 0,
            description: document.getElementById("description").value.trim(),
            image_url: document.getElementById("image_url").value.trim() || 'https://via.placeholder.com/300x200'
        };

        if (!product.name || !product.category || !product.price) {
            showToast("All fields are required", "warning");
            btn.disabled = false;
            btn.innerText = "Add Product";
            return;
        }

        try {
            const response = await fetch(PRODUCTS_URL, { // ← استخدام PRODUCTS_URL بدلاً من API_URL
                method: "POST",
                headers: getAuthHeaders(),
                body: JSON.stringify(product)
            });

            const result = await response.json().catch(() => ({}));

            console.log("ADD PRODUCT RESPONSE:", response.status, result);

            if (response.ok) {
                showToast(result.message || "Product added successfully!");
                window.location.href = "/index";
            } else {
                showToast(result.message || "Error adding product", "error");
            }
        } catch (err) {
            console.error(err);
            showToast("Server connection error", "error");
        } finally {
            btn.disabled = false;
            btn.innerText = "Add Product";
        }
    });
}

/* ================================================================
   EDIT PRODUCT
================================================================ */

const editForm = document.getElementById("editForm");

if (editForm) {
    // تحميل بيانات المنتج الحالية
    const productId = new URLSearchParams(window.location.search).get("id");
    
    async function loadProductForEdit() {
        try {
            const response = await fetch(`${PRODUCTS_URL}/${productId}`, {
                headers: getAuthHeaders()
            });
            
            const product = await response.json();
            
            document.getElementById("name").value = product.name || "";
            document.getElementById("category").value = product.category || "";
            document.getElementById("price").value = product.price || "";
            document.getElementById("description").value = product.description || "";
            document.getElementById("image_url").value = product.image_url || "";
        } catch (err) {
            console.error(err);
            showToast("Failed to load product", "error");
        }
    }
    
    // تحميل البيانات عند فتح الصفحة
    if (productId) {
        loadProductForEdit();
    }
    
    // إرسال التعديلات
    editForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        const btn = editForm.querySelector("button");
        btn.disabled = true;
        btn.innerText = "Updating...";
        
        const updatedProduct = {
            name: document.getElementById("name").value.trim(),
            category: document.getElementById("category").value.trim(),
            price: Number(document.getElementById("price").value) || 0,
            description: document.getElementById("description").value.trim(),
            image_url: document.getElementById("image_url").value.trim() || 'https://via.placeholder.com/300x200'
        };
        
        try {
            const response = await fetch(`${PRODUCTS_URL}/${productId}`, {
                method: "PUT",
                headers: getAuthHeaders(),
                body: JSON.stringify(updatedProduct)
            });
            
            const result = await response.json();
            
            if (response.ok) {
                showToast(result.message || "Product updated successfully!");
                window.location.href = "/index";
            } else {
                showToast(result.message || "Error updating product", "error");
            }
        } catch (err) {
            console.error(err);
            showToast("Server connection error", "error");
        } finally {
            btn.disabled = false;
            btn.innerText = "Update Product";
        }
    });
}

/* ================================================================
   DETAILS PAGE (PRODUCT)
================================================================ */

if (document.querySelector(".details-wrapper")) {
    const productId = new URLSearchParams(window.location.search).get("id");

    async function loadProductDetails() {
        try {
            const res = await fetch(`${PRODUCTS_URL}/${productId}`, {
                headers: getAuthHeaders()
            });

            const product = await res.json();

            document.getElementById("p-img").src = product.image_url || 'https://via.placeholder.com/300x200';
            document.getElementById("p-name").textContent = product.name || 'Unnamed Product';
            document.getElementById("p-category").textContent = product.category || 'Uncategorized';
            document.getElementById("p-price").textContent = (product.price || 0) + ' SAR';
            document.getElementById("p-description").textContent = product.description || 'No description available';

            document.getElementById("edit-link").href = `/edit?id=${product.id}`;
            document.getElementById("deleteBtn").onclick = () => confirmDelete(product.id);
        } catch (err) {
            console.error(err);
            showToast("Failed to load product", "error");
        }
    }

    loadProductDetails();
}

/* ================================================================
   REGISTER (CREATE ACCOUNT)
================================================================ */

const registerForm = document.getElementById("registerForm");

if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const name = document.getElementById("reg_name").value.trim();
        const email = document.getElementById("reg_email").value.trim();
        const password = document.getElementById("reg_password").value.trim();

        if (!name || !email || !password) {
            showToast("All fields are required!", "warning");
            return;
        }

        try {
            const response = await fetch(`${API_BASE}/register`, {
                method: "POST",
                headers: { "Content-Type": "application/json", "Accept": "application/json" },
                body: JSON.stringify({ name, email, password })
            });

            const result = await response.json();

            if (response.ok) {
                showToast(result.message || "Account created successfully!");
                window.location.href = "/login";
            } else {
                showToast(result.message || "Error creating account", "error");
            }

        } catch (err) {
            console.error(err);
            showToast("Server error, try again later", "error");
        }
    });
}

/* ================================================================
   INITIALIZE DASHBOARD
================================================================ */

if (document.getElementById("product-list")) {
    // تحميل المنتجات عند فتح الداشبورد
    loadProducts();
    
    // إضافة event listeners للبحث والتصفية
    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");
    const sortSelect = document.getElementById("sortSelect");
    
    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            loadProducts(e.target.value, categoryFilter?.value, sortSelect?.value);
        });
    }
    
    if (categoryFilter) {
        categoryFilter.addEventListener("change", (e) => {
            loadProducts(searchInput?.value, e.target.value, sortSelect?.value);
        });
    }
    
    if (sortSelect) {
        sortSelect.addEventListener("change", (e) => {
            loadProducts(searchInput?.value, categoryFilter?.value, e.target.value);
        });
    }
}