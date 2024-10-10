@props(['post','full' => false])

<div class="card">

    <h2 class="font-bold text-xl mb-2"> {{ $post->title }}</h2>


    <div class="text-xs font-light mb-4">
        <span>
            POSTED {{ $post->created_at->diffForHumans() }}
        </span>
        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium">{{ $post->user->userName }}</a>
    </div>


    {{-- body --}}
    @if ($full)
        <div class="text-sm">
            <p>
                {{ $post->body }}
            </p>
        </div>
    @else
        <div class="text-sm">
            <span>
                {{ Str::words($post->body, 15) }}
            </span>
            <a href="{{ route('posts.show', $post) }} " class="text-blue-500 mt-1"> Read more &rarr;</a>
        </div>
    @endif

    <div class="mt-2">
        {{$slot}}
    </div>

</div>
