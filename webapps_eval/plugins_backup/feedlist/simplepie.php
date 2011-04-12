<?php

	require_once 'simplepie.inc';
	function simplepie_fetch_rss($feedURL,$cache,$cache_timeout){
		$feed = new SimplePie();
		// Use the URL that was passed to the page in SimplePie
		$feed->set_feed_url($feedURL);
		$feed->set_cache_location(ABSPATH . '/' . 'wp-content/cache/');
		$feed->enable_cache($cache);
		if($cache && is_numeric($cache_timeout)){
			$feed->set_cache_duration($cache_timeout);
		}

		$feed->set_image_handler('./handler_image.php');
		$feed->set_favicon_handler('./handler_image.php');
		$success = $feed->init();
		

		$a = array();
		$items = array();

			foreach($feed->get_items() as $i):
				$item = array();
				$item["title"] = $i->get_title();
				$item["description"] = $i->get_content();
				$item["link"] = $i->get_link();
				$item["feeddate"] = $i->get_local_date();
				$item["pubdate"] = $i->get_date();
				$items[]=$item;
			endforeach; 

		$a["items"] = $items;

		return $a;

	}

?>