<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <label for="email" class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 block">Email Address</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 input-icon"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                    placeholder="name@company.com"
                    class="input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm" />
            </div>
            @if($errors->has('email'))
                <p class="text-red-400 text-xs mt-2 font-medium flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('email') }}
                </p>
            @endif
        </div>

        <!-- Password -->
        <div class="relative">
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 input-icon"></i>
                <input id="password" type="password" name="password" required 
                    placeholder="••••••••"
                    class="input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm" />
            </div>
            @if($errors->has('password'))
                <p class="text-red-400 text-xs mt-2 font-medium flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-slate-700 bg-slate-800/50 text-blue-500 shadow-sm focus:ring-blue-500/30 w-4 h-4 transition-all cursor-pointer">
                <span class="ms-3 text-sm text-slate-400 group-hover:text-slate-300 transition-colors">Keep me signed in</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="btn-glow w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                <span>Sign In to Dashboard</span>
                <i class="fas fa-arrow-right text-sm"></i>
            </button>
        </div>
    </form>
</x-guest-layout>
