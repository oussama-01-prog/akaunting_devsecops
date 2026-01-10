<!-- <x-layouts.auth>
    <x-slot name="title">
        {{ trans('auth.register_user') }}
    </x-slot>

    <x-slot name="content">
        <div>
            <img src="{{ asset('public/img/akaunting-logo-green.svg') }}" class="w-16" alt="Akaunting" />

            <h1 class="text-lg my-3">
                {{ trans('auth.register_user') }}
            </h1>
        </div>

        <div :class="(form.response.success) ? 'w-full bg-green-100 text-green-600 p-3 rounded-sm font-semibold text-xs' : 'hidden'"
            v-if="form.response.success"
            v-html="form.response.message"
            v-cloak
        ></div>

        <div :class="(form.response.error) ? 'w-full bg-red-100 text-red-600 p-3 rounded-sm font-semibold text-xs' : 'hidden'"
            v-if="form.response.error"
            v-html="form.response.message"
            v-cloak
        ></div>

        <x-form id="auth" route="register.store">
            <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5 lg:h-64">
                <x-form.input.hidden name="token" value="{{ $token }}" />

                <x-form.group.password
                    name="password"
                    label="{{ trans('auth.password.pass') }}"
                    placeholder="{{ trans('auth.password.pass') }}"
                    form-group-class="sm:col-span-6"
                    input-group-class="input-group-alternative"
                />

                <x-form.group.password
                    name="password_confirmation"
                    label="{{ trans('auth.password.pass_confirm') }}"
                    placeholder="{{ trans('auth.password.pass') }}"
                    form-group-class="sm:col-span-6"
                    input-group-class="input-group-alternative"
                />

                <x-button
                    type="submit"
                    ::disabled="form.loading"
                    class="relative flex items-center justify-center bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100 sm:col-span-6"
                    override="class"
                    data-loading-text="{{ trans('general.loading') }}"
                >
                    <i v-if="form.loading" class="submit-spin absolute w-2 h-2 rounded-full left-0 right-0 -top-3.5 m-auto"></i>
                    <span :class="[{'opacity-0': form.loading}]">
                        {{ trans('auth.register') }}
                    </span>
                </x-button>
            </div>
        </x-form>
    </x-slot>

    <x-script folder="auth" file="common" />
</x-layouts.auth> -->

<!-- version2 -->
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Akaunting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Create Account</h1>
            <p class="text-slate-600">Join Akaunting to manage your finances with ease</p>
        </div>

        <!-- Registration Card -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Full Name Field -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        Full Name
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        placeholder="John Doe"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                        placeholder="you@example.com"
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                        placeholder="Enter a strong password"
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Confirm your password"
                        required
                    >
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start gap-3 py-2">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 mt-1"
                        required
                    >
                    <label for="terms" class="text-sm text-slate-600">
                        I agree to the <a href="#" class="text-blue-600 hover:underline font-semibold">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline font-semibold">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-md transition-colors duration-200 mt-6"
                >
                    Create Account
                </button>
            </form>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-slate-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">
                    Sign In
                </a>
            </p>
        </div>

        <!-- Support Links -->
        <div class="mt-8 pt-6 border-t border-slate-200 flex justify-center gap-6 text-sm text-slate-600">
            <a href="#" class="hover:text-slate-900">Help Center</a>
            <a href="#" class="hover:text-slate-900">Contact Support</a>
            <a href="#" class="hover:text-slate-900">Status</a>
        </div>
    </div>
</body>
</html>