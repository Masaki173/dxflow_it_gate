@extends('layouts.app')

@section('title', '問い合わせ一覧')
@section('content')
<header class="py-4">
        <div class="mt-4 bg-white dark:bg-gray-800">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 text-center">
            ネットワーク部門ログ
        </h2>
        @auth
         <div class="flex space-x-2 bg-white dark:bg-gray-800 shadow-p4 p-4 flex justify-end">
         <form method="GET" action="{{ route('network.index') }}">
                <button type="submit"
                    class="px-5 py-2 border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    ネットワーク問い合わせ一覧へ
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

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h3 class="text-lg font-bold mb-2">対処済み</h3>
            <table class="table-fixed w-full divide-y divide-gray-300">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">依頼者</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">問題発生箇所</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">内容</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ファイル</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">詳細</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($logs->where('can_handle', true) as $log)
                        <tr>
                            <td class="px-4 py-2 border-r border-gray-300">{{ $log->inquiry->user->name ?? '不明' }}</td>
                            <td class="px-4 py-2 border-r border-gray-300">
                                {{ \App\Models\Inquiry::NETWORK_OPTIONS[$log->inquiry->network_option] ?? '不明' }}
                            </td>
                            <td class="px-4 py-2 border-r border-gray-300">{{ Str::limit($log->content, 50) }}</td>
                            <td class="px-2 py-2 border-r border-gray-300 w-36">
                            <a href="{{ Storage::url($log->inquiry->attachment) }}" target="_blank" class="block w-full truncate hover:underline">
                            {{ basename($log->inquiry->attachment) }}
                            </a>
                            </td>
                            <td class="px-4 py-2 border-r border-gray-300">
                                @if($log->details)
                                 <div class="mb-2 p-2 bg-gray-100 dark:bg-gray-700 rounded">
                                <strong class="text-gray-700 dark:text-gray-300">現在の詳細:</strong>
                                <p class="mt-1 text-gray-800 dark:text-gray-200">{{ $log->details }}</p>
                                 </div>
                                 @endif
                                <form method="POST" action="{{ route('network.updateDetails', $log->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="details" rows="2" required
                                         class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm">{{ old('details', $log->details ?? '') }}</textarea>
                                    <button type="submit" class="mt-1 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                        更新
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                対応可のログはありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- 対応不可ログ -->
            <h3 class="text-lg font-bold mb-2">対応不可</h3>
            <table class="table-fixed w-full divide-y divide-gray-300">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">依頼者</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">問題発生箇所</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">内容</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ファイル</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">詳細</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($logs->where('can_handle', false) as $log)
                        <tr>
                            <td class="px-4 py-2 border-r border-gray-300">{{ $log->inquiry->user->name ?? '不明' }}</td>
                            <td class="px-4 py-2 border-r border-gray-300">
                                {{ \App\Models\Inquiry::NETWORK_OPTIONS[$log->inquiry->network_option] ?? '不明' }}
                            </td>
                            <td class="px-4 py-2 border-r border-gray-300">{{ Str::limit($log->content, 50) }}</td>
                            <td class="px-2 py-2 border-r border-gray-300 w-36">
                            <a href="{{ Storage::url($log->inquiry->attachment) }}" target="_blank" class="block w-full truncate hover:underline">
                            {{ basename($log->inquiry->attachment) }}
                            </a>
                            </td>
                            <td class="px-4 py-2 border-gray-300">
                                @if($log->details)
                                 <div class="mb-2 p-2 bg-gray-100 dark:bg-gray-700 rounded">
                                <strong class="text-gray-700 dark:text-gray-300">現在の詳細:</strong>
                                <p class="mt-1 text-gray-800 dark:text-gray-200">{{ $log->details }}</p>
                                 </div>
                                 @endif
                                <form method="POST" action="{{ route('network.updateDetails', $log->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="details" rows="2" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm">{{ old('details', $log->details ?? '') }}</textarea>
                                    <button type="submit" class="mt-1 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                        更新
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                対応不可のログはありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <form method="GET" action="{{ route('overview.logs') }}">
                <button type="submit"
                    class="px-5 py-2 bg-white border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    未対処ログ一覧へ
                </button>
            </form>
    </footer>
@endsection