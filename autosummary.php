<?php
/*
Plugin Name: JP-AutoSummary
Plugin URI: http://www.jpreece.com/tutorials/wordpress/jp-autosummary/
Description: A very simple and useful utility that allows you to create page summaries, which you can then have automatically displayed on your stub pages.
Version: 0.3
Author: Jonathan Preece
Author URI: http://www.jpreece.com
License: GPL2
*/
?>
<?php
/*  Copyright 2010 Jonathan Preece  (email : info@jpreece.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php

function autosummary_func($atts)
{
	extract(shortcode_atts(array('id' => ''), $atts));
		
	// Get the page as an Object
	$portfolio = get_page_by_title($id);
				
	// Filter through all pages and find Portfolio's children
	$portfolio_children = get_page_children($portfolio->ID, get_pages());
		
	// Loop through each matching page
	for($i = 0; $i < count($portfolio_children); $i++)
	{					
		//Display the post/page title
		echo '<h3><a href="/?page_id=' . $portfolio_children[$i]->ID . '" title="' . $portfolio_children[$i]->post_title . '">' . $portfolio_children[$i]->post_title . '</a></h3>';
		
		//Get content from the page
		$page = get_page($portfolio_children[$i]->ID);
		$content = $page->post_content;
			
		//Extract shortcodes
		do_shortcode($content);
	}
}

//Acts as a handler for the Summary shortcode
function summarysc_func($atts, $content = null)
{		
	//Get attributes
	extract(shortcode_atts($atts));
	
	echo "<p>" . $content . "</p>";
}

//Adds shortcode [Summary]
add_shortcode('Summary', 'summarysc_func');

//Add Shortcode [JP-AutoSummary id="My Page"]
add_shortcode('JP-AutoSummary', 'autosummary_func');

?>