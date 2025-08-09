@props(['car'])

@php
    $minDp = 30;
    $maxDp = 50;
    $defaultDp = 30;
    $tenors = [1, 2, 3, 4, 5];
    $sim = new \App\View\Components\SimulatePrice($car)->getSimulationData($defaultDp);
@endphp

<div>
    <div class="mb-4">
        <p class="font-semibold">Model: {{ $car->model }}</p>
        <p class="text-sm text-gray-600">Price: Rp{{ number_format($car->price, 0, ',', '.') }}</p>
    </div>

    <div class="mb-6">
        <label class="block text-sm font-semibold mb-2">DOWN PAYMENT:</label>
        <div class="flex items-center gap-2">
            <input type="number" id="dpInput" value="{{ $defaultDp }}" min="{{ $minDp }}"
                max="{{ $maxDp }}" placeholder="Enter Down Payment ({{ $minDp }}-{{ $maxDp }}%)"
                class="border border-gray-300 px-3 py-1 w-28 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                oninput="validateDP(this)" />
            <span class="text-sm">%</span>
            <button type="button" onclick="showSimulation()"
                class="bg-red-600 text-white px-4 py-1.5 rounded-md text-sm hover:bg-red-700 transition">
                Simulate
            </button>
        </div>
        <p class="text-xs text-gray-500 mt-1">*Enter a number between {{ $minDp }}% and {{ $maxDp }}%</p>
    </div>

    <div id="simulationBox" class="opacity-100 bg-gray-50 rounded-lg shadow p-4 border border-gray-200">
        <h2 class="text-center text-lg font-bold mb-4 text-gray-800">CREDIT SIMULATION</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="p-2">Tenor (Years)</th>
                        @foreach ($tenors as $i)
                            <th>{{ $i }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-t">
                        <td class="font-medium py-1">Down Payment</td>
                        <td colspan="5" id="dpAmount">Rp{{ number_format($sim['dpAmount'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-medium py-1">Installments / Month</td>
                        @foreach ($sim['installments'] as $k => $val)
                            <td id="installment{{ $k + 1 }}">Rp{{ number_format($val, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr class="border-t bg-gray-50">
                        <td class="font-medium py-1">Admin Fee</td>
                        @foreach ($sim['admin'] as $k => $val)
                            <td id="admin{{ $k + 1 }}">Rp{{ number_format($val, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr class="border-t">
                        <td class="font-medium py-1">Insurance</td>
                        <td colspan="5" id="insurance">Rp{{ number_format($sim['insurance'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-t bg-gray-50">
                        <td class="py-2 font-semibold text-gray-900 bg-gray-100">Total Payment</td>
                        @foreach ($sim['total'] as $k => $val)
                            <td id="total{{ $k + 1 }}">Rp{{ number_format($val, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function validateDP(input) {
        let value = parseInt(input.value);
        if (value < {{ $minDp }}) input.value = {{ $minDp }};
        if (value > {{ $maxDp }}) input.value = {{ $maxDp }};
    }

    // Fetch simulation dynamically with AJAX
    function showSimulation() {
        let dpPercent = parseInt(document.getElementById('dpInput').value);
        if (isNaN(dpPercent) || dpPercent < {{ $minDp }} || dpPercent > {{ $maxDp }}) {
            alert('Down Payment must be between {{ $minDp }}% and {{ $maxDp }}%');
            return;
        }
        fetch(`{{ url('simulate-price/' . $car->id) }}?dp=${dpPercent}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('dpAmount').innerText = 'Rp' + data.dpAmount.toLocaleString('id-ID');
                for (let i = 1; i <= 5; i++) {
                    document.getElementById('installment' + i).innerText = 'Rp' + data.installments[i - 1]
                        .toLocaleString('id-ID');
                    document.getElementById('admin' + i).innerText = 'Rp' + data.admin[i - 1].toLocaleString(
                        'id-ID');
                    document.getElementById('total' + i).innerText = 'Rp' + data.total[i - 1].toLocaleString(
                        'id-ID');
                }
                document.getElementById('insurance').innerText = 'Rp' + data.insurance.toLocaleString('id-ID');
            });
    }
</script>
