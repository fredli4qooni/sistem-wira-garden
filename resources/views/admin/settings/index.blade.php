<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-primary leading-tight font-heading">
            Pengaturan Tampilan
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-4xl">
        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($settings as $setting)
                    <div class="col-span-1 {{ $setting->type === 'textarea' || $setting->type === 'image' ? 'md:col-span-2' : '' }}">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ $setting->label ?? $setting->key }}</label>
                        
                        @if($setting->type === 'color')
                            <div class="flex items-center gap-3">
                                <input type="color" name="{{ $setting->key }}" value="{{ $setting->value }}" class="h-10 w-20 rounded cursor-pointer border-gray-200">
                                <span class="text-sm text-gray-500 font-mono">{{ $setting->value }}</span>
                            </div>
                        @elseif($setting->type === 'textarea')
                            <textarea name="{{ $setting->key }}" rows="3" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-gray-700">{{ $setting->value }}</textarea>
                        @elseif($setting->type === 'image')
                            <div class="flex items-start gap-4">
                                @if($setting->value)
                                    <img src="{{ asset($setting->value) }}" alt="Current Image" class="h-24 w-auto rounded-lg object-cover border border-gray-100">
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="{{ $setting->key }}" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
                                    <p class="text-xs text-gray-400 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                                </div>
                            </div>
                        @else
                            <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-gray-700">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-xl transition-colors font-bold shadow-md shadow-primary/20">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
