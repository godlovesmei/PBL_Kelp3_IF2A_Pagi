document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".product-item").forEach((item) => {
        const decrementBtn = item.querySelector(".decrement");
        const incrementBtn = item.querySelector(".increment");
        const quantitySpan = item.querySelector(".quantity");
        const quantityInput = item.querySelector(".quantity-input");
        const maxStock = parseInt(item.querySelector(".quantity-control").dataset.maxStock, 10);

        // Tombol Decrement (-)
        decrementBtn.addEventListener("click", () => {
            let currentQuantity = parseInt(quantitySpan.textContent, 10);
            if (currentQuantity > 1) {
                currentQuantity--;
                quantitySpan.textContent = currentQuantity;
                quantityInput.value = currentQuantity;
            }
        });

        // Tombol Increment (+)
        incrementBtn.addEventListener("click", () => {
            let currentQuantity = parseInt(quantitySpan.textContent, 10);
            if (currentQuantity < maxStock) {
                currentQuantity++;
                quantitySpan.textContent = currentQuantity;
                quantityInput.value = currentQuantity;
            } else {
                alert("Stok maksimum tercapai!");
            }
        });
    });

    const filterButton = document.getElementById("filter-toggle");
    const sidebar = document.querySelector("#sidebar");

    if (filterButton && sidebar) {
        filterButton.addEventListener("click", () => {
            if (sidebar.classList.contains("hidden")) {
                sidebar.classList.remove("hidden");
                sidebar.classList.add("shown");
            } else {
                sidebar.classList.remove("shown");
                sidebar.classList.add("hidden");
            }
        });
    } else {
        console.error("Element filter-toggle atau sidebar tidak ditemukan!");
    }

    const filter = document.querySelector(".filter-button i");

    if (filterButton) {
        console.log("Ikon filter ditemukan:", filterButton);
    } else {
        console.error("Ikon filter tidak ditemukan!");
    }

});


