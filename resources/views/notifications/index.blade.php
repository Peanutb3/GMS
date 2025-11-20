<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notifications') }}
            </h2>
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Mark all as read
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($notifications->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($notifications as $notification)
                            <div class="p-6 hover:bg-gray-50 transition {{ $notification->is_read ? 'opacity-75' : '' }}">
                                <div class="flex items-start space-x-4">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full flex items-center justify-center 
                                            @if($notification->color === 'red') bg-red-100
                                            @elseif($notification->color === 'green') bg-green-100
                                            @elseif($notification->color === 'blue') bg-blue-100
                                            @elseif($notification->color === 'yellow') bg-yellow-100
                                            @elseif($notification->color === 'purple') bg-purple-100
                                            @else bg-gray-100
                                            @endif">
                                            @if($notification->icon === 'grievance')
                                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            @elseif($notification->icon === 'resolved')
                                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @elseif($notification->icon === 'scheduled')
                                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @elseif($notification->icon === 'request')
                                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            @else
                                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-semibold text-gray-900 flex items-center">
                                                {{ $notification->title }}
                                                @if(!$notification->is_read)
                                                    <span class="ml-2 h-2 w-2 rounded-full bg-red-500"></span>
                                                @endif
                                            </p>
                                            <div class="flex items-center space-x-2">
                                                <p class="text-xs text-gray-500">{{ $notification->time_ago }}</p>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                        
                                        <div class="mt-3 flex items-center space-x-4">
                                            @if($notification->link)
                                                <a href="{{ $notification->link }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                    View details →
                                                </a>
                                            @endif
                                            
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                                        Mark as read
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:text-red-700" onclick="return confirm('Delete this notification?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No notifications</h3>
                        <p class="mt-2 text-sm text-gray-500">You're all caught up! Check back later for updates.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
