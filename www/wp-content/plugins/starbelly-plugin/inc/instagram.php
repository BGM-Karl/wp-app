<?php

function starbelly_instagram_api_curl_connect( $api_url ) {
	$connection_c = curl_init(); // initializing
	curl_setopt( $connection_c, CURLOPT_URL, $api_url ); // API URL to connect
	curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
	curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
	$json_return = curl_exec( $connection_c ); // connect and get json data
	curl_close( $connection_c ); // close connection

	return json_decode( $json_return ); // decode and return
}

function starbelly_get_instagram_data( $count, $access_token ) {
	if ( !$count ) { $count = 6; }
	
	$return = starbelly_instagram_api_curl_connect( 'https://graph.instagram.com/me/media?fields=media_type,caption,media_url,permalink&access_token=' . $access_token );
	$data = [];

	if ( is_object( $return ) && ! isset ( $return->error ) ) {
		$i = 0; foreach ($return->data as $post) {
			if ( $post->media_type == 'IMAGE' ) {
				$i++;
				$data[] = array('url' => $post->permalink, 'image' => $post->media_url);
			}
			if ( $i == $count ) break;
		}
	}

	return $data;
}

?>
