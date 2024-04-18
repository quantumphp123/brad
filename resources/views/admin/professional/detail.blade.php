@extends('admin.layout.layout')
@section('content')




<div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
            
              User Detail
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">User Details</li>
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              {{$user[0]->name.' ('.($user[0]->id).')'}}
              
            </h3>
          </div>
          <div class="card-body">
            <h4></h4>
            <div class="row">
              <div class="col-5 col-sm-3" style="background:#f2f2f2;">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link side-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Profile</a>
					
					
					<a class="nav-link side-link" id="vert-tabs-health-tab" data-toggle="pill" href="#vert-tabs-health" role="tab" aria-controls="vert-tabs-health" aria-selected="false">Images</a>
					
				</div>
              </div>
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                  
				  <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">

<section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default " >
          <div class="card-header headertop">
            <h3 class="card-title">Profile</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <p><label>Profile Picture </label></p>
                  <img src="{{$user[0]->current_shot}}" style="height:90px;width:90px;border-radius:10px;">                </div>
              </div>
              
			
              <div class="col-md-4">
                <div class="form-group">
                  <p><label>Name </label></p>
                  <p>{{$user[0]->name}}</p>
                </div>
              </div>
			 
			  <div class="col-md-4">
                <div class="form-group">
                  <p><label>Email</label></p>
                  <p><?php echo $user[0]->email; ?></p>
                </div>
              </div>
			  
			  <div class="col-md-4">
                <div class="form-group">
                  <p><label>Password</label></p>
                  <p><?php echo $user[0]->password; ?></p>
                </div>
              </div>
			  
			  
			 <div class="col-md-4">
                <div class="form-group">
                  <p><label>Plan Name</label></p>
                  <p> @if($plan==null)
                    <mark style="background-color:yellow;width:60%;"> No Plan Chosen </mark>
                    @else
                    {{$plan[0]->name}}
                    @endif</p>
                </div>
              </div>


              <div class="col-md-4">
                <div class="form-group">
                  <p><label>DOB</label></p>
                  <p><?php echo $user[0]->dob; ?></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <p><label>Height</label></p>
                  <p><?php echo $user[0]->height; ?></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <p><label>Weight</label></p>
                  <p><?php echo $user[0]->weight; ?>Kg</p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <p><label>Body Type</label></p>
                  <p><?php echo $user[0]->body_type; ?></p>
                </div>
              </div>
			
		
			  
			 
			  
			  
			 
            </div>
           
          </div>
          <!-- /.card-body -->
         
		 
		  
		  
		  
		 <!-- <div class="card-header headertop">
            <h3 class="card-title">Address</h3>
				<div class="card-tools">
					<a href="javascript:void()" data-toggle="modal" data-target="#diagnostics-address" ><i class="fa fa-edit"></i></a>
				</div>
          </div>
		  
		  <div class="card-body">
            <div class="row">
             
			  <div class="col-md-4">
                <div class="form-group">
                  <p><label>Building Name & Number</label></p>
                  <p>Rishab tower, F-16</p>
                </div>
              </div>
			  
			   <div class="col-md-4">
                <div class="form-group">
                  <p><label>Location / Area</label></p>
                  <p>Adarsh Park, Gomti Nagar</p>
                </div>
              </div>
			  
			   <div class="col-md-4">
                <div class="form-group">
                  <p><label>City</label></p>
                  <p>Lucknow</p>
                </div>
              </div>
			  
			  <div class="col-md-4">
                <div class="form-group">
                  <p><label>State</label></p>
                  <p>Uttar Pradesh</p>
                </div>
              </div>
			  
			  <div class="col-md-4">
                <div class="form-group">
                  <p><label>Pincode</label></p>
                  <p>226556</p>
                </div>
              </div>
			  
            </div>
          </div>
		  
		  
		  
		  <div class="card-header headertop">
            <h3 class="card-title">About us</h3>
			
			<div class="card-tools">
					  <a href="javascript:void()" data-toggle="modal" data-target="#about" ><i class="fa fa-edit"></i></a>
					</div>
          </div>
		  
		  <div class="card-body">
            <div class="row">
			  <div class="col-md-12">
                <div class="form-group">
                  <p style="text-align:justify;">As you notice in the figure above, while the general trend for growth in the market looks healthy, the two main regions contributing to market growth by 2015 are the United States and the RoW (Rest of the World). The RoW market will expand by an estimated 8% from 2011 to 2015 and hence will be the major focus area for most medical diagnostics companies. In order to aid this growth, quite a few of the companies have setup global research, development and manufacturing centres within the emerging market economies and India and China host most of these centres</p>
                </div>
              </div>
            </div>
          </div>-->
		 
		 
		  
        </div>
       
        <!-- /.row -->
      </div>
	  
    </section>
	
	
		  </div>
		  
	  
			  
			 
		  
			
			
			 
			  
			  <div class="tab-pane fade" id="vert-tabs-health" role="tabpanel" aria-labelledby="vert-tabs-health-tab">
			   
			   
	  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
            <div class="card">
			
			<div class="card-header">
             
		    </div>
             
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Front Shot</th>
                    <th>Back Shot</th>
                  </tr>
                  </thead>
                  <tbody>
                  
					<tr>
						

				<td class="text-center"><img src="{{$user[0]->frontshot}}" style="height:100px;width:100px;border-radius:10px;"></td>
				
        
        <td class="text-center"><img src="{{$user[0]->backshot}}" style="height:100px;width:100px;border-radius:10px;"></td>

      
      
						
					
						
					</tr>

	
					

					
					
                  </tbody>
                  <tfoot>
                   
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
			
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
			  </div>
			  

			  
			  
			  
			 
			
			
			</div>
		  </div>
		</div>
			
			
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
		
		
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
			 
					<script>
					$(document).ready(function(){
					$("#document").change(function(){
					var DocumentVal = $('#document').val();
					if(DocumentVal=='Rejected'){
						$('#modal-reject-document').modal('show');
					}
					});
					});
					</script>
					
					<script>
					$(document).ready(function(){
					$("#Others").click(function(){
					$("#rejection-text").css('display', 'block');
					});

					});
					
					
					</script>
	
	

  @endsection