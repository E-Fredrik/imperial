<x-guest-layout>
    <div style="min-height:80vh; display:flex; align-items:center; justify-content:center; background:#000; padding:4rem 0;">
        <div style="width:100%; max-width:420px; background:#0a0a0a; padding:2rem; border-radius:12px; color:#FAEBD7; box-shadow:0 6px 18px rgba(0,0,0,0.6);">
            <div class="text-center mb-4">
                {{-- <img src="{{ asset('images/imperial-kost-logo.png') }}" alt="Imperial Logo" style="height:64px; display:block; margin:0 auto 12px;"> --}}
                <h2 style="margin:0; color:#FAEBD7; font-size:1.25rem; font-weight:600;">Sign in to your account</h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <!-- Email Address -->
                <div style="margin-bottom:0.75rem;">
                    <x-input-label for="email" :value="__('Email')" style="color:#FAEBD7;" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div style="margin-top:0.75rem;">
                    <x-input-label for="password" :value="__('Password')" style="color:#FAEBD7;" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="d-flex align-items-center" style="margin-top:0.75rem;">
                    <label for="remember_me" class="inline-flex items-center" style="color:#cfc6bc;">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span style="margin-left:0.5rem; color:#cfc6bc;">{{ __('Remember me') }}</span>
                    </label>
                    <div style="margin-left:auto;">
                        @if (Route::has('password.request'))
                            <a class="underline" href="{{ route('password.request') }}" style="color:#FAEBD7; opacity:0.9;">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>
                </div>

                <div style="margin-top:1rem;">
                    <button type="submit" style="width:100%; background:#FAEBD7; color:#000; border-radius:8px; padding:0.6rem 0; font-weight:600;">{{ __('Log in') }}</button>
                </div>
            </form>

            <div style="text-align:center; margin-top:1rem; color:#cfc6bc; font-size:0.95rem;">
                <span>Don't have an account?</span>
                <a href="{{ route('register') }}" style="color:#FAEBD7; font-weight:600; margin-left:6px;">Register</a>
            </div>
        </div>
    </div>
</x-guest-layout>
