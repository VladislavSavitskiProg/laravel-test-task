<div>
    <h2 class="text-xl font-bold mb-2">Task 3 Results</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr>
                <th class="px-4 py-2 bg-gray-100 border-b">customer id</th>
                <th class="px-4 py-2 bg-gray-100 border-b">count of rejects</th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach ($data['task3'] as $key)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $key['customer_id'] }}</td>
                    <td class="px-4 py-2 border-b">{{ $key['rejects'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
