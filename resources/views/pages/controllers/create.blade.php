@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
         {{-- Page Css files --}}
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
            	
            	<form class="form form-horizontal" method="POST" action="{{ (($mode == 'Update') ? route('controllers.update', $edit->id) : route('controllers.store')) }}">
            		@csrf
            		<div class="form-body">
                <div class="row">
                    <div class="col-12">
	                    <div class="form-group row">
	                        <div class="col-md-4">
	                          <span>Route Type</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
	                                <select class="select2 form-control @error('route_type') is-invalid @enderror" name="route_type" required autocomplete="route_type" autofocus onchange="route_type_a(this.value)">
	                                	<option value="" >Select</option>
					                    <option value="resource">RESOURCE</option>
					                    <option value="get">GET</option>
					                    <option value="post">POST</option>
					                </select>

	                                @error('route_type')
	                                  <span class="invalid-feedback" role="alert">
	                                      <strong>{{ $message }}</strong>
	                                  </span>
	                                @enderror
	                          
	                            </div>
	                        </div>
	                    </div>
	                </div>


	                <div class="col-12">
	                    <div class="form-group row">
	                        <div class="col-md-4">
	                          <span>Controller Name</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
	                                <input id="controller_name" type="text" class="form-control @error('controller_name') is-invalid @enderror" name="controller_name" placeholder="ex. CoreImports" value="{{($mode == 'Update') ? $edit->controller_name: old('controller_name')}}" required autocomplete="controller_name" autofocus onchange="controller_name_a(this.value)">
	                                <input type="text" readonly name="" id="controller_name_text" class="form-control ">
	                                @error('controller_name')
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
	                          <span>URL</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
	                                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" placeholder="" value="{{($mode == 'Update') ? $edit->url: old('url')}}" required autocomplete="url" autofocus>
	                                @error('url')
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
	                          <span>Function Name</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
	                                <input id="function_name" type="text" class="form-control @error('function_name') is-invalid @enderror" name="function_name" placeholder="" value="{{($mode == 'Update') ? $edit->function_name: old('function_name')}}" required autocomplete="function_name" autofocus>
	                                @error('function_name')
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
	                            <span>Model Create?</span>
	                          </div>
	                          <div class="col-md-8">
	                              <div class="vs-checkbox-con vs-checkbox-primary">
	                                <input type="checkbox" id="model_create" name="model_create" value="{{($mode == 'Update') ? $edit->model_create: old('model_create')}}" onchange="model_create_a()">

	                                <span class="vs-checkbox vs-checkbox-lg">
	                                  <span class="vs-checkbox--check">
	                                    <i class="vs-icon feather icon-check"></i>
	                                  </span>
	                                </span>
	                                <span class=""></span>
	                              </div>
	                          </div>
	                    </div>
	                </div>


	                <div class="col-12" id="model_section">
	                    <div class="form-group row">
	                        <div class="col-md-4">
	                          <span>Model Name</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
	                                <input id="model_name" type="text" class="form-control @error('model_name') is-invalid @enderror" name="model_name" placeholder="ex. CoreImports" value="{{($mode == 'Update') ? $edit->model_name: old('model_name')}}"  autocomplete="model_name" autofocus onchange="model_name_a(this.value)">
	                                <input type="text" readonly name="" id="model_name_text" class="form-control ">
	                                @error('model_name')
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
	                            <span>Index and Create Blade Create?</span>
	                          </div>
	                          <div class="col-md-8">
	                              <div class="vs-checkbox-con vs-checkbox-primary">
	                                <input type="checkbox" id="blade_create" name="blade_create" value="{{($mode == 'Update') ? $edit->blade_create: old('blade_create')}}" onchange="blade_create_a()">
	                                <span class="vs-checkbox vs-checkbox-lg">
	                                  <span class="vs-checkbox--check">
	                                    <i class="vs-icon feather icon-check"></i>
	                                  </span>
	                                </span>
	                                <span class=""></span>
	                              </div>
	                          </div>
	                    </div>
	                </div>

	                <div class="col-12" id="blade_section">
	                    <div class="form-group row">
	                        <div class="col-md-4">
	                          <span>Folder Name</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
	                                <input id="blade_name" type="text" class="form-control @error('blade_name') is-invalid @enderror" name="blade_name" placeholder="ex. CoreImports" value="{{($mode == 'Update') ? $edit->blade_name: old('blade_name')}}"  autocomplete="blade_name" autofocus onchange="blade_folder_a(this.value)">
	                                <input type="text" readonly name="blade_name_text" id="blade_name_text" class="form-control" value="pages/">
	                                @error('blade_name')
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
	                          <span>Status</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
	                                <select class="select2 form-control @error('status') is-invalid @enderror" name="status" required autocomplete="status" autofocus >
	                                	<option value="" >Select</option>
					                    <option value="1">Active</option>
					                    <option value="2">Inactive</option>
					                </select>
	                                @error('status')
	                                  <span class="invalid-feedback" role="alert">
	                                      <strong>{{ $message }}</strong>
	                                  </span>
	                                @enderror
	                            </div>
	                        </div>
	                    </div>
	                </div>



                    <div class="col-12">
	                    <div class="form-group row">
	                        <div class="col-md-4">
	                          <span>Navigation Head</span>
	                        </div>
	                        <div class="col-md-8">
	                            <div class="position-relative has-icon-left">
									<select class="select2 form-control " id="navigation_header" name="navigation_header" >
										@foreach ($core_navigations as $core_navigation)
										<option value="{{$core_navigation->id}}">{{$core_navigation->nav_name}}</option>
										@endforeach
									</select>
	                                @error('status')
	                                  <span class="invalid-feedback" role="alert">
	                                      <strong>{{ $message }}</strong>
	                                  </span>
	                                @enderror
	                            </div>
	                        </div>
	                    </div>
	                </div>



                </div>

                  @if ($mode == 'Update')
                    @method('PUT')
                    <input type="hidden" name="id" value = "{{($mode == 'Update') ? $edit->id: ''}}">
                  @endif
                  <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                    <button type="reset" class="btn btn-primary mr-1 mb-1">Reset</button>
                    <a href="{{route('controllers.index')}}" class="btn btn-primary mr-1 mb-1">Back</a>
                  </div>

                </div>

            	</form>

            </div>
          </div>
        </div>
      </div>
    </div>

    @foreach ($errors->all() as $error)
    {{ $error }}<br/>
