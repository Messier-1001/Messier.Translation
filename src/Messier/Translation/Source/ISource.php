<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier.DBLib
 * @since          2016-12-22
 * @subpackage     …
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\Translation\Source;


use \Messier\Translation\Locale;


interface ISource
{


   /**
    * Gets the locale of current source.
    *
    * @return \Messier\Translation\Locale
    */
   public function getLocale() : Locale;

   /**
    * Gets all translation categories, known by current source.
    *
    * @return array
    */
   public function getCategories() : array;

   /**
    * Returns if the current source requires numeric (integer) identifiers.
    *
    * @return bool
    */
   public function hasNumericIdentifier() : bool;

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
    * @return \Messier\Translation\Source\ISource
    */
   public function setOption( string $name, $value ) : ISource;

   /**
    * Reload the source by current defined options.
    *
    * @return \Messier\Translation\Source\ISource
    * @throws \Exception
    */
   public function reload() : ISource;

   /**
    * Gets the translation with the defined identifier
    *
    * @param string|int  $identifier
    * @param string|null $defaultTranslation Is returned if the translation was not found
    * @return string|null
    */
   public function getTranslation( $identifier, ?string $defaultTranslation = null ) : ?string;

   /**
    * Gets all translations of an specific category. If no category is defined all translations of all categories
    * are returned.
    *
    * @param string|null $category
    * @return array
    */
   public function getTranslations( ?string $category = null ) : array;

}

