
@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('content')
<style type="text/css">
  .div-upload{
    display: none;
  }
</style>
<section id="basic-horizontal-layouts">
  <div class="row match-height">
      
      <div class="col-md-6 col-12 offset-md-3">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">{{$mode}} {{$title}}</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form class="form form-horizontal" enctype="multipart/form-data" method="POST" action="{{(($mode == 'Update') ? route('general_settings.update', $edit->id) : route('general_settings.store'))}}">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Setting Name</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="setting_name" type="text" class="form-control @error('setting_name') is-invalid @enderror" name="setting_name" value="{{($mode == 'Update') ? $edit->setting_name: old('setting_name')}}"  autocomplete="setting_name" autofocus>
                                                  @error('setting_name')
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

                                  <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Setting Value</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="setting_value" type="text" class="form-control @error('setting_value') is-invalid @enderror" name="setting_value" value="{{($mode == 'Update') ? $edit->setting_value: old('setting_value')}}" required autocomplete="setting_value" autofocus>
                                                  @error('setting_value')
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

                                  <div class="col-12">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <span>Setting Description</span>
                                      </div>
                                      <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                          <fieldset class="form-label-group">
                                              <textarea class="form-control @error('setting_description') is-invalid @enderror" id="label-textarea" rows="3" name="setting_description">{{($mode == 'Update') ? $edit->setting_description: old('setting_description')}}</textarea>
                                          </fieldset>

                                        </div>
                                      </div>
                                    </div>



 
                                  </div>

                                  <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Category</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <select id="category" name="category" class="form-control">
                                                    <option value="1" {{ ($mode == 'Update' && $edit->category == '1') ? 'selected' : ''}}>Normal Settings</option>
                                                    <option value="2" {{ ($mode == 'Update' && $edit->category == '2') ? 'selected' : ''}}>Upload File</option>
                                                  </select>
                                                  @error('category')
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

                                  <div class="col-12 div-upload">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>File Path</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <select name="file_path" class="form-control">
                                                    <option value=""></option>
                                                    <option value="images\pages\" {{ ($mode == 'Update' ? 'selected' : '')}}>public/images/pages/</option>
                                                  </select>
                                                  @error('file_path')
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


                                  <div class="col-12 div-upload">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <span>Image</span>
                                      </div>
                                      <div class="col-md-8">
                                        <div class="position-relative has-icon-left overflow-hidden">
                                          <input id="image" type="file" class="form-control @error('img') is-invalid @enderror" name="img" autocomplete="off" autofocus accept="image/*">

                                          @error('img')
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

                                  <div class="col-12 div-upload">
                                     <div class="row no-gutters overflow-hidden">
                                       <img id="image-preview" class="{{ ($mode == 'Update') ? 'rounded w-100 mb-2' : '' }}" src="{{ ($mode == 'Update' && isset($path)) ? asset($path.$image) : '' }}" alt="{{ ($mode == 'Update' && isset($path)) == 'Update' ?  $image : '' }}">
                                     </div>
                                   </div>

                                  @if ($mode == 'Update')
                                    @method('PUT')
                                    <input type="hidden" name="id" value = "{{($mode == 'Update') ? $edit->id: ''}}">
                                  @endif
                                  <div class="col-md-10 offset-md-2">
                                      <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                      <button type="reset" class="btn btn-primary mr-1 mb-1">Reset</button>
                                      <a href="{{route('general_settings.index')}}" class="btn btn-primary mr-1 mb-1">Back</a>
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

@section('page-script')
<script>
$(document).ready(function(){
  function checkCategory(){
    var category = $('#category :selected').val();

    if(category == 2){
      $('.div-upload').css('display', 'block');
    }else{
      $('.div-upload').css('display', 'none');
    }
  }
  function refreshImage(){
    var file = $('#image').get(0).files[0];
    
    if(file){
        var reader = new FileReader();

        reader.onload = function(){
          $("#image-preview").attr("src", reader.result);
          $("#image-preview").attr("class", "rounded w-100 mb-2");
        }

        reader.readAsDataURL(file);
    }
  }

  refreshImage();
checkCategory();
  $('#image').on('change', function(){
    refreshImage();
  });

  $('#category').on('change', function(){
    checkCategory();
  });
});
</script>
@endsection
