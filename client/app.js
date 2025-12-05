/* ================================================================
   CONSTANTS
================================================================ */

const API_URL = "http://127.0.0.1:8000/api/products";

/* ================================================================
   PAGE PROTECTION
================================================================ */

const protectedPages = ["index.html", "add.html", "edit.html", "product.html"];
if (protectedPages.some(page => window.location.pathname.includes(page))) {
    const token = localStorage.getItem("token");
    if (!token) {
        window.location.href = "login.html";
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

        const res = await fetch("http://127.0.0.1:8000/api/login", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        if (res.ok) {
            // خزنّا التوكن والإيميل
            localStorage.setItem("token", result.token);
            localStorage.setItem("user", data.email);

            showToast(result.message || "Welcome back!");
            window.location.href = "index.html";
        } else {
            showToast(result.message || "Invalid credentials", "error");
        }
    });
}

/* ================================================================
   LOGOUT + SHOW USER
================================================================ */

function logout() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    window.location.href = "login.html";
}

const loggedUser = localStorage.getItem("user");
if (loggedUser && document.getElementById("userEmail")) {
    document.getElementById("userEmail").innerText = "Welcome, " + loggedUser;
}

/* ================================================================
   LOAD PRODUCTS (SEARCH + FILTER + SORT)
================================================================ */

async function loadProducts(search = "", category = "", sort = "") {
    const response = await fetch(API_URL, {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });

    let products = await response.json();

    // SEARCH
    if (search.trim()) {
        products = products.filter(p =>
            p.name.toLowerCase().includes(search.toLowerCase()) ||
            p.category.toLowerCase().includes(search.toLowerCase())
        );
    }

    // FILTER
    if (category.trim()) {
        products = products.filter(p => p.category.toLowerCase() === category.toLowerCase());
    }

    // SORT
    switch (sort) {
        case "price-asc": products.sort((a, b) => a.price - b.price); break;
        case "price-desc": products.sort((a, b) => b.price - a.price); break;
        case "name-asc": products.sort((a, b) => a.name.localeCompare(b.name)); break;
        case "name-desc": products.sort((a, b) => b.name.localeCompare(a.name)); break;
    }

    renderProducts(products);
}

/* ================================================================
   RENDER PRODUCTS
================================================================ */

function renderProducts(products) {
    const list = document.getElementById("product-list");
    if (!list) return;

    list.innerHTML = "";

    products.forEach(p => {
        list.innerHTML += `
            <div class="card-prod" onclick="viewDetails(${p.id})">
                <img src="${p.image_url}" alt="Product Image">
                <h3>${p.name}</h3>
                <p>${p.category}</p>
                <p class="price">${p.price} SAR</p>

                <div class="actions">
                    <button class="btn-edit" onclick="event.stopPropagation(); editProduct(${p.id})">Edit</button>
                    <button class="btn-delete" onclick="event.stopPropagation(); confirmDelete(${p.id})">Delete</button>
                </div>
            </div>
        `;
    });
}

/* ================================================================
   VIEW DETAILS
================================================================ */

function viewDetails(id) {
    window.location.href = `product.html?id=${id}`;
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
        const response = await fetch(`${API_URL}/${id}`, {
            method: "DELETE",
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        });

        if (response.ok) {
            showToast("Product deleted successfully!");
            setTimeout(() => (window.location.href = "index.html"), 800);
        } else {
            showToast("Failed to delete product", "error");
        }
    } catch {
        showToast("Server connection error", "error");
    }
}

/* ================================================================
   ADD PRODUCT
================================================================ */

const addForm = document.getElementById("addForm");

