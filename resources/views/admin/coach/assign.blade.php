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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Assign Coach</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Assign Coach</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<!--@if ($errors->any())-->
	<!--<div class="card-body">-->
	<!--<div class="alert alert-danger alert-dismissible">-->
	<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->

	<!--@foreach ($errors->all() as $error)-->
	<!--<p>{{ $error }}</p>-->
	<!--@endforeach-->

	<!--</div>-->

	<!--</div>-->

	<!--@endif-->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Assign Coach</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <form action="{{ route('users.update-coach', $user->id) }}" role="form" id="quickForm" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
                 

                <div class="card-body">
                    
                  <div class="form-group">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <label for="coach">Select Coach:</label>
                    <select name="coach_id" id="coach" class="form-control @error('coach_id') is-invalid @enderror">
                        <option value="">Select Coach</option>
                       @foreach($coaches as $coach)
                <option value="{{ $coach->id }}" {{ $user->coach_id == $coach->id ? 'selected' : '' }}>{{ $coach->name }}</option>
            @endforeach
        </select>
                        
        </select>
          @error('coach_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                  
                 
      
				  
                <!-- </div> -->
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection

  @section('script')


  @endsection