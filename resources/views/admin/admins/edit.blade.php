@extends('layouts.master')
@section('title')
    @lang('translation.Admin_Detail')
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle')
            @lang('translation.Home')
        @endslot
        @slot('MenuTitle')
            @lang('translation.Admin_Menu')
        @endslot
          @slot('ParentTitle')
            @lang('translation.Admin_Manager')
        @endslot
        @slot('childrenTitle')
            @lang('translation.Admin_List')
        @endslot
        @slot('title')
            @lang('translation.Admin_Detail')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form acction="{{route('admin.admins.update',$user->id)}}" method="POST"> 
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Email')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="email" 
                                    placeholder="@lang('translation.Email')" value="{{ $user->email }}" name="email" readonly/>
                                @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.id')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{{ $user->nick_name }}"
                                    id="example-text-input" name="nick_name" />
                                     @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('nick_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Contract')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number" value="{{ $user->number_phone }}"
                                    id="example-text-input" name="number_phone" />
                                    @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('number_phone') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Full_Name')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{{ $user->full_name }}"
                                    id="example-text-input" name="full_name" />
                                     @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('full_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Date_of_Joining')</label>
                            <div class="col-md-4">
                              <label for="example-text-input" class="col-md-4 col-form-label">   {{$user->date_of_joining }} </label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Rank')</label>
                            <div class="col-md-4">
                                <select class="form-select" name="rank_id">
                                    <option value="{{$user->rank->id}}">{{ $user->rank->name }}</option>
                                    @foreach ( $ranks as $rank )
                                        <option value="{{$rank->id}}">{{$rank->name}}</option>
                                    @endforeach
                                </select>
                                  @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('rank_id') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Status_Member')</label>
                            <div class="col-md-4">
                                <select class="form-select" name="status_user_id">
                                    <option value="{{$user->status_user_id}}">{{ $user->status_name }}</option>
                                    @foreach ( $status_users as $key => $status_user )
                                        <option value="{{$status_user}}">{{trans('translation.'.$key)}}</option>
                                    @endforeach
                                </select>
                                  @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('status_user') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('admin.admins.index') }}" class="btn btn-info waves-effect waves-light">@lang('translation.Back_page')</a>
                                    <button  type="submit" class="btn btn-primary  waves-effect waves-light ms-2">@lang('translation.Update')</button>
                                </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
