<?php
/*------------------------------------------------------------------------
 # Yt Megamenu - Version 1.0
 # Copyright (C) 2009-2011 The YouTech Company. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: The YouTech Company
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!class_exists('YtObject')){
	class YtObject
	{
		function YtObject()
		{
			$args = func_get_args();
			call_user_func_array(array(&$this, '__construct'), $args);
		}

		function __construct() {}

		function get($property, $default=null)
		{
			if(isset($this->$property)) {
				return $this->$property;
			}
			return $default;
		}

		function getProperties( $public = true )
		{
			$vars  = get_object_vars($this);

			if($public)
			{
				foreach ($vars as $key => $value)
				{
					if ('_' == substr($key, 0, 1)) {
						unset($vars[$key]);
					}
				}
			}

			return $vars;
		}

		function set( $property, $value = null )
		{
			$previous = isset($this->$property) ? $this->$property : null;
			$this->$property = $value;
			return $previous;
		}

		function setProperties( $properties )
		{
			$properties = (array) $properties; //cast to an array

			if (is_array($properties))
			{
				foreach ($properties as $k => $v) {
					$this->$k = $v;
				}

				return true;
			}

			return false;
		}

		function toString()
		{
			return get_class($this);
		}

		function getPublicProperties()
		{
			return $this->getProperties();
		}
	}
}
