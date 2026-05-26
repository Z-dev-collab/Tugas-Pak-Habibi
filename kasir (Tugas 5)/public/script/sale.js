
let cart = [];


function addToCart(kode, nama, harga, stok, quantity = 1) {
    if (quantity <= 0) {
        alert("Jumlah harus lebih dari 0");
        return;
    }
    
    if (quantity > stok) {
        alert("Stok tidak cukup! Stok tersedia: " + stok);
        return;
    }
    
    const existingItem = cart.find(item => item.kode === kode);
    
    if (existingItem) {
        existingItem.qty += quantity;
    } else {
        cart.push({
            kode: kode,
            nama: nama,
            harga: parseInt(harga.replace(/\D/g, '')),
            qty: quantity
        });
    }
    
    
    decreaseStockInTable(kode, quantity);
    
    updateCart();
}


function decreaseStockInTable(kode, quantity) {
    const rows = document.querySelectorAll('.data-table tbody tr');
    rows.forEach(row => {
        const rowKode = row.cells[0].textContent.trim();
        if (rowKode === kode) {
            const stokCell = row.cells[3];
            const currentStok = parseInt(stokCell.textContent);
            stokCell.textContent = currentStok - quantity;
        }
    });
}


function removeFromCart(kode) {
    if (confirm("Apakah anda yakin menghapus produk dari keranjang?")) {
        const item = cart.find(item => item.kode === kode);
        if (item) {
            increaseStockInTable(kode, item.qty);
        }
        cart = cart.filter(item => item.kode !== kode);
        updateCart();
    }
}

function increaseStockInTable(kode, quantity) {
    const rows = document.querySelectorAll('.data-table tbody tr');
    rows.forEach(row => {
        const rowKode = row.cells[0].textContent.trim();
        if (rowKode === kode) {
            const stokCell = row.cells[3];
            const currentStok = parseInt(stokCell.textContent);
            stokCell.textContent = currentStok + quantity;
        }
    });
}

function updateQuantity(kode, newQty) {
    const quantity = parseInt(newQty);
    
    if (quantity <= 0) {
        removeFromCart(kode);
        return;
    }
    
    const item = cart.find(item => item.kode === kode);
    if (item) {
        item.qty = quantity;
        updateCart();
    }
}

function calculateSubtotal(harga, qty) {
    return harga * qty;
}

function calculateTotal() {
    return cart.reduce((total, item) => total + (item.harga * item.qty), 0);
}

function formatRupiah(amount) {
    return "Rp " + amount.toLocaleString('id-ID');
}

function updateCart() {
    const cartTable = document.querySelector('.keranjang tbody');
    const totalPrice = document.querySelector('.harga');
    
    cartTable.innerHTML = '';
    
    cart.forEach(item => {
        const subtotal = calculateSubtotal(item.harga, item.qty);
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.nama}<br><span>${item.kode}</span></td>
            <td>${formatRupiah(item.harga)}</td>
            <td>
                <input type="number" value="${item.qty}" class="qty" onchange="updateQuantity('${item.kode}', this.value)">
                <button class="ok" onclick="updateQuantity('${item.kode}', document.querySelector('input[value=${item.qty}]').value)">OK</button>
            </td>
            <td>${formatRupiah(subtotal)}
                <a href="#" class="hapus" onclick="removeFromCart('${item.kode}'); return false;">X</a>
            </td>
        `;
        cartTable.appendChild(row);
    });
    
    totalPrice.textContent = formatRupiah(calculateTotal());
}

function checkout() {
    const namaKasir = document.querySelector('.nama_kasir').value;
    const uangBayar = parseInt(document.querySelector('.uang_bayar').value.replace(/\D/g, ''));
    const total = calculateTotal();
    
    if (!namaKasir) {
        alert("Nama kasir harus diisi!");
        return;
    }
    
    if (!uangBayar || uangBayar < total) {
        alert("Uang bayar tidak valid atau kurang!");
        return;
    }
    
    if (cart.length === 0) {
        alert("Keranjang kosong!");
        return;
    }
    
    const kembalian = uangBayar - total;
    
    alert(`Transaksi Berhasil!\n\nNama Kasir: ${namaKasir}\nTotal: ${formatRupiah(total)}\nUang Bayar: ${formatRupiah(uangBayar)}\nKembalian: ${formatRupiah(kembalian)}`);
    
    cart = [];
    document.querySelector('.nama_kasir').value = '';
    document.querySelector('.uang_bayar').value = '';
    updateCart();
}

function searchItems(query) {
    const rows = document.querySelectorAll('.data-table tbody tr');
    
    rows.forEach(row => {
        const kode = row.cells[0].textContent.toLowerCase();
        const nama = row.cells[1].textContent.toLowerCase();
        
        if (kode.includes(query.toLowerCase()) || nama.includes(query.toLowerCase())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-keranjang a').forEach((button, index) => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const kode = row.cells[0].textContent;
            const nama = row.cells[1].textContent;
            const harga = row.cells[2].textContent;
            const stok = parseInt(row.cells[3].textContent);
            
            addToCart(kode, nama, harga, stok);
        });
    });
    
    document.querySelector('.search button').addEventListener('click', function() {
        const query = document.querySelector('.search input').value;
        searchItems(query);
    });
    
    document.querySelector('.checkout').addEventListener('click', checkout);
});
