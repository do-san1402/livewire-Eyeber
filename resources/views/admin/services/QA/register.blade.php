@extends('layouts.master')
@section('title') @lang('translation.Q&A')  @lang('translation.Registration') @endsection
@section('content')
@component('common-components.breadcrumb')
      @slot('pageTitle') @lang('translation.Home')@endslot
        @slot('MenuTitle') @lang('translation.Service_center') @endslot
        @slot('ParentTitle')@lang('translation.Notice')@endslot
        @slot('title') @lang('translation.Q&A')  @lang('translation.Registration') @endslot 
@endcomponent 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <form action="{{route('admin.services.qa.store')}}" method="POST">
                     @csrf
                       <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.Question_(title)')</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" id="validationCustom03"
                                    placeholder="@lang('translation.Please_include_a_Q&A_question')" name="name" value="{{old('name')}}"   />
                               @error('name') 
                                <small class="form-text text-danger">
                                    @lang('translation.Please_enter_name')
                                </small>
                                @enderror  
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.Answer_(content)')</label>
                            <div class="col-md-8">
                               <textarea  id="classic-editor" name="description" placeholder="@lang('translation.Please_include_a_Q&A_answer')">{{old('content')}}</textarea>
                              @error('description') 
                                <small class="form-text text-danger">
                                    @lang('translation.Please_enter_description')
                                </small>
                                @enderror  
                            </div>
                        </div>
                         <div class="float-end">
                            <a href="{{route('admin.services.qa.index')}}" class="btn btn-secondary waves-effect">
                                @lang('translation.Page_back')
                            </a>
                            <button type="submit" class="btn btn-success inner">
                                @lang('translation.Registration')
                            </button>
                        </div>
                     </form>  
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
       <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/ckeditor/ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>
@endsection