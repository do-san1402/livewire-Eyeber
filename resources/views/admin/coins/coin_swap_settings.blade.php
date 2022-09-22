@extends('layouts.master')
@section('title') @lang('translation.Dashboard') 

@endsection
@section('css')
    <!-- DataTables -->
    <style>
        .cusor-hand{
            cursor:pointer
        }
    </style>
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pageTitle')
        @lang('translation.Home')
    @endslot
    @slot('title')@lang('translation.Coin_swap_settings')@endslot
    @slot('childrenTitle') @lang('translation.Status_Coins') @endslot
@endcomponent 
    <div class="row">
        <div class="col-xl-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table table-responsive table-sm ">
                        <table id="coin_table" class="table table-borderless table-centered table-nowrap ">
                            <tbody id="coin_tbody" class="cusor-hand">
                                @foreach($coins as $coin )
                                    <tr id="{{$coin->id}}" class="{{$coin->id === 1 ? 'table-active' : ''}} ">
                                        @if($coin->image)
                                        <td ><img src="{{ url('/storage/images/coins/' . $coin->image) }}" class="avatar-xs rounded-circle " alt=""></td>
                                        @else
                                        <td ><img src="{{ $image_default }}" class="avatar-xs rounded-circle " alt=""></td>
                                        @endif    
                                        <td>
                                            <p class="text-muted font-size-11 mb-0"></i>{{$coin->symbol_name}}</p>
                                            <h6 class="font-size-14 mb-1 fw-normal  {{$coin->id === 1 ? 'text-white' : ''}}">{{$coin->name}}</h6>
                                        </td>
                                        <td class="text-muted fw-semibold text-end pb-0">{{$coin->admin_wallet->amount}}</td>
                                    </tr>
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-sm-6">
            <div class="card mb-0">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Coin_swap_settings')</h4>
                    <div class="card-body" id="coin_detail">
                        <div class="clearfix align-items-center d-flex">
                            <input type="hidden" class="hidden" value="{{$coin_present->id}}" name="coin_id" />
                            @if($coin_present->image)
                                <img src="{{ url('/storage/images/coins/' . $coin_present->image) }}" alt="" class="avatar-lg rounded-circle img-thumbnail float-start">
                                <div class="px-4">
                                    <h6 class="font-weight-bold mb-0"></i>{{$coin_present->symbol_name}}</h6>
                                    <h4 class="font-weight-bold mb-0">{{$coin_present->name}}</h4>
                                </div>
                            @else
                                <img src="{{ $image_default }}" alt="" class="avatar-lg rounded-circle img-thumbnail float-start">
                                <div class="px-4">
                                    <h6 class="font-weight-bold mb-0"></i>{{$coin_present->symbol_name}}</h6>
                                    <h4 class="font-weight-bold mb-0">{{$coin_present->name}}</h4>
                                </div>
                            @endif
                        </div>
                        <form id="saveCoinSwap"  onsubmit = "return validate_coin()">
                            <div class="mb-3 row mt-4" >
                                <label for="name-coin-input" class="col-md-4 col-form-label">@lang('translation.Swap_minimum_quantity')</label>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="number" class="form-control" name="min_value" value="{{$min_value}}" id="name-coin-input">
                                        </div>
                                        <label class="col-md-2 col-form-label">{{$coin_present->symbol_name}}</label>
                                    </div>
                                    <p class="text-danger d-none" id='coin_min'>{{trans('translation.Please_enter_swap_minimum')}}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="symbol-coin-input" class="col-md-4 col-form-label">@lang('translation.Commission')</label>
                                <div class="col-md-8">
                                    <div class="row">
                                        <label class="col-md-3 col-form-label" for="price_bmt">1 {{$coin_present->symbol_name}} @lang('translation.Party')</label>
                                        <div class="col-md-9">
                                            @foreach($receive_list as $key => $receive)
                                            
                                                <div class="row mt-2 div-receive">
                                                    <input type="hidden" class="hidden" name="coin_receive_id[]" value="{{$receive['coin_receive']}}">
                                                        <div class="col-md-10">
                                                            <input step="any" class="form-control" type="number" name="coin_receive[]" value="{{$receive['rate']}}" id="price_bmt">
                                                            <p class="text-danger d-none">{{trans('translation.Please_enter_value')}}</p>
                                                        </div>
                                                        <label class="col-md-2 col-form-label">{{$receive['symbol_name']}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div>
                                <div class="float-end ms-2">
                                    <a class="btn btn-success waves-effect float-end" onclick="submitCoin()">@lang('translation.Save')</a>
                                </div>
                                <div class="float-end">
                                    <a onclick="reset()" class="btn btn-secondary waves-effect float-end">@lang('translation.reset')</a>
                                </div>
                            </div>
                        </form>
                    </div>          
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
       <!-- apexcharts -->
       <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
       <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
       <script>

            var image_default = "{{$image_default}}";
            var coin_present = "{{$coin_present->id}}"

            $('#coin_table tbody#coin_tbody').on('click', 'tr', function(){
                data = {
                    coin_id : $(this).attr('id')
                };
                $('#coin_table tbody tr.table-active').removeClass('table-active');
                $('#coin_table tbody tr .font-size-14').removeClass('text-white');
                $(this).addClass('table-active');
                $(this).find('.font-size-14').addClass('text-white');

                $.ajax({
                    url: '{{ route('admin.coins.detailCoinSwapSetting') }}',
                    datatype: "html",
                    type: "POST",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        detail(response.data.coin ,response.data.receive_list, response.data.min_value )
                    },
                    error: function(error) {
                    },
                })
            })

            function validate_coin(){
                let valid = true;
                min_value =  $('input[name="min_value"]').val();
                if(!min_value){
                    valid = false;
                   $('#coin_min').removeClass("d-none");
                }else{
                    $('#coin_min').addClass("d-none");
                }
                $('.div-receive').each (function() {
                  if(!$(this).find('input.form-control').val()){
                    valid = false;
                    $(this).find('p.text-danger').removeClass("d-none");
                  }else{
                    $(this).find('p.text-danger').addClass("d-none");
                    }   
                });
                return valid;      
            }

            function submitCoin() {
                validate = validate_coin();
                if(!validate){
                    return false;
                }
                dataform = new FormData($('#saveCoinSwap')[0])
                console.log(dataform);
                data = {
                    'coin_exchange' : $('input[name="coin_id"]').val(),
                    'coin_receive_rates' : dataform.getAll('coin_receive[]'),
                    'coin_receive_ids': dataform.getAll('coin_receive_id[]'),
                    'min': $('input[name="min_value"]').val()

                }
                $.ajax({
                    url: '{{ route('admin.coins.updateSwapSetting') }} ',
                    datatype: "html",
                    type: "POST",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        detail(response.data.coin ,response.data.receive_list, response.data.min_value )
                        notificationSwal(response.status);
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            }
            function detail(coin, receive_list,min_value ){
                coin_detail_html = `<div class="clearfix align-items-center d-flex">
                                            <input type="hidden" class="hidden" value="${coin.id}" name="coin_id" />
                                            <img src="${coin.image_url ? coin.image_url : image_default}" alt="" class="avatar-lg rounded-circle img-thumbnail float-start">
                                                <div class="px-4">
                                                    <h6 class="font-weight-bold mb-0"></i>${coin.symbol_name}</h6>
                                                    <h4 class="font-weight-bold mb-0">${coin.name}</h4>
                                                </div>
                                    </div>`;
                coin_detail_html += `<form  id="saveCoinSwap"  onsubmit = "return validate_coin()">
                                        <div class="mb-3 row mt-4" >
                                            <label for="name-coin-input" class="col-md-4 col-form-label">@lang('translation.Swap_minimum_quantity')</label>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="number" class="form-control" name="min_value" value="${min_value}" id="name-coin-input">
                                                    </div>
                                                    <label class="col-md-2 col-form-label">${coin.symbol_name}</label>
                                                </div>
                                                <p class="text-danger d-none" id='coin_min'>{{trans('translation.Please_enter_swap_minimum')}}</p>
                                            </div>
                                        </div>`                       
                coin_detail_html += ` <div class="mb-3 row">
                                        <label for="symbol-coin-input" class="col-md-4 col-form-label">@lang('translation.Commission')</label>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-3 col-form-label" for="price_bmt">1 ${coin.symbol_name} @lang('translation.Party')</label>
                                                <div class="col-md-9">`
                for( let receive of receive_list){
                    coin_detail_html += `<div class="row mt-2 div-receive">
                                            <input type="hidden" class="hidden" name="coin_receive_id[]" value="${receive.coin_receive}">
                                                        <div class="col-md-9">
                                                            <input step="any" class="form-control" id="valid_first" type="number" name="coin_receive[]" value="${receive.rate}" id="price_bmt">
                                                            <p class="text-danger d-none" id='coin_first'>{{trans('translation.Please_enter_value')}}</p>
                                                        </div>
                                                        <label class="col-md-3 col-form-label">${receive.symbol_name}</label>
                                                </div>`  
                }
                coin_detail_html += `</div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div>
                                        <div class="float-end ms-2">
                                            <a type="submit" class="btn btn-success waves-effect float-end" onclick="submitCoin()">@lang('translation.Save')</a>
                                        </div>
                                        <div class="float-end">
                                            <a onclick="reset()" class="btn btn-secondary waves-effect float-end">@lang('translation.reset')</a>
                                        </div>
                                    </div>
                                </form>`                                    
                $('#coin_detail').html(coin_detail_html);
            }
            
            function reset(){
                location.reload(true);
            }
       </script>
@endsection
