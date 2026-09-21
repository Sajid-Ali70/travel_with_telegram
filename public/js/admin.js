// Admin Dashboard v9.0 - Country Management Added
console.clear();
console.log("%c !!! ADMIN JS v9.0 LOADED !!! ", "background: red; color: white; font-size: 20px;");

let productModal, countryModal;
let isInitializing = false;

// 1. Dashboard Initialization
async function initAdmin() {
    if (isInitializing) return;
    isInitializing = true;
    console.log("Initializing Admin Panel...");

    try {
        const pModalEl = document.getElementById('productModal');
        if (pModalEl && typeof bootstrap !== 'undefined') {
            productModal = new bootstrap.Modal(pModalEl);
        }

        const cModalEl = document.getElementById('countryModal');
        if (cModalEl && typeof bootstrap !== 'undefined') {
            countryModal = new bootstrap.Modal(cModalEl);
        }

        // Product Save
        const btnSave = document.getElementById('btnSaveProduct');
        if (btnSave) {
            btnSave.onclick = async function(e) {
                if(e) { e.preventDefault(); e.stopPropagation(); }
                const name = document.getElementById('pName').value;
                const cashPrice = parseFloat(document.getElementById('pCashPrice').value);
                const instPrice = parseFloat(document.getElementById('pInstPrice').value);
                const pId = document.getElementById('editProductId').value;
                if (!name || isNaN(cashPrice) || isNaN(instPrice)) {
                    alert("Please fill in Name, Cash Price, and Inst. Price.");
                    return false;
                }
                btnSave.disabled = true;
                const originalText = btnSave.innerHTML;
                btnSave.innerHTML = 'Saving...';
                try {
                    let imageUrls = [];
                    const fileInput = document.getElementById('pImages');
                    const files = fileInput ? fileInput.files : [];
                    if (files.length > 0) {
                        const ref = storage.ref(`products/${Date.now()}_${files[0].name}`);
                        const snap = await ref.put(files[0]);
                        imageUrls.push(await snap.ref.getDownloadURL());
                    }
                    const productData = {
                        name: name,
                        brand: document.getElementById('pBrand').value,
                        cashPrice: cashPrice,
                        installmentPrice: instPrice,
                        stock: parseInt(document.getElementById('pStock').value) || 0,
                        updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                    };
                    if (imageUrls.length > 0) productData.images = imageUrls;
                    if (pId) {
                        await db.collection('Products').doc(pId).update(productData);
                    } else {
                        productData.createdAt = firebase.firestore.FieldValue.serverTimestamp();
                        await db.collection('Products').add(productData);
                    }
                    alert("Saved Successfully!");
                    if (productModal) productModal.hide();
                    loadDashboardData();
                } catch (err) {
                    console.error("Firebase Error:", err);
                    alert("Error: " + err.message);
                } finally {
                    btnSave.disabled = false;
                    btnSave.innerHTML = originalText;
                }
                return false;
            };
        }

        // Country Save
        const btnSaveCountry = document.getElementById('btnSaveCountry');
        if (btnSaveCountry) {
            btnSaveCountry.onclick = async function(e) {
                if(e) { e.preventDefault(); e.stopPropagation(); }
                const name = document.getElementById('cName').value;
                const cId = document.getElementById('editCountryId').value;
                if (!name) {
                    alert("Please enter country name.");
                    return false;
                }
                btnSaveCountry.disabled = true;
                const originalText = btnSaveCountry.innerHTML;
                btnSaveCountry.innerHTML = 'Saving...';
                try {
                    let flagUrl = "";
                    const fileInput = document.getElementById('cFlag');
                    const files = fileInput ? fileInput.files : [];
                    if (files.length > 0) {
                        const ref = storage.ref(`countries/${Date.now()}_${files[0].name}`);
                        const snap = await ref.put(files[0]);
                        flagUrl = await snap.ref.getDownloadURL();
                    }
                    const countryData = {
                        name: name,
                        updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                    };
                    if (flagUrl) countryData.flag = flagUrl;
                    if (cId) {
                        await db.collection('Countries').doc(cId).update(countryData);
                    } else {
                        if (!flagUrl) {
                            alert("Flag image is required for new country.");
                            btnSaveCountry.disabled = false;
                            btnSaveCountry.innerHTML = originalText;
                            return false;
                        }
                        countryData.createdAt = firebase.firestore.FieldValue.serverTimestamp();
                        await db.collection('Countries').add(countryData);
                    }
                    alert("Country Saved!");
                    if (countryModal) countryModal.hide();
                    loadDashboardData();
                } catch (err) {
                    console.error("Firebase Error:", err);
                    alert("Error: " + err.message);
                } finally {
                    btnSaveCountry.disabled = false;
                    btnSaveCountry.innerHTML = originalText;
                }
                return false;
            };
        }
    } catch (err) {
        console.error("Init failed", err);
    }
}

