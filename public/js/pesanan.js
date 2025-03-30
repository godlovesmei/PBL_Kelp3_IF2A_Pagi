// Fungsi untuk membuka modal konfirmasi dan set ID pesanan
function openConfirmModal(idPesanan) {
    document.getElementById('confirmId').value = idPesanan; // Set ID pesanan ke dalam input hidden
    document.getElementById('modalConfirm').style.display = 'block'; // Tampilkan modal
}

// Fungsi untuk membuka modal tolak dan set ID pesanan
function openRejectModal(idPesanan) {
    document.getElementById('rejectId').value = idPesanan; // Set ID pesanan ke dalam input hidden
    document.getElementById('modalReject').style.display = 'block'; // Tampilkan modal
}

// Fungsi untuk menutup modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none'; // Sembunyikan modal
}
