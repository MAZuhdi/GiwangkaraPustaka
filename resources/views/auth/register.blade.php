<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- NISN/NIP -->
            <div>
                <x-label for="id_pengguna" :value="__('NISN/NIP')" />

                <x-input id="id_pengguna" class="block mt-1 w-full" type="text" name="id_pengguna" :value="old('id_pengguna')"  />
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Kelas -->
            <div class="mt-4">
                <x-label for="kelas" :value="__('Kelas')" />

                <select name="kelas" id="kelas" class="block mt-1 w-full">
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>

            <!-- Jurusan -->
            <div class="mt-4">
                <x-label for="jurusan" :value="__('Jurusan')" />

                <select name="jurusan" id="jurusan" class="block mt-1 w-full">
                    <option value="IPA">IPA</option>
                    <option value="IPS">IPS</option>
                </select>
            </div>

            <!-- Nomor Kelas -->
            <div class="mt-4">
                <x-label for="nomor_kelas" :value="__('Nomor Kelas')" />

                <x-input id="nomor_kelas" class="block mt-1 w-full" type="text" name="nomor_kelas" :value="old('nomor_kelas')"  />
            </div>

            <!-- Status -->
            <div class="mt-4">
                <x-label for="status" :value="__('Status')" />

                <x-input id="status" class="block mt-1 w-full" type="text" name="status" :value="old('status')"  />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
