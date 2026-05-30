<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="animate-fade-in-down w-full max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Left Section - Welcome -->
                <div class="hidden md:block space-y-6">
                    <h2 class="text-4xl font-bold text-gray-900">Welcome to 23WebC</h2>
                    <h3 class="text-xl text-gray-700">E-commerce Platform of CDKTCT</h3>
                    <p class="text-gray-600 text-base leading-relaxed mt-8 opacity-90">
                        Log in to access the management system and start managing your business.
                    </p>
                </div>

                <!-- Right Section - Login Form -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

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

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition duration-200 flex items-center justify-center">
                            Sign In
                        </button>

                        <!-- Register Link -->
                        <p class="text-center text-gray-600 text-sm">
                            Don't have an account?
                        </p>
                        <a href="{{ route('auth.register') }}"
                            class="block w-full text-center bg-white border-2 border-gray-300 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-50 transition duration-200">
                            Create an account
                        </a>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-4 text-center md:text-left">
                <div class="text-gray-600 text-sm">
                    Copyright Example Company
                </div>
                <div class="text-gray-600 text-sm md:text-right">
                    &copy; {{ now()->year }}
                </div>
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
</body>

</html>
