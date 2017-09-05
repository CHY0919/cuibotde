<?php

include_once("plugins/simple_html_dom.php");

	  function crawl_page($url)
	{
			$domain = "http://www.egv.org.tw";
					// open the web page
			$html = new simple_html_dom();
			$html->load_file($url);

			// array to store scraped links
			$links = $html->find("img");
			$sub_menu = $links[0]->src;
			// crawl the webp	age for links
			return $domain.$sub_menu;


	}

?>