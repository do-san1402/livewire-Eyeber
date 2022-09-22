@extends('layouts.master')
@section('title')
    @lang('translation.Admin_List')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
            @lang('translation.Coin_deposit_and_withdrawal_status')
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
                                    <strong>@lang('translation.status_classification')</strong>
                                    <input class="ms-2" type="checkbox" id="all_status_member" />
                                    <label for="all_status_member"> @lang('translation.All')</label>
                                    @foreach ($status_classification_coins as $key => $status_classification_coin)
                                        <input class="ms-2" type="checkbox" id="status_member_{{ $status_classification_coin }}"
                                            name="status_classification" value="{{ $status_classification_coin }}" />
                                        <label for="status_member_{{ $status_classification_coin }}">{{ trans('translation.'.$key) }}</label>
                                    @endforeach
                                </div>
                                <div class="col-md-8">
                                    <strong>@lang('translation.Withdrawal_Status')</strong>
                                    <input class="ms-2" type="checkbox" id="all_withdrawal_status" />
                                    <label for="all_withdrawal_status"> @lang('translation.All')</label>
                                    @foreach ($status_log_coins as $key => $status_log_coin)
                                        <input class="ms-2" type="checkbox" id="withdrawal_status_{{ $status_log_coin }}"
                                            name="withdrawal_status" value="{{ $status_log_coin }}" />
                                        <label for="withdrawal_status_{{ $status_log_coin }}">{{ trans('translation.'.$key) }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
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
                                        <th>@lang('translation.status_classification')</th>
                                        <th>@lang('translation.date')</th>
                                        <th>@lang('translation.id')</th>
                                        <th>@lang('translation.coin')</th>
                                        <th>@lang('translation.Amount')</th>
                                        <th>@lang('translation.Processing_Date')</th>
                                        <th>TXLD</th>
                                        <th>@lang('translation.status')</th>
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
                    url: "{!! route('admin.coins.log.fetchData') !!}",
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
                        data: 'status_classification_coin',
                        name: 'status_classification_coin',
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
                        data: 'status_log_coin',
                        name: 'status_log_coin'
                    }
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
        });
    </script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
