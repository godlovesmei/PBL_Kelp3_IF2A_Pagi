@props(['customer', 'order', 'car'])

<div class="bg-white rounded-md shadow p-6 border border-stone-200">
    <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-stone-300 gap-6">
        {{-- Customer Section --}}
        <div class="pr-0 sm:pr-6">
            <div class="text-lg font-bold mb-3">Customer</div>
            <dl class="space-y-1">
                <div><dt class="font-medium inline">Name:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($customer->user)->name ?? '-' }}</dd></div>
                <div><dt class="font-medium inline">Email:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($customer->user)->email ?? '-' }}</dd></div>
                <div><dt class="font-medium inline">Phone:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($customer->user)->phone ?? '-' }}</dd></div>
                <div><dt class="font-medium inline">Address:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($customer->user)->address ?? '-' }}</dd></div>
                @if(!empty($customer->nik))
                    <div><dt class="font-medium inline">NIK:</dt> <dd class="inline text-gray-800 ml-1">{{ $customer->nik }}</dd></div>
                @endif
                @if(!empty($customer->gender))
                    <div><dt class="font-medium inline">Gender:</dt> <dd class="inline text-gray-800 ml-1">{{ ucfirst($customer->gender) }}</dd></div>
                @endif
                @if(!empty($customer->birth_date))
                    <div><dt class="font-medium inline">Birth Date:</dt> <dd class="inline text-gray-800 ml-1">{{ $customer->birth_date }}</dd></div>
                @endif
            </dl>
        </div>

        {{-- Car Section --}}
        <div class="pt-6 sm:pt-0 sm:pl-6">
            <div class="text-lg font-bold mb-3">Vehicle</div>
            @if(optional($order->car)->image)
                <img src="{{ asset('images/' . $order->car->image) }}" alt="Car Image"
                     class="h-28 w-auto object-contain rounded-lg border mb-4" />
            @endif
            <dl class="space-y-1">
                <div><dt class="font-medium inline">Brand:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($order->car)->brand ?? '-' }}</dd></div>
                <div><dt class="font-medium inline">Model:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($order->car)->model ?? '-' }}</dd></div>
                <div><dt class="font-medium inline">Year:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($order->car)->year ?? '-' }}</dd></div>
                <div>
                    <dt class="font-medium inline">Colors:</dt>
                    <dd class="inline ml-1">
                        @if(optional($order->car)->colors && $order->car->colors->count())
                            <div class="inline-flex flex-wrap gap-1">
                                @foreach($order->car->colors as $color)
                                    <span class="py-0.5 text-md rounded bg-white text-gray-800 border border-white">
                                        {{ $color->color_name ?? '-' }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="italic text-gray-400">-</span>
                        @endif
                    </dd>
                </div>
                <div><dt class="font-medium inline">Category:</dt> <dd class="inline text-gray-800 ml-1">{{ optional($order->car)->category ?? '-' }}</dd></div>
                <div><dt class="font-medium inline">Vehicle code:</dt> <dd class="inline font-mono text-gray-800 ml-1">{{ optional($order->car)->car_code ?? '-' }}</dd></div>
                <div><dt class="font-medium inline">Price:</dt> <dd class="inline text-emerald-700 font-semibold ml-1">Rp {{ number_format(optional($order->car)->price ?? 0, 0, ',', '.') }}</dd></div>

                {{-- Specifications with Toggle --}}
                <div x-data="{ expanded: false }">
                    <dt class="font-medium inline">Specifications:</dt>
                    <dd class="inline text-gray-800 ml-1">
                        <span x-show="!expanded">
                            {{ Str::limit(optional($order->car)->specifications, 80, '...') }}
                        </span>
                        <span x-show="expanded">
                            {{ optional($order->car)->specifications }}
                        </span>

                        @if(strlen(optional($order->car)->specifications) > 70)
                            <button
                                @click="expanded = !expanded"
                                class="ml-2 text-blue-600 hover:underline text-sm"
                            >
                                <span x-text="expanded ? 'Show less' : 'Show more'"></span>
                            </button>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="font-medium inline">Dealer:</dt>
                    <dd class="inline text-gray-800 ml-1">
                        {{ optional($order->car->dealer->user)->name ?? '-' }}
                        @if(optional($order->car->dealer)->city)
                            <span class="text-xs text-gray-400">({{ $order->car->dealer->city }})</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
