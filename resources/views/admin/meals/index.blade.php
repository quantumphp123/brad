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
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}" >Home</a></li>
              <li class="breadcrumb-item active">Meals</li>
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
          <div class="col-12">
		  
		
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="{{url('add-meals')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add Meal</button></a></h3>
                {{-- <h3 class="card-title"><a href="{{url('ExportProfessional')}}"><button style="margin-left:10px;" type="button" class="btn btn-block bg-gradient-success">Export</button></a></h3> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>User</th>
                    <th>Meal 1</th>
                    <th>Meal 2</th>
                    <th>Meal 3</th>
                    <th>Meal 4</th>
                    <th>Meal 5</th>
                    <th>Meal 6</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($data as $key => $item)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$item->name}} ({{$item->email}})</td>
                    <td>{{$item->meal_1}}</td>
                    <td>{{$item->meal_2}}</td>
                    <td>{{$item->meal_3}}</td>
                    <td>{{$item->meal_4}}</td>
                    <td>{{$item->meal_5}}</td>
                    <td>{{$item->meal_6}}</td>

                    <td>
                      <button type="button" class="btn btn-primary" data-target="#editModal{{$item->id}}"  data-toggle="modal" ><i class="fa fa-edit"></i></button>
                      <button type="button" class="btn btn-danger" data-target="#deleteModal{{$item->id}}"  data-toggle="modal" ><i class="fa fa-trash"></i></button>
                    </td>
                 </tr>
				  
		<div class="modal fade" id="deleteModal{{$item->id}}">
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
              <a href="{{url('delete-meal/'.$item->id)}}"><button type="button" class="btn btn-primary">Yes</button></a>
            </div>
          </div>
        </div>
      </div>	


      <div class="modal fade" id="editModal{{$item->id}}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update Meal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{url('post-update-meals')}}" role="form" method="post">
                @csrf
               <div class="card-body">
                <input type="hidden" value="{{$item->id}}" name="id">
             
                 <div class="form-group">
                   <label for="plan_name">Meal 1</label>
                   <input type="text" name="meal_1" value="{{$item->meal_1}}" class="form-control" id="plan_name" placeholder="Enter plan name...">
                 </div>
         
                 <div class="form-group">
                   <label for="plan_name">Meal 2</label>
                   <input type="text" name="meal_2" value="{{$item->meal_2}}" class="form-control" id="plan_name" placeholder="Enter plan name...">
                 </div>
         
                 <div class="form-group">
                   <label for="plan_name">Meal 3</label>
                   <input type="text" name="meal_3" value="{{$item->meal_3}}" class="form-control" id="plan_name" placeholder="Enter plan name...">
                 </div>
         
                 <div class="form-group">
                   <label for="plan_name">Meal 4</label>
                   <input type="text" name="meal_4" value="{{$item->meal_4}}" class="form-control" id="plan_name" placeholder="Enter plan name...">
                 </div>
         
                 <div class="form-group">
                   <label for="plan_name">Meal 5</label>
                   <input type="text" name="meal_5" value="{{$item->meal_5}}" class="form-control" id="plan_name" placeholder="Enter plan name...">
                 </div>
         
                 <div class="form-group">
                   <label for="plan_name">Meal 6</label>
                   <input type="text" name="meal_6" value="{{$item->meal_6}}" class="form-control" id="plan_name" placeholder="Enter plan name...">
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
                    <th>User</th>
                    <th>Meal 1</th>
                    <th>Meal 2</th>
                    <th>Meal 3</th>
                    <th>Meal 4</th>
                    <th>Meal 5</th>
                    <th>Meal 6</th>
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



  