<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Reset Password</h2>
                    <p class="text-gray-600">Enter your details to reset your password</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input id="email" type="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition"
                            value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                        @error('email')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
                        <input id="password" type="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition"
                            required autocomplete="new-password">
                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition"
                            required autocomplete="new-password">
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-8">
                        <button type="submit"
                            class="bg-indigo-600 text-white font-semibold py-3 px-8 rounded-lg hover:bg-indigo-700 transition duration-200">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
