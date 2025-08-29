<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-6">
                ログイン
            </h2>

            <!-- セッションステータス -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- メールアドレス -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        メールアドレス
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm 
                        focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50
                        dark:bg-gray-700 dark:text-gray-200" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- パスワード -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        パスワード
                    </label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm 
                        focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50
                        dark:bg-gray-700 dark:text-gray-200" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- ログイン情報を記憶 -->
                <div class="flex items-center mb-4">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        ログイン状態を保持する
                    </label>
                </div>

                <!-- ボタン -->
                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:underline dark:text-indigo-400"
                           href="{{ route('password.request') }}">
                            パスワードをお忘れですか？
                        </a>
                    @endif

                    <button type="submit"
                        class="ml-3 px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        ログイン
                    </button>
                </div>
            </form>

            <!-- 登録へのリンク -->
            <!-- @if (Route::has('register'))
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    アカウントをお持ちでないですか？
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline dark:text-indigo-400">
                        新規登録
                    </a>
                </p>
            @endif -->
        </div>
    </div>
</x-guest-layout>
