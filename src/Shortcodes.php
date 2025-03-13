<?php

/**
 * This file is part of the FoWeb package.
 *
 * (c) FoWeb Team
 */

namespace FoWeb\RgpdCookies;


use Timber\Timber;
use Timber\Cache\Cleaner;
use FoWeb\RgpdCookies\Config;

use FoWeb\RgpdCookies\ContextInjector;


class Shortcodes{

	private $viewsFolder;
	private $themeViewsFolder;

	public function __construct()
	{

		$this->viewsFolder      = dirname( __FILE__, 2 ) . "/resources/views/";
		$this->themeViewsFolder = get_template_directory() . '/' . Config::getOption('theme_views_folder');
		$this->contextGlobal    = Timber::context_global();


		/**
		 * Register all Shortcodes
		 * 
		 * @since 0.0.1
		 */

		add_shortcode( 'fw_rgpd_cookies_page' , array( $this, 'cookiesPage' ) );
		add_shortcode( 'fw_popup_content'     , array( $this, 'popupContent') );
	}


	/**
	 * Shortcode popup Content function 
	 * 
	 * Used by internal API to give access to the popup content 
	 * 
	 * This Shortcode is also included as a variable on context @see documentation
	 * 
	 * @since 0.0.1
	 */

	public function popupContent( $attributes, string $content = null )
	{

		global $fw_rgpd_popupContent;
		$fw_rgpd_popupContent ++;

		$datas = $this->contextGlobal;

		$datas['type']   = 'fw_rgpd_popupContent';
		$datas['index']  = $fw_rgpd_popupContent;

		return Timber::compile( $this->getTemplateFile( 'popup.twig' ), $this->contextGlobal );
	}	


	/**
	 * Shortcode Cookies page function 
	 * 
	 * @since 0.0.1
	 */

	public function cookiesPage( $attributes, string $content = null )
	{

		global $fw_rgpd_cookies_page;
		$fw_rgpd_cookies_page ++;

		$datas = $this->contextGlobal;
		$datas['type']   = 'fw_rgpd_cookies_page';
		$datas['index']  = $fw_rgpd_cookies_page;

		return Timber::compile( $this->getTemplateFile( 'cookies_page.twig' ) , $datas);
	}



	/**
	 * Try to find if theme has overrided twig file for shortocode and get the full path.
	 *
	 * @since 0.0.1
	 *
	 * @param string $templateFileName The expected name of the template file
	 * 
	 * @return string Full path of twig template file
	 */

	private function getTemplateFile( string $templateFileName ) : string
	{
		// Default file path
		$fullTemplatePath   = $this->viewsFolder . $templateFileName;

		// Construction of the full name of the expected file
		$customTemplateFile = $this->themeViewsFolder . $templateFileName;

		// Check if custom template exist 
		if( file_exists( $customTemplateFile ) ){

			// Replace filePath with the custom one
			$fullTemplatePath = $customTemplateFile;
		}

		// Return fullPath of template to compile it
		return $fullTemplatePath;

	}


}