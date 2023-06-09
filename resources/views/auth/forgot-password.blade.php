<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">

        </x-slot>

        <!-- <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div> -->

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <a style="display:flex; margin-left: 35%" href="/" class="brand-logo">
                                <img src="../../../app-assets\images\logo\Logodoanxem.png" alt="" style="width: 50px; height: 50px;">
                                <h2 style="margin-top: 10px;font-size: 23px;font-weight: bold;" class="brand-text text-primary ms-1 ml-3">Đoán Xem</h2>
                            </a>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Đặt lại mật khẩu') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
