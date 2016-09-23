<?php 
	// setup the default data set here to avoid breaking the code
	isset($host_addr)?$host_addr:$host_addr="";
	isset($host_logo_image)?$host_logo_image:$host_logo_image="";
	isset($host_target_addr)?$host_target_addr:$host_target_addr="";
	isset($host_keywords)?$host_keywords:$host_keywords="";
	isset($host_title_name)?$host_title_name:$host_title_name="";
	isset($host_admin_title_name)?$host_admin_title_name:$host_admin_title_name="";
	isset($host_default_poster)?$host_default_poster:$host_default_poster="";
	isset($host_default_cover_image)?$host_default_cover_image:$host_default_cover_image="";
	isset($host_blog_play_limit)?$host_blog_play_limit:$host_blog_play_limit="";
	isset($host_sessionvar_prefix)?$host_sessionvar_prefix:$host_sessionvar_prefix="";
	isset($host_sessionvar_suffix)?$host_sessionvar_suffix:$host_sessionvar_suffix="";
	isset($host_favicon)?$host_favicon:$host_favicon="";
	// default global variables for functions to use
	global  $host_addr,
			$host_logo_image,
			$host_target_addr,
			$host_price_limit,
			$host_keywords,
			$host_title_name,
			$host_admin_title_name,
			$host_default_poster,
			$host_default_cover_image,
			$host_sessionvar_prefix,
			$host_sessionvar_suffix,
			$host_favicon;
?>