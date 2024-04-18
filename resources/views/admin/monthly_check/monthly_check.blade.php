@extends('admin.layout.layout')

@section('content')

@section('style')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

<style>
  .fc-button{

    background-color: #db0808;
    color: black;
  }
  /* .fc-icon */
</style>


    
@endsection

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Monthly Checkins</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Monthly Checkins</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

    <div class="row m-1">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-body p-0">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
        


</div>
@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<script>
$(document).ready(function(){

  var data=@json($month_data);
  console.log(data);

  $('#calendar').fullCalendar({

    header:{
         left:'prev,next,today',
         center:'title',
        //  right:'month'

    },
    events:data,
    selectable:true,
    selectHelper:true,
    eventClick:function(event){
      window.location = '{{ url("show-user-monthly") }}/'+event.id;
    }
  
  });

})
</script>
    
@endsection

