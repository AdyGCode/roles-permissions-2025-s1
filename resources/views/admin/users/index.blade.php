<x-app-layout>

    <x-slot name="header">
        <a href="{{route('admin.users.index')}}" class="grow">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fa-solid fa-users text-gray-600 text-2xl mr-2"></i>
                {{ __('Users') }}
            </h2>
        </a>

        <div class="flex space-x-4">
            @can('add user')
                <a href="{{ route('admin.users.create') }}"
                   class="text-green-800 hover:text-green-100
                 bg-gray-100 hover:bg-green-800
                 border border-gray-300
                 rounded-lg
                 transition ease-in-out duration-200
                 px-4 py-1">

                    <i class="fa-solid fa-user-plus pr-1 aria-hidden:true"></i>

                    New User
                </a>
            @endcan

            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-row gap-0">
                <x-text-input id="search"
                              type="text"
                              name="search"
                              class="border border-gray-200 rounded-r-none shadow-transparent"
                              :value="$search??''"
                />

                <button type="submit"
                        class="text-gray-800 hover:text-gray-100
                         bg-gray-100 hover:bg-gray-800
                           border border-gray-300
                           rounded-lg
                           transition ease-in-out duration-200
                           px-4 py-1
                           rounded-l-none">
                    <i class="fa-solid fa-magnifying-glass pr-1 aria-hidden:true"></i>
                    Search
                </button>
            </form>

        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="grid grid-cols-10 bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <span class="col-span-1">#</span>
                        <span class="col-span-3">User</span>
                        <span class="col-span-1">Added</span>
                        <span class="col-span-2">Role</span>
                        <span class="col-span-3">Actions</span>
                    </header>

                    @foreach ($users as $user)
                        <section
                            class="px-4 grid grid-cols-12 py-1 hover:bg-gray-100 border-b border-b-gray-300 transition duration-150">
                            <p class="col-span-1">{{ $loop->index + 1 }}</p>

                            <h5 class="flex flex-col col-span-4 text-gray-800">
                                {{ $user->name }}
                                <br>
                                <small class="text-xs text-gray-400">
                                    {{ $user->email }}
                                </small>
                            </h5>

                            <p class="text-xs text-gray-400 col-span-1 p-1">
                                {{ $user->created_at->format('j M Y') }}
                            </p>

                            <p class="col-span-2 space-x-0.5 ">
                                @foreach($user->roles as $role)
                                    <span
                                        class="inline-block align-middle text-xs bg-gray-800 text-gray-100 rounded-full px-2 py-0.5">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </p>

                            <!-- Only Admin and Staff access these options -->
                            @role('staff|admin|super-admin')
                            <form method="POST"
                                  class="col-span-4 space-x-2 flex px-0 overflow-hidden"
                                  action="{{ route('admin.users.delete', $user) }}">

                                @csrf

                                @can('read user')
                                    <x-link-button
                                        href="{{ route('admin.users.show', $user) }}"
                                        class="bg-gray-700 hover:bg-blue-500!
                                                text-blue-500! hover:text-gray-100! text-center
                                                transition ease-in-out duration-300
                                                group px-8 py-1.5">
                                        <i class="fa-solid fa-user mr-4 aria-hidden:true group-hover:text-white "></i>
                                        {{ __('Show') }}
                                    </x-link-button>
                                @endcan

                                @can('edit user')
                                    <x-link-button
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="bg-gray-700 hover:bg-amber-500!
                                             text-amber-500! hover:text-gray-100!  text-center
                                               transition ease-in-out duration-300
                                                group px-8 py-1.5">
                                        <i class="fa-solid fa-user-edit mr-4 aria-hidden:true group-hover:text-white "></i>
                                        {{ __('Edit') }}
                                    </x-link-button>
                                @endcan

                                @can('delete user')
                                    <x-secondary-button type="submit"
                                                        class="hover:bg-red-500
                                                             text-red-500! hover:text-gray-100!
                                                             text-center
                                                             transition ease-in-out duration-300
                                                             group ">
                                        <i class="fa-solid fa-user-minus mr-4 aria-hidden:true group-hover:text-white "></i>
                                        {{ __('Delete') }}
                                    </x-secondary-button>
                                @endcan

                            </form>
                            @endrole
                            <!-- /Only Admin and Staff access these options -->

                        </section>
                    @endforeach
                    <footer class="px-4 pb-2 pt-4 ">
                        {{ $users->links() }}
                    </footer>
                </article>

            </div>
        </div>
    </div>
</x-app-layout>
