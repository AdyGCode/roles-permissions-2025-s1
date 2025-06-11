<x-app-layout>

    <x-slot name="header">
        <a href="{{route('posts.index')}}" class="grow">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight grow">
                {{ __('Posts') }}
            </h2>
        </a>

        <div class="flex space-x-4">

            @can('add post')
                <a href="{{ route('posts.create') }}"
                   class="text-green-800 hover:text-green-100
                 bg-gray-100 hover:bg-green-800
                 border border-gray-300
                 rounded-lg
                 transition ease-in-out duration-200
                 px-4 py-1">
                    New Post
                    <i class="fa-solid fa-file-circle-minus"></i>
                </a>
            @endcan

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-red-500 text-red-50 text-lg px-4 py-4">
                        <h5 class="text-2xl font-bold">
                            {{ __('Confirm Deletion') }}:
                            <em class="font-light">{{ $post->title }}</em>
                        </h5>
                    </header>

                    <section class="px-4 flex flex-col text-gray-800 space-y-4 mt-6">

                        <div class="w-full border grid grid-cols-8 space-x-4">
                            <p class="text-gray-500 text-sm col-span-1">Title:</p>
                            <p class="col-span-7">
                                {{ $post->title ?? "No Title provided" }}
                            </p>
                        </div>

                        <div class="w-full border grid grid-cols-8 space-x-4">
                            <p class="text-gray-500 text-sm col-span-1">Excerpt:</p>
                            <p class="col-span-7">
                                {{ $post->excerpt() ?? "No extract available" }}
                            </p>
                        </div>

                        <div class="w-full border grid grid-cols-8 space-x-4">
                            <p class="text-gray-500 text-sm col-span-1">Added:</p>
                            <p class="col-span-7">
                                {{ $post->created_at->format('j M Y') }}
                            </p>
                        </div>

                        <div class="w-full border grid grid-cols-8 space-x-4">
                            <p class="text-gray-500 text-sm col-span-1">Last Updated:</p>
                            <p class="col-span-7">
                                {{ $post->updated_at->format('j M Y') }}
                            </p>
                        </div>

                        <!-- Only Admin and Staff access these options -->
                        <form method="POST"
                              class="w-full mt-4 mb-8 gap-4 flex flex-col text-gray-800"
                              action="{{ route('posts.destroy', $post) }}">

                            @csrf
                            @method('delete')

                            <div class="flex flex-row space-x-6  ">

                                <a href="{{ route('posts.index') }}"
                                   class="bg-gray-100 hover:bg-blue-500
                                          text-blue-800 hover:text-gray-100 text-center
                                          border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-24 rounded">
                                    <i class="fa-solid fa-times inline-block"></i>
                                    {{ __('Cancel') }}
                                </a>

                                <button type="submit"
                                        class="bg-gray-100 hover:bg-red-500
                                             text-red-800 hover:text-gray-100 text-center
                                             border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-32 rounded">
                                    <i class="fa-solid fa-file-circle-minus-minus text-sm"></i>
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </form>
                        <!-- /Only Admin and Staff access these options -->

                    </section>


                </article>

            </div>
        </div>
    </div>
</x-app-layout>
