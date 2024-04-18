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
                <h3 class="card-title"><a href="{{url('add-professional')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add User</button></a></h3>
                {{-- <h3 class="card-title"><a href="{{url('ExportProfessional')}}"><button style="margin-left:10px;" type="button" class="btn btn-block bg-gradient-success">Export</button></a></h3> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Payment Status</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Chat</th>
                    <th>Assign</th>
                    <th>Registered Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($data as $key => $item)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->contact}}</td>
					          <td>
                               @if($item->payment_status==0)
                                <h5>No</h5>
                                @else
                                <h5>Yes</h5>
                               @endif
                    
                    </td>
                    <td>{{$item->gender}}</td>
                    <td>
                      @if($item->isActive==1)
                      <h5 class="bg-green p-1 rounded">Active</h5>
                      @else
                      <h5 class="bg-danger p-1 rounded" >InActive</h5>
                      @endif
                    </td>
                    <td>   <a href="{{url('chat')}}/{{$item->id}}"><button class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></a></td>
                     <td>
                      <a href="{{ url('assign-coach/'.$item->id) }}"><button class="btn btn-primary"><i class="fa fa-tasks"></i></button></a>
                </td>
                    <td>{{$item->created_at}}</td>
                    <td>
                      <a href="{{url('view-professional',$item->id)}}"><button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                      <button type="button" class="btn btn-danger" data-target="#modal-delete{{$item->id}}" data-toggle="modal" ><i class="fa fa-trash"></i></button>
                    </td>
                 </tr>
				  
			<div class="modal fade" id="modal-delete{{$item->id}}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Alert</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are You Sure You Want To Delete This Item ?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
              <a href="{{url('delete-professional/'.$item->id)}}"><button type="button" class="btn btn-primary">Yes</button></a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
				  
				  @endforeach	
                  
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Payment Status</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Chat</th>
                     <th>Assign</th>
                    <th>Registered Date</th>
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


  