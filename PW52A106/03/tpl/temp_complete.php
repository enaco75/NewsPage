<!-- 仮登録｜仮登録完了ページのビュー -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>仮会員登録｜仮登録完了ページ</title>
</head>
<body>
<div id="wrapper">

    <header>
        <h1>enaco</h1>
    </header>

    <main>
        <div class="center">
            <h2>会員仮登録の完了</h2>
            <p>メールのURLから本登録を完成させてください。</p>
            <!-- メール内容の添付 -->
            <div class="mailContent">
                <p>To：<?php echo $mailto;?></p>
                <p><?php echo $headers;?></p>
                <p>タイトル：<?php echo $title;?></p>
                <p>メッセージ：<?php echo $message;?></p>
                <p><a href="<?php echo $url;?>"><?php echo $url;?></a></p>
            </div>
    
        </div>
    </main>

    <footer id="footer">
        <p>©︎2021 PH24 Erina no hyo-ka Kadai</p>
    </footer>

</div><!-- wrapper -->
</body>
</html>