@endforeach
  </section>
@endsection
@section('vendor-script')
        <!-- vendor files -->
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>




<script>
var model_section = document.getElementById('model_section');
var blade_section = document.getElementById('blade_section');
model_section.style.display = "none";
blade_section.style.display = "none";

var route_type = '';
var create_model = false;
var create_blade = false;

blade_create_a();
model_create_a();


function route_type_a(value){
	route_type = value;
	var function_name = document.getElementById('function_name'); 
	if(route_type == 'resource'){
		 function_name.readOnly = true; 
		 function_name.value = 'index,create,store,show,edit,update,destroy'
	}else{
		 function_name.readOnly = false; 
		 function_name.value = ''
	}
	console.log(value)
}

const maybePluralize = (count, noun, suffix = 's') =>
  `${noun}${count !== 1 ? suffix : ''}`;


function capitalize(input) {  
    var words = input.split(' ');  
    var CapitalizedWords = [];  
    words.forEach(element => {  
        CapitalizedWords.push(element[0].toUpperCase() + element.slice(1, element.length));  
    });  
    return CapitalizedWords.join(' ');  
}  









// CONTROLLER



function controller_name_a(value){
	var controller_name = document.getElementById('controller_name_text');

	var fix_name = maybePluralize(0, value);

	controller_name.value = fix_name+'Controller'; 
	console.log(capitalize(fix_name))
}











//MODEL


function model_create_a(){
	var model_create = document.getElementById('model_create');
	
	if(model_create.checked == true){
		model_create.value = true;
		create_model = true
		model_section.style.display = "block";

	}else{
		create_model = false
		model_create.value = false;
		model_section.style.display = "none";
	}


}

// if(create_model == true){
	function model_name_a(value){
		var model_name = document.getElementById('model_name_text');

		var fix_name = maybePluralize(0, value);

		model_name.value = 'core_'+fix_name; 
		// console.log(capitalize(fix_name))
	}

// }




// BLADE

function blade_create_a(){
	
	var blade_create = document.getElementById('blade_create');

	if(blade_create.checked == true){
		blade_create.value = true;
		create_blade = true;
		blade_section.style.display = "block";
	}else{
		create_blade = false
		blade_create.value = false;
		blade_section.style.display = "none";
	}
	console.log(blade_create.value)
}


// if(create_blade == true){
	function blade_folder_a(value){
		var blade_loc = document.getElementById('blade_name_text');
		blade_loc.value = 'pages/'+value;

	}
// }
</script>


@endsection