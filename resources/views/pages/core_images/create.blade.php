
@extends('layouts/contentLayoutMaster')

@section('title', $title)
@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
      
        <div class="col-md-6 col-12 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$mode}} {{$title}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                       
                       	<form id="form" class="form form-horizontal" enctype="multipart/form-data" method="POST" action="{{(($mode == 'Update') ? route('images1.update', $edit->id) : route('images1.store'))}}">
                        @csrf
                            <div class="form-body">
                                <div class="row">
	                                <div class="col-12">
	                                  <div class="form-group row">
	                                    <div class="col-md-4">
	                                      <span>File Category</span>
	                                    </div>
	                                    <div class="col-md-8">
	                                      <div class="position-relative has-icon-left">
	                                        <select class="form-control" name="file_category">
	                                          <option value="" {{ ($mode == 'Update')? '':'selected' }} style="display:none;">Please Select ....</option>
	                                          @foreach($file_categories as $file_category)
	                                            <option value="{{$file_category}}">{{$file_category}}</option>
	                                          @endforeach
	                                        </select>
	                                        <div class="form-control-position">
	                                          <i class="feather icon-user"></i>
	                                        </div>
	                                      </div>
	                                    </div>
	                                  </div>
	                                </div>

	                                @foreach ($errors->all() as $error)
    {{ $error }}<br/>
@endforeach


                                    <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Upload Image</span>
                                          </div>
   
                                            <div class="col-md-8">
                                                <div class="position-relative has-icon-left">
                                                	<input id="file" type="file" name="file[]" class="form-control @error('file') is-invalid @enderror">
                                                  @error('file')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>



           

                                  @if ($mode == 'Update')
                                    @method('PUT')
                                    <input type="hidden" name="id" value = "{{($mode == 'Update') ? $edit->id: ''}}">
                                  @endif
                                  <div class="col-md-8 offset-md-4">
                                      <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                      <a href="{{route('images1.index')}}" class="btn btn-primary mr-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  </div>
</section>
@endsection
@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')

		<script src="{{ asset(mix('js/scripts/forms/number-input.js')) }}"></script>
<script>


var numFiles = $("#file")[0].files.length;


function check_count(){
console.log($("#file")[0])

}



$('#file').change(function(){
    var files = $(this)[0].files;
    console.log(files)
    if(files.length > 20){
        // alert("you can select max 10 files.");
    Swal.fire({
        title: 'File Upload Count Reached',
        text: 'You can Upload 20 files per upload.',
        type: 'error',
        confirmButtonText: 'Confirm'
      })
        $("#file").val(null);
    }else{

    }
});

</script>
@endsection