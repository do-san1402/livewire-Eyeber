@extends('layouts.master')
@section('title') @lang('translation.Advertisement_List') @endsection
@section('content')
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>input[type="checkbox"], input[type="search"]::-webkit-search-cancel-button, .checkbox_all {cursor: pointer;}</style>
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@component('common-components.breadcrumb')

    @slot('pageTitle')  
            @lang('translation.Home')
    @endslot
    @slot('MenuTitle') @lang('translation.Advertising_Management') @endslot
    @slot('title') @lang('translation.Advertisement_List') @endslot
@endcomponent 
    <div class="filter_datatable_wrap">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body user_filter">
                        <form id="advertisement_filter_form">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <input type="search" placeholder="@lang('translation.Enter_a_search_term')" class="form-control"
                                            name="search" />
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="button" class="btn btn-primary waves-effect waves-light">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6">
                                    <strong>@lang('translation.Advertising_status')</strong>
                                    <input class="ms-2" type="checkbox" id="all_status_member" />
                                    <label for="all_status_member"> @lang('translation.All')</label>
                                    @foreach ($ads_stautus as $key => $ad_stautus)
                                        <input class="ms-2" type="checkbox"  id="{{ $key }}"
                                            name="ad_status_id" value="{{ $ad_stautus }}" />
                                        <label for="{{ $key }}">{{ trans('translation.'.$key) }}</label>
                                    @endforeach
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="col-md-4 float-end">
                                        <a class="btn btn-success float-end" href="{{route('admin.advertisements.register')}}"> @lang('translation.Advertising_registration')</a>
                                    </div>    
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-12">
                                </div>
                            </div>
                        </form>
                        <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                            <div class="col-12">
                                <button class="btn btn-info waves-effect waves-light active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_change_status_advertisement">@lang('translation.Status_Change')</button>
                            </div>
                            <div class="col-12">
                            <button class="btn btn-secondary ms-2 active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_delete_advertisement"> @lang('translation.Delete')</button>
                            </div>

                            <div class="col-12">
                                <a class="btn btn-success ms-2" href="{{route('admin.advertisements.monitoring')}}"> @lang('translation.Advertising_monitoring')</a>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-3">
                                    <a class="btn btn-primary ms-2"  href="{{route('admin.advertisements.mining_status')}}"> @lang('translation.Mining_amount_ranking')</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="setting_advertisement_table">
                            <table id="advertisement_table" class="table table-bordered dt-responsive "
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="all_age" name="somecheckbox" class="checkbox_all">
                                        </th>
                                        <th>@lang('translation.advertisement_name')</th>
                                        <th>@lang('translation.advertisement_date')</th>
                                        <th>@lang('translation.views')</th>
                                        <th>@lang('translation.rewards')</th>
                                        <th>@lang('translation.Advertising_status')</th>
                                        <th>@lang('translation.Edit')</th>
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


    <div id="modal_delete_advertisement" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_delete_advertisement_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Delete')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('translation.Cannot_restore_ad_when_delete_Are_you_sure_you_want_to_remove')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light delete_advertisement"
                        data-bs-dismiss="modal">@lang('translation.Yes')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">@lang('translation.No')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->
     <div id="modal_change_status_advertisement" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_change_status_advertisement_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Status_Member')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-select" name="status">
                        <option>@lang('translation.Select_state_value')</option>
                       @foreach ( $ads_stautus as $key => $ad_stautus )
                           <option value="{{$ad_stautus}}">@lang('translation.'. $key)</option>
                       @endforeach
                    </select>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success waves-effect waves-light setting_change_status"
                        data-bs-dismiss="modal">@lang('translation.Setting')</button>
                    <button type="button" class="btn btn-danger waves-effect"
                        data-bs-dismiss="modal">@lang('translation.Cancel')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->
@endsection
@section('script')
       <!-- apexcharts -->
       <script>
        $(function() {
            var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
            var advertisement_table = $('#advertisement_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.advertisements.fetchData') !!}",
                    data: function(d) {
                        var advertisement_data = new FormData($('form#advertisement_filter_form')[0]);
                        d.search = advertisement_data.get('search'),
                        d.ads_status_id = advertisement_data.getAll('ad_status_id')
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'views',
                        name: 'views'
                    },
                    {
                        data: 'rewards',
                        name: 'rewards'
                    },
                    {
                        data: 'ad_status_name',
                        name: 'ad_status_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
                columnDefs: [
                    {orderable: false, targets: 6 },
                    {orderable: false, targets: 0 },
                ],
                order: [[1, 'asc']],
            });
            $('form#advertisement_filter_form input:checkbox').on('change', function() {
                if($('#all_status_member').is(':checked')){
                    $('input[name="ad_status_id"]').prop('disabled', true);
                }else{
                    $('input[name="ad_status_id"]').prop('disabled', false);
                }
                if($('input[name="ad_status_id"]').is(':checked')){
                    $('#all_status_member').prop('disabled', true);
                }else{
                    $('#all_status_member').prop('disabled', false);
                }
                advertisement_table.draw();
            });
            $('form#advertisement_filter_form input[name="search"]').on('keyup', function() {
                advertisement_table.draw();
            })
            $('button.delete_advertisement').on('click', function() {
                var advertisements = []
                $("input[name='advertisement_id[]']:checked").each(function() {
                    advertisements.push(parseInt($(this).val()));
                });
                if (advertisements.length === 0) {
                    return false;
                }
                data = {
                    advertisements: advertisements
                };
                $.ajax({
                    url: '{{ route('admin.advertisements.delete') }}',
                    datatype: "html",
                    type: "delete",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        notificationSwal(response.status);
                        $('.active_with_checkbox').prop('disabled', true);
                        advertisement_table.draw();
                        $(".checkbox_all").prop('checked', false); 
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            })
            $('button.setting_change_status').on('click', function() {
                    status = parseInt($('.modal-body select[name="status"]').val());
                    if (!status) {
                        return false;
                    }
                    var advertisements = []
                    $("input[name='advertisement_id[]']:checked").each(function() {
                        advertisements.push(parseInt($(this).val()));
                    });
               
                    
                    data = {
                        status: status,
                        advertisements: advertisements,
                    };
                    $.ajax({
                        url: '{{ route('admin.advertisements.changeStatus') }}',
                        datatype: "html",
                        type: "put",
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            notificationSwal(response.status);
                            $('.active_with_checkbox').prop('disabled', true);
                            advertisement_table.draw();
                            $(".checkbox_all").prop('checked', false); 
                        },
                        error: function(error) {
                            errorSwal();
                        },
                    })
                })
        });
    </script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection