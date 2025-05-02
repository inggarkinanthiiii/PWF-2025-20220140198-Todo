<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Hanya tampil jika ada pencarian --}}
                    @if(request('search'))
                        <div class="px-6 pt-6 pb-5 md:pb-0 md:w-1/2 xl:w-1/3">
                            <h2 class="pb-3 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                Search result for: {{ request('search') }}
                            </h2>
                        </div>
                    @endif

                    <form class="flex items-center gap-2 mb-4">
                        <div>
                            <x-text-input id="search" name="search" type="text" class="w-56"
                                          placeholder="Search by name or email" value="{{ request('search') }}" autofocus />
                        </div>
                        <div class="p-0">
                            <x-primary-button type="submit">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="px-6 py-4 bg-green-100 text-green-800 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('danger'))
                        <div class="px-6 py-4 bg-red-100 text-red-800 rounded mb-4">
                            {{ session('danger') }}
                        </div>
                    @endif

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Todo</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                    <td class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p>
                                            {{ $user->todos->count() }}
                                            <span>
                                                <span class="text-green-600 dark:text-green-400">
                                                    ({{ $user->todos->where('is_done', true)->count() }})
                                                </span>
                                                /
                                                <span class="text-blue-600 dark:text-blue-400">
                                                    ({{ $user->todos->where('is_done', false)->count() }})
                                                </span>
                                            </span>
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 flex items-center space-x-2">
                                        @if(auth()->user()->is_admin)
                                            @if ($user->is_admin)
                                                <form action="{{ route('user.removeAdmin', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus status admin?');" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-yellow-600 dark:text-yellow-400 hover:underline whitespace-nowrap">
                                                        Remove Admin
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('user.makeAdmin', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menjadikan user ini sebagai admin?');" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap">
                                                        Make Admin
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('user.destroy', $user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 dark:text-red-400 hover:underline whitespace-nowrap">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No data available
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-5">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
