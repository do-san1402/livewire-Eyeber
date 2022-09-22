@extends('layouts.master')
@section('title') @lang('translation.Advertising_audit') @endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Home @endslot
    @slot('childrenTitle') @lang('translation.Management_ad')@endslot
    @slot('title') @lang('translation.Advertising_audit') @endslot
@endcomponent 
    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
    <form action="{{route("admin.advertisements.update_ads", $advertisement->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-left">
                        <p class="text-muted">@lang('translation.Advertising_video')</p>
                        <div class="row mb-3 ">
                            <video class="col-12 video-stream html5-main-video" controls autoplay>
                                <source id="video_here" class="video-lg" src="{{url('storage/video/advertisements/'.$advertisement->video)}}" type="video/mp4"> 
                          </video>
                        </div>
                    </div>
                    @error('video') 
                    <small class="form-text text-danger">
                        {{$message}}
                    </small>
                    @enderror
                    <div class="d-flex flex-wrap gap-3 mt-3 float-end">
                        <a  type="submit" class="btn btn-danger waves-effect waves-light mb-1 left delete-video " ui-toggle-class="">
                            @lang('translation.Delete_video')
                        </a>
                        <input type="hidden" name="video_hidden" value="{{$advertisement->video}}"  class="form-control" accept="video/*">
                        <input type="file" name="video" value="{{$advertisement->video}}"  class=" hidden form-control" accept="video/*" id="upload_file_input">
                        <input type="hidden" name="time" id="length_video" >
                        <a type="submit" class="btn btn-success waves-effect waves-light mb-1 change-image">@lang('translation.Change_video')</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn btn-primary waves-effect waves-light action-statistics-modal" data-bs-toggle="modal" id="ad_statistics" data-bs-target="#ad_view_statistics">@lang('translation.Ad_view_statistics')</button>
                    </div>
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
                                <input class="form-control" type="text" name="advertisement_name" value="{{$advertisement->name}}" id="name-input" placeholder="@lang('translation.advertisement_name')">
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
                                <textarea name="description" class="form-control" rows="5" placeholder="@lang('translation.Brief_description')">{{$advertisement->description}}</textarea>
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
                                <div class="col-md-3 mb-0 form-check form-check-left ">
                                    <input type="radio" id="input_mining" name="mining_settings" value="{{config('apps.common.mining_settings.direct')}}" {{ ($advertisement->mining_settings== config('apps.common.mining_settings.direct'))? "checked" : "" }}  class="form-check-input">
                                    <label class="form-check-label" for="input_mining">@lang('translation.Direct_setting')</label>
                                </div>
                                <div class="col-md-3 px-0 col-form-label">
                                    <label for="advertisement_setting" class="mb-0">@lang('translation.Advertisement_setting')</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="advertisement_setting" value="{{$advertisement_setting}}"  id="advertisement_setting">
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
                                <div class="col-md-3 form-check form-check-left ">
                                    <input type="radio" id="input_mining_auto" name="mining_settings" value="{{config('apps.common.mining_settings.auto')}}" {{ ($advertisement->mining_settings== config('apps.common.mining_settings.auto'))? "checked" : "" }} class="form-check-input">
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
                                <input class="form-control" type="text" name="set_collection_deduction" value="{{$advertisement->set_collection_deduction}}" id="Set_collection_deduction" placeholder="@lang('translation.Set_collection_deduction')">
                            </div> 
                            <label class="col-md-2 col-form-label">@lang('translation.Episode')</label>
                            <div class="col-md-4">
                                @error('set_collection_deduction') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="advertising_period" class="col-md-3 col-form-label">@lang('translation.Advertising_period')</label>
                            <div class="col-md-4">
                                <input id="advertising_period" class="form-control" type="date" name="date_start" value="{{$advertisement->date_start}}">
                                @error('date_start') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                            <label class="col-md-1 text-center col-form-label">~</label>
                            <div class="col-md-4">
                                <input class="form-control" type="date" name="date_end" value="{{$advertisement->date_end}}">
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
                                <div class="row">
                                    <div class="col-md-3 form-check">
                                        <input class="form-check-input " name="ad_nation_id" value="0" type="checkbox" id="all_payment">
                                        <label class="form-check-label" for="all_payment">
                                            @lang('translation.all')
                                        </label>
                                    </div>
                                
                                    @foreach ($nation as $value) 
                                    <div class="col-md-3 form-check">
                                        <input class="form-check-input name-payment"  name="ad_nation_id[]" value="{{$value->id}}" {{ ($nation_id && in_array($value->id, $nation_id)) ? 'checked' : '' }} type="checkbox" id="payment_{{$value->id}}">
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
                                    
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Ad_status')</label>
                            <div class="col-md-7">
                                <select class="form-select" name="ad_status_id">
                                    <option name="ad_status_id" value="{{config('apps.common.ads_status.hide')}}" {{$advertisement->ad_status_id == config('apps.common.ads_status.hide') ? 'selected': ''}} value="{{config('apps.common.ads_status.hide')}}">@lang('translation.hide')</option>
                                    <option name="ad_status_id" value="{{config('apps.common.ads_status.show')}}"  {{$advertisement->ad_status_id == config('apps.common.ads_status.show') ? 'selected': ''}} value="{{config('apps.common.ads_status.show')}}">@lang('translation.show')</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Registration_date')</label>
                            <span class="col-md-5 col-form-label h6">{{$advertisement->created_at -> format('d/m/Y')}}</span>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.views')</label>
                            <span class="col-md-5 col-form-label h6">{{$advertisement->views}}</span>
                        </div>
                        <div class="float-end">
                            <a href="{{url()->previous()}}" type="reset" class="btn btn-secondary waves-effect">
                                @lang('translation.Page_back')
                            </a>
                            <button type="submit" class="btn btn-success inner">
                                @lang('translation.Edit')
                            </button>
                        </div>

    </form>
                </div>
                <div id="ad_view_statistics" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <h5 class="modal-title text-center">@lang('translation.Advertising_statistics')</h5>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                              <div class="row">
                                                    <div class="col-md-10">
                                                        <form action="" id="order_status_filter_form"></form>
                                                        <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                                                            <div class="col-12 px-3">
                                                                <h4 class="card-title">@lang('translation.Period_setting')</h4>
                                                            </div>
                                                            <div class="col-md-4 px-0">
                                                                
                                                                <button id='1' id="date_btn_1" class="btn btn-primary btn-secondary action-btn-time btn-rounded waves-effect waves-light  handle_hover_chart btn-sm" >@lang('translation.1_day')
                                                                </button>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <button id="7" class="btn btn-primary action-btn-time btn-rounded waves-effect waves-light date_btn_7 1_week_btn handle_hover_chart btn-sm" >@lang('translation.1_week')
                                                                </button>
                                                            </div>
                                                            <div class="col-md-4 px-0">
                                                                <button id="30" class="btn btn-primary btn-rounded waves-effect waves-light action-btn-time date_btn_30 handle_hover_chart btn-sm" >@lang('translation.1_month')</button>
                                                            </div>
                                                            <div class="d-flex align-items-center input-daterange">
                                                                <div class="col-md-5 input-daterange">
                                                                    <input type="date" class="form-control" name="date_start_modal" placeholder="dd-mm-yyyy" />
                                                                </div>
                                
                                                                <div class="col-md-1 text-center">
                                                                <i class="">~</i>
                                                                </div>
                                
                                                                <div class="col-md-5 input-daterange">
                                                                    <input type="date" class="form-control" name="date_end_modal" placeholder="dd-mm-yyyy" />
                                                                </div>
                                                            </div>
                                                            <div class="col-12 px-5 mx-5">
                                                                <h4 class="card-title">@lang('translation.Statistical_status')</h4>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <p id="date_start_validate" class="text-danger text-center"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a  class="btn btn-success float-end" id="btnExport">
                                                            @lang('translation.Download_excel')
                                                        </a>
                                                    </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="card">
                                                    <h4 class="card-title mx-3 px-4 my-0 py-2">@lang('translation.Total_watch_time_minutes')</h4>
                                                    <div class="progress mb-1" style="height: 1px;">
                                                        <div class="progress-bar" role="progressbar" style="width: 100%; background: rgb(204 204 205 / 50%);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="card-body py-5">
                                                        <div class="d-flex flex-column justify-content-center align-items-center mx-4">
                                                            <h1 class="total_time_ads"></h1>
                                                        </div>
                                                    </div><!-- end card-body-->
                                                </div> <!-- end card-->
                                            </div><!-- end col -->

                                            <div class="col-xl-6">
                                                <div class="card">
                                                    <h4 class="card-title mx-3 px-4 my-0 py-2">@lang('translation.Participants')</h4>
                                                    <div class="progress mb-1" style="height: 1px;">
                                                        <div class="progress-bar"  role="progressbar" style="width: 100%; background: rgb(204 204 205 / 50%);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="card-body py-5">
                                                        <div class="d-flex flex-column justify-content-center align-items-center mx-4">
                                                            <h1 class="total_view_ads"></h1>
                                                        </div>
                                                    </div><!-- end card-body-->
                                                </div> <!-- end card-->
                                            </div><!-- end col -->


                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <canvas id="line-chart" height="200"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                            
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <form class="setting_product_table">
                                                    <p class="card-text">@lang('translation.Mining_item_ranking')(@lang('translation.Total_of') {{$count_product_ads}} @lang('translation.Items_used'))</p>
                                                    <table id="datatable_mining" class="table table-bordered dt-responsive"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th >@lang('translation.ranking')</th>
                                                                <th>@lang('translation.Item_Name')</th>
                                                                <th>@lang('translation.Number_of_items_used')</th>
                                                                <th>@lang('translation.Cumulative_mining')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           
                                                        </tbody>
                            
                                                    </table>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-body">
                                                <form class="setting_product_table">
                                                    <p class="card-text">@lang('translation.Member_mining_ranking') (@lang('translation.Total') {{$count_number_ads}} @lang('translation.People'))</p>
                                                    <table id="datatable_member" class="table table-bordered dt-responsive"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th >@lang('translation.ranking')</th>
                                                                <th>@lang('translation.id')</th>
                                                                <th>@lang('translation.Cumulative_viewing_time_minutes__number_of_times')</th>
                                                                <th>@lang('translation.Cumulative_mining')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           
                                                        </tbody>
                            
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-dismiss="modal" >@lang('translation.Confirm')</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
            
        </div>

         
    </div>
        
    
