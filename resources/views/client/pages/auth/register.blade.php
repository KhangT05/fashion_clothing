<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="animate-fade-in-down w-full max-w-md">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Register to 23WebC</h3>
                    <p class="text-gray-600">Create an account to get started</p>
                </div>

                <!-- Form -->
                <form action="{{ route('auth.register') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Username Field -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Full Name</label>
                        <input type="text" name="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('name') border-red-500 @enderror"
                            placeholder="Enter your full name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-2">* {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('email') border-red-500 @enderror"
                            placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-2">* {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="Enter your password" required>
                        @error('password')
                            <p class="text-red-600 text-sm mt-2">* {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="flex items-center mt-4">
                        <input type="checkbox" id="terms" name="terms" class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-600" required>
                        <label for="terms" class="ml-3 text-gray-700 text-sm">
                            I agree to the terms and conditions
                        </label>
                    </div>

                    <!-- Register Button -->
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition duration-200 mt-6 flex items-center justify-center">
                        Create Account
                    </button>

                    <!-- Login Link -->
                    <p class="text-center text-gray-600 text-sm mt-4">
                        Already have an account?
                    </p>
                    <a href="{{ route('login') }}"
                        class="block w-full text-center bg-white border-2 border-gray-300 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-50 transition duration-200">
                        Sign In
                    </a>
                </form>

                <!-- Footer -->
                <p class="text-center text-gray-500 text-xs mt-6">
                    &copy; {{ now()->year }} 23WebC Platform. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.6s ease-out;
        }
    </style>

    <script>
        // Simple checkbox handling for iCheck compatibility
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('terms');
            if (checkbox) {
                checkbox.addEventListener('change', function() {
                    // Styling already handled by Tailwind
                });
            }
        });
    </script>
</body>

</html>
