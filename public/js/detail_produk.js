document.addEventListener('DOMContentLoaded', () => {
    const quantityControl = document.querySelector('.quantity-control');
    const minusButton = quantityControl.querySelector('.btn:first-child');
    const plusButton = quantityControl.querySelector('.btn:last-child');
    const quantityDisplay = quantityControl.querySelector('.quantity');
    const quantityInput = document.querySelector('input[name="quantity"]');
    const addToCartButton = document.querySelector('.btn-add-to-cart');
    const maxStock = parseInt(quantityControl.dataset.maxStock, 10); // Ambil data stok dari atribut
    const totalInCart = parseInt(quantityControl.dataset.totalInCart, 10) || 0; // Jumlah di keranjang

    // Tombol minus (-)
    minusButton.addEventListener('click', () => {
        let quantity = parseInt(quantityDisplay.textContent, 10);
        if (quantity > 1) {
            quantity -= 1;
            quantityDisplay.textContent = quantity;
            quantityInput.value = quantity; // Update hidden input
        }
    });

    // Tombol plus (+)
    plusButton.addEventListener('click', () => {
        let quantity = parseInt(quantityDisplay.textContent, 10);
        const totalRequested = totalInCart + quantity;

        if (totalRequested < maxStock) {
            quantity += 1;
            quantityDisplay.textContent = quantity;
            quantityInput.value = quantity; // Update hidden input
        } else {
            alert(
                `Stok tidak cukup. Anda sudah memiliki ${totalInCart} barang di keranjang.`
            );
        }
    });

    // Validasi sebelum submit
    addToCartButton.addEventListener('click', (event) => {
        let quantity = parseInt(quantityInput.value, 10);
        const totalRequested = totalInCart + quantity;

        if (totalRequested > maxStock) {
            alert(
                `Jumlah total barang di keranjang dan permintaan ini melebihi stok (${maxStock}). Anda sudah memiliki ${totalInCart} barang di keranjang.`
            );
            event.preventDefault(); // Batalkan pengiriman formulir
        }
    });
});
