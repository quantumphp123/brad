@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Workout</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Workout</li>
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
                <h3 class="card-title"><a href="{{url('add-workout')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add Workout</button></a></h3>
                <a href="{{url('add-exercise')}}" class="float-right m-2"> <button class="btn btn-primary">Add Exercise</button> </a>
                <a href="{{url('show-exercises')}}" class="float-right m-2"> <button class="btn btn-primary">Show Exercises</button> </a>
                <!--<h3 class="card-title"><a href="{{url('ExportProfessional')}}"><button style="margin-left:10px;" type="button" class="btn btn-block bg-gradient-success">Export</button></a></h3> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Show</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php 
                    $i = 1;
                    @endphp 
                    @foreach ($name as $item)
 
                       <tr>
                         <td>{{$i}}</td>
                         <td>{{$item->name}}</td>
                
                        
                        <td>
                          <a href="{{ url('user-workout',$item->id) }}">
                            <button type="button" class="btn btn-primary mr-3}}"> <i class="fa fa-eye"></i> </button>
                        </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger mr-3" data-toggle="modal" data-target="#deleteModal{{$item->id}}"> <i class="fa fa-trash"></i> </button>
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
                        <a href="{{url('delete-workout/'.$item->id)}}"><button type="button" class="btn btn-primary">Yes</button></a>
                      </div>
                    </div>
                  </div>
                </div>

                @php
                $i++;

                @endphp

          </tbody>
          @endforeach
		
                  <tfoot>
                    <tr>
                      <th>S.No</th>
                      <th>Name</th>
                      <th>Show</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body Close -->
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
