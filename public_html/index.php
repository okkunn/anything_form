<?php
	require_once(dirname(__FILE__) . "/../system/FormController.php");
	require_once(dirname(__FILE__)."/../system/lib.php");
	require_once(dirname(__FILE__)."/../etc/config.php");
	$ctl = new FormController();
	$ctl->run('form');
	$input = $ctl->getInput();
	$error = $ctl->getError();
?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="Keywords" content="" />
	<meta name="description" content="" />
	
	<title>Anything Form | 入力画面</title>
	
	<link rel="stylesheet" type="text/css" href="/css/reset.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/base.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/form.css" media="all" />
</head>
<body>
<div id="container">
	<header>
		<div class="inn">
			<h1>Anything Form　入力画面</h1>
		</div>
	</header>
	<div id="contents">
		<form id="forms" name="forms" action="./confirm.php" method="POST">
			<div class="inputBox">
				<dl class="clearfix">
					<dt class="clearfix">お名前<span class="require">※</span></dt>
					<dd>
						<input class="mr20" type="text" name="sei" value="<?php $ctl->esPrint($input["sei"]); ?>" />
						<input type="text" name="mei" value="<?php $ctl->esPrint($input["mei"]); ?>" />
						<p class="error"><?php $ctl->esPrint($error["sei"]); ?></p>
						<p class="error"><?php $ctl->esPrint($error["mei"]); ?></p>
					</dd>
				</dl>
				<dl class="clearfix">
					<dt class="clearfix">フリガナ<span class="require">※</span></dt>
					<dd>
						<input class="mr20" type="text" name="kana_sei" value="<?php $ctl->esPrint($input["kana_sei"]); ?>" />
						<input type="text" name="kana_mei" value="<?php $ctl->esPrint($input["kana_mei"]); ?>" />
						<p class="error"><?php $ctl->esPrint($error["kana_sei"]); ?></p>
						<p class="error"><?php $ctl->esPrint($error["kana_mei"]); ?></p>
					</dd>
				</dl>
				<dl class="clearfix">
					<dt class="clearfix">メールアドレス<span class="require">※</span></dt>
					<dd>
						<input class="w450" type="text" name="mail" value="<?php $ctl->esPrint($input["mail"]); ?>" />
						<p class="error"><?php $ctl->esPrint($error["mail"]); ?></p>
					</dd>
				</dl>
				<div class="buttonArea">
					<input class="nextBtn" type="submit" value="確認する" />
				</div>
			</div>
		</form>
	</div>
	<footer>
	</footer>
</div>
</body>
</html>
