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

                    <div class="flex flex-1 justify-between p-2 items-end bg-gray-200">
                        <h2 class="text-2xl ">Roles</h2>
                        <a href="{{ route('admin.roles.create') }}"
                           class="rounded bg-green-500 text-white hover:bg-white hover:text-green-500 border-green-500 px-4 py-2">
                            New Role
                        </a>
                    </div>

                    <table class="min-w-full divide-y-2 divide-gray-200">

                        <thead class="ltr:text-left rtl:text-right">
                        <tr class="*:font-medium *:text-gray-900">
                            <th class="px-3 py-2 whitespace-nowrap">Role Name</th>
                            <th class="px-3 py-2 whitespace-nowrap">Actions</th>

                        </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                        @foreach($roles as $role)
                            <tr class="*:text-gray-900 *:first:font-medium">
                                <td class="px-3 py-2 whitespace-nowrap">{{ $role->name }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">

                                    <x-link-button
                                        class="hover:bg-amber-400 focus:bg-amber-400 active:bg-amber-400"
                                        href="{{ route('admin.roles.edit', $role) }}">
                                        Edit
                                    </x-link-button>

                                    <x-link-button
                                        class="hover:bg-red-500 focus:bg-red-400 active:bg-red-400"
                                        href="{{ route('admin.roles.delete', $role) }}">
                                        Delete
                                    </x-link-button>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="2" class="p-3">
                                @if( $roles->hasPages())
                                    {{ $roles->links() }}
                                @else
                                    <p class="text-sm text-gray-500">All Roles shown</p>
                                @endif
                            </td>
                        </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
