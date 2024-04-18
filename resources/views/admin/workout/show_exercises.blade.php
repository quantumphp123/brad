@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Exercises</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Exercises</li>
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

            <div class="card">
              <div class="card-header">
                <h4>Exercises</h4>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Exercise</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($exercises as $key => $item)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$item->exercise_name}}</td>
                    <td>{{$item->category}}</td>
                    <td>
                      <button type="button" class="btn btn-primary" data-target="#editModal{{$item->id}}" data-toggle="modal" ><i class="fa fa-edit"></i></button>
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
              <a href="{{url('delete-added-exercise/'.$item->id)}}"><button type="button" class="btn btn-primary">Yes</button></a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



      
      <div class="modal fade" id="editModal{{$item->id}}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update Exercise</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{url('post-update-exercise')}}" role="form" method="post">
                @csrf
               <div class="card-body">
                <input type="hidden" value="{{$item->id}}" name="id">
             
                 <div class="form-group">
                   <label for="plan_name">Exercise</label>
                   <input type="text" name="exercise" value="{{$item->exercise_name}}" class="form-control" id="plan_name" placeholder="Enter plan name...">
                 </div>
         

         


                <button type="submit" id="submit" class="btn btn-primary mt-3">Update</button>

               </div>
             </form>
             
             
            </div>
          </div>
        </div>
      </div>



				  
				  @endforeach	
                  
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>S.No</th>
                      <th>Exercise</th>
                      <th>Category</th>
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


  