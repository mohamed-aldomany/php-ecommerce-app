<?php

 function lang($word){

	static $lang = array(
		"home"    => "Brand",
		"section" => "Categories",
		"items"   => "Items",
		"members" => "Members",
		"comment"   => "Comments",
		"live"    => "live",
	);

	return $lang[$word]; 
}


?>