<?php

/**
 * @class Helper
 * 
 * This class contains public helper methods 
 */
class Helper {

	public static function getUpdatesRSSFeed($feedURL='',$entriesCount=1) {
		$items=[];
		if($feedURL != ''){
			Feed::$userAgent = Yii::app()->params['curlUserAgent'];
			Feed::$cacheDir = Yii::app()->params['latestUpdatesFeedCacheDir'];
			Feed::$cacheExpire = Yii::app()->params['latestUpdatesFeedCacheExp'];
			$feed = Feed::loadRss(Yii::app()->params[$feedURL]);
			if (!empty($feed)) {
				$i=0;
				foreach ($feed->item as $item) {
					if($i > $entriesCount-1){
						break;
					}
					$more = ' <a href="' . $item->link . '" target="_blank">Read more</a>';
					$item->description = trim(str_replace(' [&#8230;]', '...' . $more, $item->description));
					$item->description = preg_replace('/The post.*appeared first on .*\./', '', $item->description);
					$items[]=$feed->item[$i];
					$i++;
				}
				//$items = $feed->item;
			}
		}
		return $items;
	}	
}

?>