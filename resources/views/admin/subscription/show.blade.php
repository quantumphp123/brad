




@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Subscription</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">User Subscription</li>
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

                   <h3> {{$name[0]->name}}</h3>
                </div>
                
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Plans</th>
                      <th>Subscription Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($data as $key => $item)
                    <tr>
                      <td>{{$key + 1}}</td>
                      @if($item->isActive==1)
                      <td>{{$item->plan_name}} <mark class="bg-success rounded">(Active)</mark></td>
                     @else
                     <td>{{$item->plan_name}} <mark class="bg-danger rounded">(InActive)</mark></td>
                      @endif
                      <td>{{$item->created_at}}</td>
                   </tr>
                    
      
                    
                    @endforeach	
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>S.No</th>
                            <th>Plans</th>
                            <th>Subscription Date</th>
                          </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              
              
              
              
              
              
              
              
              <!-- /.card -->
            </div>
            
		  
		
          
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
   </div>


  @endsection



