<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
     <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
      <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-6">
        新規登録
      </h2>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            名前
            </label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm 
            focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

    <div class="mb-4">
    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        部署
    </label>
    <select id="role_id" name="role_id" required
        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm 
               focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50
               dark:bg-gray-700 dark:text-gray-200">
        <option value="" disabled selected>選択してください</option>
        <option value="1">管理者</option>
        <option value="2">社員</option>
        <option value="3">IT部門</option>
        <option value="4">ソフトウェア</option>
        <option value="5">ハードウェア</option>
        <option value="6">ネットワーク</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                メールアドレス
            <label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm 
                        focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50
                        dark:bg-gray-700 dark:text-gray-200" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div class="mb-4">
             <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  パスワード
             </label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm 
                        focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50
                        dark:bg-gray-700 dark:text-gray-200"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
             パスワードを再入力してください
             </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50
                        dark:bg-gray-700 dark:text-gray-200" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex justify-end mt-4">
        <button type="submit"
            class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            新規登録
        </button>
         </div>
    </form>
    @if (Route::has('login'))
             <!-- <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400"> -->
                    
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline dark:text-indigo-400">
                        ログイン
                    </a>
                </p>
            @endif
        </div>
    </div>
</x-guest-layout>
