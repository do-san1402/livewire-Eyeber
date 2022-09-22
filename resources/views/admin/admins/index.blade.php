@extends('layouts.master')
@section('title')
    @lang('translation.Admin_List')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>input[type="checkbox"], input[type="search"]::-webkit-search-cancel-button, .checkbox_all {cursor: pointer;}</style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle')
            @lang('translation.Home')
        @endslot
        @slot('MenuTitle')
            @lang('translation.Admin_Menu')
        @endslot
        @slot('childrenTitle')
            @lang('translation.Admin_Manager')
        @endslot
        @slot('title')
            @lang('translation.Admin_List')
        @endslot
    @endcomponent
    <div class="filter_datatable_wrap">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body user_filter">
                        <form id="admins_filter_form">
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
                                <div class="col-md-8">
                                    <strong>@lang('translation.Status_Member')</strong>
                                    <input class="ms-2" type="checkbox" id="all_status_member" />
                                    <label for="all_status_member"> @lang('translation.All')</label>
                                    @foreach ($status_users as $key => $status_user)
                                        <input class="ms-2" type="checkbox" id="status_member_{{ $status_user }}"
                                            name="status_member" value="{{ $status_user }}" />
                                        <label for="status_member_{{ $status_user }}">{{ trans('translation.'.$key) }}</label>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-success ms-2 active_with_checkbox float-end" href="{{route('admin.admins.create')}}"> @lang('translation.Admin_Registration')</a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <strong>@lang('translation.Rank_Classification')</strong>
                                    <input class="ms-2" type="checkbox" id="all_rank" />
                                    <label for="all_rank"> @lang('translation.All')</label>
                                    @foreach ($ranks as $rank)
                                        <input class="ms-2" type="checkbox" id="{{ $rank->name }}" name="ranks"
                                            value="{{ $rank->id }}" />
                                        <label for="{{ $rank->name }}">{{ $rank->name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-4">
                            <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                                <div class="col-md-2">
                                    <button class="btn btn-info waves-effect waves-light active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_change_status_admin">@lang('translation.Status_Change')</button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-secondary ms-2 active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_delete_admin"> @lang('translation.Delete')</button>
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
                        <form class="setting_admin_table">
                            <table id="admin_table" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="all_age" name="somecheckbox" class="checkbox_all">
                                        </th>
                                        <th>@lang('translation.id')</th>
                                        <th>@lang('translation.Name')</th>
                                        <th>@lang('translation.Contract')</th>
                                        <th>@lang('translation.Rank')</th>
                                        <th>@lang('translation.Date_of_Joining')</th>
                                        <th>@lang('translation.Status_Member')</th>
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
    <div id="modal_delete_admin" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_delete_admin_la_bel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Delete_Member')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('translation.Cannot_restore_account_when_delete_Are_you_sure_you_want_to_remove')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light delete_admin"
                        data-bs-dismiss="modal">@lang('translation.Yes')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">@lang('translation.No')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->

    <div id="modal_change_status_admin" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_change_status_admin_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Status_Member')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-select" name="change_status_member">
                        <option>@lang('translation.Select_state_value')</option>
                        @foreach ($status_users as  $key => $status)
                            <option value="{{ $status }}">{{ trans('translation.'.$key) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger waves-effect"
                        data-bs-dismiss="modal">@lang('translation.Cancel')</button>
                    <button type="button" class="btn btn-success waves-effect waves-light setting_change_status_admin"
                        data-bs-dismiss="modal">@lang('translation.Setting')</button>
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
            var admin_table = $('#admin_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.admins.fetchData') !!}",
                    data: function(d) {
                        var userFilterData = new FormData($('form#admins_filter_form')[0]);
                        d.search = userFilterData.get('search'),
                            d.status_members = userFilterData.getAll('status_member'),
                            d.ranks = userFilterData.getAll('ranks')
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nick_name',
                        name: 'nick_name'
                    },
                    {
                        data: 'number_phone',
                        name: 'number_phone'
                    },
                    {
                        data: 'rank_name',
                        name: 'rank_name'
                    },
                    {
                        data: 'date_of_joining',
                        name: 'date_of_joining'
                    },
                    {
                        data: 'status_user_name',
                        name: 'status_user_name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                columnDefs: [
                    {orderable: false, targets: 7 },
                ],
                order: [[1, 'desc']],
            });
            $('form#admins_filter_form input:checkbox').on('change', function() {
                // Status
                if($('#all_status_member').is(':checked')){
                    $('input[name="status_member"]').prop('disabled', true);
                }else{
                    $('input[name="status_member"]').prop('disabled', false);
                }
                if($('input[name="status_member"]').is(':checked')){
                    $('#all_status_member').prop('disabled', true);
                }else{
                    $('#all_status_member').prop('disabled', false);
                }
                // Rank
                if($('#all_rank').is(':checked')){
                    $('input[name="ranks"]').prop('disabled', true);
                }else{
                    $('input[name="ranks"]').prop('disabled', false);
                }
                if($('input[name="ranks"]').is(':checked')){
                    $('#all_rank').prop('disabled', true);
                }else{
                    $('#all_rank').prop('disabled', false);
                }
                admin_table.draw();
            });
            $('form#admins_filter_form input[name="search"]').on('keyup', function() {
                admin_table.draw();
            })
            $('button.delete_admin').on('click', function() {
                var users = []
                $("input[name='user_id[]']:checked").each(function() {
                    users.push(parseInt($(this).val()));
                });
                if (users.length === 0) {
                    return false;
                }
                data = {
                    users: users
                };
                $.ajax({
                    url: '{{ route('admin.admins.deleteAdmin') }}',
                    datatype: "html",
                    type: "delete",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        notificationSwal(response.status);
                        $('.active_with_checkbox').prop('disabled', true);
                        admin_table.draw();
                        $(".checkbox_all").prop('checked', false); 
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            })
            $('button.setting_change_status_admin').on('click', function() {
                    console.log(134);
                    status_user = parseInt($('.modal-body select[name="change_status_member"]').val());
                    if (!status_user) {
                        return false;
                    }
                    var users = []
                    $("input[name='user_id[]']:checked").each(function() {
                        users.push(parseInt($(this).val()));
                    });
                    data = {
                        status_user: status_user,
                        users: users,
                    };
                    $.ajax({
                        url: '{{ route('admin.admins.changeStatusAdmin') }}',
                        datatype: "html",
                        type: "put",
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            notificationSwal(response.status);
                            $('.active_with_checkbox').prop('disabled', true);
                            admin_table.draw();
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
