<?php
	require_once(dirname(__FILE__) . '/../system/FormController.php');
	require_once(dirname(__FILE__) . '/../system/lib.php');
	require_once(dirname(__FILE__) . '/../etc/config.php');
	$ctl = new FormController();
	$ctl->run('confirm');
	$post = $ctl->getInput();
?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="Keywords" content="" />
	<meta name="description" content="" />
	
	<title>Anything Form | 確認画面</title>
	
	<link rel="stylesheet" type="text/css" href="/css/reset.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/base.css" media="all" />
</head>
<body>
<div id="container">
	<header>
		<div class="inn">
			<h1>Anything Form　確認画面</h1>
		</div>
	</header>
	<div id="contents">
		<section>
			<form id="forms" name="forms" action="./finish.php" method="POST">
				<div class="inputBox">
					<dl class="clearfix">
						<dt>お名前</dt>
						<dd><?php $ctl->esPrint($post["sei"]); ?>　<?php $ctl->esPrint($post["mei"]); ?></dd>
					</dl>
					<dl class="clearfix">
						<dt>フリガナ</dt>
						<dd><?php $ctl->esPrint($post["kana_sei"]); ?>　<?php $ctl->esPrint($post["kana_mei"]); ?></dd>
					</dl>
					<dl class="clearfix">
						<dt>メールアドレス</dt>
						<dd><?php $ctl->esPrint($post["mail"]); ?></dd>
					</dl>
					<div class="buttonArea clearfix">
						<a class="backBtn" href="./index.php?back=1">戻る</a>
						<input class="nextBtn conf" type="submit" value="送信する" />
					</div>
				</div>
			</form>
		</section>
	</div>
	<footer>
	</footer>
</div>
</body>
</html>
