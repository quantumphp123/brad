@extends('admin.layout.layout')
@section('content')

@section('style')
<style>
.error{
         color:red;
}
</style>
@endsection
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Answer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">User Answer</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    @if (session('success'))
	<div class="card-body">
	<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5>{{ Session::get('success') }}</h5>
	<?php Session::forget('success');?>
	</div>
    </div>
	@endif

    @if (session('failed'))
	<div class="card-body">
	<div class="alert alert-warning alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5>{{ Session::get('failed') }}</h5>
	<?php Session::forget('failed');?>
	</div>
    </div>
	@endif



     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
        
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                @foreach($username as $name)

                <h5><b>{{$name->name}}</b> ({{$name->email}})</h5>
                @break

                @endforeach

              </h3>
            </div>

            <div class="card-body">

              <div class="container-fluid">
                <div class="row">

              <div class="col-sm-4">
                
                <div class="card">
                  <div class="card-header">
                    <h5><b>Create Meal</b></h5>
                  </div>
                  <div class="card-body">

                    <form class="form" action="{{url('meal-quantity')}}" method="POST">
                      @csrf
                      <input type="hidden" name="user_id" value="{{$username[0]->id}}">
                      <label  for="meal1">Meal 1</label>
                      <select name="meal1[]" class="custom-select" id="meal1" multiple="multiple" required>
                       
                        @foreach ($options as $option)
                        <option value="{{$option->options}}">{{$option->options}}</option>
                        @endforeach
                        <option value="Honey">Honey</option>
                      </select>

                      <label  for="meal2">Meal 2</label>
                      <select name="meal2[]" class="custom-select" id="meal2" multiple="multiple" required>
                    
                        @foreach ($options as $option)
                        <option value="{{$option->options}}">{{$option->options}}</option>
                        @endforeach
                        <option value="Honey">Honey</option>
                
                      </select>

                      <label  for="meal3">Meal 3</label>
                      <select name="meal3[]" class="custom-select" id="meal3" multiple="multiple" required>
                        
                        @foreach ($options as $option)
                        <option value="{{$option->options}}">{{$option->options}}</option>
                        @endforeach
                        <option value="Honey">Honey</option>

                      </select>

                      <label  for="meal4">Meal 4</label>
                      <select name="meal4[]" class="custom-select" id="meal4" multiple="multiple" required>
                        
                        @foreach ($options as $option)
                        <option value="{{$option->options}}">{{$option->options}}</option>
                        @endforeach
                        <option value="Honey">Honey</option>

                      </select>

                      <label  for="meal5">Meal 5</label>
                      <select name="meal5[]" class="custom-select" id="meal5" multiple="multiple">
                        
                        @foreach ($options as $option)
                        <option value="{{$option->options}}">{{$option->options}}</option>
                        @endforeach
                        <option value="Honey">Honey</option>

                      </select>

                      <label  for="meal6">Meal 6</label>
                      <select name="meal6[]" class="custom-select" id="meal6" multiple="multiple">
                        
                        @foreach ($options as $option)
                        <option value="{{$option->options}}">{{$option->options}}</option>
                        @endforeach
                        <option value="Honey">Honey</option>

                      </select>



                      <button type="submit" class="btn btn-primary my-1">Submit</button>
                    </form>
  
         
            </div>
          </div>


 

            </div>
    


            <div class="col-sm-8">

                            <div class="card">
                              <div class="card-header">
                               <h5><b>Answers</b></h4> 
                              </div>
                              <div class="card-body">

                
                                  <table class="table table-bordered table-striped">
                                      <thead>
                                         <tr>
                                             <th><h5>Q. No</h5></th>
                                             <th><h5>Question</h5></th>
                                             {{-- <th>Answer</th> --}}
                                         </tr>
                                      </thead>
                                      <tbody>
                                        @php
                                            $i=0;
                                        @endphp
                                        @foreach($questions as $question)
                                        <tr>
                                             <td>{{$i+1}}</td>
                                             <td> <h5> <b>{{$question->question}}</b></h4><br>
                                              <h5>{!!$answer_array[$i]!!}</h5>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        
                                        @endforeach
                                      </tbody>
                                    </table>
                                    <div class="ml-5">
                                    <h5 class="mt-3"><b>
                                      Would you like honey as an option in your diet?</b></h5 class="mt-3">
                                        
                                      {{--<h5>{{$honey_option[0]->honey_option}}</h5>--}}                                
                                            @php
                                                 isset($honey_option[0]) ? $honey_option[0]->honey_option : "No";
                                            @endphp
                                    </div>
                                  </div>
                                </div>

                              </div>
                               
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


                                //Initialize Select2 Elements
                                $('.select2').select2()

                                //Initialize Select2 Elements
                                $('#meal1').select2({
                                  placeholder: "Select foods...",
                                  theme: 'bootstrap4'
                                })

                                $('#meal2').select2({
                                  placeholder: "Select foods...",
                                  theme: 'bootstrap4'
                                })

                                $('#meal3').select2({
                                  placeholder: "Select foods...",
                                  theme: 'bootstrap4'
                                })

                                $('#meal4').select2({
                                  placeholder: "Select foods...",
                                  theme: 'bootstrap4'
                                })

                                $('#meal5').select2({
                                  placeholder: "Select foods...",
                                  theme: 'bootstrap4'
                                })

                                $('#meal6').select2({
                                  placeholder: "Select foods...",
                                  theme: 'bootstrap4'
                                })


                      $("#document").change(function(){
                      var DocumentVal = $('#document').val();
                      if(DocumentVal=='Rejected'){
                          $('#modal-reject-document').modal('show');
                      }
                      });
                      });
                      </script>
                      
                      <script>
                      $(document).ready(function(){


                      $("#Others").click(function(){
                      $("#rejection-text").css('display', 'block');
                      });
  

                 

                          $('#quickForm').validate({


                              rules:{

                                plan_name:'required',
                             
                              },

                              messages:{

                                plan_name:"Please enter meal name",
                              
                              }
                     


                      });
                    });
                      
                      
                      </script>

                
            @endsection
      
      