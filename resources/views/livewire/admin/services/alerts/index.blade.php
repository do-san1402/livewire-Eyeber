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

                                        @foreach ($alerts as $alert )
                                            <td class="container-alerts">
                                                <div class="row">
                                                    <div class="col-12">
                                                        @if(!empty($alert->image))
                                                            <img src="{{ url('/storage/images/alerts/'. $alert->image) }}"  id="image_alert"  class="col-xs d-block mb-2 col-md-12 image_alert" height="250">
                                                        @else
                                                            <img src="{{$image_default}}"  id="image_alert"  class="col-xs d-block mb-2 col-md-12 image_alert" height="250">
                                                        @endif    
                                                    </div>                                  
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6 p-1" >
                                                        <div class="text-center">
                                                            <input type="hidden" class="hidden" name="alert_id[]" value="{{$alert->id}}">
                                                            <input type="file" name="image[]" class="hidden image_file">
                                                            <a type="submit" class="btn btn-secondary waves-effect waves-light btn-sm Delete_image" id="btn_del" >@lang('translation.Delete_image')</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 p-1" >
                                                        <div class="text-center">
                                                            <a type="submit" class="btn btn-primary waves-effect waves-light btn-sm Image_change" name="btn_register"  >@lang('translation.Image_change')</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="d-none text-danger image_validation">{{trans('translation.please_select_the_correct_format_image')}}</p>
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th scope="row" >@lang('translation.Link') </th>
                                        @foreach ($alerts as $alert)
                                            <td><input type="text" class="form-control" placeholder="@lang('translation.link_value')" value="{{$alert->link}}" name="link[]"></td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th scope="row" >@lang('translation.Period_settings')</th>
                                        @foreach ($alerts as $alert )
                                            <td>
                                                <div class="col-md-12 pb-2" >
                                                    <input type="date" class="form-control" value="{{$alert->date_start}}" name="date_start[]"  id="set_time_start1">
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="date" class="form-control" value="{{$alert->date_end}}" name="date_end[]"  id="set_time_end1">
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th scope="row" >@lang('translation.Situation')</th>
                                        @foreach ($alerts as $alert )
                                            <td scope="row">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select class="form-select" name="status[]" id="status_1">
                                                            <option name="ad_status_id" value="{{config('apps.common.ads_status.hide')}}" {{$alert->status == config('apps.common.ads_status.hide') ? 'selected': ''}} value="{{config('apps.common.ads_status.hide')}}">@lang('translation.hide')</option>
                                                            <option name="ad_status_id" value="{{config('apps.common.ads_status.show')}}"  {{$alert->status == config('apps.common.ads_status.show') ? 'selected': ''}} value="{{config('apps.common.ads_status.show')}}">@lang('translation.show')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                        @endforeach
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
        $('td.container-alerts').each(function() {
            this_parent = $(this);
            this_parent.find('a.Image_change').click({this_parent: this_parent}, function(event) {
                this_parent = event.data.this_parent;
                this_parent.find('input.image_file').click();
            })
            this_parent.find('input.image_file').change({this_parent: this_parent}, function(event) {
                this_parent = event.data.this_parent;
                var image = this_parent.find('img.image_alert');
                if(isImage($(this).val())) {
                    this_parent.find('p.image_validation').addClass("d-none");
                    image[0].src = URL.createObjectURL(this.files[0]);  
                }else{
                    this.files[0] = null;
                    this_parent.find('p.image_validation').removeClass("d-none");
                }

            })
            this_parent.find('a.Delete_image').click({this_parent: this_parent}, function(event) {
                this_parent = event.data.this_parent;
                this_parent.find('img.image_alert')[0].src = '{{$image_default}}';
                $('input.image_file').val('');
            })
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