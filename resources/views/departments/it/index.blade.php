@extends('layouts.app')

@section('title', '問い合わせ一覧')
@section('content')
<header class="py-4">
        <div class="mt-4 bg-white dark:bg-gray-800">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 text-center">
        IT問い合わせ一覧
    </h2>
         @auth
         <div class="flex space-x-2 bg-white dark:bg-gray-800 shadow-p4 p-4 flex justify-end">
         <form method="GET" action="{{ route('it.logs') }}">
                <button type="submit"
                    class="px-5 py-2 border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    ITログ一覧へ
                </button>
            </form>
         <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-5 py-2 border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                ログアウト
            </button>
          </form>
         </div>
         @endauth
    </div>
        </header>
<table class="table-fixed w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 w-30">依頼人</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">部署</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">メールアドレス</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">問題種類</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">発生箇所</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">内容</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 w-36">ファイル</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">問い合わせ日時</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">対応</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-300 bg-white">
        @foreach ($items as $item)
            <tr class="divide-x divide-gray-300">
                <td class="px-4 py-2 border-r border-gray-300">{{ $item->user->name }}</td>
                <td class="px-4 py-2 border-r border-gray-300">{{ $item->department }}</td>
                <td class="px-4 py-2 border-r border-gray-300 break-words">{{ $item->user->email }}</td>
                <td class="px-4 py-2 border-r border-gray-300 break-words">
                    {{ \App\Models\Inquiry::ISSUE_TYPES[$item->issue_type] }}</td>
                 <td class="px-4 py-2 border-r border-gray-300">
                    <!-- 各部門の問題発生箇所表示 -->
                    @if($item->issue_type == 1) {{-- ハードウェア --}}
                    {{ \App\Models\Inquiry::HARDWARE_OPTIONS[$item->software_option] }}
                    @elseif($item->issue_type == 2) {{-- ソフトウェア --}}
                    {{ \App\Models\Inquiry::SOFTWARE_OPTIONS[$item->software_option] }}
                    @elseif($item->issue_type == 3) {{-- ネットワーク --}}
                    {{ \App\Models\Inquiry::NETWORK_OPTIONS[$item->network_option] }}
                    @endif
                </td>
                <td class="px-4 py-2 border-r border-gray-300">{{ $item->detail }}</td>
                <td class="px-2 py-2 border-r border-gray-300 w-36">
                    <a href="{{ Storage::url($item->attachment) }}" target="_blank" class="block w-full truncate hover:underline">
                    {{ basename($item->attachment) }}
                    </a>
                </td>
                <td class="px-4 py-2 border-r border-gray-300">
                {{ $item->created_at->format('Y-m-d H:i') ?? '-' }}
                </td>
        <div class="flex flex-col sm:flex-row sm:space-x-2">
        <td class="px-4 py-2 border-r border-gray-300">
    <form method="POST" action="{{ route('it.markHandled', $item->id) }}">
                        @csrf
        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
        対処済み
         </button>
    </form>
    <form method="POST" action="{{ route('it.assign', $item->id) }}">
       @csrf
       <label for="departments">各部門に振り分ける:</label>
        <select name="department"
        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm">
        @foreach($departments as $dept)
            <option value="{{ $dept->id }}">{{ $dept->name_ja }}</option>
        @endforeach
        </select>
        <button type="submit"
        class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
        振り分け
        </button>
    </form>
     </td>
   </div>
</tr>
        @endforeach
    </tbody>
</table>
@endsection
