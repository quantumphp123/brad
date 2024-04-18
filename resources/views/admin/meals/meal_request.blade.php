@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Meal Request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Meal Request</li>
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
	
	
	
	 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
		
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Requested By</th>
                    <th>Email</th>
                    <th>Requested On</th>
                    <th>Assign Meal</th>
                    <th>Chat</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($data as $key => $item)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->requested_on}}</td>
                    <td>
                      <form action="{{url('user-questions')}}" method="GET">
                        @csrf 
                        <input type="hidden" name="user_id" value="{{$item->id}}">
                        <button type="submit" class="btn btn-success">Assign</button>

                      </form>
                    </td>
                    <td>
                      <a href="{{url('chat')}}/{{$item->id}}"><button class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></a>
                    </td>

          </tr>
				  
				  @endforeach	
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>S.No</th>
                    <th>Requested By</th>
                    <th>Email</th>
                    <th>Requested On</th>
                    <th>Assign Meal</th>
                    <th>Chat</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
			
			
			
			
			
			
			
			
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
	
	
  
  
   </div>
  @endsection