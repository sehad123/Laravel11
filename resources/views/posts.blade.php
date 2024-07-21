<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-7xl mx-auto mb-6 flex justify-between items-center">
            <input type="text" id="search" placeholder="Search by title or author" class="w-full p-3 border rounded-lg mr-4">
        </div>
        <div id="pagination" class="flex space-x-2 my-10 ml-4"></div>

        <div id="posts-container" class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
            <article class="post bg-white p-6 shadow-lg rounded-lg hidden">
                <div class="mb-4">
                    <span class="text-xs font-semibold text-yellow-600 bg-yellow-200 rounded-full px-2 py-1">{{ $post->category->name }}</span>
                    <span class="text-sm text-gray-500 float-right">{{ $post->created_at->diffForHumans() }}</span>
                </div>
                <h2 class="post-title text-xl font-semibold hover:underline text-blue-600 mb-2">{{ $post['title'] }}</h2>
                <p class="leading-relaxed text-justify mb-4">
                    {{ Str::limit($post['detail'], 100) }}
                </p>
                <div class="flex items-center">
                    <span id="author-img-{{ $loop->index }}" class="inline-block w-10 h-10 mr-2 rounded-full bg-gray-300"></span>
                    <a href="/laravel11/authors/{{ $post->author->username }}" class="post-author hover:underline">{{ $post->author->name }}</a>
                </div>
                <a href="/laravel11/posts/{{ $post['slug'] }}" class="text-blue-500 hover:underline mt-4 block">Read More &raquo;</a>
            </article>
            @endforeach
        </div>
        <p id="no-results" class="hidden text-center text-red-500">Pencarian tidak ditemukan</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const posts = document.querySelectorAll('.post');
            const postsContainer = document.getElementById('posts-container');
            const pagination = document.getElementById('pagination');
            const searchInput = document.getElementById('search');
            const noResults = document.getElementById('no-results');
            const postsPerPage = 19;
            let currentPage = 1;

            function displayPosts(page) {
                posts.forEach((post, index) => {
                    post.style.display = 'none';
                    if (index >= (page - 1) * postsPerPage && index < page * postsPerPage) {
                        post.style.display = 'block';
                    }
                });
            }

            function setupPagination(totalPosts) {
                const pageCount = Math.ceil(totalPosts / postsPerPage);
                pagination.innerHTML = '';

                for (let i = 1; i <= pageCount; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.innerText = i;
                    pageButton.classList.add('px-3', 'py-1', 'rounded', 'bg-gray-300', 'hover:bg-gray-400', 'focus:outline-none', 'focus:bg-gray-500');
                    if (i === currentPage) {
                        pageButton.classList.add('bg-gray-500', 'text-white');
                    }

                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        displayPosts(currentPage);
                        setupPagination(totalPosts);
                    });

                    pagination.appendChild(pageButton);
                }
            }

            function filterPosts() {
                const searchTerm = searchInput.value.toLowerCase();
                let filteredPosts = Array.from(posts).filter(post => {
                    const title = post.querySelector('.post-title').innerText.toLowerCase();
                    const author = post.querySelector('.post-author').innerText.toLowerCase();
                    return title.includes(searchTerm) || author.includes(searchTerm);
                });

                if (filteredPosts.length === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }

                posts.forEach(post => post.style.display = 'none');
                filteredPosts.forEach((post, index) => {
                    if (index < postsPerPage) {
                        post.style.display = 'block';
                    }
                });

                setupPagination(filteredPosts.length);
                currentPage = 1;
                displayPosts(currentPage);
            }

            fetch('https://randomuser.me/api/?results={{ count($posts) }}')
                .then(response => response.json())
                .then(data => {
                    data.results.forEach((user, index) => {
                        const img = document.createElement('img');
                        img.src = user.picture.thumbnail;
                        img.classList.add('w-10', 'h-10', 'rounded-full');
                        document.getElementById(`author-img-${index}`).replaceWith(img);
                    });
                })
                .catch(error => console.error('Error fetching user images:', error));

            searchInput.addEventListener('input', filterPosts);

            setupPagination(posts.length);
            displayPosts(currentPage);
        });
    </script>
</x-layout>
