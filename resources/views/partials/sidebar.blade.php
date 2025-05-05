<div class="sidebar">
  <ul>
      <li>
          <i class="fas fa-car"></i>
          <span data-category="MPV">MPV</span>
      </li>
      <li>
          <i class="fas fa-car-side"></i>
          <span data-category="Sedan">Sedan</span>
      </li>
      <li>
          <i class="fas fa-car-sport"></i>
          <span data-category="Sports">Sports</span>
      </li>
      <li>
          <i class="fas fa-truck-pickup"></i>
          <span data-category="SUV">SUV</span>
      </li>
  </ul>
</div>
<style>
  .sidebar {
    width: 4rem;
    height: 100vh;
    background-color: #D9C6A1; /* Beige background */
    color: black;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    position: fixed;
    padding-top: 2rem;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2rem;
    transition: background-color 0.3s ease;
}

.sidebar ul li i {
    font-size: 2rem;
}

.sidebar ul li span {
    margin-left: 0.5rem;
    font-size: 1rem;
    display: none;
    transition: opacity 0.3s ease;
}

.sidebar ul li:hover {
    background-color: #BFAF92; /* Highlight color */
    cursor: pointer;
}

.sidebar ul li:hover span {
    display: inline;
    opacity: 1;
}

@media (min-width: 1024px) {
    .sidebar {
        width: 16rem; /* Expand sidebar on larger screens */
    }
}
</style>
<script>
 document.addEventListener('DOMContentLoaded', () => {
    const sidebarItems = document.querySelectorAll('.sidebar ul li span');

    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            const category = item.getAttribute('data-category');

            // Filter the cars based on the selected category
            fetch(`/cars?category=${category}`)
                .then(response => response.json())
                .then(data => {
                    // Update the car list dynamically
                    const carList = document.querySelector('.grid');
                    carList.innerHTML = ''; // Clear the current car list

                    data.forEach(car => {
                        const carItem = `
                            <div class="text-center">
                                <div class="flex items-center justify-center h-40 w-full bg-white">
                                    <img src="${car.image}" alt="${car.brand} ${car.model}" class="h-full object-contain">
                                </div>
                                <h2 class="text-lg font-semibold mb-1 mt-4">${car.model}</h2>
                                <p class="text-sm text-gray-600 mb-1">${car.category} - ${car.year}</p>
                                <p class="font-semibold">Rp${car.price}</p>
                            </div>
                        `;
                        carList.innerHTML += carItem;
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
</script>