document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('popupModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    
    // Show the modal function
    const showModal = () => {
        if (modal) {
            modal.classList.remove('hidden', 'opacity-0');
            modal.classList.add('opacity-100');
        }
    };

    // Close the modal function
    const closeModal = () => {
        if (modal) {
            modal.classList.add('hidden', 'opacity-0');
            modal.classList.remove('opacity-100');
        }
    };

    // Show modal on page load
    if (modal) {
        showModal();
    }

    // Close modal when close button is clicked
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Optional: Close modal when clicking outside the modal area
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    // Handle wishlist deletion
    document.querySelectorAll('.removeFromWishlist').forEach(button => {
        button.addEventListener('click', function () {
            const carId = this.getAttribute('data-id'); // Get car ID from data-id attribute
            const row = this.closest('tr'); // Get the corresponding table row

            // Confirm deletion
            if (!confirm('Are you sure you want to remove this car from your wishlist?')) return;

            // Send DELETE request using axios
            axios.delete(`/wishlist/${carId}`)
                .then(response => {
                    alert(response.data.message); // Show success message
                    row.remove(); // Remove the row from the table

                    // If the wishlist is now empty, show a message
                    if (!document.querySelector('tbody tr')) {
                        document.querySelector('tbody').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-5">
                                    You haven't saved any cars to your wishlist yet.
                                </td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    alert(error.response?.data?.message || 'Error removing the car from your wishlist.'); // Show error message
                });
        });
    });
});
