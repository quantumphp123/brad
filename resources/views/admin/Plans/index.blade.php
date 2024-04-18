@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Plans</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Plans</li>
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
                <h3 class="card-title"><a href="{{url('add-plans')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add Plan</button></a></h3>
                <!--<h3 class="card-title"><a href="{{url('ExportProfessional')}}"><button style="margin-left:10px;" type="button" class="btn btn-block bg-gradient-success">Export</button></a></h3> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Validity (In months)</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  @foreach($plans as $key => $orderDetails)
        <tr>
                    <td>{{$key + 1}}</td>
                    <td><img src="{{$orderDetails->image}}" style="height:50px;width:50px;"></td>
                    <td>{{$orderDetails->name}}</td>
                    <td>{{$orderDetails->price}} $</td>
                
                    <td>{{$orderDetails->validity}}</td>
              <td> 
              <button type="button" class="btn btn-primary editBtn" value="{{$orderDetails->id}}"data-target="#editModal"  data-toggle="modal" ><i class="fa fa-edit"></i></button>
						  <button type="button" class="btn btn-danger" data-target="#deleteModal{{$orderDetails->id}}"  data-toggle="modal" ><i class="fa fa-trash"></i></button>
            </td>
      </tr>

			


          {{-- Edit Modal --}}
       

           
          <div class="modal fade" id="editModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Update Plan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                 <form action="{{url('update_plan')}}" method="POST">
                  @csrf
                  @method('PUT')
                 <input type="hidden" name="plan_id" id="plan_id">
                    <div class="form-group">
                      <label for="name">Plan Name</label>
                      <input type="text" class="form-control" name="plan_name" id="name" placeholder="Enter name...">
                    </div>
                
                    <div class="form-group">
                      <label for="price">Price</label>
                      <input type="text" class="form-control" name="plan_price" id="price" placeholder="Enter price...">
                    </div>
                
                  
                    <button type="submit" class="btn btn-primary">Update</button>

                
                </form>
                </div>
              </div>
            </div>
          </div>



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
              <a href="{{url('delete_plan/'.$orderDetails->id)}}"><button type="button" class="btn btn-primary">Yes</button></a>
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
                    <th>Name</th>
                    <th>Price</th>
                    <th>Date Created</th>
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


  @section('script')
              
         
  <script>
    $(document).ready(function(){

      $('.editBtn').click(function(){
      var plan_id=$(this).val();
      $('#editModal').show();
      
     $.ajax({
      url:"edit_plan/"+plan_id,
      type:"GET",
      success:function(response){
         $('#plan_id').val(plan_id);
         $('#name').val(response.name);
         $('#price').val(response.price);
      }

      });

        })

      })
  </script>

@endsection
