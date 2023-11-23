@extends('layouts.simple')

@section('content')
    <div class="container small">
        <h1 class="list-heading">{{ trans('notifications.notification') }}</h1>
        {{-- @if(count($notifications) > 0)
            <div class="activity-list card px-xl py-m">
                @foreach($notifications as $notification)
                    <div class="activity-list-item">
                        <div>
                            @if($notification->user)
                                <img class="avatar" src="{{ $notification->user->getAvatar(30) }}" alt="{{ $notification->user->name }}">
                            @endif
                        </div>
                        
                        <div>
                            @if($notification->user)
                                <span>{{ $notification->user->name }}</span>
                            @else
                                {{ trans('common.deleted_user') }}
                            @endif
                        
                            {{ $notification->getText() }}
                        
                            @if($notification->entity && is_null($notification->entity->deleted_at))
                                <span>{{ $notification->entity->name }}</span>
                            @endif
                        
                            @if($notification->entity && !is_null($notification->entity->deleted_at))
                                "{{ $notification->entity->name }}"
                            @endif
                        
                            <br>
                        
                            <span class="text-muted"><small>@icon('time'){{ $notification->created_at->diffForHumans() }}</small></span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted empty-text mb-none pb-l">{{ trans('common.no_notification') }}</p>
        @endif --}}

        <div class="card py-m">
            <div class="px-m">
                <div class="entity-list compact">
                    @foreach($notifications as $notification)
                        <a href="" class="page entity-list-item" data-entity-type="page" data-entity-id="262">

                            <div>
                                @if($notification->user)
                                    <img class="avatar" src="{{ $notification->user->getAvatar(30) }}" alt="{{ $notification->user->name }}">
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="entity-list-item-name break-text">
                                    @if($notification->user)
                                        {{ $notification->user->name }} 
                                    @else
                                        {{ trans('common.deleted_user') }}
                                    @endif
                                    
                                    {{ $notification->getText() }}

                                    @if($notification->entity && is_null($notification->entity->deleted_at))
                                        {{ $notification->entity->name }}
                                    @endif

                                    @if($notification->entity && !is_null($notification->entity->deleted_at))
                                        "{{ $notification->entity->name }}"
                                    @endif
                                </h4>

                                <br>
                            
                                <span class="text-muted"><small>@icon('time'){{ $notification->created_at->diffForHumans() }}</small></span>
                            </div>
                        </a>   
                    @endforeach
                </div>
            </div>
        </div>   
    </div>
@stop