<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <script src='https://js.stripe.com/v2/' type='text/javascript'></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #0C4160;

            padding: 30px 10px;
        }

        .card {
            max-width: 500px;
            margin: auto;
            color: black;
            border-radius: 20 px;
        }

        p {
            margin: 0px;
        }

        .container .h8 {
            font-size: 30px;
            font-weight: 800;
            text-align: center;
        }

        .btn.btn-primary {
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            background-image: linear-gradient(to right, #77A1D3 0%, #79CBCA 51%, #77A1D3 100%);
            border: none;
            transition: 0.5s;
            background-size: 200% auto;

        }


        .btn.btn.btn-primary:hover {
            background-position: right center;
            color: #fff;
            text-decoration: none;
        }



        .btn.btn-primary:hover .fas.fa-arrow-right {
            transform: translate(15px);
            transition: transform 0.2s ease-in;
        }

        .form-control {
            color: white;
            background-color: #223C60;
            border: 2px solid transparent;
            height: 60px;
            padding-left: 20px;
            vertical-align: middle;
        }

        .form-control:focus {
            color: white;
            background-color: #0C4160;
            border: 2px solid #2d4dda;
            box-shadow: none;
        }

        .text {
            font-size: 14px;
            font-weight: 600;
        }

        ::placeholder {
            font-size: 14px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container p-0">
        <form accept-charset="UTF-8" action="{{ url('pay')}}" class="require-validation" 
            data-cc-on-file="false" 
            data-stripe-publishable-key="{{ env('STRIPE_PUBLISHABLE_KEY') }}" 
            id="payment-form" method="post" autocomplete="off" >

            @csrf

            <input type="hidden" name="userId" value="{{ $userId }}">
  
            <input type="hidden" name="planId" value="{{ $planId }}">

            {{-- card starts here --}}
            <div class="card px-4">
                <div class="pt-2 pb-2">
                    <img src="{{ url('assets/zoltz_logo.png') }}" alt="" class="img img-responsive img-thumbnail img-circle">
                </div>
                <div class="row gx-3">
                    <div class="col-6 mb-2">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Subscriber</p>
                             <b><u>{{$user[0]->userName}}</u></b>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Plan</p>
                            <b><u>{{ $plan[0]->planName }}</u></b>
                            {{-- <input class="form-control mb-3" type="text" value="" disabled> --}}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Person Name</p>
                            <input class="form-control mb-3" type="text" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Card Number</p>
                            <input class="form-control mb-3 card-number" type="text" name="card_number" placeholder="1234 5678 4356 7830">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Expiry Month</p>
                            <input class="form-control mb-3 card-expiry-month" name="exp_month" type="text" placeholder="MM">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Expiry Year</p>
                            <input class="form-control mb-3 card-expiry-year" name="exp_year" type="text" placeholder="YYYY">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">CVV/CVC</p>
                            <input class="form-control mb-3 pt-2 card-cvc" name="cvc" type="password" placeholder="***">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mb-3">
                                <span class="ps-3">Pay ${{ $plan[0]->planPrice }}</span>
                                <span class="fas fa-arrow-right"></span>
                        </button>
                    </div>
                </div>
            </div>


        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    {{-- stripe script --}}
    <script>

        $(function() {
    
            $('form.require-validation').bind('submit', function(e) {
    
              var $form         = $(e.target).closest('form'),
    
                  inputSelector = ['input[type=email]', 'input[type=password]',
    
                                   'input[type=text]', 'input[type=file]',
    
                                   'textarea'].join(', '),
    
                  $inputs       = $form.find('.required').find(inputSelector),
    
                  $errorMessage = $form.find('div.error'),
    
                  valid         = true;
    
    
    
              $errorMessage.addClass('hide');
    
              $('.has-error').removeClass('has-error');
    
              $inputs.each(function(i, el) {
    
                var $input = $(el);
    
                if ($input.val() === '') {
    
                  $input.parent().addClass('has-error');
    
                  $errorMessage.removeClass('hide');
    
                  e.preventDefault(); // cancel on first error
    
                }
    
              });
    
            });
    
          });
    
    
    
          $(function() {
    
            var $form = $("#payment-form");
    
    
    
            $form.on('submit', function(e) {
    
              if (!$form.data('cc-on-file')) {
    
                e.preventDefault();
    
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
    
                Stripe.createToken({
    
                  number: $('.card-number').val(),
    
                  cvc: $('.card-cvc').val(),
    
                  exp_month: $('.card-expiry-month').val(),
    
                  exp_year: $('.card-expiry-year').val()
    
                }, stripeResponseHandler);
    
              }
    
            });
    
    
    
            function stripeResponseHandler(status, response) {
    
              if (response.error) {
    
                $('.error')
    
                  .removeClass('hide')
    
                  .find('.alert')
    
                  .text(response.error.message);
    
              } else {
    
                // token contains id, last4, and card type
    
                var token = response['id'];
    
                // insert the token into the form so it gets submitted to the server
    
                $form.find('input[type=text]').empty();
    
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
    
                console.log(token);
    
                $form.get(0).submit();
    
              }
    
            }
    
          })
    
        </script>
    


</body>
</html>