<x-guest-layout>
    <div style="min-height:80vh; display:flex; align-items:center; justify-content:center; background:#000; padding:4rem 0;">
        <div style="width:100%; max-width:520px; background:#0a0a0a; padding:2rem; border-radius:12px; color:#FAEBD7; box-shadow:0 6px 18px rgba(0,0,0,0.6);">
            <div class="text-center mb-4">
                {{-- <img src="{{ asset('images/imperial-kost-logo.png') }}" alt="Imperial Logo" style="height:64px; display:block; margin:0 auto 12px;"> --}}
                <h2 style="margin:0; color:#FAEBD7; font-size:1.25rem; font-weight:600;">Create your account</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                <!-- Name -->
                <div style="margin-bottom:0.75rem;">
                    <x-input-label for="name" :value="__('Name')" style="color:#FAEBD7;" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div style="margin-bottom:0.75rem;">
                    <x-input-label for="email" :value="__('Email')" style="color:#FAEBD7;" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div style="margin-bottom:0.75rem;">
                    <x-input-label for="password" :value="__('Password')" style="color:#FAEBD7;" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom:0.75rem;">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" style="color:#FAEBD7;" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div style="margin-top:1rem;">
                    <button type="submit" style="width:100%; background:#FAEBD7; color:#000; border-radius:8px; padding:0.6rem 0; font-weight:600;">{{ __('Register') }}</button>
                </div>
            </form>

            <div style="text-align:center; margin-top:1rem; color:#cfc6bc; font-size:0.95rem;">
                <span>Already registered?</span>
                <a href="{{ route('login') }}" style="color:#FAEBD7; font-weight:600; margin-left:6px;">Log in</a>
            </div>
        </div>
    </div>
</x-guest-layout>
