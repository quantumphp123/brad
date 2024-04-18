@extends('admin.layout.layout')
@section('content')

@section('style')
<style>
  .error{
    color:red;
  }
</style>
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Coach</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Edit Coach</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<!--@if ($errors->any())-->
	<!--<div class="card-body">-->
	<!--<div class="alert alert-danger alert-dismissible">-->
	<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->

	<!--@foreach ($errors->all() as $error)-->
	<!--<p>{{ $error }}</p>-->
	<!--@endforeach-->

	<!--</div>-->

	<!--</div>-->

	<!--@endif-->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('coaches.update', $coach->id) }}" role="form" id="quickForm" method="post" enctype="multipart/form-data">
                @csrf
                 @method('PUT')
                 

               <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $coach->name) }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description', $coach->description) }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                       <div class="form-group">
    <label for="image">{{ __('Image') }}</label>
    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
    <div id="imagePreview" style="width: 50px; height: 50px;">
        @if ($coach->image)
            <img src="{{ asset('storage/app/public/' . $coach->image) }}" alt="Coach Image" style="width: 300px; height: 150px;">
        @endif
    </div>

    @error('image')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<br><br><br><br>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('coach.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                     </div>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection

  @section('script')

  <script>
    // JavaScript to handle file input change event
    document.getElementById('image').addEventListener('change', function(event) {
        var preview = document.getElementById('imagePreview');
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function() {
            // Create an image element and set its src to the data URL obtained from FileReader
            var img = document.createElement('img');
            img.src = reader.result;
            
            // Clear the previous preview
            while (preview.firstChild) {
                preview.removeChild(preview.firstChild);
            }
            
            // Append the image to the preview container
            preview.appendChild(img);
        };

        if (file) {
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    });
</script>
  @endsection