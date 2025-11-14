<x-guest-layout>

    <style>
        body {
            background: #f4f6f9;
        }

        .login-container {
            max-width: 30%;
            width:50%;
            margin: 60px auto;
            padding: 40px 35px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.1);
        }

        .login-title {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            color: #4e73df;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            margin-bottom: 6px;
            display: block;
        }

        .form-group input {
            padding: 10px 12px !important;
        }

        .action-row {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .register-link {
            margin-top: 25px;
        }
    </style>

    <div class="login-container">

        <div class="login-title">Login</div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email"
                    class="block mt-1 w-full"
                    :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password"
                    class="block mt-1 w-full"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="form-group">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="action-row">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif

                <button type="submit"
    class="btn btn-primary w-auto px-6 py-2"
    style="background:#4e73df; border-radius:8px;color:white; border:none;">
    Log in
</button>

            </div>

            <!-- Register -->
            <div class="text-center register-link">
                <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">
                    Create a new account
                </a>
            </div>

        </form>

    </div>

</x-guest-layout>
