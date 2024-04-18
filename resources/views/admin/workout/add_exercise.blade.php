@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Exercise</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Add Exercise</li>
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
       <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h5>{{ Session::get('failed') }}</h5>
                <?php Session::forget('failed');?>
       </div>
    </div>
    @endif


    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Exercise</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{url('post-add-exercise')}}" role="form" id="quickForm" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="user_name">Select User</label>
                      <select name="category" class="form-control" id="user">
                        <option selected disabled>...Select exercise category...</option>
                          @foreach($exercise_category as $category)
                          <option value="{{$category->id}}" >{{$category->category}}</option>
                          @endforeach
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label for="exercise">Exercise Name</label>
                        <input type="text" name="exercise" id="exercise" class="form-control"  placeholder="Exercise name...">
                      </div>
                   </div>
                  
          
                  <!-- /.card-footer -->
                  <div class="card-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Add</button>
                  </div>
                  
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

                $(document).ready(function(){

                  $('.select2').select2()


                //Initialize Select2 Elements
                  $('#user').select2({
                    theme: 'bootstrap4'
                  });


                });

                </script>

    @endsection


  