@props(['carPrice'])

<div class="mt-8" x-data="creditForm(@json($carPrice))" x-init="init()" x-show="paymentMethod === 'credit'" x-cloak>
    <div class="border rounded-xl p-6 bg-gray-50 space-y-8">

        <!-- Tenor & Down Payment Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Installment Period -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Installment Period
                </label>
                <div class="flex flex-wrap gap-2">
                    <template x-for="option in tenorOptions" :key="option">
                        <button type="button" @click="tenor = option; updateSimulation()"
                            :class="tenor === option ?
                                'bg-gray-500 text-white' :
                                'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100'"
                            class="px-3 py-2 rounded-lg font-medium text-sm focus:outline-none transition"
                            x-text="option + ' months'"></button>
                    </template>
                    <input type="hidden" name="tenor" :value="tenor">
                </div>
            </div>

            <!-- Down Payment Selection (Preset & Manual) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Down Payment
                </label>
                <div class="flex flex-wrap gap-3 mb-2">
                    <template x-for="item in dpPresetOptions" :key="item">
                        <label class="inline-flex items-center space-x-2 cursor-pointer">
                            <input type="radio" class="form-radio accent-black" name="dp_preset"
                                :value="item" x-model="dpPreset" @change="dpManual = ''; updateDP()">
                            <span class="text-sm" x-text="item + '%'"></span>
                        </label>
                    </template>
                </div>

                <div class="flex items-center gap-2">
                    <input type="number" class="form-input border border-gray-300 rounded-md px-3 py-2 w-24"
                        min="30" max="70" step="1" placeholder="Custom %" x-model="dpManual"
                        @input="dpPreset = ''; updateDP()">
                    <span class="text-sm">%</span>
                    <span class="text-xs text-gray-400 ml-2">(30–70% allowed)</span>
                </div>

                <template x-if="dpError">
                    <p class="text-red-500 text-sm mt-2" x-text="dpError"></p>
                </template>

                <input type="hidden" name="down_payment_percent" :value="dpPercent">
                <input type="hidden" name="down_payment" :value="dpNominal">
            </div>
        </div>

        <!-- Summary Section -->
        <div class="bg-white rounded-xl p-5 shadow-inner text-xs md:text-base">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-gray-700">
                <div class="space-y-2">
                    <div class="grid grid-cols-2">
                        <span>Car Price</span>
                        <span class="text-right font-semibold text-gray-900 text-sm"
                            x-text="formatRupiah(carPrice)"></span>
                    </div>
                    <div class="grid grid-cols-2">
                        <span>Down Payment</span>
                        <span class="text-right font-semibold text-gray-900 text-sm"
                            x-text="formatRupiah(dpNominal) + ' (' + dpPercent + '%)'"></span>
                    </div>
                    <div class="grid grid-cols-2">
                        <span>Amount Financed</span>
                        <span class="text-right font-semibold text-gray-900 text-sm"
                            x-text="formatRupiah(financedAmount)"></span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="grid grid-cols-2">
                        <span>Estimated Monthly Installment</span>
                        <span class="text-right font-bold text-green-600 text-sm"
                            x-text="formatRupiah(monthlyInstallment) + ' x ' + tenor + ' mo'"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Note -->
        <div class="flex items-start gap-3 text-gray-500 text-sm bg-white rounded-lg shadow-inner p-4">
            <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" fill="#FDE68A" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4m0-4h.01" />
            </svg>
            <span>
                <strong>Note:</strong> Down payment must be between 30% and 70% of the car price.
            </span>
        </div>
    </div>
</div>

<script>
    function creditForm(carPrice) {
        return {
            // State
            paymentMethod: '{{ old('payment_method', 'credit') }}',
            tenorOptions: [12, 24, 36, 48, 60],
            tenor: {{ old('tenor', 36) }},
            dpPresetOptions: [30, 40, 50],
            dpPreset: '{{ old('down_payment_percent', 30) }}',
            dpManual: '',

            // Calculated Values
            carPrice,
            dpNominal: 0,
            dpPercent: 0,
            financedAmount: 0,
            monthlyInstallment: 0,

            // Error
            dpError: '',

            // Methods
            updateDP() {
                this.dpError = '';
                // If manual is filled, use manual
                if (this.dpManual !== '' && this.dpManual !== null) {
                    this.dpPercent = parseFloat(this.dpManual);
                } else if (this.dpPreset !== '' && this.dpPreset !== null) {
                    this.dpPercent = parseFloat(this.dpPreset);
                } else {
                    this.dpPercent = 0;
                }

                if (isNaN(this.dpPercent) || this.dpPercent === 0) {
                    this.dpError = 'Please set a valid down payment percent.';
                    this.dpNominal = 0;
                    this.updateSimulation();
                    return;
                }

                if (this.dpPercent < 30 || this.dpPercent > 70) {
                    this.dpError = 'Down payment must be between 30% and 70%.';
                    this.dpNominal = 0;
                    this.updateSimulation();
                    return;
                }

                this.dpNominal = Math.round(this.carPrice * this.dpPercent / 100);
                this.updateSimulation();
            },

            updateSimulation() {
                if (this.dpError || this.dpNominal === 0 || this.dpNominal >= this.carPrice) {
                    this.financedAmount = 0;
                    this.monthlyInstallment = 0;
                    return;
                }

                this.financedAmount = this.carPrice - this.dpNominal;

                const interestRatePerMonth = 0.005; // 0.5% flat per month
                const totalInterest = this.financedAmount * interestRatePerMonth * this.tenor;
                const totalLoan = this.financedAmount + totalInterest;

                this.monthlyInstallment = Math.round(totalLoan / this.tenor);
            },

            formatRupiah(val) {
                const number = this.toNumber(val);
                return 'Rp ' + number.toLocaleString('id-ID');
            },

            toNumber(val) {
                return parseInt(String(val).replace(/[^\d]/g, '')) || 0;
            },

            init() {
                this.updateDP();
            }
        }
    }
</script>
