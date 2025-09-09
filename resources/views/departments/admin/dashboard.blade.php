{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">管理者ダッシュボード</h1>
      <div class="flex justify-end">
         <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-5 py-2 border border-gray-300 rounded bg-white justify-end ">
                ログアウト
            </button>
          </form>
         </div>
         </div>
        <div class="space-y-2">

            <a href="{{ route('register') }}" class="flex flex-col items-center p-6 bg-white hover:bg-green-100 transition rounded-2xl shadow">
                    <span class="text-lg font-semibold text-gray-700">ユーザー登録</span>
                    <span class="text-sm text-gray-500 mt-2">新しいユーザーを追加</span>
             </a>
            <a href="{{ route('manage.logs') }}" class="flex flex-col items-center p-6 bg-white hover:bg-green-100 transition rounded-2xl shadow">
                <span class="text-lg font-semibold text-gray-700">ログ管理</span>
                  <span class="text-sm text-gray-500 mt-2">ログ履歴を確認・削除</span>
            </a>

        </div>

</div>
@endsection
