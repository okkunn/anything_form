<?php

error_reporting(0);

mb_language('japanese');
mb_detect_encoding('utf8,ascii');
mb_internal_encoding('utf8');
mb_regex_encoding('utf8');

// メール設定を取得
function getMailConfig(){
	$conf = array(
		// メールのFROM
		'from'  => 'info@okkunn.xyz',
		// 管理者メール送信先
		'admin'  => 'info@okkunn.xyz',
		// 管理者メールタイトル
		'admin_title'	=> 'お問い合わせがありました。',
		// 送信確認メールタイトル
		'customer_title' => 'お問い合わせフォーム｜自動配信メール',
	);
	return $conf;
}
