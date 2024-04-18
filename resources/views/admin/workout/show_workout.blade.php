@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> User Workout</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Workout</li>
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
                  <a href="{{url('workout')}}"><button class="btn btn-primary float-right">Back</button></a>
                @foreach($user as $item)
                <h4>User Name:  <b>{{$item->name}}</b></h4>
                @break
              @endforeach
              </div>

           

              <div class="card-body">
              
               <table id="example1" class="table table-bordered table-striped">

                <thead>
                  <tr>
                       <th>Sr.No.</th>
                       <th>Category</th>
                       <th>Exercise</th>
                       <th>Sets</th>
                       <th>Reps</th>
                       <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @for($i=0;$i<count($category);$i++)
                  <tr>
                   
                    <td>{{$i+1}}</td>
                    <td>{{$category[$i]}}</td>

                    <td>{{$exercise[$i]}}</td>

                    <td>{{$sets[$i]->sets}}</td>
                    <td>{{$reps[$i]->reps}}</td>

                      <td>

                        <button type="button" class="btn btn-danger" data-target="#deleteModal{{$exercise_id[$i]}}"  data-toggle="modal" ><i class="fa fa-trash"></i></button>
   
                      </td>
                      
                  </tr>

                     {{-- Delete Modal --}}

                <div class="modal fade" id="deleteModal{{$exercise_id[$i]}}">
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
                        <a href="{{url('delete-exercise/'.$exercise_id[$i])}}"><button type="button" class="btn btn-primary">Yes</button></a>
                      </div>
                    </div>
                  </div>
                </div>


                  @endfor
                </tbody>


               </table>
              </div>

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
