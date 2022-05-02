<!-- 本登録｜入力ページのビュー -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>本登録｜TOP</title>
</head>
<body>
<div id="wrapper">

    <header>
        <h1>enaco</h1>
    </header>
        
    <main class="main_list">
        <div class="form_wrap">
            <form action="./main_entry.php?login_id=<?php echo $row['hash_login_id'];?>" method="POST" enctype="multipart/form-data">
                <div class="_intro">
                    <h2>本登録｜入力ページ</h2>
                    <p>パスワードを入力し、JPG画像を選択してください。</p>
                    <!-- ↓パスワードミスった場合のエラー↓ -->
                    <p class="err"><?php echo isset($err['match'])?$err['match']:'';?></p>
                </div>
                <label class="input_wrap">
                    <h3 class="title">氏名</h3>
                    <div class="input_set">
                        <p class="namae"><?php echo $name;?></p>
                    </div>
                </label>

                <label class="input_wrap">
                    <h3 class="title">パスワード</h3>
                    <div class="input_set">
                        <input type="password" name="password" value="">
                        <p class="err"><?php echo isset($err['password'])?$err['password']:'';?></p>
                    </div>
                </label>

                <label class="input_wrap">
                    <h3 class="title">画像</h3>
                    <div class="input_set">
                        <input type="file" name="file" class="noBorder">
                        <p class="err_f"><?php echo isset($err['file'])?$err['file']:'';?></p>
                        <p class="err"><?php echo isset($err['ext'])?$err['ext']:'';?></p>
                    </div>
                </label>

                <div class="btn_wrap"><button type="submit" name="state" value="main_entry">登録</button></div>

            </form>
        </div>
    </main>

    <footer id="footer">
        <p>©︎2021 PH24 Erina no hyo-ka Kadai</p>
    </footer>
</div><!-- wrapper -->
</body>
</html>