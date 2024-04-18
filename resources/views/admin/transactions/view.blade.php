@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Transactions</h1>
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
	
	
	
	
	 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
		
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                  <p>Payment</p>
                <div class="d-flex align-items-center">
                    <h3>${{ $data[0]->charge }}</h3>
                    &nbsp;&nbsp;
                    <?php 
                    if($data[0]->status != 'succeeded') { ?>
                        <span class="badge-secondary badge">{{ $data[0]->status }}</span>
                   <?php } else {?>
                        <span class="badge-success badge">{{ $data[0]->status }}</span>
                    <?php } ?>
                </div>
            </div>
              <div class="card-body">
                
                <div class="row">
                    <div class="col-md-2">
                        <b>Last Updated : </b> &nbsp;@php if($data[0]->updated_at == NULL) { echo $data[0]->created_at; } else {  echo $data[0]->updated_at; }  @endphp
                    </div>
                    <div class="col-md-2">
                        <b>Customer : </b> &nbsp;{{ $data[0]->userName }}
                    </div>
                    <div class="col-md-6">
                        <b>Card Used : </b> &nbsp;****-****-****-{{ isset($data[0]->lastFourDigits) ? $data[0]->lastFourDigits : '' }} <span class="badge badge-secondary">{{ isset($data[0]->brand)? $data[0]->brand : '' }}</span>
                    </div>
                </div>

                <hr>

                <b>Timeline</b>
                <div class="row mt-4">
                    <div class="col-md-12">
                      <!-- The time line -->
                      <div class="timeline">

                        <div>
                          <i class="fas fa-user bg-green"></i>
                          {{-- <i class="fa-sharp fa-solid fa-badge-check"></i> --}}
                          <i class="fa-sharp fa-solid fa-shield-check"></i>
                          <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ $data[0]->updated_at }}</span>
                            <h3 class="timeline-header no-border">Payment {{ $data[0]->status }}</h3>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <div>
                          <i class="fas fa-clock bg-gray"></i>
                          <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ $data[0]->created_at }}</span>
                            <h3 class="timeline-header no-border">Payment Initiated with {{ $data[0]->brand." ****  ".$data[0]->lastFourDigits }}</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->
                  </div>

                <hr>
                
                <div style="margin-top: 25px;">
                    <b>Payment Details</b>
                            <table class="col-md-6">
                                <tr>
                                    <td>Transaction Id:</td>
                                    <td>{{ $data[0]->transactionId }}</td>
                                </tr>
                                <tr>
                                    <td>Amount:</td>
                                    <td>$ {{ $data[0]->charge }}</td>
                                </tr>
                                <tr>
                                    <td>Processing Fees:</td>
                                    <td>2% Platform Charge</td>
                                </tr>
                                <tr>
                                    <td>Total Amount:</td>
                                    <td>$ {{ $data[0]->overallAmount }}</td>
                                </tr>
                                <tr>
                                    <td>Description:</td>
                                    <td>{{ $data[0]->description }}</td>
                                </tr>
                                <tr>
                                    <td>Plan:</td>
                                    <td>{{ $data[0]->planName }}</td>
                                </tr>
                                <tr>
                                    <td>Purchased By:</td>
                                    <td>{{ $data[0]->userName }}</td>
                                </tr>
                            </table>
                <div>

                    <hr>
                    


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



  