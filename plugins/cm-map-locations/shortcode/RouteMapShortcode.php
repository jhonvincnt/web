<?php
namespace com\cminds\maplocations\shortcode;

use com\cminds\maplocations\controller\FrontendController;
use com\cminds\maplocations\model\Settings;
use com\cminds\maplocations\controller\RouteController;
use com\cminds\maplocations\model\Route;

class RouteMapShortcode extends Shortcode {
	
	const SHORTCODE_NAME = 'cmloc-location-map';
	
	static function shortcode($atts) {
		
		$atts = shortcode_atts(array(
			'id' => null,
			'route' => null,
			'graph' => 1,
			'params' => 1,
			'map' => 1,
			'mapwidth' => '',
			'mapheight' => '',
			'width' => '',
			'showtitle' => 1,
			'showdate' => 1,
			'theme' => 'standard',
		), $atts);
		
		if (!empty($atts['id'])) {
			$route = Route::getInstance($atts['id']);
		}
		else if (!empty($atts['route'])) {
			$route = $atts['route'];
		}
		
		if (!empty($route) AND $route instanceof Route AND $route->canView()) {
			FrontendController::enqueueStyle();
			RouteController::loadSinglePageScripts();
			$displayParams = Settings::getOption(Settings::OPTION_SINGLE_ROUTE_PARAMS);
			return RouteController::loadFrontendView('shortcode-map', compact('route', 'atts', 'displayParams'));
		}
		
	}

}