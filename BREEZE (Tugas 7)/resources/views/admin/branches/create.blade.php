<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.branches.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tambah Cabang
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.branches.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            {{-- Kode --}}
                            <div>
                                <x-input-label for="code" value="Kode Cabang" />
                                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code')" required autofocus placeholder="Contoh: CBG-001" />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            {{-- Nama --}}
                            <div>
                                <x-input-label for="name" value="Nama Cabang" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required placeholder="Contoh: Cabang Jakarta" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <x-input-label for="address" value="Alamat" />
                                <textarea id="address" name="address" rows="3"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    placeholder="Alamat lengkap cabang">{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            {{-- Telepon --}}
                            <div>
                                <x-input-label for="phone" value="Telepon" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" placeholder="Contoh: 021-1234567" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('admin.branches.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                                    Batal
                                </a>
                                <x-primary-button>
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Simpan
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
