<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informações de Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Atualize as informações de perfil e endereço de e-mail da sua conta.") }}
        </p>
    </header>



<div class="box box-primary">

    <div class="box-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" :value="__('Nome')" /><br>
                <x-text-input class="form-control" id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('nome')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" /><br>
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>


            <div class="box-footer">
                <div class="flex items-center gap-4">
                    <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </div>

        </form>

    </div>

</div>



</section>


