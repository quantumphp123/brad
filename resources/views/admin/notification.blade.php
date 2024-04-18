<!-- Content Wrapper. Contains page content -->
@extends('admin.layout.layout')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Notifications</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Notifications</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
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
      <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bullhorn"></i>
                    Notifications
                </h3>
            </div>
            <div class="card-body">
                @foreach ($data as $item)    
                <a href="{{ route('user-questions', ['user_id' => $item->user_id]) }}" class="">
                <div class="callout callout-info">
                    <h5>{{ $item->title }}</h5>
                    <p>{{ $item->description }}</p>
                    <span class=" text-sm text-muted">{{ \Carbon\Carbon::parse($item->time)->diffForhumans() }}</span>
                </div>
            </a>
                @endforeach
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection