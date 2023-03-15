
@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('content')
<section id="basic-horizontal-layouts">
  <div class="row match-height">
      
      <div class="col-md-6 col-12 offset-md-3">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Test Mobile SMS</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form class="form form-horizontal" method="POST" action="{{(($mode == 'Update') ? route('sms_outbox.update', $edit->id) : route('sms_outbox.store'))}}">
                        @csrf
                          <div class="form-body">
                              <div class="row">




                                  <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Mobile Number</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{($mode == 'Update') ? $edit->mobile_number: old('mobile_number')}}"  autocomplete="mobile_number" autofocus min="11" max="12">
                                                  @error('mobile_number')
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
                                        <span>Message</span>
                                      </div>
                                      <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                          <fieldset class="form-label-group">
                                              <textarea class="form-control @error('content') is-invalid @enderror" id="label-textarea" rows="3" name="content">{{($mode == 'Update') ? $edit->content: old('content')}}</textarea>
                                          </fieldset>
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
                                      <a href="{{route('sms_outbox.index')}}" class="btn btn-primary mr-1 mb-1">Back</a>
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
