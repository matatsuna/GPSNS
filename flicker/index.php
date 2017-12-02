<?php
    require("./init.php");
	//ライブラリを読み込む
	require_once './phpflickr-master/phpFlickr.php' ;

	// インスタンスを作成する
	$flickr = new phpFlickr( $app_key , $app_secret ) ;

	//オプションの設定
	$option = array(
		'per_page' => 500 ,			// 取得件数
        'extras' => 'url_q,url_c,geo' , 		// 画像サイズ
        'text'=>'landscape',
        'safe_search' => 1 ,		// セーフサーチ
        'media'=>'photos',
        'page'=>2,
        'content_type'=>1,
        'bbox'=>'122.5601,24.2658,148.4508,45.3326'
	) ;

	// 検索を実行し、取得したデータを[$result]に代入する
    $result = $flickr->photos_search( $option ) ;
    
	// [$result]をJSONに変換する
	$json = json_encode( $result );

	// JSONをオブジェクト型に変換する
	$obj = json_decode( $json ) ;

	// HTML用
	$html = '<meta charset="utf-8">' ;

	// 写真検索を実行する
	$html .= '<h2>条件を指定する</h2>' ;
	$html .= '<p>条件を指定して、写真を検索してみて下さい。</p>' ;
	$html .= '<form>' ;
	$html .= 	'<p style="font-size:.9em; font-weight:700;"><label for="text">検索キーワード (text)</label></p>' ;
	$html .= 		'<p style="margin:0 0 1em;"><input id="text" name="text" value="寺" placeholder="寺"></p>' ;
	$html .= 	'<p style="font-size:.9em; font-weight:700;"><label for="bbox">位置範囲 (bbox)</label></p>' ;
	$html .= 		'<p style="margin:0 0 1em;"><input id="bbox" name="bbox" list="bbox-data" placeholder=""></p>' ;
	$html .= 		'<datalist id="bbox-data">' ;
	$html .= 			'<option value="139.74136476171873,35.67800739824976,139.78565339697263,35.71146639304908">' ;
	$html .= 		'</datalist>' ;
	$html .= 	'<p><button>検索する</button></p>' ;
	$html .= '</form>' ;

	// 実行結果の表示
	$html .= '<h2>実行結果</h2>' ;
	$html .= '<p>リクエストの実行結果です。</p>' ;

	// リスト形式で表示する
	$html .= '<ul style="margin:2em 0 0; padding:0; overflow:hidden; list-style-type:none; text-align:center;">' ;

	// ループ処理
	foreach( $obj->photo as $photo )
	{
		// データが揃っていない場合はスキップ
		if( !isset($photo->url_q) || !isset($photo->width_q) || !isset($photo->height_q) )
		{
			continue ;
		}

		// データの整理
		$t_src = $photo->url_q ;		// サムネイルの画像ファイルのURL
		$t_width = $photo->width_q ;	// サムネイルの横幅
		$t_height = $photo->height_q ;	// サムネイルの縦幅
		$o_src = ( isset($photo->url_c) ) ? $photo->url_c : $photo->url_q ;		// 画像ファイルのURL

		// 出力する
		$html .= '<li style="float:left; margin:1px; padding:0; overflow:hidden; height:112.5px">' ;
		$html .= 	'<a href="' . $o_src . '" target="_blank">' ;
		$html .= 		'<img src="' . $t_src . '" width="' . $t_width . '" height="' . $t_height . '" style="max-width:100%; height:auto">' ;
		$html .= 	'</a>' ;
		$html .= '</li>' ;
	}

	$html .= '</ul>' ;

	// 取得したデータ
	$html .= '<h2>取得したデータ</h2>' ;
	$html .= '<p>下記のデータを取得できました。</p>' ;
	$html .= 	'<h3>JSONに変換後</h3>' ;
	$html .= 	'<p><textarea rows="8">' . $json . '</textarea></p>' ;

?>

<?php
	// ブラウザに[$html]を出力 (HTMLのヘッダーとフッターを付けましょう)
	echo $html ;
?>