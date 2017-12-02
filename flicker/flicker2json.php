<?php
    set_time_limit(500);
    require("./init.php");
	//ライブラリを読み込む
	require_once './phpflickr-master/phpFlickr.php' ;

	// インスタンスを作成する
	$flickr = new phpFlickr( $app_key , $app_secret ) ;
    for($i=100;$i<300;$i++){
    echo $i;
	//オプションの設定
	$option = array(
		'per_page' => 500 ,			// 取得件数
        'extras' => 'url_q,url_c,geo' , 		// 画像サイズ
        'text'=>'landscape',
        'safe_search' => 1 ,		// セーフサーチ
        'media'=>'photos',
        'page'=>$i,
        'content_type'=>1,
        'bbox'=>'122.5601,24.2658,148.4508,45.3326'
	) ;

	// 検索を実行し、取得したデータを[$result]に代入する
    $result = $flickr->photos_search( $option ) ;
    
	// [$result]をJSONに変換する
    $json = json_encode( $result );
    file_put_contents("json/".$i.".json",$json);
    }
