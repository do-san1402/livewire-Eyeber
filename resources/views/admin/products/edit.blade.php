@extends('layouts.master')
@section('title')
    @lang('translation.Product_Detail')
@endsection
@section('css')
    <style>
    .set-width-modal{
        height: 300px;
        overflow-y: auto;
    }
    </style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
         @slot('pagetitle')
            @lang('translation.Home')
        @endslot
         @slot('MenuTitle')
            @lang('translation.Product_management')
        @endslot
          @slot('ParentTitle')
            @lang('translation.Product_List')
        @endslot
        @slot('title')
            @lang('translation.Product_Detail')
        @endslot
    @endcomponent
    <form acction="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-4">
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-end">
                            <label for="example-text-input" class="col-md-12 col-form-label">@lang('translation.Product_Thumbnail')</label>
                            <div class="col-md-6">
                                <div>
                                    @if(!empty($product->image))
                                        <img  src="{{ url('/storage/images/products/' . $product->image) }}" alt="" class="avatar-lg img-thumbnail">
                                    @else 
                                        <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt="" class="avatar-lg rounded-circle img-thumbnail rounded-circle" >
                                    @endif
                                </div>
                            </div>
                           
                            <div class="col-md-6 d-flex flex-column">
                                <input type="hidden" class="hidden" name="product_id_hidden"
                                    value="{{ $product->id }}" />
                                <input type="file" name="image" value="{{ $product->image }}" class="hidden"
                                    id="upload_file_input" class="form-control">
                                <a type="submit"
                                    class="btn btn-success waves-effect waves-light mb-1 change-image float-end">@lang('translation.Image_change')</a>
                                <a class="btn btn-danger  waves-effect waves-light mb-1 float-end delete_image">@lang('translation.Delete_image')</a>
                            </div>
                            <p class="d-none text-danger form-text" id="image_validation">{{trans('translation.please_select_the_correct_format_image')}}</p>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <a type="button" class="btn btn-info waves-effect waves-light mb-1"
                                href="{{ route('admin.products.orders.index') .'?product_id='.$product->id }}">@lang('translation.Sales_history_of_the_product')</a>
                            <a type="button" class="btn btn-success w-lg waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#product_upgrade_setting">@lang('translation.Upgrade_Settings')</a>
                            <a type="button" class="btn btn-primary waves-effect waves-light mb-1"
                                data-bs-toggle="modal" data-bs-target="#product_enhancement_settings">@lang('translation.Enhancement_Settings')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-0">
                    <div class="card-body">
                        <h4 class="card-title">@lang('translation.Product_information')</h4>
                        <div class="mb-3 row">
                            <label for="example-id-input" class="col-md-3 col-form-label">@lang('translation.Product_name')</label>
                            <div class="col-md-8">
                                <input class="form-control" name="name" type="text" value="{{ $product->name }}"
                                    id="example-id-input">
                                 @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif    
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-name-input" class="col-md-3 col-form-label">@lang('translation.Brief_description')</label>
                            <div class="col-md-8">
                                <textarea id="textarea" class="form-control" name="description" maxlength="225" rows="3">{{ $product->description }}</textarea>
                                  @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif 
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-name-input" class="col-md-3 col-form-label">@lang('translation.Available_Coins')</label>
                            <div class="col-md-8">
                                <label for="example-name-input" class="col-md-4 col-form-label">{{$product->available_coins_name}}</label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Sales_Amount_(Polygon)')</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="form-control" name="price_matic"
                                            value="{{$product->price_matic}}" id="price_matic" type="number">
                                        @if ($errors->any())        
                                            <p class="text-danger">{{ $errors->first('price_matic') }}</p>
                                        @endif
                                    </div>
                                    <label class="col-md-4 col-form-label" for="price_matic">@lang('translation.MATIC')</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-id-input" class="col-md-3 col-form-label">@lang('translation.Durability')</label>
                            <div class="col-md-8">
                                <input class="form-control" type="number" name="durability" value="{{ $product->durability }}"
                                    id="example-id-input" step="any">
                                @if ($errors->any())        
                                    <p class="text-danger">{{ $errors->first('durability') }}</p>
                                @endif            
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Repair_cost')</label>
                            <div class="col-md-9">
                                @if ($product->durability_used)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-md-6 col-form-label"
                                                    for="durability_used">@lang('translation.Durability_used')</label>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="durability_used">
                                                        <option value='{{ $product->durability_used }}'>
                                                            {{ $product->durability_used }}</option>
                                                        @for ($i = 0; $i < 100; $i++)
                                                            <option value='{{ $i }}'>{{ $i }}
                                                            </option>
                                                        @endfor
                                                        <select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <label class="col-md-8 col-form-label"
                                                    for="Direct_setting">@lang('translation.%Party')</label>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-3 mt-2">
                                            <div class="custom-radio form-check form-check-inline">
                                                <input type="radio" id="Direct_setting"  name="repair_cost"
                                                value="{{ config('apps.common.repair_cost.Direct_setting') }}" 
                                                    class="form-check-input">
                                                <label class="form-check-label"   for="Direct_setting">@lang('translation.Direct_setting')</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-md-6 col-form-label"
                                                    for="Durability_used">@lang('translation.Durability_used')</label>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="durability_used" disabled>
                                                        @for ($i = 0; $i < 100; $i++)
                                                            <option value='{{ $i }}'>{{ $i }}
                                                            </option>
                                                        @endfor
                                                        <select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row">
                                                <label class="col-md-4 col-form-label"
                                                    for="Direct_setting">@lang('translation.%Party')</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>    
                        <div class="mb-3 row">
                            <label for="example-id-input" class="col-md-3 col-form-label">@lang('translation.Sales_status')</label>
                            <div class="col-md-8">
                                <select class='form-select' name="sale_status_id">
                                    @foreach ($sales_status as $key => $sale_status)
                                 
                                        <option value="{{ $sale_status }}" {{($product->sale_status_id == $sale_status)? 'selected' : '' }}>{{ trans('translation.' . $key) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>    
                         <!-- upgrade-setting -->
                         <input type="hidden" name="bmt_upgrade_setting">
                         <input type="hidden" name="level">
                         <input type="hidden" name="bst_upgrade_setting">
                         <input type="hidden" name="durability_upgrade_setting">
                         <input type="hidden" name="mining_upgrade_setting">
                   
                         <div class="mb-3 row">
                            <label for="example-id-input" class="col-md-3 col-form-label">@lang('translation.glass')</label>
                            <div class="col-md-8">
                                <select class='form-select' name="glass">
                                    <option value="{{$product->glass_type}}">{{$product->glass_name}}</option> 
                                    @foreach($glass_category as $key => $glass)
                                        <option value="{{$glass}}">@lang('translation.'.$key)</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Glasses_value')</label>
                            <div class="col-md-8">
                                <div class='row'>
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="@lang('translation.BST')"
                                            id="BST_input_glass" value="{{$product->glass_value}}" readonly >  
                                    </div>
                                    <input type="hidden" class="hidden" name="mining"  value="{{$product->glass_value}}" > 
                                    <label class="col-md-4 col-form-label" for="on">@lang('translation.BST')</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="float-end">
                               <a href="{{route('admin.products.index')}}" class="btn btn-secondary waves-effect">
                                     @lang('translation.Back_page')
                               </a>
                                <button type="submit" class="btn btn-success inner">
                                    @lang('translation.correction')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    

        <div id="product_upgrade_setting"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <div class="row justify-content-center">
                                <h5 class="modal-title text-center" id="modalMiningStatusLabel" style="padding-left: 30px;">@Lang('translation.Upgrade_Settings')</h5>        
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body set-width-modal">
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Upgrade_Settings')</label>
                            <div class="col-md-10">
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" class="form-control" name="BMT" id="bmt_upgrade_settings" step="any" value="{{$product_upgrade ? $product_upgrade->bmt:1}}" />
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <label class="form-check-label" for="customRadioInline2">:</label>
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" class="form-control" name="BST" id="bst_upgrade_settings"  step="any"  value="{{$product_upgrade ? $product_upgrade->bst : 5}}" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Upgrade_stat_settings')</label>
                            <div class="col-md-10">
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" name="durability_upward_fixed" class="form-control"  step="any"  value="{{$product_upgrade ? $product_upgrade->durability : 0.1}}"  id="durability_upward_fixed" />
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <label class="form-check-label"  for="customRadioInline2">:</label>
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" class="form-control" name="Mining_amount"  step="any"  value="{{$product_upgrade ? $product_upgrade->mining : 0.12}}" id="Mining_amount_upward_fixed" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class='col-md-7 ms-4 mt-2'>
                                <a class="btn btn-primary form-control btn-sm waves-effect waves-light ms-2" onclick="apply()">@lang('translation.Apply')</a>
                            </div>
                        </div>
                        <table class="table table-bordered border-dark mb-0" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="2">@lang('translation.Level_classification')</th>
                                    <th colspan="2" class="text-center">@lang('translation.Upgrade_cost')</th>
                                    <th colspan="2" class="text-center">@lang('translation.Upgrade_stats')</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>BMT</th>
                                    <th>BST</th>
                                    <th>@lang('translation.Durability')</th>
                                    <th>@lang('translation.Mining_volume')</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_upgrade_settings">
                                @if( count($product->product_upgrades) >0)
                                    @foreach($product->product_upgrades as $product_upgrade)
                                        <tr>
                                            <th scope="row">{{$product_upgrade->level}}</th>
                                            <td>{{$product_upgrade->bmt}}</td>
                                            <td>{{$product_upgrade->bst}}</td>
                                            <td>{{$product_upgrade->durability}}</td>
                                            <td>{{$product_upgrade->mining}}</td>
                                        </tr>
                                    @endforeach
                                @endif    
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a  class="btn btn-danger waves-effect cancelSetting" data-bs-dismiss="modal">@lang('translation.Cancellation')</a>
                        <a class="btn btn-success waves-effect waves-light set_upgrade_setting" data-bs-dismiss="modal">@lang('translation.Set')</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div id="product_enhancement_settings"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="exampleModalFullscreenLabel">@lang('translation.Enhancement_Settings')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body set-width-modal">
                        <table class="table table-bordered border-dark mb-0" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="2">@lang('translation.Reinforced_division')</th>
                                    <th class="text-center">@lang('translation.Fortification_cost')</th>
                                    <th colspan="2" class="text-center">@lang('translation.Reinforcement_stats')</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>BST</th>
                                    <th>@lang('translation.Durability')</th>
                                    <th>@lang('translation.Mining_volume')</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_Enhancement_Settings"> 
                                @if(!count($product->enhancement_settings))
                                    @for($i = 2; $i< 31 ;$i++)
                                            <tr>
                                                <th scope="row">+{{$i}}<input type="hidden" class="form-control" value="{{$i}}" name="reinforced_division[]"/></th>
                                                <td><input type="number" class="form-control" name="bst_enhancement[]" step="any" ></td>
                                                <td><input type="number" class="form-control" name="durability_enhancement[]" step="any" ></td>
                                                <td><input type="number" class="form-control" name="mining_volume_enhancement[]" step="any" ></td>
                                            </tr>
                                    @endfor
                                @else
                                    @foreach($product->enhancement_settings as $key => $enhancement_setting)
                                        <tr>
                                            <th scope="row">+{{$enhancement_setting->reinforced_division}}<input type="hidden" class="form-control" value="{{$enhancement_setting->reinforced_division}}" name="reinforced_division[]"/></th>
                                            <td><input type="number" name="bst_enhancement[]" step="any" class="form-control"  value="{{$enhancement_setting->bst}}"></td>
                                            <td><input type="number" name="durability_enhancement[]" step="any"  class="form-control"  value="{{$enhancement_setting->durability}}"></td>
                                            <td><input type="number" name="mining_volume_enhancement[]" step="any" class="form-control" value="{{$enhancement_setting->mining}}"></td>
                                        </tr>
                                    @endforeach
                                    @php
                                    $enhancement =  30 -   count($product->enhancement_settings);
                                    $j = count($product->enhancement_settings) + 2;
                                    @endphp
                                    @for( $j;  $j< 31 ; $j++)
                                        <tr>
                                            <th scope="row">+{{ $j}} <input type="hidden" class="form-control" value="{{$j}}" name="reinforced_division[]"/></th>
                                            <td><input type="number" name="bst_enhancement[]" class="form-control" step="any"></td>
                                            <td><input type="number" name="durability_enhancement[]" class="form-control" step="any" ></td>
                                            <td><input type="number" name="mining_volume_enhancement[]" class="form-control" step="any" ></td>
                                        </tr>
                                    @endfor
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a  class="btn btn-danger waves-effect Cancellation_Enhancement_Settings"
                            data-bs-dismiss="modal">@lang('translation.Cancellation')</a>
                        <a  class="btn btn-success waves-effect waves-light" data-bs-dismiss="modal">@lang('translation.Set')</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>
@endsection
@section('script')
    <!-- apexcharts -->
    <script>
        $(function() {
            $('input[name="repair_cost"]').on('change', function() {
                if (parseInt($(this).val()) === 1) {
                    $('select[name="durability_used"]').prop('disabled', false);
                    $('select[name="of_mining"]').prop('disabled', true);
                    $('#bst_input_number').prop('disabled', false);
                } else {
                    $('select[name="durability_used"]').prop('disabled', true);
                    $('select[name="of_mining"]').prop('disabled', false);
                    $('#bst_input_number').prop('disabled', true);
                }
            });
            $('.change-image').on('click', function() {
                $('#upload_file_input').trigger('click');
            })
            $('a.delete-image').on('click', function() {
                $('.avatar-lg').prop('src', '');
                $('#upload_file_input').val('')
            })
            $('input[name="BMT"]').on('change', function(){
              let  BMT = $(this).val();
                   BST = BMT*5;
                $('input[name="BST"]').val(BST);
            })
            $('input[name="durability"]').on('change', function(){
              let  durability = $(this).val();
                Mining_amount = durability*1.2;
                $('input[name="Mining_amount"]').val(Mining_amount);
            })
            $('input#BST_input').on('keyup', function(){
                $('input#bst_input_number').val($(this).val())
            })
            $('input[name="image"]').on('change', function(){
                var image = $('.avatar-lg');
                if(isImage($(this).val())){
                image[0].src = URL.createObjectURL(this.files[0]);  
                $('#image_validation').addClass("d-none");
                }else{
                    this.files[0] =  this.files[0] ?  this.files[0] : null;
                    $('#image_validation').removeClass("d-none");
                }
            })
            $('.delete_image').on('click', function(){
                var image = $('.avatar-lg');
                image[0].src = "{{asset('assets/images/logo-sm.png')}}";
                $('input[name="image"]').val('');
            })
        })
        function apply(){
            html_table_product_upgrade();
        }
        bmt_upgrade_setting   = [];
        level_array = [];
        bst_upgrade_setting = [];
        durability_upgrade_setting = [];
        mining_upgrade_setting = [];
        tbody_html_old = $('#tbody_upgrade_settings').html();
        var level =  parseInt('{{$level}}');
        function html_table_product_upgrade(cancel){
            if(cancel){
                level =  parseInt('{{$level}}');
                bmt_upgrade_setting   = [];
                level_array = [];
                bst_upgrade_setting = [];
                durability_upgrade_setting = [];
                mining_upgrade_setting = [];
                $('#tbody_upgrade_settings').html(tbody_html_old);
                $('input[name="bmt_upgrade_setting"]').val('');
                $('input[name="level"]').val(level_array);
                $('input[name="bst_upgrade_setting"]').val('');
                $('input[name="durability_upgrade_setting"]').val('');
                $('input[name="mining_upgrade_setting"]').val('');
                return true;
            }
            var bmt  = parseInt($('#bmt_upgrade_settings').val());
            bst = parseFloat($('#bst_upgrade_settings').val());
            divisor_bmt = bst / bmt;
            html_table = '';
            level_limit = parseInt('{{$level_limit_product_upgrade}}');
            durability = parseFloat($('#durability_upward_fixed').val());
            mining = parseFloat($('#Mining_amount_upward_fixed').val());
            level++;
                html_table += `<tr>
                                <td>${level}</td>    
                                <td>${bmt}</td>    
                                <td>${bmt * divisor_bmt}</td>    
                                <td>${durability}</td>    
                                <td>${mining}</td>    
                            </tr>`
            bmt_upgrade_setting.push(bmt);
            level_array.push(level);
            bst_upgrade_setting.push( bmt * divisor_bmt);
            durability_upgrade_setting.push(durability);
            mining_upgrade_setting.push(mining);                
            $('#tbody_upgrade_settings').append(html_table);
            $('input[name="bmt_upgrade_setting"]').val(bmt_upgrade_setting);
            $('input[name="level"]').val(level_array);
            $('input[name="bst_upgrade_setting"]').val(bst_upgrade_setting);
            $('input[name="durability_upgrade_setting"]').val(durability_upgrade_setting);
            $('input[name="mining_upgrade_setting"]').val(mining_upgrade_setting);
        }
        $('.cancelSetting').on('click', function(){
            html_table_product_upgrade(1);
        })
        tbody_Enhancement_Settings_old = $('#tbody_Enhancement_Settings').html(); 
        $('.Cancellation_Enhancement_Settings').on('click', function(){
            $('#tbody_Enhancement_Settings').html(tbody_Enhancement_Settings_old);
        })
        function isImage(filename) {
            var ext = getExtension(filename);
            switch (ext.toLowerCase()) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'bmp':
            case 'ico':
                // etc
                return true;
            }
            return false;
        }
        function getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        }
        $('select[name="glass"]').on('change', function() {
            var glass_category = {!! json_encode($glass_category) !!};
            var glass_type = {!! json_encode($glass_type) !!};
            var glass_category_value = $('select[name="glass"]').find(":selected").val();
            $.each(glass_category , function (k_type, v_type){  
                if(glass_category_value == v_type) {
                    $.each(glass_type , function (k_glass, v_glass){  
                        if(k_glass == k_type) {
                            $("#BST_input_glass").val(v_glass);
                            $('input[name="mining"]').val(v_glass);
                        }
                    })  
                }
            }); 
        })
    </script>
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
