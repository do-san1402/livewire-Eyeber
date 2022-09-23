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
      <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pageTitle')
        @lang('translation.Home')
    @endslot
    @slot('title')@lang('translation.Manage_Coin')@endslot
    @slot('childrenTitle') @lang('translation.Status_Coins') @endslot
@endcomponent 
    <div class="row">
        <div class="col-xl-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table table-responsive table-sm ">
                        <table id="coin_table" class="table table-borderless table-centered table-nowrap ">
                            <tbody id="coin_tbody" class="cusor-hand">
                                @foreach($coins as $coin_value)
                                    <tr id="{{$coin_value->id}}" class="{{$coin_value->id === 1 ? 'table-active' : ''}} ">
                                        @if($coin_value->image)
                                        <td ><img src="{{ url('/storage/images/coins/' . $coin_value->image) }}" class="avatar-xs rounded-circle " alt=""></td>
                                        @else
                                        <td ><img src="{{ $image_default }}" class="avatar-xs rounded-circle " alt=""></td>
                                        @endif    
                                        <td>
                                            <p class="text-muted font-size-11 mb-0"></i>{{$coin_value->symbol_name}}</p>
                                            <h6 class="font-size-14 mb-1 fw-normal  {{$coin_value->id === 1 ? 'text-white' : ''}}">{{$coin_value->name}}</h6>
                                        </td>
                                        <td class="text-muted fw-semibold text-end pb-0">{{$coin_value->admin_wallet->amount}}</td>
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
                    <h4 class="card-title">@lang('translation.Coin_details')</h4>
                    <div class="card-body" id="coin_detail">
                        <div class="text-center">
                            <input type="hidden" class="hidden" value="{{$coin->id}}" name="coin_id" />
                            @if($coin->image)
                            <input type="file" name="image" class="hidden" id="upload_file_input" onchange="upload_image()" class="form-control">
                                <img src="{{ url('/storage/images/coins/' . $coin->image) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-1 float-end Delete_image" onclick="Delete_image()">@lang('translation.Delete_image')</button>
                                <a class="btn btn-success waves-effect waves-light mb-1 float-end d-none Image_change" onclick="change_image()">@lang('translation.Image_change')</a>
                            @else
                                <input type="file" name="image" class="hidden" id="upload_file_input" class="form-control" onchange="upload_image()">
                                <img src="{{ $image_default }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                <a class="btn btn-success waves-effect waves-light mb-1 float-end Image_change" onclick="change_image()">@lang('translation.Image_change')</a>
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-1 float-end d-none Delete_image" onclick="Delete_image()">@lang('translation.Delete_image')</button>
                            @endif
                        </div>
                        <p class="text-danger d-none" id="image_validate">{{trans('translation.please_select_the_correct_format_image')}}</p>
                        <div class="mb-3 row mt-4">
                            <label for="name-coin-input" class="col-md-4 col-form-label">@lang('translation.Name_coin')</label>
                            <div class="col-md-8">
                                <input class="form-control" name="name" type="text" value="{{$coin->name}}" id="name-coin-input">
                                <p class="text-danger d-none" id='coin_name'>{{trans('translation.Please_enter_name')}}</p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="symbol-coin-input" class="col-md-4 col-form-label">@lang('translation.Symbol_coin')</label>
                            <div class="col-md-8">
                                <input class="form-control " type="text" name="symbol_name" value="{{$coin->symbol_name}}" id="symbol-coin-input">
                                <p class="text-danger d-none" id='coin_symbol_name'>{{trans('translation.Please_enter_symbol_name')}}</p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="quantity-coin-input" class="col-md-4 col-form-label">@lang('translation.Quantity_coin')</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" value="{{$coin->admin_wallet->amount}}" id="quantity-coin-input" disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">@lang('translation.Status_coin')</label>
                            <div class="col-md-8">
                                <select class="form-select"  name="status"> 
                                    <option value="{{config('apps.common.status_wallet.not_activate')}}" {{$coin->admin_wallet->status == config('apps.common.status_wallet.not_activate') ? 'selected': ''}}>@lang('translation.not_activate')</option>
                                    <option value="{{config('apps.common.status_wallet.activate')}}"  {{$coin->admin_wallet->status == config('apps.common.status_wallet.activate') ? 'selected': ''}}>@lang('translation.activate')</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="float-end ms-2">
                                <button type="submit" class="btn btn-success waves-effect float-end" onclick="update_coin()">@lang('translation.Save')</button>
                            </div>
                            <div class="float-end">
                                <a onclick="reset()" class="btn btn-secondary waves-effect float-end">@lang('translation.reset')</a>
                            </div>
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 mt-4 row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                        <h4 class="card-title">@lang('translation.Coin_status_current')</h4>
                        <div class="row">
                            <div class="col-md-4 pb-4">
                                <input type="search" placeholder="@lang('translation.Enter_a_search_term')" class="form-control"
                                    name="search" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary waves-effect waves-light">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table table-responsive table-sm">    
                            <table id="wallet_table" class="table dt-responsive table-bordered "style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>@lang('translation.id')</th>
                                        <th>@lang('translation.Coin_status_current')</th>
                                        <th>@lang('translation.wallet_address')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
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
       <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
       <script>
           var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
           var image_default = "{{$image_default}}";
            url = '/datatable-translations/lang-' + lang + '.json';
            var wallet_table = $('#wallet_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.coins.fetchData') !!}",
                    data: function(d) {
                        d.search = $('input[name="search"]').val(),
                        d.coins = $('#wallet_table').data('coins')
                    }
                },
                columns: [
                    {
                        data: 'nick_name',
                        name: 'nick_name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'wallet_address',
                        name: 'wallet_address'
                    },
                    
                ]
            });
            $('input[name="search"]').on('keyup', function(){
                wallet_table.draw();
            })
           
            $('#coin_table tbody#coin_tbody').on('click', 'tr', function(){
                data = {
                    coin_id : $(this).attr('id')
                };
                $('#wallet_table').data('coins', { coin_id: $(this).attr('id') });
                $('#coin_table tbody tr.table-active').removeClass('table-active');
                $('#coin_table tbody tr .font-size-14').removeClass('text-white');
                $(this).addClass('table-active');
                $(this).find('.font-size-14').addClass('text-white');
                wallet_table.draw();
                $.ajax({
                    url: '{{ route('admin.coins.detailOrUpdate') }}',
                    datatype: "html",
                    type: "POST",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        detail(response.data.coin, response.data.admin_wallet)
                    },
                    error: function(error) {

                    },
                })
            })
            function update_coin(){
                coin_name =  $('input[name="name"]').val();
                if(!coin_name){
                   $('#coin_name').removeClass("d-none");
                    return false;
                }else{
                    $('#coin_name').addClass("d-none"); 
                }
                coin_id = $('input[name="coin_id"]').val();
                coin_symbol_name =  $('input[name="symbol_name"]').val();
                if(!coin_symbol_name){
                    $('#coin_symbol_name').removeClass("d-none");
                    return false;
                }else{
                    $('#coin_symbol_name').addClass("d-none");
                }
                coin_status  = $('select[name="status"]').val();
                coin_image = $("#upload_file_input")[0].files.length ?  $("#upload_file_input")[0].files[0] : null;
                var data = new FormData();
                data.append("image", coin_image)
                data.append("coin_name", coin_name)
                data.append("coin_id", coin_id)
                data.append("coin_symbol_name", coin_symbol_name)
                data.append("coin_status", coin_status)
                $.ajax({
                    url: '{{ route('admin.coins.detailOrUpdate') }}',
                    datatype: "json",
                    type: "POST",
                    data: data,
                    contentType: false,
                    processData: false, 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        message = response.data['coin_symbol_name'] ? response.data['coin_symbol_name'][0]:'';
                        if(message){
                            $('#coin_symbol_name').html(message);
                            $('#coin_symbol_name').removeClass("d-none");
                            return false;
                        }else{
                            $('#modal_loading').hide();
                            notificationSwal(response.status);
                            detail(response.data.coin, response.data.admin_wallet)
                            coins_html_table(response.data.coins, response.data.position);
                        }
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            }

            function detail(coin, admin_wallet){
               
                coin_detail_html = '';
                coin_detail_html += `<input type="hidden"   class="hidden" value="${coin.id}" name="coin_id" />
                                    <div class="text-center">
                                        <input type="file" name="image" class="hidden" id="upload_file_input" onchange="upload_image()" class="form-control">
                                        <img src="${coin.image_url ?  coin.image_url : image_default}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                        <button type="button" class="btn btn-primary waves-effect waves-light mb-1 float-end ${coin.image ? '' : 'd-none'} Delete_image" onclick="Delete_image()">@lang('translation.Delete_image')</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light mb-1 float-end ${coin.image ? 'd-none' : ''} Image_change"  onclick="change_image()">@lang('translation.Image_change')</button>
                                    </div>
                                    <p class="text-danger d-none" id="image_validate">{{trans('translation.please_select_the_correct_format_image')}}</p>`
                coin_detail_html += `<div class="mb-3 row mt-4">
                                        <label for="name-coin-input" class="col-md-4 col-form-label">@lang('translation.Name_coin')</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="name" value="${coin.name}" id="name-coin-input">
                                            <p class="text-danger d-none" id='coin_name'>{{trans('translation.Please_enter_name')}}</p>
                                        </div>
                                    </div>`
                coin_detail_html += `<div class="mb-3 row">
                                        <label for="symbol-coin-input" class="col-md-4 col-form-label">@lang('translation.Symbol_coin')</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="symbol_name" value="${ coin.symbol_name}" id="symbol-coin-input">
                                            <p class="text-danger d-none" id='coin_symbol_name'>{{trans('translation.Please_enter_symbol_name')}}</p>
                                        </div>
                                    </div>`
                coin_detail_html += `<div class="mb-3 row">
                                        <label for="quantity-coin-input" class="col-md-4 col-form-label">@lang('translation.Quantity_coin')</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" value="${ admin_wallet.amount}" id="quantity-coin-input" disabled>
                                        </div>
                                    </div>`
                coin_detail_html += `<div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">@lang('translation.Status_coin')</label>
                                        <div class="col-md-8">
                                            <select class="form-select" name="status">
                                                <option value="{{config('apps.common.status_wallet.not_activate')}}" ${ parseInt(admin_wallet.status) === parseInt("{{config('apps.common.status_wallet.not_activate')}}") ? 'selected': ''}>@lang('translation.not_activate')</option>
                                                <option value="{{config('apps.common.status_wallet.activate')}}"  ${ parseInt(admin_wallet.status) === parseInt("{{config('apps.common.status_wallet.activate')}}") ? 'selected': ''}>@lang('translation.activate')</option>
                                            </select>
                                        </div>
                                    </div>`
                coin_detail_html += `<div>
                                        <div class="float-end ms-2">
                                            <button type="submit" class="btn btn-success waves-effect float-end" onclick="update_coin()">@lang('translation.Save')</button>
                                        </div>
                                        <div class="float-end">
                                            <a onclick="reset()"  class="btn btn-secondary waves-effect float-end">@lang('translation.reset')</a>
                                        </div>
                                    </div>`                                                  
                $('#coin_detail').html(coin_detail_html);
            }
            
            function coins_html_table(coins, position){
                coin_html = '';
                for(let coin of coins){
                    coin_html +=   `<tr id="${coin.id}" class="${coin.id == position ? 'table-active': ''}">
                                        <td ><img src="${coin.image ? '/storage/images/coins/' +  coin.image : image_defaul}" class="avatar-xs rounded-circle " alt=""></td>    
                                        <td>
                                            <h6 class="font-size-14 mb-1 fw-normal  ${coin.id == position ? 'text-white' : ''}">${coin.name}</h6>
                                            <p class="text-muted font-size-11 mb-0"></i>${coin.symbol_name}</p>
                                        </td>
                                        <td class="text-muted fw-semibold text-end">${coin.admin_wallet.amount}</td>
                                    </tr>`
                }
                $("#coin_tbody").html(coin_html);
            }
            function change_image(){
                $("#upload_file_input").click();
            }
            function upload_image(){
                image = $('.avatar-lg');
                if(isImage($("#upload_file_input").val())){
                    image[0].src = URL.createObjectURL($("#upload_file_input")[0].files[0]);
                    $('.Delete_image').removeClass("d-none")
                    $('.Image_change').addClass("d-none");
                }else{
                    $('#image_validate').removeClass('d-none');
                    $("#upload_file_input").files =  null;
                    $("#upload_file_input").val('');
                    return false;
                }
            }
            function Delete_image(){
                image = $('.avatar-lg');
                image[0].src = '{{$image_default}}';
                $("#upload_file_input").files =  null;
                $("#upload_file_input").val('');
                $('.Delete_image').addClass('d-none');
                $('.Image_change').removeClass("d-none");
            }
            function isImage(filename) {
                var ext = getExtension(filename);
                switch (ext.toLowerCase()) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'bmp':
                case 'ico':
                return true;
            }
            return false;
            }
        
            function getExtension(filename) {
                var parts = filename.split('.');
                return parts[parts.length - 1];
            }
            function reset(){
                coin_id = $('input[name="coin_id"]').val();
                data = {
                    coin_id: coin_id
                };
                $.ajax({
                    url: '{{ route('admin.coins.detailOrUpdate') }}',
                    datatype: "html",
                    type: "POST",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        detail(response.data.coin, response.data.admin_wallet)
                        coins_html_table(response.data.coins, response.data.position);
                    },
                    error: function(error) {

                    },
                })
            }
            
           
       </script>
@endsection
