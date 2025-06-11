<x-app-layout>

    <x-slot name="header">
        <a href="{{route('posts.index')}}" class="grow">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight grow">
                {{ __('Posts') }}
            </h2>
        </a>

        <div class="flex space-x-4">

        <a href="{{ route('posts.create') }}"
           class="text-green-800 hover:text-green-100
                 bg-gray-100 hover:bg-green-800
                 border border-gray-300
                 rounded-lg
                 transition ease-in-out duration-200
                 px-4 py-1">
            New Post
            <i class="fa-solid fa-file-circle-plus"></i>
        </a>

        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <h5>
                            {{ __('Details for') }}
                            <em>{{ $post->name }}</em>
                        </h5>
                    </header>

                    <section class="px-4 flex flex-col text-gray-800">

                        <div class="grid grid-rows-3 mt-6 ">
                            <p class="text-gray-500 text-sm ">Name:</p>
                            <p class="w-full ml-4">
                                {{ $post->name ?? "No Name provided" }}
                            </p>
                        </div>

                        <div class="grid grid-rows-3  ">
                            <p class="text-gray-500 text-sm ">Email:</p>
                            <p class="w-full ml-4">
                                {{ $post->email ?? "No Email Provided" }}
                            </p>
                        </div>

                        <div class="grid grid-rows-3  ">
                            <p class="text-gray-500 text-sm ">Role:</p>
                            <p class="w-full ml-4">
                                {{ $post->role ?? "No Role Provided" }}
                            </p>
                        </div>

                        <div class="grid grid-rows-3  ">
                            <p class="text-gray-500 text-sm ">Added:</p>
                            <p class="w-full ml-4">
                                {{ $post->created_at->format('j M Y') }}
                            </p>
                        </div>

                        <div class="grid grid-rows-3  ">
                            <p class="text-gray-500 text-sm ">Last Updated:</p>
                            <p class="w-full ml-4">
                                {{ $post->updated_at->format('j M Y') }}
                            </p>
                        </div>

                        <!-- Only Admin and Staff access these options -->
                        <form method="POST"
                              class="flex my-8 gap-6 ml-4"
                              action="{{ route('posts.delete', $post) }}">

                            @csrf

                            <a href="{{ route('posts.index') }}"
                               class="bg-gray-100 hover:bg-blue-500
                                          text-blue-800 hover:text-gray-100 text-center
                                          border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-24 rounded">
                                <i class="fa-solid fa-post inline-block"></i>
                                {{ __('All Posts') }}
                            </a>

                            <a href="{{ route('posts.edit', $post) }}"
                               class="bg-gray-100 hover:bg-amber-500
                                        text-amber-800 hover:text-gray-100  text-center
                                          border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-24 rounded">
                                <i class="fa-solid fa-post-edit text-sm"></i>
                                {{ __('Edit') }}
                            </a>

                            <button type="submit"
                                    class="bg-gray-100 hover:bg-red-500
                                             text-red-800 hover:text-gray-100 text-center
                                             border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-16 rounded">
                                <i class="fa-solid fa-post-minus text-sm"></i>
                                {{ __('Delete') }}
                            </button>

                        </form>
                        <!-- /Only Admin and Staff access these options -->

                    </section>

                </article>

            </div>
        </div>
    </div>
</x-app-layout>
