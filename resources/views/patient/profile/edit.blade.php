@extends('layouts.patient')

@section('header_title', 'Profil Saya')
@section('header_subtitle', 'Kelola informasi akun Anda.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        
        <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                <div class="relative group">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-indigo-50 shadow-sm">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <label for="avatarInput" class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </label>
                    
                    <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <div class="mt-2">
                        <label for="avatarInput" class="text-sm text-indigo-600 font-bold cursor-pointer hover:underline">
                            Ubah Foto Profil
                        </label>
                        @error('avatar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                        <input type="number" name="age" value="{{ old('age', $user->age) }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('age') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="gender" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="pria" {{ old('gender', $user->gender) == 'pria' ? 'selected' : '' }}>Pria</option>
                            <option value="wanita" {{ old('gender', $user->gender) == 'wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100">
                    <h4 class="text-md font-bold text-gray-800 mb-4">Ganti Password (Opsional)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Kosongkan jika tidak diganti">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                let img = input.closest('.group').querySelector('img');
                if(img) {
                    img.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection