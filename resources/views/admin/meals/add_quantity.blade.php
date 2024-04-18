@extends('admin.layout.layout')

@section('style')

  <style>
    


  </style>
    
@endsection
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Meal Quantity</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Meal Quantity</li>
            </ol>
          </div>
        </div>
      </div>
    </section>


    <section class="content">

        <div class="container">
            <div class="row">


                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                        <h4>Meal Quantity</h4>
                        </div>

                        <div class="card-body">

                            <form action="{{url('post-add-meals')}}" method="POST">

                                 @csrf
                                 <input type="hidden" name="user_id" value="{{$user_id}}">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2>Meal 1</h2>
                                     @for ($i = 0; $i <count($meal_1); $i++)
                                     <input type="text" value="{{$meal_1[$i]}}"  name="meal_1[]" class="form-control" readonly=""> <br>

                                     @endfor

                                    </div>
                                
                                
                                    <div class="col-sm-6">
                                       <h2> Quantity</h2>
                                        @for ($i = 0; $i <count($meal_1); $i++)
                                        <input type="text" name="meal_1_quantity[]" class="form-control" placeholder="..." required /> <br>
                                        @endfor

                                    </div>
                                                              
                                
                                    <div class="col-sm-6">
                                        <h2>Meal 2</h2>
                                     @for ($i = 0; $i <count($meal_2); $i++)
                                     <input type="text" value="{{$meal_2[$i]}}"  name="meal_2[]" class="form-control" readonly="" /> <br>

                                     @endfor

                                    </div>
                                
                                
                                    <div class="col-sm-6">
                                       <h2 class="text-white"> Quantity</h2>
                                        @for ($i = 0; $i <count($meal_2); $i++)
                                        <input type="text"  name="meal_2_quantity[]" class="form-control" placeholder="..." required /> <br>
                                        @endfor

                                    </div>
                                                              
                                
                                    <div class="col-sm-6">
                                        <h2>Meal 3</h2>
                                     @for ($i = 0; $i <count($meal_3); $i++)
                                     <input type="text" value="{{$meal_3[$i]}}"  name="meal_3[]" class="form-control" readonly="" /> <br>

                                     @endfor

                                    </div>
                                
                                
                                    <div class="col-sm-6">
                                       <h2 class="text-white"> Quantity</h2>
                                        @for ($i = 0; $i <count($meal_3); $i++)
                                        <input type="text" value=""  name="meal_3_quantity[]" class="form-control" placeholder="..." required /> <br>
                                        @endfor

                                    </div>
                                                              
                                    <div class="col-sm-6">
                                        <h2>Meal 4</h2>
                                     @for ($i = 0; $i <count($meal_4); $i++)
                                     <input type="text" value="{{$meal_4[$i]}}"  name="meal_4[]" class="form-control" readonly="" /> <br>

                                     @endfor

                                    </div>
                                
                                
                                    <div class="col-sm-6">
                                       <h2 class="text-white"> Quantity</h2>
                                        @for ($i = 0; $i <count($meal_4); $i++)
                                        <input type="text" value=""  name="meal_4_quantity[]" class="form-control" placeholder="..." required /> <br>
                                        @endfor

                                    </div>
                                
                                    @if(!$meal_5==null)

                                    <div class="col-sm-6">
                                        <h2>Meal 5</h2>
                                     @for ($i = 0; $i <count($meal_5); $i++)
                                     <input type="text" value="{{$meal_5[$i]}}"  name="meal_5[]" class="form-control" readonly="" /> <br>

                                     @endfor

                                    </div>
                                
                                
                                    <div class="col-sm-6">
                                       <h2 class="text-white"> Quantity</h2>
                                        @for ($i = 0; $i <count($meal_5); $i++)
                                        <input type="text" value=""  name="meal_5_quantity[]" class="form-control" placeholder="..." required /> <br>
                                        @endfor

                                    </div>

                                         
                                    @else
                                        
                                    <input type="hidden" name="meal_5" value="0">

                                    @endif
                                 
                               
                                    @if (!$meal_6==null)
                                    
                                    <div class="col-sm-6">
                                        <h2>Meal 6</h2>
                                     @for ($i = 0; $i <count($meal_6); $i++)
                                     <input type="text" value="{{$meal_6[$i]}}"  name="meal_6[]" class="form-control" readonly="" /> <br>

                                     @endfor

                                    </div>
                                
                                
                                    <div class="col-sm-6">
                                       <h2 class="text-white"> Quantity</h2>
                                        @for ($i = 0; $i <count($meal_6); $i++)
                                        <input type="text" value=""  name="meal_6_quantity[]" class="form-control" placeholder="..." required /> <br>
                                        @endfor

                                    </div>

                                    @else

                                    <input type="hidden" name="meal_6" value="0">

                                    @endif
                                 
                                
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                      
                            </form>
                   
                        </div>

                    </div>
                      

                </div>

                
            </div>

        </div>







      
      </section>

  </div>

  @endsection



    @section('script')


    

                <script>

                $(document).ready(function(){

                  $('.select2').select2()


                  $('#user').select2({
                    theme: 'bootstrap4'
                  });


                });

                </script>

    @endsection


  