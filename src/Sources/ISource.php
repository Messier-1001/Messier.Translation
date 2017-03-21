<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\Translation\Sources
 * @since          2017-03-21
 * @version        0.2.0
 */


declare( strict_types = 1 );


namespace Messier\Translation\Sources;


use Messier\Translation\Locale;


/**
 * Each translation source must implement this interface.
 *
 * @since v0.2.0
 */
interface ISource
{


   /**
    * Gets if the current source is valid for reading.
    *
    * @return bool
    */
   public function isValid() : bool;

   /**
    * Reads one or more translation values.
    *
    * @param  null|string|int $identifier
    * @param  null|string     $category
    * @return mixed
    */
   public function read( $identifier, ?string $category = null );

   /**
    * Returns all usable category names
    *
    * @return array
    */
   public function getAllCategories() : array;

   /**
    * Gets the current defined locale.
    *
    * @return \Messier\Translation\Locale
    */
   public function getLocale() : Locale;

   /**
    * Gets all options of the translation source.
    *
    * @return array
    */
   public function getOptions() : array;

   /**
    * Gets the option value of option with defined name or FALSE if the option is unknown.
    *
    * @param string $name The name of the option.
    * @param mixed  $defaultValue This value is remembered and returned if the option not exists
    * @return mixed
    */
   public function getOption( string $name, $defaultValue = false );

   /**
    * Gets if an option with defined name exists.
    *
    * @param string $name The option name.
    * @return bool
    */
   public function hasOption( string $name ) : bool;

   /**
    * Sets a options value.
    *
    * @param string $name
    * @param $value
    * @return \Messier\Translation\Sources\ISource
    */
   public function setOption( string $name, $value );

   /**
    * Reload the source by current defined options.
    *
    * @return \Messier\Translation\Sources\ISource
    * @throws \Throwable
    */
   public function reload();


}

