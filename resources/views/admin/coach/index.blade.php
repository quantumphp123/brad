@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
	
	
	
	 <section class="content">
      {{-- <div class="container-fluid">
        <div class="row">
          <div class="col-12"> --}}
		  
		
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="{{ route('add-coach') }}"><button type="button" class="btn btn-block bg-gradient-primary">Add Coach</button></a></h3>
             
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
               @foreach($coaches as $index => $coach)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/app/public/'.$coach->image) }}" alt="Coach Image" style="width: 100px; height: 100px;">
                            </td>
                            <td>{{ $coach->name }}</td>
                            <td>{{ $coach->description }}</td>
                             <td>
                                <a href="{{ route('coaches.edit', $coach->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('coaches.destroy', $coach->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this coach?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                  
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Name</th>
                    
                    <th>Description</th>
                   
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>
		
          {{-- </div>
        </div>
      </div> --}}
    </section>
   </div>

  @endsection


  