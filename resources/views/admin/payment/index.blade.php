<?php error_reporting(E_ERROR | E_WARNING | E_PARSE); ?>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Brad Fitness Checkout</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

{{-- <link rel="stylesheet"

  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"> --}}

</head>



<body>

  <div class="container">

    <div class='row'>

      {{-- <div class='col-sm-2'></div> --}}

      <div class='col-sm-12'>

        <!-- <div class="alert alert-success">

            <p> card number: 4242424242424242 </p>

            <p> cvc = 123 </p>

            <p>any future expiry date</p>

        </div> -->

        @if ($errors->any())

           <div class="card-body">

			<div class="alert alert-primary solid alert-dismissible fade show">

			@foreach ($errors->all() as $error)

			<strong>{{ $error }}</strong><br> 

			@endforeach

			<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>

			</button>

            

            

			 </div>

			</div>

            @endif

        <b><span class="text-primary">Welcome {{ $user[0]->userName }}</span></b>

        <p>

          Plan Name: {{ $plan[0]->planName }}

        </p>



        <script src='https://js.stripe.com/v2/' type='text/javascript'></script>



        <form accept-charset="UTF-8" action="{{ url('pay')}}" class="require-validation"

          data-cc-on-file="false"

          data-stripe-publishable-key="{{ env('STRIPE_PUBLISHABLE_KEY') }}"

          id="payment-form" method="post">

          @csrf

          <input type="hidden" name="userId" value="{{ $userId }}">

          <input type="hidden" name="planId" value="{{ $planId }}">

          <div class='form-row'>

            <div class='col-sm-12 form-group required'>

              <label class='control-label'>Card Holder Name</label> <input

                class='form-control' type='text' placeholder="Enter Card Holder Name">

            </div>

          </div>

          <div class='form-row'>

            <div class='col-sm-12 form-group card required'>

              <label class='control-label'>Card Number</label> <input

                autocomplete='off' class='form-control card-number' maxlength='20'

                type='text' name="card_number" placeholder="Enter Card number">

            </div>

          </div>

          <div class='form-row'>

            <div class='col-sm-4 form-group cvc required'>

              <label class='control-label'>CVC</label> <input

                autocomplete='off' class='form-control card-cvc'

                placeholder='CVV' name="cvc" maxlength="3" type='text'>

            </div>

            <div class='col-sm-4 form-group expiration required'>

              <label class='control-label'>Month</label> <input

                class='form-control card-expiry-month' name="exp_month" placeholder='MM' maxlength="2"

                type='text'>

            </div>

            <div class='col-sm-4 form-group expiration required'>

              <label class='control-label'>YEAR</label> <input

                class='form-control card-expiry-year' name="exp_year" placeholder='YYYY'

                maxlength="9" type='text'>

            </div>

          </div>

          <div class='form-row'>

            <div class='col-md-12 form-group'>

              <button class='form-control btn btn-primary submit-button'

                type='submit' style="margin-top: 10px;">Pay ${{ $plan[0]->planPrice }}</button>

            </div>

          </div>

          <div class='form-row'>

            {{-- <div class='col-md-12 error form-group hide'>

              <div class='alert-danger alert'>Please correct the errors and try

                again.</div>

            </div> --}}

          </div>

        </form>

        @if ((Session::has('success-message')))

        <div class="alert alert-success col-md-12">{{

          Session::get('success-message') }}</div>

        @endif @if ((Session::has('fail-message')))

        <div class="alert alert-danger col-md-12">{{

          Session::get('fail-message') }}</div>

        @endif

      </div>

      {{-- <div class='col-sm-2'></div> --}}

    </div>

  </div>

    <script src="https://code.jquery.com/jquery-1.12.3.min.js"

    integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ="

    crossorigin="anonymous"></script>

   <script

    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"

    integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"

    crossorigin="anonymous"></script>

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