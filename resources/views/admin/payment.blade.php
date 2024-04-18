<!DOCTYPE html>

<html>

   <head>

      <title>Please pay for your plan</title>

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

      <style type="text/css">

         .panel-title {

         display: inline;

         font-weight: bold;

         }

         .display-table {

         display: table;

         }

         .display-tr {

         display: table-row;

         }

         .display-td {

         display: table-cell;

         vertical-align: middle;

         width: 61%;

         }

      </style>

   </head>

   <body>

      <div class="container">

         <h1>Please pay for your plan</h1>

         <div class="row">

            <div class="col-md-6 col-md-offset-3">

               <div class="panel panel-default credit-card-box">

                  <div class="panel-heading display-table" >

                     

                  </div>

                  <div class="panel-body">

                     @if (Session::has('success'))

                     <div class="alert alert-success text-center">

                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                        <p>{{ Session::get('success') }}</p>

                     </div>

                     @endif

                     <form

                        role="form"

                        action="{{url('userPayment')}}"

                        method="post"

                        

                        id="payment-form">

                        @csrf

                        <div class='form-row row'>

                           <div class='col-xs-12 form-group required'>

                              <label class='control-label'>Name on Card</label>

							  <input class='form-control' size='4' type='text'>

							  <input class='form-control' size='4' type='hidden' name="planid" value="<?php echo $planId; ?>">

							  <input class='form-control' size='4' type='hidden' name="userId" value="<?php echo $userId; ?>">

                           </div>

                        </div>

                        <div class='form-row row'>

                           <div class='col-xs-12 form-group card required'>

                              <label class='control-label'>Card Number</label> <input

                                 autocomplete='off' class='form-control card-number' size='20'

                                 type='text'>

                           </div>

                        </div>

                        <div class='form-row row'>

                           <div class='col-xs-12 col-md-4 form-group cvc required'>

                              <label class='control-label'>CVC</label> <input autocomplete='off'

                                 class='form-control card-cvc' placeholder='ex. 311' size='4'

                                 type='text'>

                           </div>

                           <div class='col-xs-12 col-md-4 form-group expiration required'>

                              <label class='control-label'>Expiration Month</label> <input

                                 class='form-control card-expiry-month' placeholder='MM' size='2'

                                 type='text'>

                           </div>

                           <div class='col-xs-12 col-md-4 form-group expiration required'>

                              <label class='control-label'>Expiration Year</label> <input

                                 class='form-control card-expiry-year' placeholder='YYYY' size='4'

                                 type='text'>

                           </div>

                        </div>

                        

                        <div class="row">

                           <div class="col-xs-12">

                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($100)</button>

                           </div>

                        </div>

                     </form>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </body>

   <!-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script> -->

   

</html>