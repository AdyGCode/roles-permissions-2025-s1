<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                <div class="overflow-x-auto rounded border border-gray-300 shadow-sm">

                    <div class="flex flex-1 justify-between px-6 py-3 items-end bg-gray-200">
                        <h2 class="text-2xl ">Edit Role</h2>

                        <div class="space-x-4 py-2">
                            <a href="{{ route('admin.roles.index') }}"
                               class="rounded bg-blue-500 text-white hover:bg-white hover:text-blue-500 border-blue-500 px-4 py-2">
                                All Roles
                            </a>

                            @can('add role')
                                <a href="{{ route('admin.roles.create') }}"
                                   class="rounded bg-green-500 text-white hover:bg-white hover:text-green-500 border-green-500 px-4 py-2">
                                    New Role
                                </a>
                            @endcan
                        </div>

                    </div>

                    @can('edit role')
                        <form action="{{ route('admin.roles.update', $role) }}"
                              method="POST"
                              class="p-6 flex flex-col space-y-4">

                            @csrf
                            @method('patch')

                            <div>

                                <x-input-label for="name" :value="__('Role Name')"/>

                                <x-text-input id="name" class="block mt-1 w-full" type="name" name="name"
                                              :value="old('name')??$role->name" required/>

                                <x-input-error :messages="$errors->get('name')" class="mt-2"/>

                            </div>

                            <div class="flex flex-row space-x-4">

                                <x-primary-button type="submit">
                                    Save
                                </x-primary-button>
                                <x-link-button href="{{route('admin.roles.index')}}">
                                    Cancel
                                </x-link-button>

                            </div>
                        </form>

                        <section class="grid grid-cols-2 space-y-2 mt-4 px-6  space-x-8">
                            <div class="-mx-6 bg-gray-100 col-span-2 px-6 pb-2">

                                <h3 class="-mx-6 px-6 py-2 text-lg font-semibold col-span-2 bg-gray-100">
                                    Current Permissions
                                </h3>

                                <div class="flex flex-row gap-1 flex-wrap pb-2">

                                    @forelse($rolePermissions as $rolePermission)
                                        <p class="text-xs bg-gray-700 text-gray-100 p-1 px-2 rounded-full whitespace-nowrap">{{ $rolePermission->name }}</p>
                                    @empty
                                        <p class="text-gray-600 text-sm">
                                            No Permissions
                                        </p>
                                    @endforelse

                                </div>
                            </div>

                            <div class="mt-2 mb-6 bg-gray-100 shadow border border-gray-300 rounded p-4 pt-2">

                                <h3 class="mb-2 bg-gray-300 text-gray-800 px-4 py-1 -mt-2 -mx-4">Add Permissions</h3>

                                <form method="POST" action="{{ route('admin.roles.permissions', $role->id) }}">

                                    @csrf

                                    <div class="sm:col-span-6">

                                        <x-input-label for="permission" :value="__('Permission')"/>

                                        <select id="permission" name="permission" autocomplete="permission-name"
                                                class="mt-1 mb-4 block w-full py-1 px-3
                                                   border border-gray-300 bg-white rounded-md shadow-sm
                                                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                                                   sm:text-sm">

                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->name }}">
                                                    {{ $permission->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        <x-input-error :messages="$errors->get('permission')" class="mt-2"/>
                                    </div>

                                    <x-primary-button class="bg-green-600 hover:bg-green-500 text-white" type="submit">
                                        Assign
                                    </x-primary-button>
                                </form>
                            </div>

                            @if ($role->permissions)

                                <div class="mt-2 mb-6 bg-gray-100 shadow border border-gray-300 rounded px-4 pt-2">
                                    <h3 class="mb-2 bg-gray-300 text-gray-800 px-4 py-1 -mt-2 -mx-4">
                                        Revoke Permissions
                                    </h3>

                                    <div class="flex space-x-4 flex-wrap">

                                        @foreach ($role->permissions as $rolePermission)

                                            <form class="px-0 py-1 text-white rounded-md"
                                                  method="POST"
                                                  action="{{ route('admin.roles.permissions.revoke',
                                                            [$role->id, $rolePermission->id]) }}"
                                                  onsubmit="return confirm('Are you sure?');">

                                                @csrf
                                                @method('DELETE')

                                                <x-danger-button type="submit" class="px-2! py-1!">
                                                    {{ $rolePermission->name }}
                                                </x-danger-button>

                                            </form>

                                        @endforeach

                                    </div>
                                </div>

                            @endif

                            @else
                                <p class="p-6 bg-red-500 text-white">You are not able to edit roles</p>
                            @endcan


                        </section>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
