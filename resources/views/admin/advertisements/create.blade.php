@extends('layouts.master')
@section('title') @lang('translation.Create_product') @endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Home @endslot
    @slot('childrenTitle') @lang('translation.List_product')@endslot
    @slot('title') @lang('translation.Register_Advertisement') @endslot
@endcomponent 

    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
    <form action="{{url("admin/advertisements/register-ads")}}" method="POST" enctype="multipart/form-data" id="advertisement_filter_form">
                    @csrf
                    <div class="text-left">
                        <p class="text-muted">@lang('translation.Advertising_video')</p>
                        <div class="row mb-3 ">
                            <video class="col-12 video-stream html5-main-video" controls autoplay>
                                <source class="video-lg" id="video_here" src="" type="video/mp4"> 
                          </video>
                        </div>
                        @error('video') 
                        <small class="form-text text-danger">
                            {{$message}}
                        </small>
                        @enderror
                    </div>
                    <input type="file" name="video" value="" accept="video/*" class="hidden upload_file_input" id="upload_file_input" class="form-control">
                    <a type="submit" class="btn btn-success waves-effect waves-light mb-1 change-image float-end">@lang('translation.Image_registration')</a>

                   <input type="hidden" name="time" id="length_video" >
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card mb-0">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Advertising_information')</h4>
                        <div class="mb-3 row">
                            <label for="name-input" class="col-md-3 col-form-label">@lang('translation.advertisement_name')</label>
                            <div class="col-md-9">

                                <input class="form-control" type="text" name="advertisement_name" value="" id="name-input" placeholder="@lang('translation.advertisement_name')">
                                @error('advertisement_name')  
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Brief_description')</label>
                            <div class="col-md-9">
                                <textarea name="description" class="form-control" rows="5" placeholder="@lang('translation.Brief_description')"></textarea>
                                @error('description') 
                                <small class="form-text text-danger">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Payment_coin')</label>
                            <span class="col-md-2 col-form-label">BST</span>
                        </div>

                        <div class="mb-3 row">
                            <div class="d-inline-flex align-items-center">
                                <label class="col-md-3 col-form-label">@lang('translation.Mining_settings')</label>

                                <div class="col-md-3 form-check form-check-left mx-2 ">
                                    <input type="radio" id="input_mining" name="mining_settings" value="{{config('apps.common.mining_settings.direct')}}" class="form-check-input">
                                    <label class="form-check-label" for="input_mining">@lang('translation.Direct_setting')</label>
                                </div>
                                <div class="col-md-3 px-0 col-form-label">
                                    <label for="advertisement_setting" class="mb-0">@lang('translation.Advertisement_setting')</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="advertisement_setting" value="" id="advertisement_setting" placeholder="">
                                    @error('advertisement_setting') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="d-inline-flex align-items-center">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-3 form-check form-check-left mx-2">
                                    <input type="radio" id="input_mining_auto" name="mining_settings" value="{{config('apps.common.mining_settings.auto')}}" class="form-check-input">
                                    <label class="form-check-label" for="input_mining_auto">@lang('translation.Auto_setup')</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label"></label>
                            <div class="col-md-5 form-check form-check-left">
                                @error('mining_settings') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                        </div>



                        <div class="mb-3 row">
                            <label for="set_collection_deduction" class="col-md-3 col-form-label">@lang('translation.Set_collection_deduction')</label>

                            <div class="col-md-4">
                                <input class="form-control" type="text" name="set_collection_deduction" value="" id="Set_collection_deduction" placeholder="@lang('translation.Set_collection_deduction')">
                                @error('set_collection_deduction') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div> 
                            <label class="col-md-2 col-form-label">@lang('translation.Episode')</label>
                        </div>

                        <div class="mb-3 row">
                            <label for="advertising_period" class="col-md-3 col-form-label">@lang('translation.Advertising_period')</label>
                            <div class="col-md-4">
                                <input id="advertising_period" class="form-control" type="date" name="date_start" value="">
                                @error('date_start') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                            <label class="col-md-1 text-center col-form-label">~</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" name="date_end" value="">
                                @error('date_end') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="mb-3 row">
                            <label for="set_collection_deduction" class="col-md-3 col-form-label">@lang('translation.Payment_area')</label>
                            <div class="col-md-9">
                                <div class="row mx-1    ">
                                    <div class="col-md-3 form-check">
                                        <input class="form-check-input" name="ad_nation_id" value="0" type="checkbox" id="all_payment">
                                        <label class="form-check-label" for="all_payment">
                                            @lang('translation.all')
                                        </label>
                                    </div>
                                    @foreach ($nation as $value)
                                        <div class="col-md-3 form-check">
                                            <input class="form-check-input name-payment" name="ad_nation_id[]" value="{{$value->id}}" type="checkbox" id="payment_{{$value->id}}">
                                            <label class="form-check-label" for="payment_{{$value->id}}">
                                                {{$value->name}}
                                            </label>
                                        </div> 
                                    @endforeach
                                    @error('ad_nation_id') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                                    
                                </div>
                            </div>
                        </div>
                        <div class="float-end">
                            <a href="{{url()->previous()}}" class="btn btn-secondary waves-effect">
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
        
    
@endsection
@section('script')
    <script>
        $('.change-image').on('click', function() {
                $('#upload_file_input').trigger('click');
        })

        $('input:checkbox').on('change', function() {
            if($('#all_payment').is(':checked')){
                $('input[name="ad_nation_id[]"]').prop('disabled', true);
            }else {
                $('input[name="ad_nation_id[]"]').prop('disabled', false);
            }
        
            if($('input[name="ad_nation_id[]"]').is(':checked')) {
                $('#all_payment').prop('disabled', true);
            }else {
                $('#all_payment').prop('disabled', false);
            }
        })

        $(document).on("change", ".upload_file_input", function(evt) {
            var $source = $('#video_here');
            $source[0].src = URL.createObjectURL(this.files[0]);
            $source.parent()[0].load();
            document.querySelector('.html5-main-video').ondurationchange = function() {
                $("#length_video").val(this.duration);
            };
        });

        $('input[name="mining_settings"]').on('click', function() {
            if($('#input_mining').is(':checked')){
                $('#advertisement_setting').prop('disabled', false);
            }
            if($('#input_mining_auto').is(':checked')){
                $('#advertisement_setting').prop('disabled', true);
            }
        });
        
    </script>
       <!-- apexcharts -->
       <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection