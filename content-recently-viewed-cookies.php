<?php
/**
 * File for storing cookie functionality for Recently Viewed Items
 *
 * @package boiler
 */
	// Get ID of current product
	$currentItem = $post->ID;
	
	if( !isset($_COOKIE['recentlyviewed']) ) {
		
		$recentlyViewed = array();
		
		setRecentlyViewedCookie($recentlyViewed, $currentItem);
		
	} else {
		// pull down recently viewed items from cookie if it is already set
		$recentlyViewed = json_decode($_COOKIE['recentlyviewed'], true);
		//echo '<pre>'; print_r($recentlyViewed); echo '</pre>';
		if (!in_array($currentItem, $recentlyViewed)) {
			setRecentlyViewedCookie($recentlyViewed, $currentItem);
			
		} else {
			// get the position of the element in the array
			$itemLocation = array_search($currentItem, $recentlyViewed);
			
			// remove the current item from the recently viewed items
			unset($recentlyViewed[$itemLocation]);
			
			setRecentlyViewedCookie($recentlyViewed, $currentItem);
			
		}
		
	}
	
	function setRecentlyViewedCookie($recentlyViewed, $currentItem) {		
		// add current item to beginning of recently viewed array
		array_unshift($recentlyViewed, $currentItem);
		
		// encode the array to a json cookie
		$encodeCookie = json_encode($recentlyViewed);

		// set the updated cookie
		setcookie('recentlyviewed', $encodeCookie, strtotime( '+30 days' ), "/");
	}
	
?>

