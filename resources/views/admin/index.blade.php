<x-app-layout>

    <x-slot name="header">
        <a href="{{route('admin.index')}}" class="grow">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-users text-gray-600 text-2xl mr-2"></i>
            {{ __('System Administration') }}
        </h2>
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-3 gap-8 p-8">

                @role('staff|admin|super-admin')
                <a href="{{ route('admin.roles.index') }}"
                   class="border p-6 hover:bg-blue-500 hover:text-white grow">
                    <h3 class="text-xl">Roles</h3>
                    <p>This could be a card with statistics about Roles</p>
                </a>
                @endrole

                @role('staff|admin|super-admin')
                <a href="{{ route('admin.permissions.index') }}"
                   class="border p-6 hover:bg-blue-500 hover:text-white grow">
                    <h3 class="text-xl">Permissions</h3>
                    <p>This could be a card with statistics about Permissions</p>
                </a>
                @endrole

                @role('staff|admin|super-admin')
                <a href="{{ route('admin.users.index') }}"
                   class="border p-6 hover:bg-blue-500 hover:text-white grow">
                    <h3 class="text-xl">Users</h3>
                    <p>This could be a card with statistics about Permissions</p>
                </a>
                @endrole

                @role('staff|admin|super-admin')
                <a href="{{ route('admin.index') }}"
                   class="border p-6 hover:bg-blue-500 hover:text-white grow">
                    <h3 class="text-xl">Another Admin Link</h3>
                    <p>This could be a card with statistics about Permissions</p>
                </a>
                @endrole

            </div>
        </div>
    </div>
</x-app-layout>
