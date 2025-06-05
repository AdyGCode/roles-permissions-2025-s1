<x-app-layout>

    <x-slot name="header">
        <a href="{{route('admin.users.index')}}" class="grow">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight grow">
            {{ __('Users') }}
        </h2>
        </a>

        <div class="flex space-x-4">

        <a href="{{ route('admin.users.create') }}"
           class="text-green-800 hover:text-green-100
                 bg-gray-100 hover:bg-green-800
                 border border-gray-300
                 rounded-lg
                 transition ease-in-out duration-200
                 px-4 py-1">
            New User
            <i class="fa-solid fa-user-plus"></i>
        </a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <h5>
                            {{ __('Edit User') }}
                        </h5>
                    </header>

                    <section>

                        <form method="POST"
                              class="my-4 px-4 gap-4 flex flex-col text-gray-800"
                              action="{{ route('admin.users.update', $user) }}">

                            @csrf
                            @method('patch')

                            <div class="flex flex-col">

                                <x-input-label for="name" :value="__('Name')"/>

                                <x-text-input id="name" class="block mt-1 w-full"
                                              type="text"
                                              name="name"
                                              :value="old('name')??$user->name"
                                              required autofocus autocomplete="name"/>

                                <x-input-error :messages="$errors->get('name')" class="mt-2"/>

                            </div>

                            <div class="flex flex-col">
                                <x-input-label for="Email" :value="__('Email')"/>
                                <x-text-input id="Email" class="block mt-1 w-full"
                                              type="text"
                                              name="email"
                                              :value="old('email')??$user->email"
                                              required autofocus autocomplete="email"/>
                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                            </div>

                            <div class="flex flex-col">
                                <x-input-label for="Password" :value="__('Password')"/>
                                <x-text-input id="Password" class="block mt-1 w-full"
                                              type="text"
                                              name="password"
                                              autofocus/>
                                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                            </div>

                            <div class="flex flex-col">
                                <x-input-label for="Password_Confirmation" :value="__('Confirm Password')"/>
                                <x-text-input id="Password_Confirmation" class="block mt-1 w-full"
                                              type="text"
                                              name="password_confirmation"
                                              autofocus/>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                            </div>

                            <div class="flex flex-row gap-6  ">

                                <a href="{{ route('admin.users.index') }}"
                                   class="bg-gray-100 hover:bg-blue-500
                                          text-blue-800 hover:text-gray-100 text-center
                                          border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-24 rounded">
                                    <i class="fa-solid fa-times inline-block"></i>
                                    {{ __('Cancel') }}
                                </a>

                                <button type="submit"
                                        class="bg-gray-100 hover:bg-green-500
                                             text-green-800 hover:text-gray-100 text-center
                                             border border-gray-300
                                             transition ease-in-out duration-300
                                             p-2 min-w-32 rounded">
                                    <i class="fa-solid fa-save text-sm"></i>
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>

                        <section class="grid grid-cols-2 space-y-2 mt-4 px-6  space-x-8">

                            <div class="-mx-6 bg-gray-100 col-span-2 px-6 pb-2">

                                <h3 class="-mx-6 px-6 py-2 text-lg font-semibold col-span-2 bg-gray-100">
                                    Current Role(s)
                                </h3>

                                <div class="flex flex-row gap-1 flex-wrap pb-2">

                                    @forelse($userRoles as $role)
                                        <p class="text-xs bg-gray-700 text-gray-100 p-1 px-2 rounded-full whitespace-nowrap">{{ $role->name }}</p>
                                    @empty
                                        <p class="text-gray-600 text-sm">
                                            No Roles
                                        </p>
                                    @endforelse

                                </div>
                            </div>


                            <div class="mt-2 mb-6 bg-gray-100 shadow border border-gray-300 rounded p-4 pt-2">

                                <h3 class="mb-2 bg-gray-300 text-gray-800 px-4 py-1 -mt-2 -mx-4">Add roles</h3>

                                <div class="flex space-x-4 flex-wrap">

                                @foreach ($roles as $role)

                                    <form class="px-0 py-1 text-white rounded-md"
                                          method="POST"
                                          action="{{ route('admin.users.roles',
                                                            [$user]) }}"
                                          onsubmit="return confirm('Are you sure?');">

                                        @csrf

                                        <input type="hidden" name="role" value="{{$role->id}}"/>

                                        <x-primary-button type="submit" class="bg-green-600">
                                            {{ $role->name }}
                                        </x-primary-button>

                                    </form>

                                @endforeach

                                </div>
                            </div>

                            @if ($userRoles)

                                <div class="mt-2 mb-6 bg-gray-100 shadow border border-gray-300 rounded px-4 pt-2">
                                    <h3 class="mb-2 bg-gray-300 text-gray-800 px-4 py-1 -mt-2 -mx-4">
                                        Revoke Role
                                    </h3>

                                    <div class="flex space-x-6 flex-wrap">

                                        @foreach ($userRoles as $currentRole)

                                            <form class="px-0 py-1 text-white rounded-md"
                                                  method="POST"
                                                  action="{{ route('admin.users.roles.revoke',
                                                            [$user->id]) }}"
                                                  onsubmit="return confirm('Are you sure?');">

                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden" name="role" value="{{$currentRole->id}}"/>

                                                <x-danger-button type="submit" class="px-2! py-1!">
                                                    {{ $currentRole->name }}
                                                </x-danger-button>

                                            </form>

                                        @endforeach

                                    </div>
                                </div>

                            @endif

                        </section>


                </article>

            </div>
        </div>
    </div>
</x-app-layout>
