@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transactions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}" >Home</a></li>
              <li class="breadcrumb-item active">Transactions</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	
	@if (session('message'))
    <div class="card-body">
       <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h5>{{ Session::get('message') }}</h5>
                <?php Session::forget('message');?>
       </div>
    </div>
    @endif
	
	 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
		
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Txn Id</th>
                    <th>User Name</th>
                    <th>Plan Name</th>
                    <th>Status</th>
                    <th>Payment Initiated at</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  
                  <tbody>
                    <?php  $i=1 ?>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $item->transactionId }}</td>
                            <td>
                                @php
                                    if(isset($item->userName)) {
                                        echo $item->userName;
                                    } else {
                                        echo "Deleted User";
                                    }
                                @endphp
                            </td>

                            <td>{{ $item->planName }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a href="{{ route('transaction-details', ['txnId' => $item->transactionId]) }}">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                </a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                    @endforeach
                  </tbody>

                  <tfoot>
                    <tr>
                        <th>S.No</th>
                        <th>Txn Id</th>
                        <th>User Name</th>
                        <th>Plan Name</th>
                        <th>Status</th>
                        <th>Payment Initiated at</th>
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



  