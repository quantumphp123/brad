@extends('admin.layout.layout')

@section('style')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

.direct-chat-primary{
    height: 800%;
    
}

</style>


    
@endsection

@section('content')


  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Chat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Direct Chat</li>
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
	

  @if ($errors->any())
	<div class="card-body">
	<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	@foreach ($errors->all() as $error)
	<p>{{ $error }}</p>
	@endforeach

	</div>


	</div>

	@endif
	
	 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">





                <div class="card-header" >
                  @if(count($chat)>=2)

                  <h2 class="card-title"> Chatting with <b>{{$name[0]->name}}</b></h2>
 
                  @else

                  <h2 class="card-title"> Chatting with <b>{{$chat[0]->name}}</b></h2>

                 @endif
                </div>
                
                <div class="card-body h-200">
                
                <div class="direct-chat-messages" style="height:380px;">

                  @if(count($chat)>=2)

 
                @foreach($chat as $item)
                    

                                
                <div class="direct-chat-msg right">

                  @if ($item->from_user=='admin')

                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right">You</span>
                    <img class="direct-chat-img" src="{{url('https://image.cnbcfm.com/api/v1/image/104891709-Bill_Gates_the_co-Founder.jpg?v=1558120888&w=1400&h=950')}}" alt="message user image">
                  </div>

                    @else

                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">{{$item->name}}</span>
                      <img class="direct-chat-img" src="{{$item->frontshot}}" alt="">
                    </div>

                        
                    @endif
                
                  @if($item->type=='text')
                  @if($item->from_user=='admin')
                  <div class="direct-chat-text bg-info">
                 <p>{{$item->description}}</p>
                  </div>

                  @else

                  <div class="direct-chat-text">
                    <p>{{$item->description}}</p>
                     </div>

                  @endif

                  @else

                  @if($item->from_user=='admin')
                  <div class="direct-chat-text bg-info">
                 <img src="{{$item->description}}" style="height:50x;width:50x;" class="img-fluid">
                  </div>

                  @else

                  <div class="direct-chat-text">
                    <img src="{{$item->description}}" class="img-fluid">
                  </div>

                  @endif

                  @endif
                  
                  </div>

                    

                @endforeach

                @else


                   <div class="text-center">Chat Here...</div>
                                 
    

               @endif



                </div>
                
            
                
                </div>


                <div class="card-footer">
                  <form action="{{url('post-chat')}}/{{$user_id}}" method="post">
                    @csrf
                  <div class="input-group">
                  <input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control">
                  <span class="input-group-append">
                  <button type="submit" class="btn btn-primary">Send</button>
                  </span>
                  </div>
                  </form>
                  </div>

                
		  
		
   
			
			
			
			
			
			
          </div>
        </div>
      </div>
    </section>
	

	
  
  
   </div>
  @endsection
  
  @section('script')

      <script>
           $(document).ready(function(){

            $(button).click(function(e){
                 e.preventDeafult();
           var msg= $('#message').val();
            })

            if(msg==''){
              alert('Please enter a message...')
            }

           });
      </script>
      
  @endsection


  @section('script')

     <script>
         $(document).ready(function(){
                $('.card-body').stop ().animate ({
                scrollTop: $('.card-body')[0].scrollHeight
                });
         });
     </script>
      
  @endsection


  {{-- @section('script')

            <script>

                $(document).ready(function(){


                  $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });


                  $('').on('click',function(){

                    var msg=$('#message').val();
                    var id=$('#user_id').val();

                    if(msg==''){
                      alert('Please enter a message');
                    }

                    else{

                      $.ajax({
                        url:'{{"post-chat"}}/'+id,
                        type:"POST",
                        data:{
                          msg
                        },
                        success:function(response){
                          var message=response[0].description;

                          function autoRefresh_div() {



                            }


                            setInterval(autoRefresh_div, 5000); // every 5 seconds
                            autoRefresh_div(); // on load

                          }

                        });

                      }
                    });
 
        
                });

            </script>
      
  @endsection
 --}}



