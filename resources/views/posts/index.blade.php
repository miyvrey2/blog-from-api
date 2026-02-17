<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="font-bold pb-6 text-xl text-gray-700 leading-tight">
                        {{ __('posts.posts') }}
                    </h1>

                    @forelse($posts as $post)
                        <article class="pb-4">
                            <a class="font-bold" href="{{ url(route('posts.show', $post)) }}">{{ $post->title }}</a>
                            <p>{{ get_snippet($post->body, 15) }}</p>
                            <em>{{ __('core.by') . ": " . $post->author->name }}</em>
                        </article>

                    @empty
                        {{ __('posts.no_posts_found') }}
                    @endforelse
                </div>
                <div class="p-6 pt-0 text-gray-900">
                    @if($posts)
                        {{ $posts->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
