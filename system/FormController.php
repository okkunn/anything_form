<?php
/*
 * フォームクラス
 */
class FormController {


	public function __construct() {
		session_start();
		$this->basePath = realpath(dirname(__FILE__).'/../');
	}

	/*
	 * メイン処理実行
	 */
	public function run($flow)
	{
		switch ($flow) {
		case 'form':
			//確認画面
			$this->displayForm();
			break;
		case 'confirm':
			//確認画面
			$this->displayConf();
			break;
		case 'finish':
			//完了画面
			$this->displayDone();
			break;
		default :
			//フォーム表示
			$this->displayForm();
			break;
		}
	}

	/*
	 * フォーム画面
	 */
	public function displayForm()
	{
		$data = array();
		if ($_GET['back']) {
			// セッションから入力値、エラーを取り出し
			$data['input'] = $_SESSION['post'];
			$data['error'] = $_SESSION['errors'];
			unset($_SESSION['errors']);
		}
		$this->setData($data);
		
	}
	
	/*
	 * 確認画面
	 */
	public function displayConf()
	{
		$post = $_POST;

		// エラーチェック
		$errors = $this->validate($post);

		// エラーがあれば入力フォームに戻る
		if (count($errors) > 0 ) {
			
			//セッションに登録
			$_SESSION['post'] = $post;
			$_SESSION['errors'] = $errors;
			
			// エラーが有るとき入力に戻る
			header("Location:index.php?back=1");
			exit;
		}

		$_SESSION['post'] = $post;

		$data = array();
		$data['input'] = $post;
		$data['error'] = $error;
		$this->setData($data);

	}

	/*
	 * 完了画面
	 */
	public function displayDone()
	{
		
		// セッションから入力データ取得
		$post = $_SESSION['post'];
		
		// エラーチェック
		$errors = $this->validate($post);

		// エラーがあれば入力フォームに戻る
		if (count($errors) > 0 ) {
			//エラー内容をセッションに登録
			$_SESSION['errors'] = $errors;
			
			// エラーが有るとき入力に戻る
			header("Location:index.php?back=1");
			exit;
		}
		
		$post = $this->postFormat($post);
		
		$send = $this->_sendMail($post);
		
		// 二重投稿防止の為、セッションを削除
		unset($_SESSION['post']);
		unset($_SESSION['errors']);
		
		// メール送信成功
		if ( $send ) {
			header("Location:complete.php");
		} else {
			// メール送信エラー
			header("Location:bad.php");
			exit;
		}
		
	}
	
	// メール送信
	function _sendMail($input) {
		
		$send = $this->_sendCustomerMail($input);
		if ($send) {
			$send = $this->_sendAdminMail($input);
		}
		return $send;
	}
	
	/*
	 * 担当者にメール送信
	 *
	 * @param  $post   array 入力データ
	 *
	 */
	public function _sendAdminMail($post)
	{
		$config = getMailConfig();
		$to = $config["admin"];
		$from = $config["from"];
		$subject = $config["admin_title"];
		$body = $this->getMailBody($post, 'admin');

		$header = sprintf("From: %s<%s>", mb_encode_mimeheader($config["fromName"], 'ISO-2022-JP', 'UTF-8'), $from );

		$returnPath = "-f "."{$config["admin"]}";

		//メール送信
		$send =  $this->sendMail($to, $subject , $body, $header , $returnPath);

		return $send;
		
	}
	
	/*
	 * ユーザーにメール送信
	 *
	 * @param  $post   array 入力データ
	 *
	 */
	public function _sendCustomerMail($post)
	{
		$config = getMailConfig();

		$to = $post["mail"];
		$from = $config["from"];
		$subject = $config["customer_title"];
		$body = $this->getMailBody($post, 'user');

		$header = sprintf("From: %s<%s>", mb_encode_mimeheader($config["fromName"], 'ISO-2022-JP', 'UTF-8'), $from );

		$returnPath = "-f "."{$config["admin"]}";

		//メール送信
		$send =  $this->sendMail($to, $subject , $body, $header , $returnPath);

		return $send;
	}
	
	// メール送信
	public function sendMail($to, $subject , $body, $header , $returnPath) {
		$send = mb_send_mail($to, $subject , $body, $header, $returnPath);

		return $send;
	}
	
	// メール本文作成
	public function getMailBody($input, $type) {
		$path = $this->basePath . '/system/templates/' . $type . 'Mail.tpl';
		if ( !file_exists($path)) {
			return false;
		}
		$txt = file_get_contents($path);
		
		// {$hensu}を $input['hensu']に変換
		preg_match_all('/{\$([\w_]+)}/s', $txt, $matches);
		$vars = $matches[1];
		$target = $matches[0];
		if ($vars) {
			foreach ($vars as $k => $var) {
				$txt = str_replace($target[ $k ], $input[ $var ], $txt);
			}
		}
		return $txt;
	}
	
	// バリデーションチェック
	public function validate( $input ) {
		require_once("../system/Validate.php");

		// getFormConfig in lib.php
		$formConfig = getFormConfig();

		// 引数チェック
		if ( count($formConfig) < 1 ) {
			// error=trueを返す
			return true;
		}
		// エラーチェック
		$error = array();
		$validate = new Validate();
		foreach ($formConfig as $formName => $config) {
			// 入力値をバリデーション用にセット
			$config["data"] = $input[ $formName ];
			$validResult = $validate->check($config);
			if ($validResult) {
				$error[ $formName ] = $validResult;
			}
		}
		
		return $error;
	  
	}
	
	public function postFormat( $post )
	{
		// 名前
		if ( $post['sei'] && $post['mei'] ) {
			$post['name'] = $post['sei'] . '　' . $post['mei'];
		}

		// フリガナ
		if ( $post['kana_sei'] && $post['kana_mei'] ) {
			$post['kana'] = $post['kana_sei'] . '　' . $post['kana_mei'];
		}
		
		return $post;
	}
	
	// データセット
	public function setData($data) {
		$this->data = $data;
	}
	// データ取得
	public function getData() {
		return $this->data;
	}
	// データ取得
	public function getInput() {
		return $this->data['input'];
	}
	// データ取得
	public function getError() {
		return $this->data['error'];
	}
	// エスケープ処理
	public function esPrint($str) {
		return print(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
	}
	// 改行処理
	public function esPrintBr($str) {
		return print( nl2br(htmlspecialchars($str, ENT_QUOTES, 'UTF-8')));
	}
	
	// フォーマット処理
	public function formatBr($str) {
		return preg_replace("/\r\n|\r|\n/", "\n", $str);
	}
	// エラーセッション削除処理
	public function clearError() {
		unset($_SESSION["errors"]);
	}

}