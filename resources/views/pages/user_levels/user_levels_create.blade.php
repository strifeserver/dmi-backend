
@extends('layouts/contentLayoutMaster')

@section('title', 'User Level')

@section('content')
<section>
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$mode}} User Level</h4>
        </div>

        <div class="card-content">
          <div class="card-body">

            <form class="form" method="POST"
              action="{{(($mode == 'Update') ? route('user_levels.update', $user_level->id) : route('user_levels.store'))}}">
              @csrf

              <!-- name -->
              <div class="form-group">
                <label>Access Level Name</label>

                <div class="position-relative has-icon-left">
                  <input id="accesslevel" type="text" class="form-control @error('accesslevel') is-invalid @enderror"
                  name="accesslevel"
                  value="{{($mode == 'Update') ? $user_level->accesslevel: old('accesslevel')}}"
                  required
                  autocomplete="accesslevel"
                  autofocus>

                  @error('accesslevel')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror

                  <div class="form-control-position">
                    <i class="feather icon-user"></i>
                  </div>
                </div>
              </div> 



              {{-- .form-group --}}

              @if ($mode == 'Update')
              @method('PUT')
              <input type="hidden" name="id" value = "{{($mode == 'Update') ? $user_level->id: ''}}">
              @endif

              <!-- allowed modules -->

              <div class="form-group">
                <label>Allowed Modules</label>

                <div class="core-module-list mt-1">

                  @foreach($modules as $k => $rootModule)
                  @php
                    // value of name attribute in checkbox
                    $allowName = "root_module[$k][allow]";
                    $addName = "root_module[$k][add]";
                    $editName = "root_module[$k][edit]";
                    $deleteName = "root_module[$k][delete]";
                    $importName = "root_module[$k][import]";
                    $exportName = "root_module[$k][export]";
                  @endphp

                  <div class="core-module" data-module-id="{{ $k }}"> <!-- repeat -->

                    <!-- parent module -->
                    <div class="row core-parent-module mb-1 mt-1 mr-1">
                      <!-- root module -->
                      <div class="core-module-header-label col-6">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox"
                            data-module="{{ $k }}"
                            class="custom-control-input root-module-chk"
                            name="{{ $allowName }}"
                            id="{{ $allowName }}"
                            {{ isset($rootModule['permissions']['allow']) ? 'checked' : 'data-unchecked=1' }}>
                          <label class="custom-control-label text-primary font-weight-bold" for="{{ $allowName }}">
                            {{ $rootModule['name'] }}

                            <span class="text-muted">{{ $rootModule['path'] }}</span>
                          </label>
                        </div>
                      </div>

                      <!-- permissions -->
                      <div class="col core-module-header-permissions">
                        <div class="row core-permissions-fieldset" data-master-switch="{{ $k }}">
                          <div class="col">
                            <div class="custom-control custom-checkbox" hidden>
                              <input type="checkbox" class="custom-control-input" name="{{ $addName }}" id="{{ $addName }}"
                                {{ isset($rootModule['permissions']['add']) ? 'checked' : '' }} >
                              <label class="custom-control-label" for="{{ $addName }}">Add</label>
                            </div>
                          </div>

                          <div class="col">
                            <div class="custom-control custom-checkbox" hidden>
                              <input type="checkbox" class="custom-control-input" name="{{ $editName }}" id="{{ $editName }}"
                                {{ isset($rootModule['permissions']['edit']) ? 'checked' : '' }}>
                              <label class="custom-control-label" for="{{ $editName }}">Edit</label>
                            </div>
                          </div>

                          <div class="col">
                            <div class="custom-control custom-checkbox" hidden>
                              <input type="checkbox" class="custom-control-input" name="{{ $deleteName }}"id="{{ $deleteName }}"
                                {{ isset($rootModule['permissions']['delete']) ? 'checked' : '' }}>
                              <label class="custom-control-label" for="{{ $deleteName }}">Delete</label>
                            </div>
                          </div>

                          <div class="col">
                            <div class="custom-control custom-checkbox" hidden>
                              <input type="checkbox" class="custom-control-input" name="{{ $importName }}" id="{{ $importName }}"
                                {{ isset($rootModule['permissions']['import']) ? 'checked' : '' }}>
                              <label class="custom-control-label" for="{{ $importName }}">Import</label>
                            </div>
                          </div>

                          <div class="col">
                            <div class="custom-control custom-checkbox" hidden>
                              <input type="checkbox" class="custom-control-input" name="{{ $exportName }}"id="{{ $exportName }}"
                               {{ isset($rootModule['permissions']['export']) ? 'checked' : '' }}>
                              <label class="custom-control-label" for="{{ $exportName }}">Export</label>
                            </div>
                          </div>
                        </div> <!-- .row.fieldset -->

                      </div> <!-- .module-header-permissiond -->
                    </div>

                    <hr>
                    <!-- child modules -->
                    <div class="core-child-module-list m-1">

                      @foreach($rootModule['sub_modules'] as $j => $subModule)
                      @php
                        // value of name attribute in checkbox
                        $allowName = "sub_module[$j][allow]";
                        $addName = "sub_module[$j][add]";
                        $editName = "sub_module[$j][edit]";
                        $deleteName = "sub_module[$j][delete]";
                        $importName = "sub_module[$j][import]";
                        $exportName = "sub_module[$j][export]";
                      @endphp

                      <div class="row core-child-module" data-master-switch="{{ $k }}"> <!-- repeat -->
                        <!-- root module -->
                        <div class="core-module-header-label col-6">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input sub-module-master-chk"
                            data-sub-id="{{ $j }}"
                            name="{{ $allowName }}" id="{{ $allowName }}"
                              {{ isset($subModule['permissions']['allow']) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="{{ $allowName }}">
                              {{ $subModule['name'] }} <span class="text-muted"> {{ $subModule['path'] }}</span>
                            </label>
                          </div>
                        </div>
                        <hr />

                        <!-- permissions -->
                        <div class="col core-module-header-permissions">
                          <div class="row core-permissions-fieldset" data-parent-sub="{{ $j }}">
                            <div class="col">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sub-module-chk" name="{{ $addName }}" id="{{ $addName }}"
                                  {{ isset($subModule['permissions']['add']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="{{ $addName }}">Add</label>
                              </div>
                            </div>

                            <div class="col">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sub-module-chk" name="{{ $editName }}"id="{{ $editName }}"
                                  {{ isset($subModule['permissions']['edit']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="{{ $editName }}">Edit</label>
                              </div>
                            </div>

                            <div class="col">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sub-module-chk" name="{{ $deleteName }}" id="{{ $deleteName }}"
                                  {{ isset($subModule['permissions']['delete']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="{{ $deleteName }}">Delete</label>
                              </div>
                            </div>

                            <div class="col">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sub-module-chk" name="{{ $importName }}" id="{{ $importName }}"
                                  {{ isset($subModule['permissions']['import']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="{{ $importName }}">Import</label>
                              </div>
                            </div>

                            <div class="col">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sub-module-chk" name="{{ $exportName }}" id="{{ $exportName }}"
                                  {{ isset($subModule['permissions']['export']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="{{ $exportName}}">Export</label>
                              </div>
                            </div>
                          </div> <!-- .row.fieldset -->
                        </div> <!-- .module-header-permissions -->
                      </div> <!-- module -->
                      @endforeach

                    </div> <!-- child-module-list -->

                  </div> <!-- .core-module -->
                  @endforeach

                </div> <!-- .list -->
              </div> <!-- form group -->

              <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-outline-primary">Reset</button>
              </div>
            </form>

          </div> <!-- card-body -->
        </div> <!-- card-content -->
      </div> <!-- card -->
    </div>
  </div>
</section>
@endsection

@section('page-script')
<script>

$(document).ready(function() {

  // uncheck submodule when their root is unchecked
  $('input.root-module-chk[type=checkbox]').click((elem) => {
    if(!elem.target.checked) {
      var e = $(elem.target);
      var slaves = $('[data-master-switch=' +  e.data('module') +']');
      // uncheck sub modules as well:
      slaves.find('input[type=checkbox]').removeAttr('checked');
    }
  })

  // for sub modules: uncheck permissions
  $('input.sub-module-master-chk[type=checkbox]').click((elem) => {
    if(!elem.target.checked) {
      var e = $(elem.target);
      var slaves = $('[data-parent-sub=' + e.data('sub-id') + ']');

      slaves.find('input[type=checkbox]').removeAttr('checked');
    }
  })

})


</script>
@endsection
