@extends('layouts.master')
@section('title') @lang('translation.Notice_details') @endsection
@section('content')
@component('common-components.breadcrumb')
      @slot('pageTitle') @lang('translation.Home')@endslot
        @slot('MenuTitle') @lang('translation.Service_center') @endslot
        @slot('ParentTitle')@lang('translation.Notice')@endslot
        @slot('title') @lang('translation.Notice_details') @endslot 
@endcomponent 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <form action="{{route('admin.services.notices.update',$notice->id)}}" method="POST">
                     @csrf
                     @method("PUT")
                       <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.Notice_title')</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" id="validationCustom03"
                                    placeholder="@lang('translation.Notice_title')" name="title" value="{{$notice->title}}" />
                               @error('title') 
                                <small class="form-text text-danger">
                                    @lang('validation.title')
                                </small>
                                @enderror  
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.contents')</label>
                            <div class="col-md-8">
                               <textarea  id="classic-editor" name="content">{{$notice->content}}</textarea>
                              @error('content') 
                                <small class="form-text text-danger">
                                    @lang('validation.content')
                                </small>
                                @enderror  
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.Post_status')</label>
                            <div class="col-md-8">
                               <select class="form-select" name="status">
                                    <option value="{{$notice->ad_status_id}}">{{$notice->status}}</option>
                                @foreach($ads_stautus as $key => $ad_stautus)
                                    <option value="{{$ad_stautus}}" >{{trans('translation.'.$key)}}</option>
                                @endforeach
                               </select> 
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.Registration_date')</label>
                            <div class="col-md-8">
                                 <label for="example-text-input" class="col-md-3 col-form-label">{{$notice->registration_date}}</label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-3 col-form-label">@lang('translation.views')</label>
                            <div class="col-md-8">
                                 <label for="example-text-input" class="col-md-3 col-form-label">{{number_format($notice->views)}}</label>
                            </div>
                        </div>
                         <div class="float-end">
                            <a href="{{route('admin.services.notices.index')}}" class="btn btn-secondary waves-effect">
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