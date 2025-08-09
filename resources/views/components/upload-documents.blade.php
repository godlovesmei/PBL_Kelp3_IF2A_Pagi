@props(['required' => true, 'errors' => []])

@auth
    <div>
        <div class="font-semibold text-gray-800 mb-3">{{ __('Upload Supporting Documents') }}</div>
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="ktp" :value="__('ID Card')" />
                <input id="ktp" name="ktp" type="file" accept=".jpg,.jpeg,.png,.pdf"
                    {{ $required ? 'required' : '' }} class="block w-full border text-sm border-gray-300 p-2 rounded" />
                <x-input-error :messages="$errors->get('ktp')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="npwp" :value="__('Tax ID')" />
                <input id="npwp" name="npwp" type="file" accept=".jpg,.jpeg,.png,.pdf"
                    {{ $required ? 'required' : '' }} class="block w-full border text-sm border-gray-300 p-2 rounded" />
                <x-input-error :messages="$errors->get('npwp')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="salary" :value="__('Salary')" />
                <input id="salary" name="salary" type="file" accept=".jpg,.jpeg,.png,.pdf"
                    {{ $required ? 'required' : '' }} class="block w-full border text-sm border-gray-300 p-2 rounded" />
                <x-input-error :messages="$errors->get('salary')" class="mt-2" />
            </div>
        </div>
    </div>
@endauth
