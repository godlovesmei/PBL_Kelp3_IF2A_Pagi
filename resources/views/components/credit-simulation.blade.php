@props(['carPrice'])

<div id="simulationBox" class="hidden opacity-0 transition-opacity duration-500 ease-in-out mt-6">
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Credit Simulation</h2>

    <div class="overflow-x-auto">
      <table class="min-w-full table-auto text-sm text-center border-collapse">
        <thead>
          <tr class="bg-green-600 text-white">
            <th class="p-3 text-left">Item</th>
            <th class="p-3">1 Yr</th>
            <th class="p-3">2 Yrs</th>
            <th class="p-3">3 Yrs</th>
            <th class="p-3">4 Yrs</th>
            <th class="p-3">5 Yrs</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr class="border-t">
            <td class="font-medium py-2 text-left">Down Payment</td>
            <td colspan="5" id="dpAmount" class="py-2 text-center">Rp0</td>
          </tr>
          <tr class="border-t bg-gray-50">
            <td class="font-medium py-2 text-left">Installments / Month</td>
            <td id="installment1" class="py-2">Rp0</td>
            <td id="installment2" class="py-2">Rp0</td>
            <td id="installment3" class="py-2">Rp0</td>
            <td id="installment4" class="py-2">Rp0</td>
            <td id="installment5" class="py-2">Rp0</td>
          </tr>
          <tr class="border-t">
            <td class="font-medium py-2 text-left">Admin Fee</td>
            <td id="admin1" class="py-2">Rp0</td>
            <td id="admin2" class="py-2">Rp0</td>
            <td id="admin3" class="py-2">Rp0</td>
            <td id="admin4" class="py-2">Rp0</td>
            <td id="admin5" class="py-2">Rp0</td>
          </tr>
          <tr class="border-t bg-gray-50">
            <td class="font-medium py-2 text-left">Insurance</td>
            <td colspan="5" id="insurance" class="py-2 text-center">Rp0</td>
          </tr>
          <tr class="border-t border-b bg-gray-100">
            <td class="font-semibold py-3 text-left text-gray-900">Total Payment</td>
            <td id="total1" class="font-semibold text-gray-900">Rp0</td>
            <td id="total2" class="font-semibold text-gray-900">Rp0</td>
            <td id="total3" class="font-semibold text-gray-900">Rp0</td>
            <td id="total4" class="font-semibold text-gray-900">Rp0</td>
            <td id="total5" class="font-semibold text-gray-900">Rp0</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    window.validateDP = function(input) {
        let value = input.value;
        if (value < 30) input.value = 30;
        if (value > 50) input.value = 50;
    };

    window.showSimulation = function() {
        const dpInput = document.getElementById('dpInput');
        if (!dpInput) return;

        const dpValue = parseFloat(dpInput.value);
        if (isNaN(dpValue) || dpValue < 30 || dpValue > 50) {
            alert('Please enter a valid down payment percentage between 30% and 50%');
            return;
        }

        const carPrice = @json($carPrice);
        const dpAmount = (dpValue / 100) * carPrice;
        const dpAmountElem = document.getElementById('dpAmount');
        if (dpAmountElem) dpAmountElem.innerText = `Rp${dpAmount.toLocaleString()}`;

        // Example installment values, replace with your logic if needed
        const installments = [23504404, 12407596, 8718386, 6960195, 6013016];
        installments.forEach((amount, index) => {
            const instElem = document.getElementById(`installment${index + 1}`);
            if (instElem) instElem.innerText = `Rp${(amount - (dpAmount / 60)).toLocaleString()}`;
            const adminElem = document.getElementById(`admin${index + 1}`);
            if (adminElem) adminElem.innerText = `Rp${(1246000 + (index * 50000)).toLocaleString()}`;
            const totalElem = document.getElementById(`total${index + 1}`);
            if (totalElem) totalElem.innerText = `Rp${(amount + (1246000 + (index * 50000)) + 11336400).toLocaleString()}`;
        });

        // Example insurance value
        const insuranceElem = document.getElementById('insurance');
        if (insuranceElem) insuranceElem.innerText = `Rp${(dpAmount * 0.02).toLocaleString()}`;

        const simulationBox = document.getElementById('simulationBox');
        if (simulationBox) {
            simulationBox.classList.remove('hidden', 'opacity-0');
            simulationBox.classList.add('opacity-100');
        }
    };

    const dpInput = document.getElementById('dpInput');
    if (dpInput) {
        dpInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            if (value < 30 || value > 50) {
                this.setCustomValidity('Please enter a number between 30 and 50.');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});
</script>