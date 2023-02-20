<div class="mb-8">
    <h2 class="text-xl font-bold mb-2">Task 1 Results</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr>
                <th class="px-4 py-2 bg-gray-100 border-b">Id</th>
                <th class="px-4 py-2 bg-gray-100 border-b">name</th>
                <th class="px-4 py-2 bg-gray-100 border-b">count of bookings</th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach ($data['task1'] as $key)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $key['id'] }}</td>
                    <td class="px-4 py-2 border-b">{{ $key['name'] }}</td>
                    <td class="px-4 py-2 border-b">{{ $key['bookings_count'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
