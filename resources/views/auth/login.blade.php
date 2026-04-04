<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-4">
        @csrf

        <!-- Email Address -->
        <div class="premium-input-wrapper">
            <label for="email" class="text-white text-xs font-semibold mb-2 block opacity-70 uppercase tracking-widest">Email Address</label>
            <div class="relative">
                <input id="email" class="premium-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com" />
                <i class="fas fa-envelope premium-input-icon"></i>
            </div>
            @if($errors->has('email'))
                <p class="text-red-400 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div class="premium-input-wrapper">
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="text-white text-xs font-semibold block opacity-70 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs link-premium opacity-80 hover:opacity-100" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input id="password" class="premium-input" type="password" name="password" required placeholder="••••••••" />
                <i class="fas fa-lock premium-input-icon"></i>
            </div>
            @if($errors->has('password'))
                <p class="text-red-400 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-white/10 bg-white/5 text-emerald-500 shadow-sm focus:ring-emerald-500/20 w-4 h-4 transition-all" name="remember">
                <span class="ms-2 text-sm text-dim group-hover:text-white/70 transition-colors">Keep me signed in</span>
            </label>
        </div>

        <div class="mt-8">
            <button type="submit" class="btn-architect">
                Sign In to Dashboard
            </button>
        </div>

    </form>
</x-guest-layout>
