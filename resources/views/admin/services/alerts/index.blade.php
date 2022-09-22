@extends('layouts.master')
@section('title') @lang('translation.Alert_Settings') @endsection
@section('content')
@section('css')
    <!-- DataTables -->
    <style>
        .image_alert{
            object-fit: contain;
        }
    </style>
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@component('common-components.breadcrumb')
@slot('pageTitle') @lang('translation.Home')@endslot
@slot('MenuTitle') @lang('translation.Service_center') @endslot
    @slot('title') @lang('translation.Alert_Settings') @endslot
@endcomponent 
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if (Session::has('message') &&  Session::get('message') !== trans('translation.Success'))
                    <p  class="text-danger">
                        
                        {{ Session::get('message') }}
                    </p>
                    @endif
                    <form action="{{route('admin.services.alerts.update')}}" method="POST" id="form_alert_setting" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <div class="table-responsive mb-5">
                            <table id="alert_table" class="table mb-6 table-bordered table-xl">
                                <thead class="thead-light text-center ">
                                    <tr>
                                        <th class="col-1">@lang('translation.Setting_items')</th>
                                        <th class="col-sm">@lang('translation.Popup')1</th>
                                        <th class="col-sm">@lang('translation.Popup')2</th>
                                        <th class="col-sm">@lang('translation.Popup')3</th>
                                        <th class="col-sm">@lang('translation.Popup')4</th>
                                        <th class="col-sm">@lang('translation.Popup')5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="w-25">
                                            <div class="row">
                                                <div class="col-xl-12 p-1" style="width: 170px;" >
                                                   <b>@lang('translation.Image_settings')</b> (@lang('translation.Image_resolution')  000 * 000)
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    @if(!empty($alert_one->image))
                                                    <img src="{{ url('/storage/images/alerts/'. $alert_one->image) }}"  id="image_alert_one"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @else
                                                        <img src="{{$image_default}}"  id="image_alert_one"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @endif    
                                                </div>                                  
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <input type="hidden" class="hidden" name="alert_id[]" value="{{$alert_one->id}}">
                                                        <input type="file" name="image[]" class="hidden" id="image_one">
                                                        <a type="submit" class="btn btn-secondary waves-effect waves-light btn-sm Delete_image_one" id="btn_del_1" >@lang('translation.Delete_image')</a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <a type="submit" class="btn btn-primary waves-effect waves-light btn-sm Image_change_one" name="btn_register_1"  >@lang('translation.Image_change')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="d-none text-danger" id="image_validation_one">{{trans('translation.please_select_the_correct_format_image')}}</p>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    @if(!empty($alert_two->image))
                                                        <img src="{{ url('/storage/images/alerts/'. $alert_two->image) }}"  id="image_alert_two"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @else
                                                        <img src="{{$image_default}}"  id="image_alert_two"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @endif
                                                </div>                                  
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <input type="file" name="image[]" class="hidden" id="image_two">
                                                        <input type="hidden" class="hidden" name="alert_id[]" value="{{$alert_two->id}}">
                                                        <a type="submit" class="btn btn-secondary waves-effect waves-light btn-sm Delete_image_two " id="btn_del_1" >@lang('translation.Delete_image')</a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <a type="submit" class="btn btn-primary waves-effect waves-light btn-sm Image_change_two" name="btn_register_1"  >@lang('translation.Image_change')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="d-none text-danger" id="image_validation_two">{{trans('translation.please_select_the_correct_format_image')}}</p>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    @if(!empty($alert_three->image))
                                                        <img src="{{ url('/storage/images/alerts/'. $alert_three->image) }}"  id="image_alert_three"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @else
                                                        <img src="{{$image_default}}"  id="image_alert_three"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @endif    
                                                </div>                                  
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <input type="file" name="image[]" class="hidden" id="image_three">
                                                        <input type="hidden" class="hidden" name="alert_id[]" value="{{$alert_three->id}}">
                                                        <a type="submit" class="btn btn-secondary waves-effect waves-light btn-sm Delete_image_three" id="btn_del_1" >@lang('translation.Delete_image')</a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <a type="submit" class="btn btn-primary waves-effect waves-light btn-sm Image_change_three" name="btn_register_1"  >@lang('translation.Image_change')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="d-none text-danger" id="image_validation_three">{{trans('translation.please_select_the_correct_format_image')}}</p>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    @if(!empty($alert_four->image))
                                                        <img src="{{ url('/storage/images/alerts/'. $alert_four->image) }}"  id="image_alert_four"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @else
                                                        <img src="{{$image_default}}"  id="image_alert_four"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @endif
                                                </div>                                  
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <input type="file" name="image[]" class="hidden" id="image_four">
                                                        <input type="hidden" class="hidden" name="alert_id[]" value="{{$alert_four->id}}">
                                                        <a type="submit" class="btn btn-secondary waves-effect waves-light btn-sm Delete_image_four" id="btn_del_1" >@lang('translation.Delete_image')</a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <a type="submit" class="btn btn-primary waves-effect waves-light btn-sm Image_change_four" name="btn_register_1"  >@lang('translation.Image_change')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="d-none text-danger" id="image_validation_four">{{trans('translation.please_select_the_correct_format_image')}}</p>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    @if(!empty($alert_five->image))
                                                        <img src="{{ url('/storage/images/alerts/'. $alert_five->image) }}"  id="image_alert_five"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @else
                                                        <img src="{{$image_default}}"  id="image_alert_five"  class="col-xs d-block mb-2 col-md-12 image_alert" alt="">
                                                    @endif  
                                                </div>                                  
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <input type="file" name="image[]" class="hidden" id="image_five">  
                                                        <input type="hidden" class="hidden" name="alert_id[]" value="{{$alert_five->id}}">
                                                        <a type="submit" class="btn btn-secondary waves-effect waves-light btn-sm Delete_image_five" id="btn_del_1" >@lang('translation.Delete_image')</a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 p-1" >
                                                    <div class="text-center">
                                                        <a type="submit" class="btn btn-primary waves-effect waves-light btn-sm Image_change_five" name="btn_register_1"  >@lang('translation.Image_change')</a>
                                                    </div>
                                                </div>
                                            <p class="d-none text-danger" id="image_validation_five">{{trans('translation.please_select_the_correct_format_image')}}</p>
                                            </div>
                                        </td>   
                                    </tr>
                                    <tr>
                                        <th scope="row" >@lang('translation.Link') </th>
                                            <td><input type="text" class="form-control" placeholder="@lang('translation.link_value')" value="{{$alert_one->link}}" name="link[]"></td>
                                            <td><input type="text" class="form-control" placeholder="@lang('translation.link_value')" value="{{$alert_two->link}}" name="link[]"></td>
                                            <td><input type="text" class="form-control" placeholder="@lang('translation.link_value')" value="{{$alert_three->link}}" name="link[]"></td>
                                            <td><input type="text" class="form-control" placeholder="@lang('translation.link_value')" value="{{$alert_four->link}}" name="link[]"></td>
                                            <td><input type="text" class="form-control" placeholder="@lang('translation.link_value')" value="{{$alert_five->link}}" name="link[]"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" >@lang('translation.Period_settings')</th>
                                        <td>
                                            <div class="col-md-12 pb-2" >
                                                <input type="date" class="form-control" value="{{$alert_one->date_start}}" name="date_start[]"  id="set_time_start1">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="date" class="form-control" value="{{$alert_one->date_end}}" name="date_end[]"  id="set_time_end1">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-12 pb-2" >
                                                <input type="date" class="form-control" value="{{$alert_two->date_start}}" name="date_start[]"  id="set_time_start1">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="date" class="form-control" value="{{$alert_two->date_end}}" name="date_end[]"  id="set_time_end1">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-12 pb-2" >
                                                <input type="date" class="form-control" value="{{$alert_three->date_start}}" name="date_start[]"  id="set_time_start1">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="date" class="form-control" value="{{$alert_three->date_end}}" name="date_end[]"  id="set_time_end1">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-12 pb-2" >
                                                <input type="date" class="form-control" value="{{$alert_four->date_start}}" name="date_start[]"  id="set_time_start1">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="date" class="form-control" value="{{$alert_four->date_end}}"  name="date_end[]" id="set_time_end1">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-12 pb-2" >
                                                <input type="date" class="form-control" value="{{$alert_five->date_start}}" name="date_start[]"  id="set_time_start1">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="date" class="form-control" value="{{$alert_five->date_end}}" name="date_end[]"  id="set_time_end1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" >@lang('translation.Situation')</th>
                                        <td scope="row">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-select" name="status[]" id="status_1">
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.hide')}}" {{$alert_one->status == config('apps.common.ads_status.hide') ? 'selected': ''}} value="{{config('apps.common.ads_status.hide')}}">@lang('translation.hide')</option>
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.show')}}"  {{$alert_one->status == config('apps.common.ads_status.show') ? 'selected': ''}} value="{{config('apps.common.ads_status.show')}}">@lang('translation.show')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-select" name="status[]" id="status_2">
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.hide')}}" {{$alert_two->status == config('apps.common.ads_status.hide') ? 'selected': ''}} value="{{config('apps.common.ads_status.hide')}}">@lang('translation.hide')</option>
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.show')}}"  {{$alert_two->status == config('apps.common.ads_status.show') ? 'selected': ''}} value="{{config('apps.common.ads_status.show')}}">@lang('translation.show')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-select" name="status[]" id="status_3">
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.hide')}}" {{$alert_three->status == config('apps.common.ads_status.hide') ? 'selected': ''}} value="{{config('apps.common.ads_status.hide')}}">@lang('translation.hide')</option>
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.show')}}"  {{$alert_three->status == config('apps.common.ads_status.show') ? 'selected': ''}} value="{{config('apps.common.ads_status.show')}}">@lang('translation.show')</option>
                                                    </select>   
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-select" name="status[]" id="status_4">
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.hide')}}" {{$alert_four->status == config('apps.common.status_advertisement.hide') ? 'selected': ''}} value="{{config('apps.common.ads_status.hide')}}">@lang('translation.hide')</option>
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.show')}}"  {{$alert_four->status == config('apps.common.ads_status.show') ? 'selected': ''}} value="{{config('apps.common.ads_status.show')}}">@lang('translation.show')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-select" name="status[]" id="status_5">
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.hide')}}" {{$alert_five->status == config('apps.common.status_advertisement.hide') ? 'selected': ''}} value="{{config('apps.common.ads_status.hide')}}">@lang('translation.hide')</option>
                                                        <option name="ad_status_id" value="{{config('apps.common.ads_status.show')}}"  {{$alert_five->status == config('apps.common.ads_status.show') ? 'selected': ''}} value="{{config('apps.common.ads_status.show')}}">@lang('translation.show')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="position-absolute bottom-0 end-0 px-2 py-2">
                                <a href="{{route('admin.services.alerts.index')}}" class="btn btn-secondary waves-effect">@lang('translation.reset')</a>
                                <button type="submit" class="btn btn-success waves-effect">@lang('translation.Save')</button>
                            </div>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>  
