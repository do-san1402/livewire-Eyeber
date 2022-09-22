@extends('layouts.master')
@section('title')
    @lang('translation.Notice')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        input[type="checkbox"], input[type="search"]::-webkit-search-cancel-button, .checkbox_all {cursor: pointer;}
    </style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle') @lang('translation.Home')@endslot
        @slot('MenuTitle') @lang('translation.Service_center') @endslot
        @slot('title') @lang('translation.Notice') @endslot 
    @endcomponent
    <div class="filter_datatable_wrap">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body user_filter">
                        <form id="notice_filter_form">
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
                                    <strong>@lang('translation.Post_status')</strong>
                                    <input class="ms-2" type="checkbox" id="all_status_member" />
                                    <label for="all_status_member"> @lang('translation.All')</label>
                                    @foreach ($ads_stautus as $key => $ad_stautus)
                                        <input class="ms-2" type="checkbox" id="Post_status_{{ $ad_stautus }}"
                                            name="post_status" value="{{ $ad_stautus }}" />
                                        <label for="Post_status_{{ $ad_stautus }}">{{ trans('translation.'. $key) }}</label>
                                    @endforeach
                                </div>
                                  <div class="col-12 col-md-6">
                                    <div class="col-md-4 float-end">
                                        <a class="btn btn-success float-end" href="{{route('admin.services.notices.register')}}"> @lang('translation.Notice_registration')</a>
                                    </div>    
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-4">
                            <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                                <div class="col-12 col-md-2">
                                    <button class="btn btn-info waves-effect waves-light active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_change_status">@lang('translation.Status_Change')</button>
                                </div>
                                <div class="col-12 col-md-2">
                                    <button class="btn btn-secondary ms-2 active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_delete_notice"> @lang('translation.Delete')</button>
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
                        <form class="setting_notice_table">
                            <table id="notice_table" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="all_age" name="somecheckbox" class="checkbox_all">
                                        </th>
                                        <th>@lang('translation.Notice_title')</th>
                                        <th>@lang('translation.Registration_date')</th>
                                        <th>@lang('translation.views')</th>
                                        <th>@lang('translation.Post_status')</th>
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
    <div id="modal_delete_notice" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_delete_notice_la_bel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Delete_Member')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('translation.Cannot_restore_notices_when_delete_Are_you_sure_you_want_to_remove')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light delete_notice"
                        data-bs-dismiss="modal">@lang('translation.Yes')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">@lang('translation.No')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->

    <div id="modal_change_status" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_change_status_admin_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Status_Change')</h5>
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
    <script>
        $(function() {
            var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
            var notice_table = $('#notice_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.services.notices.fetchData') !!}",
                    data: function(d) {
                        var notice_filter_form = new FormData($('form#notice_filter_form')[0]);
                        d.search = notice_filter_form.get('search'),
                        d.list_post_status = notice_filter_form.getAll('post_status')
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'registration_date',
                        name: 'registration_date'
                    },
                    {
                        data: 'views',
                        name: 'views'
                    },
                    {
                        data: 'ad_status_name',
                        name: 'ad_status_name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                columnDefs: [
                    {orderable: false, targets: 5 },
                ],
                order: [[3, 'asc']],
            });
            $('form#notice_filter_form input:checkbox').on('change', function() {
                if($('#all_status_member').is(':checked')){
                    $('input[name="post_status"]').prop('disabled', true);
                }else{
                    $('input[name="post_status"]').prop('disabled', false);
                }
                if($('input[name="post_status"]').is(':checked')){
                    $('#all_status_member').prop('disabled', true);
                }else{
                    $('#all_status_member').prop('disabled', false);
                }
                notice_table.draw();
            });
            $('form#notice_filter_form input[name="search"]').on('keyup', function() {
                notice_table.draw();
            })
            $('button.delete_notice').on('click', function() {
                var notices = []
                $("input[name='notice_id[]']:checked").each(function() {
                    notices.push(parseInt($(this).val()));
                });
                if (notices.length === 0) {
                    return false;
                }
                data = {
                    notices: notices
                };
                $.ajax({
                    url: '{{ route('admin.services.notices.delete') }}',
                    datatype: "html",
                    type: "delete",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        notificationSwal(response.status);
                        $('.active_with_checkbox').prop('disabled', true);
                        notice_table.draw();
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
                    var notices = []
                    $("input[name='notice_id[]']:checked").each(function() {
                        notices.push(parseInt($(this).val()));
                    });
                    if (notices.length === 0) {
                        return false;
                    }   
                    data = {
                        status: status,
                        notices: notices,
                    };
                    $.ajax({
                        url: '{{ route('admin.services.notices.changeStatus') }}',
                        datatype: "html",
                        type: "put",
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            notificationSwal(response.status);
                            $('.active_with_checkbox').prop('disabled', true);
                            notice_table.draw();
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


  