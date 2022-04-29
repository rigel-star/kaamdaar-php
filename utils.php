<?php 

	require_once "constants.php";

	function redirect($url) : void
	{
		header("location:$url.php");
	}


	$static_file_dir = "/kaamdaar/static/";


	function change_static_file_dir($new_path) : void
	{
		global $static_file_dir;
		$static_file_dir = $new_path;
	}


	function url_for($filename) : string
	{
		global $static_file_dir;
		return "./$static_file_dir/$filename";
	}



	function get_user_location($fields=['country', 'region', 'city', 'lat', 'lon'])
	{
		$query = @unserialize (file_get_contents('http://ip-api.com/php/'));

		$result = [];
		if($query)
		{
			foreach($fields as $field)
			{
				$result[$field] = $query[$field];
			}
		}

		return $result;
	}

?>