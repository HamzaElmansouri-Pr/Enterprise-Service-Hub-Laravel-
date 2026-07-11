<x-guest-layout>
    <div x-data="{ recovery: false }">
        <div class="mb-6 text-sm text-slate-400 text-center" x-show="! recovery">
            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
        </div>

        <div class="mb-6 text-sm text-slate-400 text-center" x-show="recovery" style="display: none;">
            {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-6">
            @csrf

            <div x-show="! recovery" class="relative">
                <label for="code" class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 block">Authentication Code</label>
                <div class="relative">
                    <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 input-icon"></i>
                    <input id="code" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code"
                        placeholder="123456"
                        class="input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm" />
                </div>
                @if($errors->has('code'))
                    <p class="text-red-400 text-xs mt-2 font-medium flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first('code') }}
                    </p>
                @endif
            </div>

            <div x-show="recovery" style="display: none;" class="relative">
                <label for="recovery_code" class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 block">Recovery Code</label>
                <div class="relative">
                    <i class="fas fa-shield-alt absolute left-4 top-1/2 -translate-y-1/2 input-icon"></i>
                    <input id="recovery_code" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code"
                        placeholder="xxxxxxxxxxxxxxxxxxxx"
                        class="input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm" />
                </div>
                @if($errors->has('recovery_code'))
                    <p class="text-red-400 text-xs mt-2 font-medium flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first('recovery_code') }}
                    </p>
                @endif
            </div>

            <div class="flex items-center justify-between pt-2">
                <button type="button" class="text-sm text-blue-400 hover:text-blue-300 transition-colors"
                                x-show="! recovery"
                                x-on:click="
                                    recovery = true;
                                    $nextTick(() => { $refs.recovery_code.focus() })
                                ">
                    {{ __('Use a recovery code') }}
                </button>

                <button type="button" class="text-sm text-blue-400 hover:text-blue-300 transition-colors"
                                x-show="recovery" style="display: none;"
                                x-on:click="
                                    recovery = false;
                                    $nextTick(() => { $refs.code.focus() })
                                ">
                    {{ __('Use an authentication code') }}
                </button>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="btn-glow w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                    <span>Verify Code</span>
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
