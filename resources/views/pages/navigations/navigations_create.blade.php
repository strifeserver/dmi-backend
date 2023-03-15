
@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('content')
<section id="basic-horizontal-layouts">
  <div class="row match-height">

      <div class="col-md-8 col-12 offset-md-2">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">{{$mode}} {{$title}}</h4>
              </div>
              <div class="card-content">
                  @if(session()->get('error'))
                      <br>
                      <p class="text-danger px-2">{{ session()->get('error') }} </p>
                  @endif
                  <!-- @foreach ($errors->all() as $error)
                          {{ $error }}<br/>
                  @endforeach -->
                  <div class="card-body">


                      <form class="form form-horizontal" method="POST" action="{{(($mode == 'Update') ? route('navigations.update', $navigation->id) : route('navigations.store'))}}">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Navigation Name</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="nav_name" type="text" class="form-control @error('nav_name') is-invalid @enderror" name="nav_name" placeholder="Navigation Name" value="{{($mode == 'Update') ? $navigation->nav_name: old('nav_name')}}" required autocomplete="nav_name" autofocus>
                                                  @error('nav_name')
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
                                            <span>Navigation Mode</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="nav_mode" type="text" class="form-control @error('nav_mode') is-invalid @enderror" name="nav_mode" placeholder="/navigation" value="{{($mode == 'Update') ? $navigation->nav_mode: old('nav_mode')}}" required autocomplete="nav_mode" autofocus>
                                                  @error('nav_mode')
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
                                            <span>Navigation Type</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                <select class="form-control" required name="nav_type" id="nav_type">
                                                  <option value="" {{ ($mode == 'Update')? '':'selected '}}" style="display:none;">Please Select....</option>
                                                  <option value="single" {{ ($mode == 'Update')?
                                                  (($navigation->nav_type == 'single')? 'selected':'') : ''}}>Single</option>

                                                  <option value="sub" {{ ($mode == 'Update')? (($navigation->nav_type == 'main')? 'selected':'') : '' }}>With Sub</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-12" id="SingleDiv" style="{{$hidesub}}" >
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Navigation Controller</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="nav_controller" type="text" class="form-control @error('nav_controller') is-invalid @enderror" name="nav_controller" placeholder="Navigation Controller" value="{{($mode == 'Update') ? $navigation->nav_controller: old('nav_controller')}}" autocomplete="nav_controller" autofocus {{ ($mode == 'Update')? 'disabled':'' }}>
                                                  @error('nav_controller')
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

                                  <!-- WITH SUB NAVIGATION -->

                                  <div class="col-12" id="MainDivSub" style="{{$hide_me}}">

                                  <div class="col-12">
                                      <div class="form-group row">

                                          <div class="col">
                                              <div class="position-relative">
                                                 <button role="button" type="button" class="btn btn-primary add_row"><i class="fa fa-plus"></i>
                                                  Add Subnavigation </button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>




                                  <table class="table table-hover" id="sub_navTable" >
                                  <thead>
                                    <tr>
                                      <th>Subnavigation name</th>
                                      <th>Subnavigation mode</th>
                                      <th>Controller Name</th>

                                      <th>Order</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <!-- id="textBoxes" -->
                                    @if(count($subnav) > 0)
                                    <!-- edit -->
                                    @foreach($subnav as $ind => $s)

                                    <tr>
                                      <td id="trow{{$ind+1}}" class="mytrow">
                                        <input type="hidden" class="rowval" name="rownum[]" value="{{$ind+1}}"></label>

                                        <input type="text" name="sub_name[]" class="form-control"
                                        value="{{$s->nav_name}}" required>
                                      </td>
                                      <td><input type="text" name="sub_mode[]" class="form-control" value="{{$s->nav_mode}}" required></td>
                                      <td><input type="text" name="controller[]" class="form-control" value="{{$s->nav_controller}}" required></td>

                                      <td width="5"><input type="text" name="order[]" class="form-control"  value="{{$s->nav_suborder}}" ></td>
                                      <td>
                                        <button type="button" class="btn btn-icon btn-danger btn-simple remove_row"
                                        id="0" >
                                        <i class="fa fa-times"></i></button>
                                      </td>
                                    </tr>
                                    @endforeach
                                    @else
                                      @if($hide_me != 'display:none;')
                                      <tr>
                                        <td id="trow1" class="mytrow">
                                          <input type="hidden" class="rowval" name="rownum[]" value="1"></label>

                                          <input type="text" name="sub_name[]" class="form-control" value="" required>
                                        </td>
                                        <td><input type="text" name="sub_mode[]" class="form-control" value="" required></td>
                                        <td><input type="text" name="controller[]" class="form-control" value="" required></td>

                                        <td width="5"><input type="text" name="order[]" class="form-control"  value="1" ></td>
                                        <td>
                                          <button type="button" class="btn btn-icon btn-danger btn-simple remove_row"
                                          id="0" >
                                          <i class="fa fa-times"></i></button>
                                        </td>
                                      </tr>
                                      @endif

                                    @endif


                                  </tbody>

                                </table>

                                </div>



                                  <!-- SINGLE NAVIGATION -->

                                  @if ($mode == 'Update')
                                    @method('PUT')
                                    <input type="hidden" name="id" value = "{{($mode == 'Update') ? $navigation->id: ''}}">
                                  @endif

                                  <div class="offset-6">
                                      <button type="submit" class="btn btn-primary mb-1">Submit</button>
                                      <button type="reset" class="btn btn-primary mb-1">Reset</button>
                                      <a href="{{route('navigations.index')}}" class="btn btn-outline-primary mb-1">Back</a>
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
$(document).ready(function() {


$("#nav_type").on("change", function() {
     var val = $(this).val();
     if(val == 'sub'){ /// show sub nav
      $('#MainDivSub').show();
      $('#SingleDiv').hide();
      //$('#nav_controller').removeAttr("disabled");
      $("#nav_controller").prop('required',false);

     }else{ //// hide sub nav
      $('#MainDivSub').hide();
      $('#SingleDiv').show();
      $('#nav_controller').removeAttr("disabled");
      $("#nav_controller").prop('required',true);
     }
});


$('.add_row').on("click", function() {
    var ctr = $('#sub_navTable').find('.rowval:last').val();

    var cnt = $("input[name='rownum[]']").eq(-0).val();
    ctr = (ctr == undefined) ? 0 : ctr;
    var cnt = parseInt(ctr) + 1;
    console.log(cnt);
    var table;

    table = '<tr align="center" id="trow' + cnt + '" class="mytrow">';
    table +='<td>';
    table += '<input type="hidden" class="rowval" name="rownum[]" value="' + cnt + '"></label>';
    table += '<input type="hidden" name="sub_id[]" value="">';
    table += '<input type="text" name="sub_name[]" class="form-control" value="" required>';
    table +='</td>';

    table +='<td>';
    table +='<input type="text" name="sub_mode[]" class="form-control" value="" required></td>';
    table +='<td><input type="text" name="controller[]" class="form-control" value="" required></td>';

    table +='<td width="5">';
    table +='<input type="text" name="order[]" class="form-control"  value="'+cnt+'" ></td>';
    table +='<td>';
    table +='  <button type="button" class="btn btn-icon btn-danger btn-simple update_btn remove_row" id="'+cnt+'" >';
    table +='  <i class="fa fa-times"></i></button>';
    table +='</td>';
    table +='</tr>';

    $('#sub_navTable tr').last().after(table);
    cnt++;

});

$("#sub_navTable").on("click", ".remove_row", function() {
   $(this).closest("tr").remove();
});






});



  /*** COLUMN DEFINE ***/
</script>

@endsection

