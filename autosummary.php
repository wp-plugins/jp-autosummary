<?php
/*
Plugin Name: JP-AutoSummary
Plugin URI: http://www.jpreece.com/tutorials/wordpress/jp-autosummary/
Description: A very simple and useful utility that allows you to create summarys on your pages using custom fields and have them automatically displayed on your stub pages.
Version: 0.2
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
		
		//Get the summary custom field
		$custompost = get_post_custom($portfolio_children[$i]->ID);		
		$custfield = $custompost['Summary'];		
		
		//Display the custom summary
		echo "<p>" . $custfield[0] . "</p>";
	}
}

//Add Shortcode [JP-AutoSummary id="My Page"]
add_shortcode('JP-AutoSummary', 'autosummary_func');

?>