<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead>
        <tr>
            <th>ID</th>
            <th>依頼者</th>
            <th>部門</th>
            <th>内容</th>
            <th>対応日時</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($logs as $log)
            @foreach ($log->inquiry->assignments as $assignment)
                <tr>
                    <td>{{ $log->inquiry->id }}</td>
                    <td>{{ $log->user->name ?? '不明' }}</td>
                    <td>{{ $assignment->department->name }}</td>
                    <td>{{ Str::limit($log->content, 50) }}</td>
                    <td>{{ $log->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500">ログがありません</td>
            </tr>
        @endforelse
    </tbody>
</table>