// 2. Auth State Change
auth.onAuthStateChanged(function(user) {
    console.log("Auth User:", user ? user.email : "Logged Out");
    const loginSec = document.getElementById('loginSection');
    const adminDash = document.getElementById('adminDashboard');
    if (user) {
        if (loginSec) loginSec.style.display = 'none';
        if (adminDash) adminDash.classList.remove('d-none');
        initAdmin();
        loadDashboardData();
    } else {
        if (loginSec) loginSec.style.display = 'block';
        if (adminDash) adminDash.classList.add('d-none');
        isInitializing = false;
    }
});

// 3. Login Binding
function bindLogin() {
    const btn = document.getElementById('btnLogin');
    if (btn) {
        btn.onclick = async function(e) {
            if(e) { e.preventDefault(); e.stopPropagation(); }
            const email = document.getElementById('loginEmail').value;
            const pass = document.getElementById('loginPassword').value;
            if (!email || !pass) {
                alert("Enter credentials");
                return false;
            }
            btn.disabled = true;
            btn.innerHTML = 'Signing in...';
            try {
                await auth.signInWithEmailAndPassword(email, pass);
            } catch (err) {
                console.error("Login failed:", err);
                alert("Login Error: " + err.message);
                btn.disabled = false;
                btn.innerHTML = 'LOGIN NOW';
            }
            return false;
        };
    } else {
        setTimeout(bindLogin, 500);
    }
}

// 4. Load Data
async function loadDashboardData() {
    try {
        const [oSnap, pSnap, cSnap] = await Promise.all([
            db.collection('Orders').get(),
            db.collection('Products').get(),
            db.collection('Countries').orderBy('name').get()
        ]);

        const statTotal = document.getElementById('statTotalOrders');
        if (statTotal) statTotal.innerText = oSnap.size;

        const tbody = document.getElementById('productTableBody');
        if (tbody) {
            tbody.innerHTML = '';
            pSnap.forEach(doc => {
                const p = doc.data();
                tbody.innerHTML += `
                    <tr>
                        <td>${p.name}</td>
                        <td>Rs. ${p.cashPrice}</td>
                        <td>${p.stock || 0}</td>
                        <td class="text-end"><button type="button" class="btn btn-sm btn-primary" onclick="editProduct('${doc.id}')">Edit</button></td>
                    </tr>`;
            });
        }

        const ctbody = document.getElementById('countryTableBody');
        if (ctbody) {
            ctbody.innerHTML = '';
            cSnap.forEach(doc => {
                const c = doc.data();
                ctbody.innerHTML += `
                    <tr>
                        <td><img src="${c.flag}" class="country-flag-preview"></td>
                        <td>${c.name}</td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-primary" onclick="editCountry('${doc.id}')">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteCountry('${doc.id}')">Delete</button>
                        </td>
                    </tr>`;
            });
        }
    } catch (e) {
        console.error("Data Load Error:", e);
    }
}

// Global Functions
window.logout = () => auth.signOut().then(() => window.location.reload());

window.showSection = (name) => {
    document.querySelectorAll('.dashboard-section').forEach(s => s.classList.add('d-none'));
    const target = document.getElementById(name + 'Section');
    if (target) target.classList.remove('d-none');
};

window.openAddProductModal = () => {
    document.getElementById('editProductId').value = '';
    document.getElementById('pName').value = '';
    document.getElementById('pBrand').value = '';
    document.getElementById('pCashPrice').value = '';
    document.getElementById('pInstPrice').value = '';
    document.getElementById('pStock').value = '';
    if (productModal) productModal.show();
};

window.editProduct = async (id) => {
    const doc = await db.collection('Products').doc(id).get();
    const p = doc.data();
    document.getElementById('editProductId').value = id;
    document.getElementById('pName').value = p.name || '';
    document.getElementById('pBrand').value = p.brand || '';
    document.getElementById('pCashPrice').value = p.cashPrice || '';
    document.getElementById('pInstPrice').value = p.installmentPrice || '';
    document.getElementById('pStock').value = p.stock || '';
    if (productModal) productModal.show();
};

window.openAddCountryModal = () => {
    document.getElementById('editCountryId').value = '';
    document.getElementById('cName').value = '';
    document.getElementById('cFlag').value = '';
    if (countryModal) countryModal.show();
};

window.editCountry = async (id) => {
    const doc = await db.collection('Countries').doc(id).get();
    const c = doc.data();
    document.getElementById('editCountryId').value = id;
    document.getElementById('cName').value = c.name || '';
    if (countryModal) countryModal.show();
};

window.deleteCountry = async (id) => {
    if (confirm("Delete this country?")) {
        await db.collection('Countries').doc(id).delete();
        loadDashboardData();
    }
};

// Start binding
bindLogin();
