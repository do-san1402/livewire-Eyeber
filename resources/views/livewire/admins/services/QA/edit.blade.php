@extends('layouts.master')
@section('title')@lang('translation.Q&A') @lang('translation.detail') @endsection
@section('content')
@component('common-components.breadcrumb')
      @slot('pageTitle') @lang('translation.Home')@endslot
        @slot('MenuTitle') @lang('translation.Service_center') @endslot
        @slot('ParentTitle')@lang('translation.qa')@endslot
        @slot('title') @lang('translation.Q&A') @lang('translation.detail') @endslot 
@endcomponent 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <form action="{{route('admin.services.qa.update',$qa->id)}}" method="POST">
                     @csrf
                     @method("PUT")
                       <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.Question_(title)')</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" id="validationCustom03"
                                    placeholder="@lang('translation.qa_title')" name="name" value="{{$qa->name}}" />
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
                               <textarea  id="classic-editor" name="description">{{$qa->description}}</textarea>
                              @error('description') 
                                <small class="form-text text-danger">
                                    @lang('translation.Please_enter_description')
                                </small>
                                @enderror  
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.Post_status')</label>
                            <div class="col-md-8">
                               <select class="form-select" name="status">
                                    <option value="{{$qa->status}}">{{$qa->status_name}}</option>
                                @foreach($ads_stautus as $key => $ad_stautus)
                                    <option value="{{$ad_stautus}}" >{{trans('translation.'.$key)}}</option>
                                @endforeach
                               </select> 
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.registration_date')</label>
                            <div class="col-md-8">
                                 <label for="example-text-input" class="col-md-3 col-form-label">{{$qa->registration_date}}</label>
                            </div>
                        </div>
                         <div class="float-end">
                            <a href="{{route('admin.services.qa.index')}}" class="btn btn-secondary waves-effect">
                                @lang('translation.Page_back')
                            </a>
                            <button type="submit" class="btn btn-success inner">
                                @lang('translation.correction')
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
    <script src="{{ URL::asset('/assets/libs/ckeditor/ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>
@endsection