<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/fav.png') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{ $plan->name }}
                </div>
                @if (Session::has('flash_message_error'))
                    <div class="alert alert-error alert-block">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>{!! session('flash_message_error') !!}</strong>
                    </div>
                @endif
                @if (Session::has('flash_message_success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>{!! session('flash_message_success') !!}</strong>
                    </div>
                @endif
                @php
                    $array = array(array('metaname' => 'color', 'metavalue' => 'blue'),
                            array('metaname' => 'size', 'metavalue' => 'big'));
                @endphp

                <form method="POST" action="{{ route('pay') }}" id="paymentForm">
                    <div class="row" style="margin-bottom:40px;">
                      <div class="col-md-8 col-md-offset-2">
                        <p>
                            <div>
                                Name:{{ $plan->name}}<br>
                                Duration:{{ $plan->duration}}<br>
                                ₦ {{ $plan->price }}
                            </div>
                        </p>
                        {{ csrf_field() }}
                        <input type="hidden" name="amount" value="500" /> <!-- Replace the value with your transaction amount -->
                        <input type="hidden" name="payment_method" value="both" /> <!-- Can be card, account, both -->
                        <input type="hidden" name="description" value="Beats by Dre. 2017" /> <!-- Replace the value with your transaction description -->
                        <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
                        <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
                        <input type="hidden" name="email" value="test@test.com" /> <!-- Replace the value with your customer email -->
                        <input type="hidden" name="firstname" value="Oluwole" /> <!-- Replace the value with your customer firstname -->
                        <input type="hidden" name="lastname" value="Adebiyi" /> <!-- Replace the value with your customer lastname -->
                        <input type="hidden" name="metadata" value="{{ json_encode($array) }}" > <!-- Meta data that might be needed to be passed to the Rave Payment Gateway -->
                        <input type="hidden" name="phonenumber" value="090929992892" /> <!-- Replace the value with your customer phonenumber -->
                        {{-- <input type="hidden" name="paymentplan" value="362" /> <!-- Ucomment and Replace the value with the payment plan id --> --}}
                        {{-- <input type="hidden" name="ref" value="MY_NAME_5uwh2a2a7f270ac98" /> <!-- Ucomment and  Replace the value with your transaction reference. It must be unique per transaction. You can delete this line if you want one to be generated for you. --> --}}
                        {{-- <input type="hidden" name="logo" value="https://pbs.twimg.com/profile_images/915859962554929153/jnVxGxVj.jpg" /> <!-- Replace the value with your logo url (Optional, present in .env)--> --}}
                        {{-- <input type="hidden" name="title" value="Flamez Co" /> <!-- Replace the value with your transaction title (Optional, present in .env) --> --}}
                        <input type="submit" value="Buy"  />
                        </p>
                      </div>
                    </div>
            </form>
            </div>
        </div>
    </body>
</html>
