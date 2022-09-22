@extends('layouts.master')
@section('title') @lang('translation.Edit') @endsection
@section('content')
@section('css')
    <style>
    .set-width-modal{
        height: 300px;
        overflow-y: auto;
    }
    </style>
@endsection
@component('common-components.breadcrumb')
    @slot('pagetitle') @lang('translation.Home') @endslot
    @slot('childrenTitle') @lang('translation.Uers')@endslot
    @slot('title') @lang('translation.Edit_Details') @endslot
@endcomponent 

    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
    <form action="{{url("admin/users/$user->id/edit")}}" method="POST" enctype="multipart/form-data">
        @csrf
                    <div class="text-center">
                        <div>
                            @if(!empty($user->avatar))
                                <img  src="{{url('storage/images/avatars/'.$user->avatar)}}" alt="" id="image_users" class="avatar-lg rounded-circle img-thumbnail rounded-circle">
                            @else 
                                <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt="" id="image_users" class="avatar-lg rounded-circle img-thumbnail rounded-circle" >
                            @endif
                        </div>
                        <div class="mt-4 float-end">
                            @if(!empty($user->avatar))
                                <a href="{{url("admin/users/$user->id/delete-image")}}"  class="btn btn-primary waves-effect waves-light mb-1 left" ui-toggle-class="">
                                    @lang('translation.Delete_Image')
                                </a>
                            @else
                            <div class="form-group">
                                <input type="hidden" class="hidden" name="" value="{{ $user->id }}" />
                                <input type="file" name="avatar" value="{{ $user->avatar }}" class="hidden" id="upload_file_input" class="form-control">
                                <a type="submit"
                                    class="btn btn-success waves-effect waves-light mb-1 change-image">@lang('translation.Image_change')
                                </a>
                            </div>
                            <p class="d-none text-danger form-text" id="image_validation_one">{{trans('translation.please_select_the_correct_format_image')}}</p>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr class="my-4">
                    <div class="d-grid gap-2">
                        <a class="btn btn-primary waves-effect waves-light mb-1" id="coin_holding_status" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" >@lang('translation.Coin_holding_status')</a>
                        <a href="{{route('admin.coins.log.index') .'?user_id='. $user->id}}" class="btn btn-primary waves-effect waves-light mb-1">@lang('translation.Coin_deposit_and_witdrawal_history')</a>
                    </div>
                    <hr class="my-2">
                    <div class="progress mb-3" style="height: 2px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <hr class="my-2">
                    <div class="d-grid gap-2">
                        <a href="{{route('admin.products.orders.index') . '?user_id=' .$user->id}}" class="btn btn-primary waves-effect waves-light mb-1">@lang('translation.Purchase_history')</a>
                        <a id="product_holding_status" class="btn btn-primary waves-effect waves-light mb-1" data-bs-toggle="modal" data-bs-target="#modalProductStatus">@lang('translation.Product_holding_status')</a>
                        <a class="btn btn-primary waves-effect waves-light mb-1" id="mining-status" data-bs-toggle="modal" data-bs-target="#modalMiningStatus">@lang('translation.Mining_Status')</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card mb-0">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Member_information')</h4>
                    <form action="{{url("admin/users/$user->id/edit")}}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="example-id-input" class="col-md-2 col-form-label">ID</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" name="email" value="{{$user->email}}" id="example-id-input" readonly >
                                @error('email') 
                                    <small class="form-text text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-name-input" class="col-md-2 col-form-label">@lang('translation.Name')</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="full_name" value="{{$user->full_name}}" id="example-name-input" >
                                @error('full_name') 
                                    <small class="form-text text-danger">
                                        @lang('validation.full_name')
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-nickname-input" class="col-md-2 col-form-label">@lang('translation.Nickname')</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nick_name" value="{{$user->nick_name}}" id="example-nickname-input" > 
                                @error('nick_name') 
                                    <small class="form-text text-danger">
                                        @lang('validation.nick_name')
                                    </small>
                                @enderror
                            </div>
                        </div>
                        
    
                        <div class="mb-3 row">
                            <label for="example-date-input" class="col-md-2 col-form-label">@lang('translation.Date_birth')</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" name="birthday" value="{{$user->birthday}}" id="example-date-input" >
                                @error('birthday') 
                                    <small class="form-text text-danger">
                                        @lang('validation.birthday')
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Gender')</label>
                            <div class="col-md-10">
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="radio" id="customRadioInline1" name="gender" value="1" {{ ($user->gender=="1")? "checked" : "" }} class="form-check-input">
                                    <label class="form-check-label" for="customRadioInline1">@lang('translation.Male')</label>
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="radio" id="customRadioInline2" name="gender" value="2" {{ ($user->gender=="2")? "checked" : "" }} class="form-check-input">
                                    <label class="form-check-label" for="customRadioInline2">@lang('translation.Female')</label>
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="radio" id="customRadioInline3" name="gender" value="3" {{ ($user->gender=="3")? "checked" : "" }} class="form-check-input">
                                    <label class="form-check-label" for="customRadioInline3">@lang('translation.No_choice')</label>
                                </div> 
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-nation-input" class="col-md-2 col-form-label">@lang('translation.Nation')</label>
                            <div class="col-md-10">
                                <select class="form-select" name="nation_id">
                                    @foreach ($nation as $nation_item)
                                            <option name="nation_id" value="{{ $nation_item->id }}" {{ ( $nation_item->id == $user->nation_id       ) ? 'selected' : '' }}> {{ $nation_item->name }} </option>
                                    @endforeach  
                                </select>
                                @error('nation') 
                                    <small class="form-text text-danger">
                                        @lang('validation.nation_id')
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-location-input" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->location_detail}}" name="location_detail" id="example-location-input" placeholder="@lang('translation.detail_location')" >
                                @error('location_detail') 
                                    <small class="form-text text-danger">
                                        @lang('validation.location_detail')
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-date-join-input" class="col-md-2 col-form-label">@lang('translation.Date_join')</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" name="date_of_joining" value="{{$user->date_of_joining}}" id="example-date-join-input" >
                                @error('date_of_joining') 
                                    <small class="form-text text-danger">
                                        @lang('validation.date_of_joining')
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Status')</label>
                            <div class="col-md-10">
                                <select class="form-select" name="status_user_id">
                                    @foreach ($status_users as $key => $item)
                                        <option name="status_user_id" value="{{ $item }}" {{ ( $item == $user->status_user_id) ? 'selected' : '' }}> {{ trans("translation.".$key) }} </option>
                                    @endforeach   
                                </select>
                            </div>
                        </div>
                        <div class="float-end">
                            <a href="{{route('admin.users.index')}}" class="btn btn-secondary waves-effect">
                                @lang('translation.Page_back')
                            </a>
                            <button type="submit" class="btn btn-success inner">
                                @lang('translation.Edit')
                            </button>
                        </div>

    </form>



                    
                </div>
            </div>
        </div>
    </div>
        
    <!-- statusCoin Modal -->
    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="modalCoinStatus" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row justify-content-center">
                            <h5 class="modal-title text-center" style="padding-left:30px; ">@lang('translation.Coin_holding_status')</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body set-width-modal">
                    <div class="card-body">
                        <div class="table table-bordered dt-responsive">
                            <table class="table mb-0" style="border:transparent";>
                                <tbody  id="tbody-wallet-users">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">@lang('translation.Confirm')</button>
                
                </div>
            </div>
        </div>
    </div>
    <!-- statusProducts Modal -->
    <div class="modal fade" id="modalProductStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <h5 class="modal-title text-center" id="modalProductStatusLabel" style="padding-left:30px;">@lang('translation.Product_holding_status')</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body set-width-modal">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-bordered-top border-secondary">
                                <thead>
                                    <tr class="text-center bg-secondary text-white">
                                        <th>@lang('translation.Name_Products')</th>
                                        <th>@lang('translation.Numbers')</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-product-inventory">
                                </tbody>
                            </table>
                        </div>
                        <div class="progress" style="height: 1px;">
                            <div class="progress-bar bg-dark" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>    
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">@lang('translation.Confirm')</button>
                
                </div>
            </div>
        </div>
    </div>
    <!-- statusMining Modal -->
    <div class="modal fade" id="modalMiningStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row justify-content-center">
                            <h5 class="modal-title text-center" id="modalMiningStatusLabel" style="padding-left: 30px;">@lang('translation.Mining_Status')</h5>        
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body set-width-modal">
                    <div class="card-body">
                        
                        <div class="input-group date mb-3" data-provide="datepicker">
                            <a class="btn btn-success glyphicon glyphicon-th align-self-center" id="date-reduce-day"> <i class="mdi mdi-arrow-left-bold"></i> </a>
                            <input type="date" class="form-control" id="date-control-mining-status" value="{{date('Y-m-d')}}">
                            <a class="btn btn-success glyphicon glyphicon-th align-self-center" id="date-add-day"> <i class="mdi mdi-arrow-right-bold"></i></a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-bordered-top border-secondary  ">
                                <thead>
                                    <tr class="text-center bg-secondary text-white">
                                        <th>@lang('translation.Date')</th>
                                        <th>@lang('translation.Mining_amount')</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-mining-status">
                                    <tr class="text-center">
                                        <td>2022-01-01</td>
                                        <td>9999,999</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="progress" style="height: 1px;">
                            <div class="progress-bar bg-dark" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>    
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">@lang('translation.Confirm')</button>
                
                </div>
            </div>
        </div>
    </div>

    
