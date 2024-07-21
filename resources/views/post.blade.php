<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-4xl mx-auto bg-white p-8 shadow-lg rounded-lg">
            <a href="/laravel11/posts" class="text-blue-500 hover:underline mb-4 block"> &laquo; Back to all posts</a>
            <article class="mb-10">
                <div class="flex items-center mb-4">
                    <div id="author-img" class="inline-block w-12 h-12 mr-4  rounded-full bg-gray-300"></div>
                    <div>
                        <a href="/laravel11/authors/{{ $post->author->username }}" class="hover:underline ml-4 text-xl font-semibold">{{ $post->author->name }}</a>
                        <div class="text-sm text-gray-500 ml-4">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <h2 class="text-3xl font-semibold text-blue-600 mb-4">{{ $post['title'] }}</h2>
                <span class="inline-block text-sm font-semibold text-blue-600 bg-blue-200 rounded-full px-2 py-1 mb-4">{{ $post->category->name }}</span>
                <p class="leading-relaxed text-justify mb-4">
                    {{ $post['detail'] }}
                </p>
            </article>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('https://randomuser.me/api/')
                .then(response => response.json())
                .then(data => {
                    const user = data.results[0];
                    const img = document.createElement('img');
                    img.src = user.picture.large;
                    img.classList.add('w-12', 'h-12', 'rounded-full');
                    document.getElementById('author-img').replaceWith(img);
                })
                .catch(error => console.error('Error fetching user image:', error));
        });
    </script>
</x-layout>
