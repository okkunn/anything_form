<?php
/**
 *
 * バリデーションクラス
 *
 */
class Validate {

	var $MESSAGE_NOT_EMPTY = '%%%NAME%%%を入力してください';
	var $MESSAGE_NOT_EMPTY_SELECT = '%%%NAME%%%を選択してください';
	var $MESSAGE_HIRAGANA = '%%%NAME%%%をひらがなで入力してください';
	var $MESSAGE_KATAKANA = '%%%NAME%%%をカタカナで入力してください';
	var $MESSAGE_EQUAL = '%%%NAME%%%が一致しません';
	var $MESSAGE_TEL = '電話番号の形式が不正です';
	var $MESSAGE_MAIL = 'メールアドレスの形式が不正です';
	var $MESSAGE_ZIP = '郵便番号の形式が不正です';

	/**
	*
	* バリデーションを実行してエラーメッセージを返す
	*
	*/
	function check($param) {
		$data = $param['data'];
		$checkList = $param['checkList'];
		$itemName = $param['itemName'];

		// 必須
		if ( $checkList['NotEmpty'] ) {
			if ( empty($data) ) {
				$message = $this->getMessage($itemName, $this->MESSAGE_NOT_EMPTY);
				return $message;
			}
		}
		// 必須(選択)
		if ( $checkList['NotEmptySelect'] ) {
			if ( empty($data) ) {
				$message = $this->getMessage($itemName, $this->MESSAGE_NOT_EMPTY_SELECT);
				return $message;
			}
		}
		// ひらがな
		if ( $checkList['Hiragana'] ) {
			if ( !$this->checkHiragana($data) ) {
				$message = $this->getMessage($itemName, $this->MESSAGE_HIRAGANA);
				return $message;
			}
		}
		// カタカナ
		if ( $checkList['Katakana'] ) {
			if ( !$this->checkKatakana($data) ) {
				$message = $this->getMessage($itemName, $this->MESSAGE_KATAKANA);
				return $message;
			}
		}
		// 電話番号
		if ( $checkList['Tel'] ) {
			if ( !$this->checkTel($data) ) {
				$message = $this->getMessage($itemName, $this->MESSAGE_TEL);
				return $message;
			}
		}
		// メール
		if ( $checkList['Mail'] ) {
			if ( !$this->checkMail($data) ) {
				$message = $this->getMessage($itemName, $this->MESSAGE_MAIL);
				return $message;
			}
		}
		// 郵便番号
		if ( $checkList['Zipcode'] ) {
			if ($data) {
				if ( !$this->checkZip($data) ) {
					$message = $this->getMessage($itemName, $this->MESSAGE_ZIP);
					return $message;
				}
			}
		}
		// 一致チェック
		if ( $checkList['Equal'] ) {
			$paramName = $checkList['Equal'];
			
			$input = $_SESSION['post'];
			if ( !empty($data) && !empty($input[ $paramName ])) {
				if ($data != $input[ $paramName ]) {
					$message = $this->getMessage($itemName, $this->MESSAGE_EQUAL);
					return $message;
				}
			}
		}
	}

	/**
	*
	* エラーメッセージを返す
	*
	*/
	function getMessage($itemName, $beforeMessage) {
		$message = str_replace('%%%NAME%%%', $itemName, $beforeMessage);
		return $message;
	}

	// ひらがな+空白のときtrue
	function checkHiragana($data) {
		$data = mb_convert_kana($data, "s");
		$data = trim($data);
		$data = str_replace(" ", "", $data);
		$regex = "^([ぁ-ん]+|(ー))+$";
		if (mb_ereg($regex, $data)) {
			return true;
		}
		return false;
	}

	// カタカナ+空白のときtrue
	function checkKatakana($data) {
		$data = mb_convert_kana($data, "s");
		$data = trim($data);
		$data = str_replace(" ", "", $data);
		$regex = "^[ァ-ヶー]+$";
		if (mb_ereg($regex, $data)) {
			return true;
		}
		return false;
	}

	// メール形式のときtrue
	function checkMail($data) {
		$regex = "/^([*+!.&#$|\"\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})$/i";
		if (preg_match($regex, $data)) {
			return true;
		}
		return false;
	}

	// 電話番号形式のときtrue
	function checkTel($data) {
		if (empty($data)) {
			return true;
		}
		$regex = '/^\d{1,5}-?\d{1,5}-?\d{1,5}$/';
		if (preg_match($regex, $data)) {
			return true;
		}
		return false;
	}

	// 郵便番号形式のときtrue
	function checkZip($data) {
		$regex = "/^\d{3}-?\d{4}$/";
		if (preg_match($regex, $data)) {
			return true;
		}
		return false;
	}
}



