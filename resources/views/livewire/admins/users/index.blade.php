@extends('layouts.master')
@section('title')
    @lang('translation.Members_List')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        input[type="checkbox"], input[type="search"]::-webkit-search-cancel-button, .checkbox_all {cursor: pointer;}
    </style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle')
             @lang('translation.Home')
        @endslot
        @slot('childrenTitle')
          @lang('translation.Manage_Member')
        @endslot
         @slot('title')
             @lang('translation.Members_List')
        @endslot
    @endcomponent
    <div class="filter_datatable_wrap">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body user_filter">
                        <form id="users_filter_form">
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
                                    <strong>@lang('translation.Status_Member')</strong>
                                    <input class="ms-2" type="checkbox" id="all_status_member" />
                                    <label for="all_status_member"> @lang('translation.All')</label>
                                    @foreach ($status_users as $key => $status_user)
                                        <input class="ms-2" type="checkbox" id="status_member_{{$status_user}}"
                                            name="status_member" value="{{ $status_user }}" />
                                        <label for="status_member_{{$status_user}}">{{ trans('translation.'.$key) }}</label>
                                    @endforeach
                                </div>
                                <div class="col-12 col-md-6">
                                    <strong>@lang('translation.Nation')</strong>
                                    <input class="ms-2" type="checkbox" id="all_two">
                                    <label for="all_two"> @lang('translation.All')</label>
                                    @foreach ($nations as $nation)
                                        <input class="ms-2" type="checkbox" id="{{ $nation->name }}" name="nation"
                                            value="{{ $nation->id }}" />
                                        <label for="{{ $nation->name }}">{{ $nation->name }}</label>
                                    @endforeach
                                    <input class="ms-2" type="checkbox" id="Etc" value="Etc">
                                    <label for="Etc"> @lang('translation.Etc')</label>
                                </div>
    
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6">
                                    <strong>@lang('translation.Gender')</strong>
                                    <input class="ms-2" type="checkbox" id="all_gender">
                                    <label for="all_gender"> @lang('translation.All')</label>
                                    @foreach ($genders as $key => $gender)
                                        <input class="ms-2" type="checkbox" id="{{ $key }}" name="gender"
                                            value="{{ $gender }}" />
                                        <label for="{{ $key }}">{{ trans('translation.'. $key)   }}</label>
                                    @endforeach
                                     <input class="ms-2" type="checkbox" id="@lang('translation.Unchecked')" name="gender"
                                            value="3" />
                                        <label for="@lang('translation.Unchecked')">@lang('translation.Unchecked')</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <strong>@lang('translation.Age')</strong>
                                    <input class="ms-2" type="checkbox" id="all_age">
                                    <label for="all_age"> @lang('translation.All')</label>
                                    @foreach ($ages as $key => $age)
                                        <input class="ms-2" type="checkbox" id="{{ $age }}" name="age"
                                            value="{{ $age }}">
                                        <label for="{{ $age }}"> {{ $age }}@lang('translation.Year') </label>
                                    @endforeach
                                    <input class="ms-2" type="checkbox" id="etc_age" value="etc_age">
                                    <label for="etc_age">@lang('translation.Etc')</label>
                                </div>
                            </div>
                        </form>
                        <div class="col-8 mt-4">
                            <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                                <div class="col-6 col-md-2 px-0">
                                    <button class="btn btn-info waves-effect waves-light active_with_checkbox" data-bs-toggle="modal"
                                        data-bs-target="#modal_change_status_user" disabled>@lang('translation.Status_Change')</button>
                                </div>
                                <div class="col-6 col-md-2 px-0">
                                    <button class="btn btn-secondary ms-2 active_with_checkbox" data-bs-toggle="modal"
                                    data-bs-target="#modal_delete_user" disabled> @lang('translation.Delete')</button>
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
                        <form class="setting_user_table">
                            <table id="user_table" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="all_age" name="somecheckbox" class="checkbox_all">
                                        </th>
                                        <th>@lang('translation.id')</th>
                                        <th>@lang('translation.Name')</th>
                                        <th>@lang('translation.Nation')</th>
                                        <th>@lang('translation.Gender')</th>
                                        <th>@lang('translation.Age')</th>
                                        <th>@lang('translation.Joining_Form')</th>
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
    </div>  <!-- end filter_datatable_wrap -->

    <div id="modal_delete_user" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_delete_user_la_bel" aria-hidden="true">
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
                    <button type="button" class="btn btn-success waves-effect waves-light delete_user"
                        data-bs-dismiss="modal">@lang('translation.Yes')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">@lang('translation.No')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->

    <div id="modal_change_status_user" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_change_status_user_label" aria-hidden="true">
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
                        @foreach ($status_users as $key => $status)
                            <option value="{{ $status }}">{{ trans('translation.'.$key) }}</option>
                        @endforeach
                    </select>  
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success waves-effect waves-light setting_change_status_user"
                        data-bs-dismiss="modal">@lang('translation.Setting')</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-bs-dismiss="modal">@lang('translation.Cancel')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(function() {
            var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
            var user_table = $('#user_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.users.fetchData') !!}",
                    data: function(d) {
                        var userFilterData = new FormData($('form#users_filter_form')[0]);
                        d.search = userFilterData.get('search'),
                            d.status_members = userFilterData.getAll('status_member'),
                            d.nations = userFilterData.getAll('nation'),
                            d.genders = userFilterData.getAll('gender'),
                            d.ages = userFilterData.getAll('age')
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
                        data: 'nation_name',
                        name: 'nation_name'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'joining_form_name',
                        name: 'joining_form_name'
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
                        name: 'action',
                    },

                ],
                columnDefs: [
                    {orderable: false, targets: 9 },
                ],
                order: [[1, 'desc']],
            });

            $('form#users_filter_form input:checkbox').on('change', function() {
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
                // Nation
                if($('#all_two').is(':checked')){
                    $('input[name="nation"]').prop('disabled', true);
                    $('input[id="Etc"]').prop('disabled',true);
                }else{
                    $('input[name="nation"]').prop('disabled', false);
                    $('input[id="Etc"]').prop('disabled',false);
                }
                if($('input[name="nation"]').is(':checked')  || $('input[id="Etc"]').is(':checked')){
                    $('input[id="all_two"]').prop('disabled', true);
                }else{
                    $('input[id="all_two"]').prop('disabled', false);
                }
                if($('#all_gender').is(':checked')){
                    $('input[name="gender"]').prop('disabled', true);
                }else{
                    $('input[name="gender"]').prop('disabled', false);
                }
                if($('input[name="gender"]').is(':checked')){
                    $('#all_gender').prop('disabled', true);
                }else{
                    $('#all_gender').prop('disabled', false);
                }
                if($('#all_age').is(':checked')){
                    $('input[name="age"]').prop('disabled', true);
                    $('#etc_age').prop('disabled', true)
                }else{
                    $('input[name="age"]').prop('disabled', false);
                    $('#etc_age').prop('disabled',false);
                }
                if( $('input[name="age"]').is(':checked') || $('#etc_age').is(':checked')){
                    $('#all_age').prop('disabled', true)
                   
                }else{
                    $('#all_age').prop('disabled', false)
                   
                }
                user_table.draw();
            });

            $('form#users_filter_form input[name="search"]').on('keyup', function() {
                user_table.draw();
            })

            $('button.delete_user').on('click', function() {
                var users = []
                $("input[name='user_id[]']:checked").each(function() {
                    users.push(parseInt($(this).val()));
                });
                    if(users.length === 0){
                        return false;
                    }
                data = {
                    users: users
                };
                $.ajax({
                    url: '{{ route('admin.users.deleteUser') }}',
                    datatype: "html",
                    type: "delete",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        notificationSwal(response.status);
                        $('.active_with_checkbox').prop('disabled', true);
                        user_table.draw();
                        $(".checkbox_all").prop('checked', false); 
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            })
            $('.setting_change_status_user').on('click', function(){
                status_user = parseInt($('.modal-body select[name="change_status_member"]').val()) ;
                if(!status_user){
                    return false;
                }
                var users = []
                $("input[name='user_id[]']:checked").each(function() {
                    users.push(parseInt($(this).val()));
                });
                data = {
                    status_user: status_user,
                    users : users,
                };
                $.ajax({
                    url: '{{ route('admin.users.changeStatusMember') }}',
                    datatype: "html",
                    type: "put",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        notificationSwal(response.status);
                        $('.active_with_checkbox').prop('disabled', true);
                        user_table.draw();
                        $(".checkbox_all").prop('checked', false); 
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            })

        });
    </script>
@endsection
