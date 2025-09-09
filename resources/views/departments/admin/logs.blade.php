@extends('layouts.app')

@section('title', '問い合わせ一覧')
@section('content')
<header class="py-4">
        <div class="mt-4 bg-white dark:bg-gray-800">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 text-center">
            ログ一覧
        </h2>
    @auth
         <div class="flex space-x-2 bg-white dark:bg-gray-800 shadow-p4 p-4 flex justify-end">
         <form method="GET" action="{{ route('admin.dashboard') }}">
                <button type="submit"
                    class="px-5 py-2 border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    管理者ダッシュボードへ
                </button>
            </form>
         </div>
         @endauth
    </div>
        </header>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="table-fixed w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">依頼者</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">担当部署</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">発生箇所</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">内容</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ファイル</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">対応日時</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">詳細</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($logs as $log)
                            <tr>
                                <td class="px-4 py-2 border-r border-gray-300">{{ $log->user->name}}</td>
                                <td class="px-4 py-2 border-r border-gray-300">
                                    <!-- 対応部門の表示 -->
                                  @if($log->inquiry->assignments->isNotEmpty() && $log->inquiry->assignments->first()->departments)
                               {{ $log->inquiry->assignments->first()->departments->name_ja  }}
                                @else
                                  IT
                                @endif
                                </td>
                                <td class="px-4 py-2 border-r border-gray-300">
                        <!-- 各部門の問題発生箇所表示 -->
                         @if($log->inquiry->issue_type == 1) {{-- ハードウェア --}}
                        {{ \App\Models\Inquiry::HARDWARE_OPTIONS[$log->inquiry->hardware_option]}}
                         @elseif($log->inquiry->issue_type == 2) {{-- ソフトウェア --}}
                         {{ \App\Models\Inquiry::SOFTWARE_OPTIONS[$log->inquiry->software_option]}}
                         @elseif($log->inquiry->issue_type == 3) {{-- ネットワーク --}}
                         {{ \App\Models\Inquiry::NETWORK_OPTIONS[$log->inquiry->network_option] }}
                          @endif
                                </td>
                                <td class="px-4 py-2 border-r border-gray-300">{{ Str::limit($log->content, 50) }}</td>
                                <td class="px-2 py-2 border-r border-gray-300 w-36">
                                <a href="{{ Storage::url($log->inquiry->attachment) }}" target="_blank" class="block w-full truncate hover:underline">
                                {{ basename($log->inquiry->attachment) }}
                                </a>
                                </td>
                                <td class="px-4 py-2 border-r border-gray-300">{{ $log->updated_at->format('Y-m-d H:i') ?? '-' }}</td>
                                <td class="px-4 py-2 border-r border-gray-300">
                                 <div class="mb-2 p-2 bg-gray-100 dark:bg-gray-700 rounded">
                                <strong class="text-gray-700 dark:text-gray-300">現在の詳細:</strong>
                                <p class="mt-1 text-gray-800 dark:text-gray-200">{{ $log->details }}</p>
                                 </div>
                            </td>
                            <td class="px-4 py-2 border-r border-gray-300 text-center">
                          <form action="{{ route('delete.inquiry', $log->inquiry->id) }}" method="POST" 
                            onsubmit="return confirm('本当に削除しますか？');">
                              @csrf
                            @method('DELETE')

                           <button type="submit" 
                            class="px-5 py-2 border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            削除
                           </button>
                            </form>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                    ログはありません
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>