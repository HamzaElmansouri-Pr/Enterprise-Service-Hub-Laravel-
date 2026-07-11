@extends('admin.layouts.app')

@section('title', 'Two-Factor Authentication Setup')
@section('page-title', 'Security Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Two-Factor Authentication</h5>
            </div>
            <div class="card-body">
                <p>Add additional security to your account using two-factor authentication.</p>
                <p class="text-muted small">When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.</p>

                @if(! auth()->user()->two_factor_secret)
                    <div class="mt-4">
                        <form method="POST" action="{{ route('two-factor.enable') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Enable Two-Factor Authentication
                            </button>
                        </form>
                    </div>
                @else
                    @if(session('status') == 'two-factor-authentication-enabled')
                        <div class="alert alert-success mt-3">
                            <strong>Two-factor authentication is now enabled.</strong> Scan the following QR code using your phone's authenticator application.
                        </div>

                        <div class="mt-4">
                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                        </div>

                        <div class="mt-4">
                            <p class="fw-bold mb-2">Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.</p>
                            <div class="bg-light p-3 rounded font-monospace">
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                    <div>{{ $code }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <form method="POST" action="{{ route('two-factor.confirm') }}">
                                @csrf
                                <div class="mb-3 w-50">
                                    <label class="form-label">Setup Key</label>
                                    <input type="text" name="code" class="form-control" placeholder="Enter 6-digit code" required autofocus>
                                </div>
                                <button type="submit" class="btn btn-success">Confirm & Enable</button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-check-circle me-1"></i> Two-factor authentication is active on your account.
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <form method="POST" action="{{ route('two-factor.recovery-codes') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary">
                                    Regenerate Recovery Codes
                                </button>
                            </form>

                            <form method="POST" action="{{ route('two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Disable Two-Factor Authentication
                                </button>
                            </form>
                        </div>
                        
                        @if (session('status') == 'recovery-codes-generated')
                            <div class="mt-4">
                                <p class="fw-bold mb-2">New recovery codes generated. Store them in a secure password manager.</p>
                                <div class="bg-light p-3 rounded font-monospace">
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                        <div>{{ $code }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
