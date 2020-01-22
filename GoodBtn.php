<?php
/*
* JSONとAjaxを使ったいいねボタン v1.0.0 | Copyright (c) 2018 Rimane
*
* GoodBtnクラス
* いいねボタンに関する処理をおこないます。
*
* jsonファイルの作成・取得
* いいね数の増加・取得 など
*/

Class GoodBtn {

	private $dir; //goodbtn関係のディレクトリ
	private $jsonFilename; //保存先jsonのファイル名
	private $rootPath; //ルートディレクトリから見た現在のパス
	private $icon; //ボタンのアイコン
	private $count; //現在のページのいいね数
	private $path; //現在のパス


	// コンストラクタ宣言
	public function __construct($dir = "/goodbtn",$jsonFilename = null,$icon = null,$setCountBool = true) {

		$this->rootPath = dirname( __FILE__ ); //ルートディレクトリから見た現在のパス
		$this->path = $_SERVER['REQUEST_URI']; //現在のパス

		//保存先jsonのファイル名
		if($jsonFilename == null){
			$this->jsonFilename = "data.json";
		}else{
			$this->jsonFilename = $jsonFilename;
		}

		if($icon == null){
			$this->icon = "heart";
		}else{
			$this->icon = $icon;
		}

		$this->setDir($dir); //goodgtn関係のディレクトリ
		$setCountBool;

		if($setCountBool){
			$this->setCount(); //現在のページのいいね数をセット
			//第四引数がfalseの場合はセットしない
			//主にajax用のgood.phpやいいね数の読み込みはするけどボタンは設置しないときにfalseを指定し、
			//無駄なjsonデータを追記するのを防ぐ
		}
	}


	#出力ソース圧縮用
	private function __trim($str)
	{
		// 両サイドのスペースを消す
		$str = trim($str);
		// 改行、タブをスペースへ
		$str = preg_replace('/[\n\r\t]/', '', $str);
		// 複数スペースを一つへ
		$str = preg_replace('/\s(?=\s)/', '', $str);

		return $str;
	}


	#ディレクトリをセット
	public function setDir($dir){
		$this->dir = $dir;
	}
	#ディレクトリを返す
	public function getDir(){
		return $this->dir;
	}

	#いいね数をセット
	public function setCount(){
		$path = $this->path;
		$dir = $this->dir;
		$rootPath = $this->rootPath;
		$file = $rootPath ."/". $this->jsonFilename;

		if(!file_exists($file)){ //ファイルが存在しない場合
			//現在のページに対していいね数0ををつけたデータを作成します。
			$fp = fopen($file, 'w');
			$arg = array($path => 0);
			fwrite($fp,json_encode($arg));
			fclose($fp);
		} else { //jsonが存在する場合

			$arg = json_decode(file_get_contents($file),true); //jsonを連想配列にデコードして取得
			if($arg == null){ //ファイルが存在するが中身がない場合
				$fp = fopen($file, 'w');
				$arg = array($path =>0); //いいね数0で追加
				fwrite($fp,json_encode($arg));
				fclose($fp);
			}

			if(!array_key_exists($path,$arg)){ //この該当ページのキーが存在しない場合
				$fp = fopen($file, 'w');
				$arg += array($path =>0); //いいね数0で追加
				fwrite($fp,json_encode($arg));
				fclose($fp);
			}
		}

		//いいね数を代入
		$this->count = $arg[$path];
	}

	#いいね数を返す
	public function getCount($path = null){

		$rootPath = $this->rootPath;
		$file = $rootPath ."/". $this->jsonFilename;
		$arg = json_decode(file_get_contents($file),true); //jsonをデコードして取得

		if($path == null){
			if(!array_key_exists($this->path,$arg)){//この該当ページのキーが存在しない場合
				return 0;
			}
			return $arg[$this->path];
		}

		if(!array_key_exists($path,$arg)){ //渡されたページのキーが存在しない場合
			if($path == $this->path){ //渡された値が現在のページの場合は0を返す
				return 0;
			}
			return "undefined";
		}
		return $arg[$path];
	}

	#いいね数が多いページを返します。
	#引数を空にすると最もいいね数が多いページのURLを返します。
	public function getRank($i = 1){
		$rootPath = $this->rootPath;
		$file = $rootPath ."/". $this->jsonFilename;
		$arg = json_decode(file_get_contents($file),true); //jsonをデコードして取得

		//いいね数が多い順にソートします。
		arsort($arg);
		$arg = array_keys($arg);
		$count = count($arg);

		if($count >= $i){
			$url = $arg[$i-1];
			return $url;
		} else {
			return "undefined";
		}
	}


	#ボタンの表示
	public function viewBtn($url = null){
		if($url == null) $url = $this->path; //引数が空の場合、現在のページのパスを入れる

		$btn = <<<EOM
<button class="good-btn" type="button" data-goodbtn-url="{$url}">
	<div class="good-btn-icon"><i class="fa fa-{$this->icon}"></i></div>
	<span class="good-count">{$this->getCount($url)}</span>
</button>

EOM;

	echo $this->__trim($btn);
	}


	#jsとcssのセット表示
	public function head(){
		$head = <<<EOM
<link rel="stylesheet" href="{$this->dir}/goodbtn.min.css">
<script>
	goodbtn = {
		dir: "{$this->dir}",
		jsonFilename: "{$this->jsonFilename}",
		path: "{$this->path}"
	};
</script>
<script src="{$this->dir}/goodbtn.min.js" defer></script>

EOM;

	echo $this->__trim($head);
	}


	#jsonデータを表示 本来ならgood.phpでしか使用しない
	public function updateJson($path){
		$file = $this->jsonFilename;
		$arg = json_decode(file_get_contents($file)); //jsonをデコードして取得

		if(!array_key_exists($path,$arg) && $this->setCountBool){//引数ページのキーが存在しない場合
			 $arg->$path = 0;
		}

		$arg->$path++; //ボタンが押されたページのいいね数を増加
		$fp = fopen($file, 'w'); //jsonを上書きモードで開く
		fwrite($fp,json_encode($arg)); //いいね数が増加した連想配列をjsonにエンコードして上書き
		fclose($fp); //jsonを閉じる

		return $arg;
	}



	#-- ここから下は使用非推奨 --

	#jsを実行（html内に表示）
	public function executeJs(){
		echo <<<EOM
<script>
	goodbtn = {
		dir: "{$this->dir}",
		jsonFilename: "{$this->jsonFilename}",
		path: "{$this->path}"
	};
</script>
<script src="{$this->dir}/goodbtn.min.js" defer></script>
EOM;
	}

	#ボタンの画像パスを取得
	public function getBtnImage(){
		return $this->dir."/"."heart.png";
	}


}