<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                <div class="overflow-x-auto rounded border border-gray-300 shadow-sm">

                    <div class="flex flex-1 justify-between p-2 items-end bg-gray-200">
                        <h2 class="text-2xl ">Create New Permission</h2>

                        <div class="space-x-4 py-2">
                            <a href="{{ route('admin.permissions.index') }}"
                               class="rounded bg-blue-500 text-white hover:bg-white hover:text-blue-500 border-blue-500 px-4 py-2">
                                All Permissions
                            </a>

                            @can('add permission')
                                <a href="{{ route('admin.permissions.create') }}"
                                   class="rounded bg-green-500 text-white hover:bg-white hover:text-green-500 border-green-500 px-4 py-2">
                                    New Permission
                                </a>
                            @endcan
                        </div>

                    </div>

                    @can('add permission')

                        <form action="{{ route('admin.permissions.store') }}"
                              method="POST"
                              class="p-6 flex flex-col space-y-4">

                            @csrf

                            <div>
                                <x-input-label for="name" :value="__('Permission Name')"/>

                                <x-text-input id="name" class="block mt-1 w-full" type="name" name="name"
                                              :value="old('name')" required/>

                                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                            </div>

                            <div class="flex flex-row space-x-4">

                                <x-primary-button>
                                    Save
                                </x-primary-button>
                                <x-link-button href="{{route('admin.permissions.index')}}">
                                    Cancel
                                </x-link-button>
                            </div>
                        </form>

                    @else
                        <p class="p-6 bg-red-500 text-white">You are not able to create new permissions</p>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
