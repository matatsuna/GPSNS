<?php
    set_time_limit(500);
    require("./init.php");
	//ライブラリを読み込む
    $connection=mysql_connect ('localhost', $username, $password);
    if (!$connection) {  die('Not connected : ' . mysql_error());}
    $db_selected = mysql_select_db($database, $connection);
    if (!$db_selected) {
        die ('Can\'t use db : ' . mysql_error());
    }
    for($i=1;$i<300;$i++){
        echo $i;
        $json=file_get_contents("json/".$i.".json");
        $obj = json_decode($json);
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
        $o_src = ( isset($photo->url_c) ) ? $photo->url_c : $photo->url_q ;		// 画像ファイルのURL
        $lat = $photo->latitude;
        $lng = $photo->longitude;
        
        $query = "INSERT INTO gpsns_table(link,lat,lng) VALUES('$o_src',$lat,$lng)";
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
	}



    }