if (addForm) {
    addForm.addEventListener("submit", async e => {
        e.preventDefault();

        const btn = addForm.querySelector("button");
        btn.disabled = true;
        btn.innerText = "Adding...";

        const product = {
            name: document.getElementById("name").value.trim(),
            category: document.getElementById("category").value.trim(),
            price: Number(document.getElementById("price").value),
            description: document.getElementById("description").value.trim(),
            image_url: document.getElementById("image_url").value.trim()
        };

        if (!product.name || !product.category || !product.price) {
            showToast("All fields are required", "warning");
            btn.disabled = false;
            btn.innerText = "Add Product";
            return;
        }

        const response = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("token")}`
            },
            body: JSON.stringify(product)
        });

        btn.disabled = false;
        btn.innerText = "Add Product";

        if (response.ok) {
            showToast("Product added!");
            window.location.href = "index.html";
        } else {
            showToast("Error adding product", "error");
        }
    });
}

/* ================================================================
   EDIT PRODUCT
================================================================ */

const editForm = document.getElementById("editForm");

if (editForm) {
    const id = new URLSearchParams(window.location.search).get("id");

    async function loadOne() {
        const res = await fetch(`${API_URL}/${id}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        });

        const p = await res.json();

        document.getElementById("name").value = p.name;
        document.getElementById("category").value = p.category;
        document.getElementById("price").value = p.price;
        document.getElementById("description").value = p.description;
        document.getElementById("image_url").value = p.image_url;
    }

    loadOne();

    editForm.addEventListener("submit", async e => {
        e.preventDefault();

        const updated = {
            name: document.getElementById("name").value.trim(),
            category: document.getElementById("category").value.trim(),
            price: Number(document.getElementById("price").value),
            description: document.getElementById("description").value.trim(),
            image_url: document.getElementById("image_url").value.trim()
        };

        const response = await fetch(`${API_URL}/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("token")}`
            },
            body: JSON.stringify(updated)
        });

        if (response.ok) {
            showToast("Product updated!");
            window.location.href = "index.html";
        } else {
            showToast("Error updating product", "error");
        }
    });
}

/* ================================================================
   DETAILS PAGE (PRODUCT.HTML)
================================================================ */

if (document.querySelector(".details-wrapper")) {
    const productId = new URLSearchParams(window.location.search).get("id");

    async function loadProductDetails() {
        const res = await fetch(`${API_URL}/${productId}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        });

        const product = await res.json();

        document.getElementById("p-img").src = product.image_url;
        document.getElementById("p-name").textContent = product.name;
        document.getElementById("p-category").textContent = product.category;
        document.getElementById("p-price").textContent = product.price;
        document.getElementById("p-description").textContent = product.description;

        document.getElementById("edit-link").href = `edit.html?id=${product.id}`;
        document.getElementById("deleteBtn").onclick = () => confirmDelete(product.id);
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

        // VALIDATION
        if (!name || !email || !password) {
            showToast("All fields are required!", "warning");
            return;
        }

        try {
            const response = await fetch("http://127.0.0.1:8000/api/register", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ name, email, password })
            });

            const result = await response.json();

            if (response.ok) {
                showToast(result.message || "Account created successfully!");
                window.location.href = "login.html";
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
   FORGOT PASSWORD
================================================================ */
const forgotForm = document.getElementById("forgotForm");

if (forgotForm) {
    forgotForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const email = document.getElementById("forgot_email").value.trim();

        const response = await fetch("http://127.0.0.1:8000/api/forgot-password", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email })
        });

        const result = await response.json();

        if (response.ok) {
            showToast(result.message || "Reset code sent!");
            localStorage.setItem("reset_email", email);
            window.location.href = "reset.html";
        } else {
            showToast(result.message || "Error sending reset code", "error");
        }
    });
}


/* ================================================================
   RESET PASSWORD
================================================================ */

const resetForm = document.getElementById("resetForm");

if (resetForm) {
    resetForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = {
            email: document.getElementById("reset_email").value.trim(),
            reset_code: document.getElementById("reset_code").value.trim(),
            new_password: document.getElementById("reset_new_password").value.trim(),
        };

        // تحقق بسيط
        if (!data.email || !data.reset_code || !data.new_password) {
            showToast("All fields are required!", "warning");
            return;
        }

        try {
            const response = await fetch("http://127.0.0.1:8000/api/reset-password", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            const result = await response.json();  // ← مهم جداً

            if (response.ok) {
                showToast(result.message || "Password reset successful!");
                window.location.href = "login.html";
            } else {
                showToast(result.message || "Reset code is invalid", "error");
            }

        } catch (err) {
            console.error(err);
            showToast("Server error, try again later", "error");
        }
    });
}
