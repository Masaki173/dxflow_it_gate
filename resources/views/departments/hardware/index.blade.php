@extends('layouts.app')

@section('title', '問い合わせ一覧')
@section('content')
<header class="py-4">
        <div class="mt-4 bg-white dark:bg-gray-800">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 text-center">
            ハードウェア問い合わせ一覧
          </h2>
            @auth
            <div class="flex space-x-2 bg-white dark:bg-gray-800 shadow-p4 p-4 flex justify-end">
            <form method="GET" action="{{ route('hardware.logs') }}">
                <button type="submit"
                    class="px-5 py-2 border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    ハードウェアログ一覧へ
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
                                <th class="px-4 py-2 text-left text-sm  font-medium text-gray-600">ユーザー</th>
                                <th class="px-4 py-2 text-left text-sm  font-medium text-gray-600">部署</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">メールアドレス</th>
                                <th class="px-4 py-2 text-left text-sm  font-medium text-gray-600">問題発生箇所</th>
                                <th class="px-4 py-2 text-left text-sm  font-medium text-gray-600">内容</th>
                                <th class="px-4 py-2 text-left text-sm  font-medium text-gray-600">ファイル</th>
                                <th class="px-4 py-2 text-left text-sm  font-medium text-gray-600">対応可否</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300 bg-white">
                            @foreach ($items as $item)
                            <tr>
                                <td class="px-4 py-2 border-r border-gray-300">{{ $item->user->name }}</td>
                                <td class="px-4 py-2 border-r border-gray-300">{{ $item->department }}</td>
                                <td class="px-4 py-2 border-r border-gray-300 break-words">{{ $item->user->email }}</td>
                                <td class="px-4 py-2 border-r border-gray-300">
                                    {{ \App\Models\Inquiry::HARDWARE_OPTIONS[$item->hardware_option] ?? '不明' }}
                                </td>
                                <td class="px-4 py-2 border-r border-gray-300">{{ $item->detail }}</td>
                                <td class="px-2 py-2 border-r border-gray-300 w-36"> 
                                <a href="{{ Storage::url($item->attachment) }}" target="_blank" class="block w-full truncate hover:underline">
                                {{ basename($item->attachment) }}
                                </a>
                                </td>
                                <td class="px-4 py-2 border-r border-gray-300 ">
                                    <form method="POST"
                                        action="{{ route('hardware.markHandled', $item->id) }}">
                                        @csrf
                                        <select name="can_handle" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm">
                                            <option value="1">対応済</option>
                                            <option value="0">対応不可</option>
                                        </select>
                                        <button type="submit"
                                            class="mt-1 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                            保存
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
@endsection