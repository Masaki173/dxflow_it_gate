<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF トークン -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Title') }}</title>
<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

 <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

     <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <header class="bg-white dark:bg-gray-800 shadow-p4 p-4 flex justify-end">
        <div class="mt-4">
         @auth
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-5 py-2 border border-gray-300 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                ログアウト
            </button>
          </form>
         @endauth
    </div>
        </header>
        <div class="mt-10 container mx-auto px-4">
    <h1 class="mb-4">ITサポート問い合わせ</h1>
    <div class="card mb-4"> 
    <div class="card">
        <div class="card-body">
            <form action="{{ route('inquiry.store') }}" method="post" enctype="multipart/form-data" id="supportForm">
            @csrf
                <div class="form-group">
                    <label>部署</label>
                    <input class="form-control" id=department name="department" placeholder="部署を入力" required></input>
                </div>
                <div class="form-group">
                    <label>問題の種類は？</label>
                    <select class="form-control" id="issueType" name="issue_type">
                        <option value="">選択してください</option>
                        <option value="1">ハードウェア</option>
                        <option value="2">ソフトウェア</option>
                        <option value="3">ネットワーク</option>
                    </select>
                </div>
                
                <div class="form-group" id="hardwareOptions" style="display:none;">
                    <label>ハードウェアの詳細</label>
                    <select class="form-control" name="hardware_option">
                        <option value="1">PC</option>
                        <option value="2">プリンタ</option>
                        <option value="3">その他</option>
                    </select>
                </div>
                
                <div class="form-group" id="softwareOptions" style="display:none;">
                    <label>ソフトウェアの詳細</label>
                    <select class="form-control" name="software_option">
                        <option value="1">オフィスソフト</option>
                        <option value="2">メールソフト</option>
                        <option value="3">その他</option>
                    </select>
                </div>

                <div class="form-group" id="networkOptions" style="display:none;">
                    <label>ネットワークの詳細</label>
                    <select class="form-control" name="network_option">
                        <option value="1">Wi-Fi</option>
                        <option value="2">VPN</option>
                        <option value="3">その他</option>
                    </select>
                </div>
                <div class="form-group">
                   <label for="detail">不具合の詳細</label>
                   <textarea class="form-control" id="detail" name="detail" rows="4" placeholder="不具合の内容を詳しく記入してください" required></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="attachment">添付ファイル/写真(任意)</label>
                    <input type="file" name="attachment" id="attachment" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                  file:rounded-md file:border-0
                  file:text-sm file:font-semibold
                  file:bg-blue-50 file:text-blue-700
                  hover:file:bg-blue-100">
                </div>
                <button type="submit" class="btn btn-primary">送信</button>
            </form>
        </div>
    </div>

    <div id="result" class="alert alert-success" style="display:none;"></div>
</div>
</div>
<!-- Bootstrap JS + jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#issueType').change(function() {
        const value = $(this).val();
        $('#hardwareOptions, #softwareOptions, #networkOptions').hide();

        if(value === '1') {
            $('#hardwareOptions').show();
        } else if(value === '2') {
            $('#softwareOptions').show();
        } else if(value === '3') {
            $('#networkOptions').show();
        }
    });

    $('#supportForm').submit(function(e){
         const ISSUE_TYPES = @json(\App\Models\Inquiry::ISSUE_TYPES);
         const selectedType = $('#issueType').val(); 
         const typeName = ISSUE_TYPES[selectedType];
        if(!selectedType){
            alert('問題の種類を選んでください');
            return;
        }
        $('#result').text(`送信完了: ${typeName}関連の問い合わせを受け付けました`).show();
    });
});
</script>
    </body>
</html>
