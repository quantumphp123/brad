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
          <h1>User Weekly Checkins</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">User Weekly Checkins</li>
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
            <div class="card-header text-center">
                @foreach($data as $item)
                      <h5> <b>{{$item->name}}</b> ({{$item->email}}) </h5>
                      @break
                @endforeach
            </div>



            <div class="card-body">


              <div id="accordion">
                @php
                    $i=1;
                @endphp
                @foreach($data as $item)
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapse-show" data-toggle="collapse" data-target=".collapseOne{{$i}}" aria-expanded="true" aria-controls="collapseOne">
                       @if ($i==1)
                       <h4>Latest ({{\Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }})</h4>

                            
                        @else
                        <h4>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans() }} ({{\Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }})</h4>

                            
                        @endif

                      </button>
                    </h5>
                  </div>

     

                <div class="collapseOne{{$i}} collapse"  aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">

                    {{-- <div class="row">
                      <div class="col-sm-6 text-center mt-5">Front Shot <img src="{{$item->front_shot}}" style="height:60%;width: 60%"></div>
                      <div class="col-sm-6 text-center mt-5">Back Shot<img src="{{$item->back_shot}}" style="height:60%;width: 60%"></div>
                    </div> --}}

                    <table class="table table-bordered table-striped">
                               <thead>
                                   <tr>
                                      <td class="text-center">Front Shot</td>
                                      <td class="text-center">Back Shot</td>
                                      <td>Comment</td>
                                      <td>Question</td>
                                      <td>Chat</td>
                                   </tr>
                               </thead>
                               <tbody>
                                  <tr>
                                    <td class="text-center"><img src="{{$item->front_shot}}" style="height:40%;width: 40%"></td>
                                    <td class="text-center"><img src="{{$item->back_shot}}" style="height:40%;width: 40%"></td>
                                    <td>{{$item->comments}}</td>
                                    <td>{{$item->question}}</td>
                                    <td><a href="{{url('chat')}}/{{$item->user_id}}"><button class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></a></td>
                                  </tr>
                               </tbody>
                    </table>
                  </div>
                </div>



                </div>
                  @php
                      $i++;
                  @endphp
                @endforeach
              
              
              </div>

            </div>
   

          </div>
          

      </div>

      </div>
    </div>
  </section>
        


</div>
@endsection

