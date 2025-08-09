@props(['customer', 'order', 'car'])

<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- Customer Section --}}
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Customer</h3>
            <dl class="space-y-2 text-sm text-gray-700">
                <div>
                    <dt class="font-medium inline">Name:</dt>
                    <dd class="inline ml-2">{{ optional($customer->user)->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium inline">Email:</dt>
                    <dd class="inline ml-2">{{ optional($customer->user)->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium inline">Phone:</dt>
                    <dd class="inline ml-2">{{ optional($customer->user)->phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium inline">Address:</dt>
                    <dd class="inline ml-2">{{ optional($customer->user)->address ?? '-' }}</dd>
                </div>
                @if (!empty($customer->nik))
                    <div>
                        <dt class="font-medium inline">NIK:</dt>
                        <dd class="inline ml-2">{{ $customer->nik }}</dd>
                    </div>
                @endif
                @if (!empty($customer->gender))
                    <div>
                        <dt class="font-medium inline">Gender:</dt>
                        <dd class="inline ml-2">{{ ucfirst($customer->gender) }}</dd>
                    </div>
                @endif
                @if (!empty($customer->birth_date))
                    <div>
                        <dt class="font-medium inline">Birth Date:</dt>
                        <dd class="inline ml-2">{{ $customer->birth_date }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Vehicle Section --}}
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Vehicle</h3>

            @if (optional($order->car)->image)
                <img src="{{ asset('images/' . $order->car->image) }}" alt="Car Image"
                    class="w-full h-32 object-contain rounded-lg border border-gray-200 mb-4 bg-gray-50" />
            @endif

            <dl class="space-y-2 text-sm text-gray-700">
                <div>
                    <dt class="font-medium inline">Brand:</dt>
                    <dd class="inline ml-2">{{ optional($order->car)->brand ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium inline">Model:</dt>
                    <dd class="inline ml-2">{{ optional($order->car)->model ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium inline">Year:</dt>
                    <dd class="inline ml-2">{{ optional($order->car)->year ?? '-' }}</dd>
                </div>

                {{-- Colors --}}
                <div class="flex items-start gap-2">
                    <dt class="font-medium">Colors:</dt>
                    <dd class="flex flex-wrap gap-1 ml-1">
                        @if (optional($order->car)->colors && $order->car->colors->count())
                            @foreach ($order->car->colors as $color)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700 border">
                                    {{ $color->color_name ?? '-' }}
                                </span>
                            @endforeach
                        @else
                            <span class="italic text-gray-400">-</span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="font-medium inline">Category:</dt>
                    <dd class="inline ml-2">{{ optional($order->car)->category ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium inline">Vehicle code:</dt>
                    <dd class="inline ml-2 font-mono">{{ optional($order->car)->car_code ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium inline">Price:</dt>
                    <dd class="inline ml-2 font-semibold text-emerald-600">Rp
                        {{ number_format(optional($order->car)->price ?? 0, 0, ',', '.') }}</dd>
                </div>

                {{-- Specifications with Alpine.js toggle --}}
                <div x-data="{ expanded: false }">
                    <dt class="font-medium">Specifications:</dt>
                    <dd class="ml-2 text-gray-700">
                        <span x-show="!expanded" x-transition>
                            {{ Str::limit(optional($order->car)->specifications, 80, '...') }}
                        </span>
                        <span x-show="expanded" x-transition>
                            {{ optional($order->car)->specifications }}
                        </span>

                        @if (strlen(optional($order->car)->specifications) > 70)
                            <button @click="expanded = !expanded" class="ml-2 text-blue-600 hover:underline text-xs">
                                <span x-text="expanded ? 'Show less' : 'Show more'"></span>
                            </button>
                        @endif
                    </dd>
                </div>

                {{-- Dealer --}}
                <div>
                    <dt class="font-medium inline">Dealer:</dt>
                    <dd class="inline ml-2 text-gray-800">
                        {{ optional($order->car->dealer->user)->name ?? '-' }}
                        @if (optional($order->car->dealer)->city)
                            <span class="text-xs text-gray-500">({{ $order->car->dealer->city }})</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