@endsection
@section('script')
       <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
    <script>
        $('.Image_change_one').on('click', function(){
            $('#image_one').trigger('click');
        })
        $('.Delete_image_one').on('click', function(){
            $('#image_alert_one')[0].src = '{{$image_default}}';
            $('#image_one').val('');
        })
        $('#image_one').on('change', function(){
            var image = $('#image_alert_one');
            if(isImage($(this).val())){
                console.log(this.files[0]);
                $('#image_validation_one').addClass("d-none");
                image[0].src = URL.createObjectURL(this.files[0]);  
            }else{
                this.files[0] = null;
                console.log(this.files[0]);
                $('#image_validation_one').removeClass("d-none");
            }
                   
        })
        $('.Image_change_two').on('click', function(){
            $('#image_two').trigger('click');
        })
        $('.Delete_image_two').on('click', function(){
            $('#image_alert_two')[0].src = '{{$image_default}}';
            $('#image_two').val('');
        })
        $('#image_two').on('change', function(){
            var image = $('#image_alert_two');
            if(isImage($(this).val())){
                $('#image_validation_two').addClass("d-none");
                image[0].src = URL.createObjectURL(this.files[0]);  
            }else{
                this.files[0] = null;
                $('#image_validation_two').removeClass("d-none");
            }
        })
        $('.Image_change_three').on('click', function(){
            $('#image_three').trigger('click');
        })
        $('.Delete_image_three').on('click', function(){
            $('#image_alert_three')[0].src = '{{$image_default}}';
            $('#image_three').val('');
        })
        $('#image_three').on('change', function(){
            var image = $('#image_alert_three');
            if(isImage($(this).val())){
                $('#image_validation_three').addClass("d-none");
                image[0].src = URL.createObjectURL(this.files[0]);  
            }else{
               this.files[0] = null;
                $('#image_validation_three').removeClass("d-none");
            }
        })
        $('.Image_change_four').on('click', function(){
            $('#image_four').trigger('click');
        })
        $('.Delete_image_four').on('click', function(){
            $('#image_alert_four')[0].src = '{{$image_default}}';
            $('#image_four').val('');
        })
        $('#image_four').on('change', function(){
            var image = $('#image_alert_four');
            if(isImage($(this).val())){
                image[0].src = URL.createObjectURL(this.files[0]);  
                $('#image_validation_four').addClass("d-none");
            }else{
               this.files[0] = null;
                $('#image_validation_four').removeClass("d-none");
            }
          
        })
        $('.Image_change_five').on('click', function(){
            $('#image_five').trigger('click');
        })
        $('.Delete_image_five').on('click', function(){
            $('#image_alert_five')[0].src = '{{$image_default}}';
            $('#image_five').val('');
        })
        $('#image_five').on('change', function(){
            var image = $('#image_alert_five');
            if(isImage($(this).val())){
                image[0].src = URL.createObjectURL(this.files[0]);  
                $('#image_validation_five').addClass("d-none");
            }else{
               this.files[0] = null;
                $('#image_validation_five').removeClass("d-none");
            }
        })
        function isImage(filename) {
            var ext = getExtension(filename);
            switch (ext.toLowerCase()) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'bmp':
            case 'ico':
                // etc
                return true;
            }
            return false;
        }
        function getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        }
    </script>
@endsection