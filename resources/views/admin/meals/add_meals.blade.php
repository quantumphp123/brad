@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Meals</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Meals</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Meals</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{url('user-questions')}}" role="form" id="quickForm" method="get" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="user_name">Select User</label>
                      <select name="user_id" class="form-control" id="user">
                        <option selected disabled>...Select a User...</option>
                          @foreach($users as $user)
                          <option value="{{$user->id}}" >{{$user->name}} ({{$user->email}})</option>
                          @endforeach
                        </select>
                        
                    </div>
                  
          
                  <!-- /.card-footer -->
                  <div class="card-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
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


  