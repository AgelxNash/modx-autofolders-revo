<?php
// A function to format a date, as specified in the plugin options
	if (!function_exists('getFormattedDate') ) {
		function getFormattedDate($dt, $part, $format) {		
			// $dt = datetime 
			// Part should be y, m or d
			// format should be the format ID from the config dropdown
			switch ($part) {
				case 'y':
					switch ($format) {
						case '4':
						case 'menuindex':
							return strftime("%Y", $dt);
						break;
						case '2':
							return strftime("%y", $dt);
						break;		
						default:
							return false;
						break;
					}
				break;
				case 'm':
					switch ($format) {					
						case '1':
						case 'menuindex':
							return intval(strftime("%m", $dt));
						break;	
						case '2':
							return strftime("%m", $dt);
						break;	
						case '3':
							return strftime("%B", $dt);
						break;
						case '4':
							return strftime("%b", $dt);
						break;
						default:
							return false;
						break;	
					}
				break;
				case 'd':
					switch ($format) {					
						case '1':
						case 'menuindex':
							return trim(strftime("%e", $dt));
						break;
						case '2':
							return strftime("%d", $dt);
						break;	
						default:
							return false;
						break;	
					}
				break;			
				default:
					return false;
				break;
			}
		}
	}