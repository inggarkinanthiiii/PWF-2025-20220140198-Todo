<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Create Button -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="flex items-center justify-start">
                    <x-create-button :href="route('todo.create')" />
                </div>

                <!-- Alerts -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         x-init="setTimeout(() => show = false, 5000)"
                         class="mt-4 px-4 py-2 text-sm text-green-600 bg-green-100 border border-green-300 rounded-md dark:text-green-400 dark:bg-green-900 dark:border-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('danger'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         x-init="setTimeout(() => show = false, 5000)"
                         class="mt-4 px-4 py-2 text-sm text-red-600 bg-red-100 border border-red-300 rounded-md dark:text-red-400 dark:bg-red-900 dark:border-red-700">
                        {{ session('danger') }}
                    </div>
                @endif
            </div>

            <!-- Todo Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todos as $data)
                                <tr class="odd:bg-white even:bg-gray-50 dark:bg-gray-800 border-b">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $data->title }}
                                        @if (session('edited_todo') == $data->id)
                                            <span class="text-gray-500 dark:text-gray-400 text-xs">(edited)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (!$data->is_done)
                                            <span class="bg-red-100 text-red-800 text-sm px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">Ongoing</span>
                                        @else
                                        <span class="bg-green-100 text-green-800 text-sm px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Complete</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex items-center space-x-2">
                                        @if (!$data->is_done)
                                            <form action="{{ route('todo.complete', $data) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-black bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-2.5 py-1.5 text-center dark:bg-gray-700 dark:hover:bg-gray-800 dark:focus:ring-gray-800">
                                                    Complete
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('todo.uncomplete', $data) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-500 dark:text-yellow-300">
                                                    Uncomplete
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('todo.destroy', $data) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Delete All Completed Task Button -->
                @if ($todosCompleted > 0)
                    <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                        <form action="{{ route('todo.deleteallcompleted') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua task yang sudah selesai?')">
                            @csrf
                            @method('DELETE')
                            <x-primary-button>
                                Delete All Completed Task
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
