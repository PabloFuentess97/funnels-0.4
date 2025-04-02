@foreach($notifications as $notification)
    <div class="p-4 sm:px-6 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}" id="notification-{{ $notification->id }}">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h3 class="text-sm font-medium text-gray-900">
                    {{ $notification->title }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $notification->message }}
                </p>
                <div class="mt-2 flex items-center text-xs text-gray-500">
                    <time datetime="{{ $notification->created_at->format('Y-m-d H:i:s') }}">
                        {{ $notification->created_at->diffForHumans() }}
                    </time>
                    @if($notification->read_at)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Leída
                        </span>
                    @else
                        <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="ml-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200">
                                Marcar como leída
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @if($notification->data && isset($notification->data['action_url']))
                <div class="ml-4">
                    <a href="{{ $notification->data['action_url'] }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                        Ver detalles
                    </a>
                </div>
            @endif
        </div>
    </div>
@endforeach
