<!-- ログインページのビュー -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>会員ページ｜TOP</title>
</head>
<body>
<div id="wrapper">

    <header>
        <h1>enaco</h1>
        <div class="add_line">
            <div class="imgBox"><img src="./images/user/<?php echo $id;?>/thumb_<?php echo $img;?>" alt="プロフィール画像"></div>
            <div class="welcome"><?php echo $name;?>さん</div>
            
            <form class="logout_btn" action="./index.php" method="post">
                <button type="submit" name="state" value="logout">
                    ログアウト
                </button>
            </form>
        </div>
    </header>
    
    <main class="main_list">
        <h2>News</h2>
        <div class="table_wrap">
            <div class="img_wrap">
                <p>Happy Holidays!</p>
                <img src="./images/christmas_light_1.jpeg" alt="ええ感じのオシャレな画像">
            </div>
            <?php foreach($news_list as $val){ ?>
                <a href="./index.php?news_id=<?php echo $val['id'];?>">
                <div class="items">
                    <img src="./images/coffee1.jpeg" alt="記事画像" class="img_detail">
                    <div class="news_detail">
                        <p class="pdf_link"><?php echo $val['title'];?></p>
                        <p class="time"><?php echo $val['created_at'];?></p>
                    </div>
                </div>
                </a>
            <?php } ?>
        </div>


        <!-- 前へ・次へのリンク -->
        <div class="pre-next">
            <a href="index.php?page=<?php echo $page - 1; ?>" class="<?php echo $top_class;?>">前へ</a>
            <a href="index.php?page=<?php echo $page + 1; ?>" class="<?php echo $last_class;?>">次へ</a>
        </div>

        <!-- ページ番号のリンクたち -->
        <div class="pageNation">
            
            <?php foreach($page_array as $num){?>
                <a href="index.php?page=<?php echo $num['page']; ?>" class="<?php echo $num['class']; ?>">
                    <?php echo $num['after_dot'] . $num['page'] . $num['before_dot']; ?>
                </a>
            <?php } ?> 
        </div> 
    </main>

    <footer id="footer">
        <p>©︎2021 PH24 Erina no hyo-ka Kadai</p>
    </footer>
</div><!-- wrapper -->
</body>
</html>