<div class="mb-8">
    <h2 class="text-xl font-bold mb-2">Task 2 Results</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr>
                <th class="px-4 py-2 bg-gray-100 border-b">hotel id</th>
                <th class="px-4 py-2 bg-gray-100 border-b">hotel name</th>
                <th class="px-4 py-2 bg-gray-100 border-b">rejection rate (%)</th>
                <th class="px-4 py-2 bg-gray-100 border-b">count of rejections</th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach ($data['task2'] as $key)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $key['hotel_id'] }}</td>
                    <td class="px-4 py-2 border-b">{{ $key['hotel_name'] }}</td>
                    <td class="px-4 py-2 border-b">{{ $key['rejection_rate'] }}</td>
                    <td class="px-4 py-2 border-b">{{ $key['total_rejections'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
