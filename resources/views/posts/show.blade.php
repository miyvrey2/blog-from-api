<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="font-bold text-xl text-gray-700 leading-tight">
                        {{ $post->title }}
                    </h1>

                    <em class="pb-6 block">{{ __('core.by') . ": " . $post->author->name }}</em>

                    <p> {{ $post->body }}</p>
                </div>
            </div>
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="pb-3 font-semibold text-l text-gray-600 leading-tight">{{ __('posts.comments') }}</h2>
                    @forelse($post->comments as $comment)
                        <div class="mb-6">
                            <strong title="{{ $comment->email }}">{{ $comment->name }}</strong> {{ __('core.said') }} <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            <p>{{ $comment->body }}</p>
                        </div>
                    @empty
                        {{ __('Geen comments geplaatst. Start de discussie!') }}
                    @endforelse
                </div>
            </div>

            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="pb-3 font-semibold text-l text-gray-600 leading-tight">{{ __('posts.write_a_comment') }}</h2>
                    <form method="POST" action="{{ route('comments.store', $post) }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name" class="block font-semibold">{{ __('posts.attributes.name') }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name') ?? '' }}" placeholder="Peter Pan" required class="block w-full" />
                            @error('name')
                                <div class="alert alert-danger text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="email" class="block font-semibold">{{ __('posts.attributes.email') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email') ?? '' }}" placeholder="info@example.nl" required class="block w-full" />
                            @error('email')
                                <div class="alert alert-danger text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="body" class="block font-semibold">{{ __('posts.attributes.body') }}</label>
                            <textarea id="body" name="body" required class="block w-full">{{ old('body') ?? '' }}</textarea>
                            @error('body')
                            <div class="alert alert-danger text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">{{ __('core.save') }}</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
