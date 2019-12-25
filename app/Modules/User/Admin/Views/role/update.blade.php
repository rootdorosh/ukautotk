@extends('admin.layouts.main')

@section('title', __('user::role.title.update'))
@section('module', 'user')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header p-2 border-bottom-0">
        <h3 class="card-title float-sm-left">{{ __('user::role.title.update') }}</h3>
    </div>    
    <div class="card-body">    
        @include('User.admin::role._form', [
            'action' => route('admin.user.roles.update', [$role->id]),
        ])
    </div>    
</div>    
    
@endsection