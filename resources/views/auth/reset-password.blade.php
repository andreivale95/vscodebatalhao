<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Resetar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body style="background-color: rgb(246, 247, 250)">

    <div class="classic col-xs-12 col-md-2">
        <div class="container shadow-lg p-3 mb-5 bg-white rounted">

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="col-auto">
                    <h4><x-input-label for="email" :value="__('Email')" /></h4>
                    <h5><x-text-input id="email" class="block mt-1 w-full" readonly class="form-control-plaintext"
                            type="email" name="email" :value="old('email', $request->email)" required autofocus
                            autocomplete="username" />
                    </h5>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <h5><x-input-label for="password" :value="__('Nova Senha')" /></h5>
                    <x-text-input id="password" class="form-control" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <h5><x-input-label for="password_confirmation" :value="__('Confirme a Nova Senha')" /></h5>

                    <x-text-input id="password_confirmation" class="form-control" type="password"
                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div><br>

                <div class="col-auto">
                    <button type="submit" style="width: 370px" class="btn btn-primary mb-3">Resetar Senha</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .classic {
            scale: 120px;
            width: 400px;


            position: absolute;

            top: 50%;

            left: 50%;

            transform: translate(-50%, -50%);


        }


        .container {
            margin-top: 80px;
            margin-bottom: 80px;
            border-radius: 10px;
        }

        .img-card-user {
            width: 220px;
            border-radius: 50%;
        }

        .img-mini-card {
            width: 50px;
        }

        .centered {
            margin: 0 auto !important;
            float: none !important;
        }

    </style>



</body>

</html>
