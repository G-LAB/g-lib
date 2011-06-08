<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * G-LAB Sitemap Library for Code Igniter v2
 * Written by Ryan Brodkin
 * Copyright 2011
 */

class Sitemap {
	
	private $CI;
	
	function __construct () {
		
		$this->CI =&get_instance();
	
	}
	
	function getHierarchy ($titleSort=false) {
		
		$this->CI->load->helper(array('url', 'glib_directory', 'inflector'));
		
		$pathBase = realpath(APPPATH.'controllers'); 
		$pathThis = __FILE__;

		foreach (rscandir($pathBase) as $pathController) {
			if (
				($pathController != $pathThis) 
				&& (!strpos($pathController, 'index.html')) 
			) { 
				// Make Path Relative to Web Root
				$controller = rtrim(substr($pathController, strlen($pathBase) + 1 , -4 ), '/');
				
				// Clean The Default Controllers From The List
				$defaultController = $GLOBALS["CI"]->router->routes["default_controller"];
				if (strpos($controller,$defaultController)) $controller = 
					preg_replace("/\/$defaultController/i", "", $controller);
				elseif ($controller == $defaultController) $controller = '/';
				
				// Send As Output If Not a Private Controller
				if (substr($controller, 0, 1) != '_') {
					
					// Set The Title
					if ($controller == '/') {
						$title = 'Home';
					} else {
						$title = humanize(ltrim(substr($controller, strrpos($controller, '/')), '/'));
					}
					
					// Add The Directory
					$data["$controller"] = $title;
					
					// Get The Methods When Necessary
					if (!strpos($pathController, $defaultController.'.php')) {
						
						require_once $pathController;
						if (!strpos($controller, '/')) $className = $controller;
						else $className = substr($controller, strripos($controller, '/') + 1);

						$methods = $this->getMethods(ucfirst($className));
						foreach ($methods as $method) if ($method != 'index') {
							$data["$controller"] = $title;
						}
					}
					
				}
					 
			}
		}
		
		if ($titleSort) asort($data);
		else ksort($data);
		
		return $data;
		
	}	
	
	function getXML () {
		
		header("Pragma: no-cache");
		header("Content-type: application/xml");
		
		require_once APPPATH.'libraries/SitemapPHP.php';
		$SitemapPHP = new SitemapPHP(site_url());
		
		foreach ($this->getHierarchy() as $page) $SitemapPHP->addItem($page);
		
		$SitemapPHP->render();
		$this->CI->display->disable();
		
		
	}
	
	private function getMethods ($str) {
		foreach (get_class_methods($str) as $method) {
			if (
				($method != 'get_instance')
				&& ($method[0] != '_')
			) $data[] = $method;
		}
		return $data;
	}
}
	
// End of file.
