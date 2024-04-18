@extends('admin.layout.layout')
@section('content')
@section('style')
     <style>

      .error{
        color: red;
        width: 100%;
      }
     </style>
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Workout</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Workout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
    	

	@if ($errors->any())
	<div class="card-body">
	<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	@foreach ($errors->all() as $error)
	<p>{{ $error }}</p>
	@endforeach

	</div>


	</div>

	@endif

  @if (session('success'))
	<div class="card-body">
	<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5>{{ Session::get('failed') }}</h5>
	<?php Session::forget('failed');?>
	</div>
    </div>
	@endif


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('post-add-workout')}}" role="form" id="quickForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="user_name">User Name</label>
                    <select name="user_id[]" class="form-control" id="user_name" multiple="multiple" required>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                        @endforeach
                      </select>
                      
                  </div>
				
				  <div class="form-group">
            <label for="category">Exercise Category</label>
            <select name="category" class="form-control" id="category">
              <option selected disabled>Select category...</option>
              @foreach ($category as $item)
                  
                <option value="{{$item->id}}">{{$item->category}}</option>
                @endforeach

            </select>
          </div>
				  
          <div class="form-group">
            <label for="exercise">Exercise</label>
            <select name="exercise" id="exercise" class="form-control">
            </select>
          </div>

				  <div class="form-group">
                    <label for="sets">Number of Sets</label>
                    <input type="text" name="sets" id="sets" class="form-control"  placeholder="Numbers of sets">
                  </div>

				  <div class="form-group">
                    <label for="reps">Number of Reps</label>
                    <input type="text" name="reps" id="reps" class="form-control"  placeholder="Number of pets">
                  </div>
		     </div>
	
                <!-- /.card-footer -->
                <div class="card-footer">
                  <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  @endsection


  @section('script')
      
  
  <script>
     $(function () {


      $('#category').on('change',function(){
        var id=$(this).val();

            if(id){
                $.ajax({
                    type:'GET',
                    url:'{{ url("get-exercises")}}/'+id,
                    success:function(res){
                        $("#exercise").empty();
                        $("#exercise").append('<option>Select Exercise...</option>');
                        $.each(res,function(key,value){
                            $("#exercise").append('<option value="'+value.exercise_name+'">'+value.exercise_name+'</option>');
                        });
                    }
                }); 
            }
      });


        $('#quickForm').validate({


         rules:{

          user_id:'required',
          category:'required',
          exercise:'required',
          sets:'required',
          reps:'required',
          
        },

        messages:{


          user_id:"Please select a user",
          category:"Please enter exercise category",
          exercise:"please enter exercise for above category",
          sets:"Please enter number of sets",
          reps:"Please enter number of reps"


        }


        });


    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('#user_name').select2({
      placeholder:'Select users...',
      theme: 'bootstrap4'
    })

    $('#category').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>

@endsection
  
  