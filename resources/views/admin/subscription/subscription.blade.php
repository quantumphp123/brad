@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Subscriptions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Subscriptions</li>
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
	<div class="alert alert-warning alert-dismissible">
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
              
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>User</th>
                    <th>Current Plan(Active)</th>
                    <th>History</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                  
                  @foreach($data as $key => $item)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$item->name}}</td>
                   
                    @if($item->plan_name==null)
                    <td>No Plan Chosen</td>

                    @else
                    <td class="text-success font-weight-bold">{{$item->plan_name}}</td>


                    @endif

                    @if($item->user_id==null)
                    <td>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i></button>                    
                    </td>

                    @else
                    <td>
                      <a href="{{url('show-history',$item->user_id)}}"> <button type="button" class="btn btn-primary" data-toggle="modal" ><i class="fa fa-eye"></i></button></a>
                     </td>
                    @endif
                 
                 </tr>
				  
                @php
                    $i++;
                @endphp
				  
				  @endforeach	
                  
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>S.No</th>
                        <th>User</th>
                        <th>Current Plan(Active)</th>
                        <th>History</th>
                      </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
			
			
			
			
			
			
			
			
            <!-- /.card -->
          </div>


         
          
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel">Information</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5>This user has not choosen any plan yet!</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
   </div>


           
             

  @endsection




 


  