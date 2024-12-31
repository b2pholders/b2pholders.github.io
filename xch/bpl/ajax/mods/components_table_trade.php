<?php

namespace BPL\Ajax\Mods\Token\Trade\Table\Components;

use function BPL\Mods\Local\Helpers\settings;

/**
 * @param $latest
 * @param $next
 * @param $prev
 * @param $oldest
 * @param $total
 * @param $rows
 * @param $start_row
 *
 * @return string
 *
 * @since version
 */
function paginate($latest, $next, $prev, $oldest, $total, $rows, $start_row): string
{
	$limit_from = $rows * $start_row;

	$count_total = count($total);

//	$latest_active   = '<input type="button" value=">|"' . $latest .
//		' class="uk-panel-badge uk-badge-notification uk-badge-success">';
//	$latest_disabled = '<input disabled type="button" value=">|"
//		class="uk-panel-badge uk-badge-notification uk-badge-success">';

//	$next_disabled = '<input disabled type="button" value=">>"
//		class="uk-panel-badge uk-badge-notification uk-badge-warning" style="margin-right: 10%; text-align: left">';
//	$next_active   = '<input type="button" value=">>"' . $next .
//		' class="uk-panel-badge uk-badge-notification uk-badge-warning" style="margin-right: 10%; text-align: left">';

//	$prev_disabled = '<input disabled type="button" value="<<"
//		class="uk-panel-badge uk-badge-notification uk-badge-danger" style="margin-right: 20%; text-align: left">';
//	$prev_active   = '<input type="button" value="<<"' . $prev .
//		' class="uk-panel-badge uk-badge-notification uk-badge-danger" style="margin-right: 20%; text-align: left">';

//	$oldest_active   = '<input type="button" value="|<"' . $oldest .
//		' class="uk-panel-badge uk-badge-notification uk-badge" style="margin-right: 30%; text-align: left">';
//	$oldest_disabled = '<input disabled type="button" value="|<"
//		class="uk-panel-badge uk-badge-notification uk-badge" style="margin-right: 30%; text-align: left">';

	$oldest_active   = '<input type="button" value="|<"' . $oldest .
		' class="uk-panel-badge uk-badge-notification uk-badge">';
	$oldest_disabled = '<input disabled type="button" value="|<" 
		class="uk-panel-badge uk-badge-notification uk-badge">';

	$prev_disabled = '<input disabled type="button" value="<<" 
		class="uk-panel-badge uk-badge-notification uk-badge-danger">';
	$prev_active   = '<input type="button" value="<<"' . $prev .
		' class="uk-panel-badge uk-badge-notification uk-badge-danger">';

	$next_disabled = '<input disabled type="button" value=">>" 
		class="uk-panel-badge uk-badge-notification uk-badge-warning">';
	$next_active   = '<input type="button" value=">>"' . $next .
		' class="uk-panel-badge uk-badge-notification uk-badge-warning">';

	$latest_active   = '<input type="button" value=">|"' . $latest .
		' class="uk-panel-badge uk-badge-notification uk-badge-success">';
	$latest_disabled = '<input disabled type="button" value=">|" 
		class="uk-panel-badge uk-badge-notification uk-badge-success">';

	$str = $count_total > ($limit_from + $rows) ? $oldest_active : $oldest_disabled;
	$str .= $count_total > ($limit_from + $rows) ? $prev_active : $prev_disabled;
	$str .= $start_row > 0 ? $next_active : $next_disabled;
	$str .= $start_row > 0 ? $latest_active : $latest_disabled;

	$str .= '<style>
	    /* General styling */
	    .button-group {
	        display: flex;
	        justify-content: space-around;
	        margin-bottom: 10px;
	    }
	
	    /* Responsive adjustments */
	    @media screen and (max-width: 768px) {
	        .uk-panel-title {
	            font-size: 1.2em;
	        }
	
	        .button-group input {
	            width: 20%;
	            margin-right: 0;
	            text-align: center;
	        }
	
	        .category.table th, .category.table td {
	            font-size: smaller;
	        }
	    }
	
	    @media screen and (max-width: 480px) {
	        .button-group {
	            flex-direction: column;
	            align-items: flex-start;
	        }
	
	        .button-group input {
	            width: 100%;
	            margin-bottom: 5px;
	        }
	
	        .category.table th, .category.table td {
	            font-size: smaller;
	        }
	    }
	    
	    .uk-panel {
		    overflow-x: auto; /* Allows horizontal scrolling if content is wider than the panel */
		    padding: 15px; /* Adds some padding around the content inside the panel */
		}
		
		.category.table {
		    width: 100%; /* Ensures the table fits within the width of the parent container */
		    box-sizing: border-box; /* Includes padding and border in the element\'s width and height */
		}
		
		@media screen and (max-width: 768px) {
			.category.table th, .category.table td {
				font-size: smaller; /* Reduces font size for smaller screens */
		    }
		}
	</style>';

	return $str;
}

/**
 * @param   string  $str
 *
 * @return string
 *
 * @since version
 */
function table_head_mkt(string $str): string
{
	$str .= '<table class="category table table-striped table-bordered table-hover">';
	$str .= '<thead>';
	$str .= '<tr>';
	$str .= '<th>Price</th>';
	$str .= '<th>Qty (' . settings('trading')->token_name . ')</th>';
	$str .= '<th>Total</th>';
	$str .= '</tr>';
	$str .= '</thead>';
	$str .= '<tbody style="font-size: smaller; font-weight: bold">';

	return $str;
}

/**
 * @param           $result
 * @param   string  $color
 * @param   string  $str
 * @param   string  $button
 *
 * @return string
 *
 * @since version
 */
function table_row_mkt($result, string $color, string $str, string $button): string
{
	$total = $result->amount * $result->price;

	$str .= '<tr' . $color . '>';
	$str .= '<td>' . number_format($result->price, 8) . '</td>';
	$str .= '<td>' . number_format($result->amount, 8) . '</td>';
	$str .= '<td>' . number_format($total, 5) . $button . '</td>';
	$str .= '</tr>';

	return $str;
}