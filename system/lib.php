<?php
	// フォーム設定を取得
	// フォーム設定記載
	function getFormConfig(){
				$fconfig = array(
					'sei' => array(
						'itemName' => 'お名前（姓）',
						'checkList' => array(
							'NotEmpty'  => '1',
						),
					),
					'mei' => array(
						'itemName' => 'お名前（名）',
						'checkList' => array(
							'NotEmpty'  => '1',
						),
					),
					'kana_sei' => array(
						'itemName' => 'フリガナ（セイ）',
						'checkList' => array(
							'NotEmpty'  => '1',
							'Katakana'  => '1',
						),
					),
					'kana_mei' => array(
						'itemName' => 'フリガナ（メイ）',
						'checkList' => array(
							'NotEmpty'  => '1',
							'Katakana'  => '1',
						),
					),
					'mail' => array(
						'itemName' => 'メールアドレス',
						'checkList' => array(
							'NotEmpty'  => '1',
							'Mail'  => '1',
						),
					),
					'mail_conf' => array(
						'itemName' => 'メールアドレス（確認）',
						'checkList' => array(
							'NotEmpty'  => '1',
							'Mail'  => '1',
							'Equal'  => 'mail',
						),
					),
					'tel' => array(
						'itemName' => '電話番号',
						'checkList' => array(
							'NotEmpty'  => '1',
							'Tel' => '1',
						),
					),
		);
		return $fconfig;
	}

	// 入力文字列をエスケープ
	function h($str) {
		$str = htmlspecialchars($str, ENT_QUOTES);
		return $str;
	}

// 以下フォームの用途により使用可能
	/*
	// 都道府県名取得
	function getPrefName($id = null) {
		$list = getPrefList();
		$name = "";
		if ($id > 0) {
			$name = $list[$id];
		}
		return $name;
	}

	// 都道府県一覧
	function getPrefList() {
		$prefs = array(
			"1" => "北海道",
			"2" => "青森県",
			"3" => "岩手県",
			"4" => "宮城県",
			"5" => "秋田県",
			"6" => "山形県",
			"7" => "福島県",
			"8" => "茨城県",
			"9" => "栃木県",
			"10" => "群馬県",
			"11" => "埼玉県",
			"12" => "千葉県",
			"13" => "東京都",
			"14" => "神奈川県",
			"15" => "新潟県",
			"16" => "富山県",
			"17" => "石川県",
			"18" => "福井県",
			"19" => "山梨県",
			"20" => "長野県",
			"21" => "岐阜県",
			"22" => "静岡県",
			"23" => "愛知県",
			"24" => "三重県",
			"25" => "滋賀県",
			"26" => "京都府",
			"27" => "大阪府",
			"28" => "兵庫県",
			"29" => "奈良県",
			"30" => "和歌山県",
			"31" => "鳥取県",
			"32" => "島根県",
			"33" => "岡山県",
			"34" => "広島県",
			"35" => "山口県",
			"36" => "徳島県",
			"37" => "香川県",
			"38" => "愛媛県",
			"39" => "高知県",
			"40" => "福岡県",
			"41" => "佐賀県",
			"42" => "長崎県",
			"43" => "熊本県",
			"44" => "大分県",
			"45" => "宮崎県",
			"46" => "鹿児島県",
			"47" => "沖縄県",
		);
		return $prefs;
	}

	// 性別一覧取得
	function getSexList() {
		$sexs = array(
			"1" => "男性",
			"2" => "女性",
		);
		return $sexs;
	}
	
	function getSexName($id = null) {
		$list = getSexList();
		$name = "";
		if ($id) {
			$name = $list[$id];
		}
		return $name;
	}
*/



