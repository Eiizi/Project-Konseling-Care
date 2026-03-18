@extends('layouts.patient')

@section('title', 'Detail Sesi')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('patient.appointments.index', ['view' => 'history']) }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6 transition">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Riwayat
    </a>

    @if($appointment->status == 'completed')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-indigo-900 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Catatan Medis / Feedback Konselor
                </h2>
                <span class="text-xs font-semibold bg-indigo-200 text-indigo-800 px-3 py-1 rounded-full">Sesi Selesai</span>
            </div>
            <div class="p-8">
                {{-- KITA UBAH VARIABELNYA JADI counselor_feedback --}}
                @if($appointment->counselor_feedback)
                    <div class="prose max-w-none text-gray-800 whitespace-pre-line leading-relaxed">
                        {{ $appointment->counselor_feedback }}
                    </div>
                @elseif($appointment->counselor_notes)
                    {{-- Cadangan jika data tersimpan di notes --}}
                    <div class="prose max-w-none text-gray-800 whitespace-pre-line leading-relaxed">
                        {{ $appointment->counselor_notes }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        <p class="text-gray-500 italic">Konselor belum menambahkan catatan untuk sesi ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Ulasan Anda</h3>

            @if($appointment->review)
                <div class="bg-green-50 rounded-xl p-6 border border-green-100 text-center">
                    <p class="text-green-800 font-medium mb-2">Terima kasih! Anda sudah memberikan ulasan.</p>
                    <div class="flex justify-center mb-3 text-yellow-400">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-6 h-6 {{ $i <= $appointment->review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 italic">"{{ $appointment->review->comment }}"</p>
                </div>
            @else
                <form action="{{ route('patient.reviews.store', $appointment->id) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Berikan Rating (Bintang)</label>
                        <div class="flex gap-4">
                            <div class="flex items-center space-x-1">
                                @foreach([1, 2, 3, 4, 5] as $rating)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $rating }}" class="peer sr-only" required>
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 border-gray-200 text-gray-400 peer-checked:border-yellow-400 peer-checked:bg-yellow-50 peer-checked:text-yellow-500 hover:bg-gray-50 transition">
                                            <span class="font-bold text-lg">{{ $rating }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Tulis Komentar</label>
                        <textarea name="comment" id="comment" rows="4" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Bagaimana pengalaman konseling Anda?"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-indigo-700 transition">
                        Kirim Ulasan
                    </button>
                </form>
            @endif
        </div>

    @else

        @if($appointment->meeting_type == 'offline')
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gray-900 text-white p-6 text-center">
                    <h2 class="text-2xl font-bold tracking-widest uppercase">BUKTI OFFLINE</h2>
                    <p class="text-sm text-gray-400">Tunjukkan bukti ini di klinik</p>
                </div>
                <div class="p-8">
                    <div class="text-center border-b border-dashed border-gray-300 pb-6 mb-6">
                        <p class="text-xs text-gray-500 uppercase">Kode Booking</p>
                        <p class="text-3xl font-mono font-bold text-indigo-600">#{{ $appointment->id }}</p>
                        <span class="mt-2 inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase">{{ $appointment->status }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl text-center">
                        <p class="font-bold text-gray-900">Lokasi Klinik</p>
                        <p class="text-sm text-gray-600">{{ $appointment->counselor->profile->address ?? 'Klinik Pusat MindWell' }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Sesi Online</h2>
                <p class="text-gray-500 mb-8">Masuk ke ruang video call sekarang.</p>
                <a href="{{ $appointment->meeting_link }}" target="_blank" class="inline-block px-8 py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700">Masuk Ruang Zoom</a>
            </div>
        @endif

        <div class="mt-8 text-center">
            <form action="{{ route('patient.session.complete', $appointment->id) }}" method="POST" onsubmit="return confirm('Selesaikan sesi?')">
                @csrf @method('PATCH')
                <button class="text-sm text-gray-400 underline hover:text-gray-600">Tandai Sesi Selesai (Manual)</button>
            </form>
        </div>

    @endif

</div>
@endsection