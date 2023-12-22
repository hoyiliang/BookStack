@extends('layouts.simple')

@section('content')
    <div class="container small">
        <div class="flex-container-row justify-space-between items-center">
            <h1 class="list-heading">{{ trans('notifications.notification') }}</h1>
            @if (count(auth()->user()->unreadNotifications) > 0)
                <div>
                    <form action="{{ url('/notification/mark-all-as-read') }}" method="POST">
                        {{ csrf_field() }}
                        
                        <button class="icon-list-item text-link">
                            {{ trans('notifications.mark_all_as_read') }}
                        </button>
                    </form>
                </div> 
            @endif
        </div>

        @if (count($notifications) > 0)
            <div class="card py-m">
                <div class="px-m">
                    <div class="entity-list compact">
                        @foreach($notifications as $notification)
                            @php
                                $data = $notification->data;
                                $creator = BookStack\Users\Models\User::findOrFail($data['activity_creator']['id']);

                                if ($notification->type == "BookStack\Activity\Notifications\Messages\PageUpdateNotification") {
                                    $entity = BookStack\Entities\Models\Page::findOrFail($data['activity_detail']['id']);
                                    $description = trans('activities.page_update');
                                } else { // BookStack\Activity\Notifications\Messages\CommentCreationNotification
                                    if($data['activity_detail']['entity_type'] == "page") {
                                        $entity = BookStack\Entities\Models\Page::findOrFail($data['activity_detail']['entity_id']);
                                    }
                                    $description = trans('activities.commented_on');
                                }
                            @endphp

                            <form action="{{ url('/notification/mark-as-read') }}" method="POST">
                                {{ csrf_field() }}

                                <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                                <button type="submit" class="page entity-list-item flex-container-row justify-space-between text-left" data-entity-type="page" data-entity-id="{{ $entity->id }}">
                                    <div class="flex-container-row gap-m">
                                        <div>
                                            @if($creator)
                                                <img class="avatar" src="{{ $creator->getAvatar(30) }}" alt="{{ $creator->name }}">
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <h4 class="entity-list-item-name break-text">
                                                @if($creator)
                                                    {{ $creator->name }} 
                                                @else
                                                    {{ trans('common.deleted_user') }}
                                                @endif
                                                
                                                {{ $description }} {{ $entity->name }}
                                            </h4>
            
                                            <br>
                                        
                                            <span class="text-muted"><small>@icon('time'){{ $notification->created_at->diffForHumans() }}</small></span>
                                        </div>
                                    </div>

                                    <div>
                                        @if (!$notification->read_at)
                                            <div class="primary-background" style="width:8px; height:8px; border-radius:50%;"></div>
                                        @endif
                                    </div>
                                </button>  
                            </form> 
                        @endforeach
                    </div>
                </div>
            </div>  

            <div class="text-center">
                {{ $notifications->links() }}
            </div>

            <div class="flex-container-row mt-m">
                <form action="{{ url('/notification/delete-all') }}" method="POST">
                    {{ csrf_field() }}

                    <button type="submit" class="icon-list-item inline-block text-neg">
                        {{ trans('notifications.delete_all') }}
                    </button>
                </form>
            </div>
        @else
            {{ trans('common.no_notification') }}
        @endif
    </div>
@stop