@endsection
@section('script')
        <script src="{{ URL::asset('/assets/libs/chart-js/chart-js.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/chartjs.init.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
       <script>
        if($('input[name="ad_nation_id[]"]').is(':checked')) {
            $('#all_payment').prop('disabled', true);
        }
            
        $("#all_payment").on("click", function(){
            $(".name-payment").each(function(){
                $(this).attr("checked", true);
            });
        });
        $('.change-image').on('click', function() {
                $('#upload_file_input').trigger('click');
        })

        $('input:checkbox').on('change', function() {
            if($('#all_payment').is(':checked')){
                $('input[name="ad_nation_id[]"]').prop("checked", false)
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
   
        $(document).on("change", "#upload_file_input", function(evt) {
            var $source = $('#video_here');
            $source[0].src = URL.createObjectURL(this.files[0]);
            $source.parent()[0].load();
            document.querySelector('.html5-main-video').ondurationchange = function() {
                $("#length_video").val(this.duration);
            };
        });

        $('.delete-video').on('click', function(){
            var data = new FormData();
            data.append('id','{{$advertisement->id}}')
            $.ajax({
                url: '{{ route('admin.advertisements.upload.video') }}',
                datatype: "json",
                type: "POST",
                data: data,
                contentType: false,
                processData: false, 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('.video-lg').prop('src', response.video);
                    $('.video-stream')[0].load();
                    $('.video-hidden').val(response.textVideo);
                },
                error: function(error) {
                },
            })
        })

        var today = new Date();
        function check_date_start(){
            $('#date_start_validate').html('');
            var date_start = new Date($('input[name="date_start_modal"]').val());
            var date_end = new Date($('input[name="date_end_modal"]').val());
            if(date_start > today ){
                    $('#date_start_validate').html('{{trans("translation.Please_enter_start_date_that_is_less_than_the_current_date")}}');
                    return false;
            };
            if(!$('input[name="date_end_modal"]').val()){
                    return false;
            };
            if(date_start > date_end){
                    $('#date_start_validate').html('{{trans("translation.Please_enter_start_date_that_is_less_than_the_end_date")}}');
                    return false;
            }
            datatable_mining.draw();
            datatable_member.draw();
            return true;
        }

        function check_date_end(){
            var date_end = new Date($('input[name="date_end_modal"]').val());
            $('#date_start_validate').html('');
            if(date_end > today ){
                    $('#date_start_validate').html('{{trans("translation.Please_enter_end_date_that_is_less_than_the_current_date")}}');
                    return false;
            };
            if(!$('input[name="date_start"]').val()){
                    $('#date_start_validate').html('{{trans("translation.Please_enter_start_date")}}')
                    return false;
            };
            var date_start = new Date($('input[name="date_start_modal"]').val());
            if(date_start > date_end){
                    $('#date_start_validate').html('{{trans("translation.Please_enter_start_date_that_is_less_than_the_end_date")}}');
                        return false;
            };
            datatable_mining.draw();
            datatable_member.draw();
            return true;
        }   

        $('input[name="date_start_modal"]').on('change', function(){
            check_date  =  check_date_start();
            if(check_date){
                if($('input[name="date_end_modal').val() != undefined) {
                    $('.action-btn-time.btn-secondary').removeClass('btn-secondary');
                    date_start = $('input[name="date_start_modal"]').val();
                    date_end = $('input[name="date_end_modal"]').val();
                    var id_advertisement = ["{{$advertisement->id}}"];
                    data = {
                        date_start: date_start,
                        date_end: date_end, 
                        id_advertisement: id_advertisement,
                    };
                    $.ajax({
                        url: '{{ route('admin.advertisements.ads_statistics') }}',
                        datatype: "html",
                        type: "GET",
                        data: data,
                        success: function(response) {
                            var data_chart = renderGraph(response.item_ads);
                            $('.total_time_ads').text(response.time);
                            $('.total_view_ads').text(response.view);
                            var modal = $('#ad_view_statistics');
                            var canvas = modal.find('.modal-body canvas');
                            var lineChart = canvas[0].getContext("2d");
                            var myChart = new Chart(lineChart, {
                                type: 'line',
                                data: data_chart,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }],
                                    },
                                }
                            });
                        
                        },
                        error: function(error) {

                        },
                    })
                }
            }
        })

        $('input[name="date_end_modal"]').on('change', function(){
            check_date =  check_date_end();
            if(check_date){
                $('.action-btn-time.btn-secondary').removeClass('btn-secondary');
                date_start = $('input[name="date_start_modal"]').val();
                date_end = $('input[name="date_end_modal"]').val();
                var id_advertisement = ["{{$advertisement->id}}"];
                data = {
                    date_start: date_start,
                    date_end: date_end,
                    id_advertisement: id_advertisement,
                };
                $.ajax({
                    url: '{{ route('admin.advertisements.ads_statistics') }}',
                    datatype: "html",
                    type: "GET",
                    data: data,
                    success: function(response) {
                        console.log(response)
                        var data_chart = renderGraph(response.item_ads);
                        $('.total_time_ads').text(response.time);
                        $('.total_view_ads').text(response.view);
                        var modal = $('#ad_view_statistics');
                        var canvas = modal.find('.modal-body canvas');
                        var lineChart = canvas[0].getContext("2d");
                        var myChart = new Chart(lineChart, {
                            type: 'line',
                            data: data_chart,
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero:true
                                        }
                                    }],
                                },
                            }
                        });
                    
                    },
                    error: function(error) {

                    },
                })
            }
        })
        
        $('.action-btn-time , .action-statistics-modal').on('click', function() {
            var date = $(this).attr('id');
            var id_advertisement = ["{{$advertisement->id}}"];
            data = {
                date: date,
                id_advertisement: id_advertisement,
            };
            $.ajax({
                url: '{{ route('admin.advertisements.ads_statistics') }}',
                datatype: "html",
                type: "GET",
                data: data,
                success: function(response) {
                    var data_chart = renderGraph(response.item_ads);
                    $('.total_time_ads').text(response.time);
                    $('.total_view_ads').text(response.view);
                    var modal = $('#ad_view_statistics');
                    var canvas = modal.find('.modal-body canvas');
                    var lineChart = canvas[0].getContext("2d");
                    var myChart = new Chart(lineChart, {
                        type: 'line',
                        data: data_chart,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }],
                            },
                        }
                    });
                },
                error: function(error) {

                },
            })
        })

        var renderGraph = function (item_ads) {
            var date = [];
            var mining = [];
            var view = [];
            $.each(item_ads , function (index, value){  
                date.push(value.date);
                mining.push(value.mining);
                view.push(value.view);
            });
            return char_data = {
                labels:date,
                datasets:[
                    {
                        label: "@lang('translation.Mining')",
                        data: mining,
                        backgroundColor: 'rgba(255, 99, 71, 0)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1
                    }, {
                        label: "@lang('translation.Number_of_participants')",
                        data: view,
                        backgroundColor: 'rgba(0, 128, 128, 0.3)',
                        borderColor: 'rgba(0, 128, 128, 0.7)',
                        borderWidth: 1
                    }
                ]
            };
        }

        var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
        url = '/datatable-translations/lang-' + lang + '.json';

        $('.action-btn-time').on('click', function() {
            $('.action-btn-time.btn-secondary').removeClass('btn-secondary');
            $(this).addClass('btn-secondary');
            $('#datatable_mining').data('dates',  { date: $(this).attr('id') });
            $('#datatable_member').data('dates',  { date: $(this).attr('id') });
            datatable_mining.draw();
            datatable_member.draw();
        })

        var datatable_mining = $('#datatable_mining').DataTable({
            serverSide: true,
            rowReorder: true,
            searching: false,
            bLengthChange : false,
            bInfo : false,
            paging : false,
            retrieve: true,
            language: {
                url: url,
            },
            ajax: {
                url: "{!! route('admin.advertisements.ads_statistics.table_mining') !!}",
                data: function(d) {
                    d.limit = 5;
                    d.id_advertisement = ["{{$advertisement->id}}"];
                    var date = $('#datatable_member').data('dates');
                    d.dates = date;
                    d.date_start = $('input[name="date_start_modal"]').val();
                    d.date_end = $('input[name="date_end_modal"]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'view',
                    name: 'view'
                },
                {
                    data: 'mining_rewards',
                    name: 'mining_rewards'
                },
                
            ], 
        });

        var datatable_member = $('#datatable_member').DataTable({
            serverSide: true,
            rowReorder: true,
            searching: false,
            bLengthChange : false,
            bInfo : false,
            paging : false,
            retrieve: true,
            language: {
                url: url,
            },
            ajax: {
                url: "{!! route('admin.advertisements.ads_statistics.table_mining') !!}",
                data: function(d) {
                    d.limit = 5;
                    d.id_advertisement = ["{{$advertisement->id}}"];
                    var date = $('#datatable_member').data('dates');
                    d.dates = date;
                    d.date_start = $('input[name="date_start_modal"]').val();
                    d.date_end = $('input[name="date_end_modal"]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {
                    data: 'user_id_name',
                    name: 'user_id_name'
                },
                {
                    data: 'viewTimes',
                    name: 'viewTimes'
                },
                {
                    data: 'mining_rewards',
                    name: 'mining_rewards'
                },
                
            ], 
        });
        $("#btnExport").click(function(e) 
        {
            datatable_member.page.len( -1 ).draw();
            datatable_mining.page.len( -1 ).draw();
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#datatable_member').parent().html()) + 
                encodeURIComponent($('#datatable_mining').parent().html()));
            setTimeout(function(){
                datatable_member.page.len(10).draw();
                datatable_mining.page.len(10).draw();
            }, 1000)
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
@endsection
