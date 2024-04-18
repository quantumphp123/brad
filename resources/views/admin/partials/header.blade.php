<div class="wrapper">



  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->

    <ul class="navbar-nav">

      <li class="nav-item">

        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

      </li>

     

    </ul>

    @php
    $adminNotification      = DB::table('admin_notifications')->limit(10)->get();
    $adminNotificationCount = count($adminNotification); 
    @endphp
    
    
   @php
   $chatNotification = DB::table('chats')
    ->select('from_user', 'description')
    ->where('from_user', '!=', 'admin') // Exclude messages from the admin user
    ->orderByDesc('created_at') // Order by created_at field in descending order
    ->limit(10)
    ->get();



$chatNotificationCount = count($chatNotification); 
@endphp
  <!-- /.login-logo -->
  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Display error message -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
       <li class="nav-item dropdown">
   <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    @if ($adminNotificationCount > 0)
        @php
            $firstNotification = $adminNotification->first();
            $showBadge = !$firstNotification->seen; // Show badge only if first notification is unseen
            $badgeClass = $firstNotification->seen ? 'badge-secondary' : 'badge-warning';
        @endphp
        @if ($showBadge)
            <span class="badge badge-pill {{$badgeClass}} navbar-badge">{{$adminNotificationCount}}</span>
        @endif
    @endif
</a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
             <form id="markAllAsReadForm" action="{{ route('mark-all-notifications') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button id="markAllAsReadButton" class="dropdown-item dropdown-header">Marks All as Read</button>
         
          <ul class="list-group c-scrollbar-light overflow-auto" style="max-height:300px;">
            @foreach ($adminNotification as $item)    
            <li class="list-group-item d-flex justify-content-between align-items-start hov-bg-soft-primary ">
              <a href="{{ route('user-questions', ['user_id' => $item->user_id]) }}" class="media text-inherit">
                  <div class="media-body">
                      <p class="mb-1">{{ $item->title }}</p>
                      <small class="text-muted">{{ $item->description }}</small>
                      <span class="float-right text-muted text-sm">
                        {{ \Carbon\Carbon::parse($item->time)->diffForhumans() }}
                      </span>
                  </div>
              </a>
              {{-- <span class="badge badge-md badge-dot"></span> --}}
              <span class="badge bg-primary badge-dot"> </span>
            </li>
            @endforeach 
          </ul>
          <div class="dropdown-divider"></div>
          <a href="{{ url('notifications') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comment"></i>
        <span class="badge badge-warning navbar-badge">{{$chatNotificationCount}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
        <span class="dropdown-item dropdown-header">{{$chatNotificationCount}} Chats</span>
        <table class="table table-hover mb-0">
            <tbody>
               @foreach ($chatNotification as $item)
    <tr>
        <td>
            <a href="{{ url('chat') }}/{{ $item->from_user }}">
                <div class="media-body">
                    <small class="text-muted">{{ $item->description }}</small>
                    @if(isset($item->time))
                        <span class="float-right text-muted text-sm">
                            {{ \Carbon\Carbon::parse($item->time)->diffForHumans() }}
                        </span>
                    @endif
                </div>
            </a>
        </td>
        <td>
            <span class="badge bg-primary badge-dot"></span>
        </td>
    </tr>
@endforeach

               
                  
            </tbody>
        </table>
        <div class="dropdown-divider"></div>
        <!--<a href="{{ url('chats') }}" class="dropdown-item dropdown-footer">See All Chats</a>-->
    </div>
</li>



      
       {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{$adminNotificationCount}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{$adminNotificationCount}} Notifications</span>
          @foreach ($adminNotification as $item)
            <div class="dropdown-divider"></div>
            <a href="{{ route('user-questions', ['user_id' => $item->user_id]) }}" class="dropdown-item">
              {{ $item->description }}
              <span class="float-left text-muted text-sm">
                {{ \Carbon\Carbon::parse($item->time)->diffForhumans() }}
              </span>
            </a>
          @endforeach 
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> --}}
    </ul>

  </nav>

  <!-- /.navbar -->



  <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="{{url('admin-dashboard')}}" class="brand-link">

      <img src="{{url('assets/zoltz_logo.png')}}" class="img-circle" alt="AdminLTE Logo"

           style="opacity:.8;height:60px;width:100%;border-radius:200px;">

           {{-- <span style="color:black">Heokjiok</span> --}}

    </a>



    <!-- Sidebar -->

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        

        <div class="info">

          <h4><a href="#" class="d-block">Welcome Brad</a></h4>

        </div>

      </div>



      <!-- Sidebar Menu -->

      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

         

			<li class="nav-item">

			  <a href="{{url('admin-dashboard')}}" class="nav-link">

			   <p>Dashboard</p>

			  </a>

			</li>

			

			

			<li class="nav-item">

			  <a href="{{url('professional')}}" class="nav-link">

			   <p>Users</p>

			  </a>

			</li>
			
			
				<li class="nav-item">

			  <a href="{{url('view-coach')}}" class="nav-link">

			   <p>Coach</p>

			  </a>

			</li>


      <li class="nav-item">

      <a href="{{url('workout')}}" class="nav-link">

      <p>Workout</p>

      </a>

      </li>

			

			<li class="nav-item">

			  <a href="{{url('videos')}}" class="nav-link">

			   <p>Videos</p>

			  </a>

			</li> 
      

      <li class="nav-item">

        <a href="{{url('plans')}}" class="nav-link">

         <p>Plans</p>
        </a>
      </li>

      <li class="nav-item">

        <a href="{{url('subscription')}}" class="nav-link">

         <p>Subscriptions</p>
        </a>
      </li>

        <li class="nav-item">

      <a href="{{url('meals')}}" class="nav-link">

      <p>Meals</p>
      </a>
      </li>

                <li class="nav-item">

        <a href="{{url('weekly_check')}}" class="nav-link">

         <p>Weekly Checkins</p>
        </a>
      </li>

      <li class="nav-item">

        <a href="{{url('monthly_check')}}" class="nav-link">

         <p>Monthly Checkins</p>
        </a>
      </li>


         <li class="nav-item">

        <a href="{{url('request-for-meal')}}" class="nav-link">

        <p>Meal Request</p>
        </a>
        </li>
        
         <li class="nav-item">
            <a href="{{url('transactions')}}" class="nav-link">
                <p>Transactions</p>
            </a>
        </li>
         <li class="nav-item">
            <a href="{{ url('notifications') }}" class="nav-link">
                <p>Notifications</p>
            </a>
        </li>

			

			<li class="nav-item">

			  <a href="{{url('logout')}}" class="nav-link">

			   <p>Log Out</p>

			  </a>

			</li>

         

          

         

        </ul>

      </nav>

      <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

  </aside>
<script>
    document.getElementById("markAllAsReadButton").addEventListener("click", function() {
        document.getElementById("markAllAsReadForm").submit();
    });
</script>
