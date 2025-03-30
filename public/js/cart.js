document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-quantity').forEach(button => {
        button.addEventListener('click', function () {
            const action = this.dataset.action; // "plus" atau "minus"
            const idProduk = this.dataset.idProduk; // ID produk
            const jumlahElement = this.closest('td').querySelector('.quantity-value');
            const subtotalElement = this.closest('tr').querySelector('.product-subtotal');
            const hargaProduk = parseFloat(this.closest('tr').querySelector('.product-price').dataset.hargaProduk);
            const stokProduk = parseInt(this.dataset.stokProduk); // Stok produk dari atribut data-stok-produk

            let jumlah = parseInt(jumlahElement.textContent);

            // Perbarui jumlah berdasarkan aksi
            if (action === 'minus' && jumlah > 1) {
                jumlah--;
            } else if (action === 'plus' && jumlah < stokProduk) {
                jumlah++;
            } else if (action === 'plus' && jumlah >= stokProduk) {
                // Tampilkan toast jika kuantitas melebihi stok
                showToast('Jumlah produk yang dimasukkan melebihi stok tersedia.');
                return; // Hentikan eksekusi jika jumlah melebihi stok
            }

            // Update jumlah di tampilan
            jumlahElement.textContent = jumlah;

            // Hitung ulang subtotal
            const subtotal = hargaProduk * jumlah;
            subtotalElement.textContent = `Rp${subtotal.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            })}`;

            // Kirim update ke server via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_keranjang.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'error') {
                            showToast(response.message); // Tampilkan pesan error di toast
                        } else if (response.status === 'success') {
                            // Update tampilan jika sukses (opsional, jika reload diperlukan)
                            location.reload();
                        }
                    } catch (e) {
                        console.error('Error parsing JSON response', e);
                    }
                }
            };
            xhr.send(`id_produk=${idProduk}&jumlah_produk=${jumlah}`);

            // Update total harga keranjang
            updateTotalHarga();
        });
    });

    // Fungsi untuk menghitung ulang total harga keranjang
    function updateTotalHarga() {
        let totalHarga = 0;
        document.querySelectorAll('.product-subtotal').forEach(subtotalElement => {
            const subtotalText = subtotalElement.textContent.replace(/[^\d,-]/g, ''); // Hanya angka
            const subtotal = parseFloat(subtotalText.replace(',', '.'));
            totalHarga += subtotal;
        });

        // Tampilkan total harga di elemen total
        const totalElement = document.getElementById('cart-total');
        totalElement.textContent = `Rp${totalHarga.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        })}`;
    }

    // Fungsi untuk menampilkan toast notification
    function showToast(message) {
        const toastElement = document.getElementById('toastNotification');
        const toastBody = toastElement.querySelector('.toast-body');
        toastBody.textContent = message;

        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
});
