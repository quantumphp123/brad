<div class="wrapper">



  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->

    <ul class="navbar-nav">

      <li class="nav-item">

        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

      </li>

     

    </ul>
<!-- 


   

    <ul class="navbar-nav ml-auto">

      Messages Dropdown Menu

      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">

          <i class="far fa-comments"></i>

          <span class="badge badge-danger navbar-badge">3</span>

        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <a href="#" class="dropdown-item">

           Message Start 

            <div class="media">

              <img src="{{url('assets/adminlte')}}/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">

              <div class="media-body">

                <h3 class="dropdown-item-title">

                  Brad Diesel

                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>

                </h3>

                <p class="text-sm">Call me whenever you can...</p>

                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>

              </div>

            </div>

            Message End

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">

          Message Start 

            <div class="media">

              <img src="{{url('assets/adminlte/dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">

              <div class="media-body">

                <h3 class="dropdown-item-title">

                  John Pierce

                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>

                </h3>

                <p class="text-sm">I got your message bro</p>

                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>

              </div>

            </div>

             Message End 

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">

            Message Start 

            <div class="media">

              <img src="{{url('assets/adminlte/dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">

              <div class="media-body">

                <h3 class="dropdown-item-title">

                  Nora Silvester

                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>

                </h3>

                <p class="text-sm">The subject goes here</p>

                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>

              </div>

            </div>

          Message End

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>

        </div>

      </li>

      Notifications Dropdown Menu 

      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">

          <i class="far fa-bell"></i>

          <span class="badge badge-warning navbar-badge">15</span>

        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <span class="dropdown-item dropdown-header">15 Notifications</span>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">

            <i class="fas fa-envelope mr-2"></i> 4 new messages

            <span class="float-right text-muted text-sm">3 mins</span>

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">

            <i class="fas fa-users mr-2"></i> 8 friend requests

            <span class="float-right text-muted text-sm">12 hours</span>

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">

            <i class="fas fa-file mr-2"></i> 3 new reports

            <span class="float-right text-muted text-sm">2 days</span>

          </a>

          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>

        </div>

      </li>

      <li class="nav-item">

        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">

          <i class="fas fa-th-large"></i>

        </a>

      </li>

    </ul> -->

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