@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Videos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Videos</li>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
		
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="{{url('add-videos')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add Video</button></a></h3>
                <!--<h3 class="card-title"><a href="{{url('ExportProfessional')}}"><button style="margin-left:10px;" type="button" class="btn btn-block bg-gradient-success">Export</button></a></h3> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($Videos as $key => $orderDetails)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td><img src="{{$orderDetails->image}}" style="height:50px;width:50px;"></td>
                    <td>{{$orderDetails->title}}</td>
                    <td>{{$orderDetails->description}}</td>
                    <td>{{$orderDetails->video_link}}</td>
					{{-- <td> 
						<div class="form-group">
							<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="status{{$orderDetails->id}}" @if($orderDetails->status=='1'){{'checked'}} @endif>
							<label class="custom-control-label" for="status{{$orderDetails->id}}"></label>
							</div>
						</div>
					</td> --}}

					<td>{{$orderDetails->created_at}}</td>
                  {{-- <input type="hidden" id="statusval{{$orderDetails->id}}" value="{{$orderDetails->status}}">
                  <input type="hidden" id="proff_id{{$orderDetails->id}}" value="{{$orderDetails->id}}">--}}
           
             

            <td>

             <a href="{{$orderDetails->video_link}}"><button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button></a> 

						{{-- <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#deleteModal{{$orderDetails->id}}>"><i class="fa fa-trash"></i></button> --}}
            <button type="button" class="btn btn-danger" data-target="#deleteModal{{$orderDetails->id}}"  data-toggle="modal" ><i class="fa fa-trash"></i></button>
  
          </td>
                  
          </tr>

			          {{-- Delete Modal --}}

                <div class="modal fade" id="deleteModal<?php echo $orderDetails->id; ?>">
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
                        <a href="{{url('delete-video/'.$orderDetails->id)}}"><button type="button" class="btn btn-primary">Yes</button></a>
                      </div>
                    </div>
                  </div>
                </div>
				  
				  @endforeach	
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Date</th>
                    <th>Action</th>
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