@endsection
@section('script')
       <!-- apexcharts -->
       <script>
            $(function () {
                $('#datepicker').datepicker({
                    dateFormat: 'yy-mm-dd',
                    showButtonPanel: true,
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1999:2012',
                    showOn: "button",
                    buttonImage: "images/calendar.gif",
                    buttonImageOnly: true,
                    minDate: new Date(1999, 10 - 1, 25),
                    maxDate: '+30Y',
                    inline: true
                });
            });
            
            $('.change-image').on('click', function(){
                $('#upload_file_input').trigger('click');
            })
            
            $('#upload_file_input').on('change', function(){
                var image = $('#image_users');
                if(isImage($(this).val())){
                    $('#image_validation_one').addClass("d-none");
                    image[0].src = URL.createObjectURL(this.files[0]);  
                }else{
                    this.files[0] = null;
                    console.log(this.files[0]);
                    $('#image_validation_one').removeClass("d-none");
                }
                    
            })

            
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
            $("a#coin_holding_status").on('click', function(){
                $.ajax({
                    url: '{{ route('admin.users.wallet', $user->id) }}',
                    datatype: "html",
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        wallet_html = '';
                        if(!response.data.length){
                            wallet_html = " <tr> <td>{{trans('translation.No_matching_records_found')}} </tr> </td>";
                        }else{
                            for(let wallet of response.data ){
                                wallet_html +=`<tr>
                                        <td><img src="${wallet.image_url}" alt=""
                                                    class="rounded-circle avatar-sm"> ${wallet.coin_name}</td>
                                        <td class="text-md-center align-middle">${formatter.format(wallet.amount)} ${wallet.symbol_name}</td>
                                    </tr>`
                            }
                        }
                        $('tbody#tbody-wallet-users').html(wallet_html);
                    },
                    error: function(error) {

                    },
                })
            })
            $("a#product_holding_status").on('click', function(){
                $.ajax({
                    url: '{{ route('admin.users.productInventory', $user->id) }}',
                    datatype: "html",
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        product_inventory_html = '';
                        if(!response.data.length){
                            product_inventory_html = " <tr> <td>{{trans('translation.No_matching_records_found')}} </tr> </td>";
                        }else{
                            for(let product_inventory of response.data ){
                                product_inventory_html +=` <tr>
                                            <td>${product_inventory.product_name}</td>
                                            <td  class="text-center">${product_inventory.numbers}</td>
                                        </tr>`
                            }
                        }
                        $('tbody#tbody-product-inventory').html(product_inventory_html);
                    },
                    error: function(error) {

                    },
                })
            })
            $('input#date-control-mining-status').on('change', function(){
                mining_status_html_function();
            })
            $('a#mining-status').on('click',function(){
                mining_status_html_function();
              
            })
            function mining_status_html_function(){
                data = {
                    date : $('input#date-control-mining-status').val(),
                    user_id : '{{$user->id}}'
                }
                $.ajax({
                    url: '{{ route('admin.users.miningStatus') }}',
                    datatype: "html",
                    type: "POST",
                    data:data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        mining_status_html ='';
                        if(!response.data.length){
                            mining_status_html = " <tr> <td>{{trans('translation.No_matching_records_found')}} </tr> </td>";
                        }else{
                            for(let mining_status of response.data ){
                                mining_status_html +=` <tr>
                                        <td>${formatDate(mining_status.created_at)}</td>
                                        <td  class="text-center">${mining_status.cumulative_mining}</td>
                                    </tr>`
                            }
                        }
                        $("tbody#tbody-mining-status").html(mining_status_html)
                        
                    },
                    error: function(error) {

                    },
                })
            }
            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) 
                    month = '0' + month;
                if (day.length < 2) 
                    day = '0' + day;

                return [year, month, day].join('-');
            }
 
            var formatter = new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 });
            
            function incrementDate(dateInput,increment) {
                var dateFormatTotime = new Date(dateInput);
                var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
                return increasedDate;
            }
            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) 
                    month = '0' + month;
                if (day.length < 2) 
                    day = '0' + day;

                return [year, month, day].join('-');
            }
            $('#date-reduce-day').on('click', function(){
                date = formatDate(incrementDate($('#date-control-mining-status').val(),-1))
                $('#date-control-mining-status').val(date)
                $('#date-control-mining-status').change();
            })
            $('#date-add-day').on('click', function(){
                date = formatDate(incrementDate($('#date-control-mining-status').val(),1))
                $('#date-control-mining-status').val(date)
                $('#date-control-mining-status').change();

            })
       </script>
       <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>

       <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection