@extends('client.layouts')
@section('title', 'Trang liên hệ')
@section('content')
    <!-- Page Content -->
    @foreach ($settings as $setting)
    @endforeach
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-center mb-12 text-gray-800">Liên Hệ Với Chúng Tôi</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                <div class="bg-white rounded-lg shadow p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Gửi Tin Nhắn</h3>
                    <form class="space-y-4" action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div>
                            @error('name')
                                <div class="alert alert-danger">*{{ $message }}</div>
                            @enderror
                            <label class="block text-gray-700 mb-2 font-medium">Họ và tên *</label>
                            <input type="text" name="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#667eea]"
                                placeholder="Nhập họ tên của bạn" value="{{ old('name') }}">
                        </div>
                        <div>
                            @error('email')
                                <div class="alert alert-danger">*{{ $message }}</div>
                            @enderror
                            <label class="block text-gray-700 mb-2 font-medium">Email *</label>
                            <input type="email" name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#667eea]"
                                placeholder="Nhập email của bạn" value="{{ old('email') }}">
                        </div>
                        <div>
                            @error('noidung')
                                <div class="alert alert-danger">*{{ $message }}</div>
                            @enderror
                            <label class="block text-gray-700 mb-2 font-medium">Nội dung *</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#667eea]"
                                rows="5" name="noidung" placeholder="Nhập nội dung tin nhắn của bạn...">{{ old('noidung') }}</textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-[#667eea] text-white py-3 rounded-lg hover:bg-[#5568d3] font-semibold transition">
                            Gửi Tin Nhắn
                        </button>
                    </form>
                </div>
            </div>
            <div>
                <div class="bg-white rounded-lg shadow p-8 mb-6">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Thông Tin Liên Hệ</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-[#667eea] bg-opacity-20 p-3 rounded-full mr-4">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1 text-gray-800">Địa chỉ</h4>
                                <p class="text-gray-600">{{ $setting->address }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#667eea] bg-opacity-20 p-3 rounded-full mr-4">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1 text-gray-800">Điện thoại</h4>
                                <p class="text-gray-600">{{ $setting->phone }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#667eea] bg-opacity-20 p-3 rounded-full mr-4">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1 text-gray-800">Email</h4>
                                <p class="text-gray-600">{{ $setting->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#667eea] bg-opacity-20 p-3 rounded-full mr-4">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1 text-gray-800">Giờ làm việc</h4>
                                <p class="text-gray-600">Thứ 2 - Thứ 7: 8:00 - 21:00<br>Chủ nhật: 9:00 - 18:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-8">
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Kết Nối Với Chúng Tôi</h3>
                    <div class="flex gap-4">
                        <a href="{{ $setting->facebook_url }}"
                            class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="{{ $setting->linkedin_url }}"
                            class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="{{ $setting->instagram_url }}"
                            class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700 transition">
                            <i class="fa fa-instagram"></i>
                        </a>
                        <a href="{{ $setting->youtube_url }}"
                            class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-700 transition">
                            <i class="fa fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- <!-- Map -->
        <div class="mt-12">
            <div class="bg-white rounded-lg shadow overflow-hidden h-96">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4556422342135!2d106.70298731533397!3d10.775664992320737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3330bcc5%3A0xd790c7e9c2b223a!2zTmd1eeG7hW4gSHXhu4csIFF14bqtbiAxLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1234567890123!5m2!1svi!2s"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div> --}}
    @endsection
