@extends('layouts.master')
@section('title')
    @lang('translation.Admin_List')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        th,td{
            line-break: loose ;
            max-width: 100px;
            text-overflow: ellipsis;
        }
        .dataTable > thead > tr > th[class*="sort"]:before,
        .dataTable > thead > tr > th[class*="sort"]:after {
            content: "" !important;
        }
    </style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle')
            @lang('translation.Home')
        @endslot
        @slot('MenuTitle')
            @lang('translation.Deposit_and_withdrawal_Management')
        @endslot
        @slot('title')
            @lang('translation.Witdraw_confirm')
        @endslot
       
    @endcomponent
    <div class="filter_datatable_wrap">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body user_filter">
                        <form id="coin_log_filter_form">
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
                                <div class="col-md-4">
                                    <strong>@lang('translation.coin')</strong>
                                    <input class="ms-2" type="checkbox" id="all_rank" />
                                    <label for="all_rank"> @lang('translation.All')</label>
                                    @foreach ($coins as $coin)
                                        <input class="ms-2" type="checkbox" id="coin_{{ $coin->id }}" name="coin"
                                            value="{{ $coin->id }}" />
                                        <label for="coin_{{ $coin->id }}">{{ $coin->symbol_name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                        <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                            <div class="col-12">
                                <button class="btn btn-info waves-effect waves-light active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_change_status_advertisement">@lang('translation.Witdraw_confirm')</button>
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
                        <form class="setting_coin_log_table">
                            <table id="coin_log_table" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="all_age" name="somecheckbox" class="checkbox_all"></th>
                                        <th>@lang('translation.date')</th>
                                        <th>@lang('translation.id')</th>
                                        <th>@lang('translation.coin')</th>
                                        <th>@lang('translation.Amount')</th>
                                        <th>@lang('translation.Processing_Date')</th>
                                        <th>TXLD</th>
                                        <th>@lang('translation.Witdraw_status')</th>
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
    
    <div id="modal_change_status_advertisement" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_change_status_advertisement_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Witdraw_status')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="hidden" id="Witdraw_status_id" >
                    <select class="form-select" name="status">
                        <option>@lang('translation.Select_state_value')</option>
                    @foreach ( $confirms as $key => $confirm )
                        <option value="{{$confirm}}">@lang('translation.'. $key)</option>
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
            var coin_log_table = $('#coin_log_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.coins.log.fetchDataWitdraw') !!}",
                    data: function(d) {
                        var coinLogFilterData = new FormData($('form#coin_log_filter_form')[0]);
                        d.search = coinLogFilterData.get('search'),
                        d.status_classification = coinLogFilterData.getAll('status_classification'),
                        d.coin = coinLogFilterData.getAll('coin'),
                        d.withdrawal_status = coinLogFilterData.getAll('withdrawal_status')
                    }
                },
                columns: [
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date_start',
                        name: 'date_start'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'coin_name',
                        name: 'coin_name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'date_end',
                        name: 'date_end'
                    },
                    {
                        data: 'txld',
                        name: 'txld'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    
                ],
                columnDefs: [
                    {orderable: false, targets: '_all'},
                ]
            });

            $('form#coin_log_filter_form input:checkbox').on('change', function() {
                // Status
                if($('#all_status_member').is(':checked')){
                    $('input[name="status_classification"]').prop('disabled', true);
                }else{
                    $('input[name="status_classification"]').prop('disabled', false);
                }
                if($('input[name="status_classification"]').is(':checked')){
                    $('#all_status_member').prop('disabled', true);
                }else{
                    $('#all_status_member').prop('disabled', false);
                }
                // Coin
                if($('#all_rank').is(':checked')){
                    $('input[name="coin"]').prop('disabled', true);
                }else{
                    $('input[name="coin"]').prop('disabled', false);
                }
                if($('input[name="coin"]').is(':checked')){
                    $('#all_rank').prop('disabled', true);
                }else{
                    $('#all_rank').prop('disabled', false);
                }
                //Withdrawal Status 
                if($('#all_withdrawal_status').is(':checked')){
                    $('input[name="withdrawal_status"]').prop('disabled', true);
                }else{
                    $('input[name="withdrawal_status"]').prop('disabled', false);
                }
                if($('input[name="withdrawal_status"]').is(':checked')){
                    $('#all_withdrawal_status').prop('disabled', true);
                }else{
                    $('#all_withdrawal_status').prop('disabled', false);
                }
                coin_log_table.draw();
            });
            
            $('form#coin_log_filter_form input[name="search"]').on('keyup', function() {
                coin_log_table.draw();
            })
            $('button.setting_change_status').on('click', function() {

                    status = parseInt($('.modal-body select[name="status"]').val());
                
                    if (!status) {
                        return false;
                    }
                    var coinLog = []
                    $("input[name='coin_log[]']:checked").each(function() {
                        coinLog.push(parseInt($(this).val()));
                    });
                    data = {
                        status: status,
                        coinLog: coinLog,
                        coinLogId:  $('#Witdraw_status_id').val()
                    };
                    $.ajax({
                        url: '{{ route('admin.coins.log.witdrawConfirm') }}',
                        datatype: "html",
                        type: "put",
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            notificationSwal(response.status);
                            $('.active_with_checkbox').prop('disabled', true);
                            coin_log_table.draw();
                            $(".checkbox_all").prop('checked', false); 
                        },
                        error: function(error) {
                        },
                    })
                })
            });
           function confirm_only_one(coin_log_id){
                $('#Witdraw_status_id').val(coin_log_id);
            }
            $('.active_with_checkbox').on('click', function(){
                $('#Witdraw_status_id').val('');
            })
   
    </script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
