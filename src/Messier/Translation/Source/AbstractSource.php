<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\Translation\Source
 * @since          2016-12-23
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\Translation\Source;


use \Messier\Translation\Locale;


/**
 * Defines a class that …
 */
abstract class AbstractSource implements ISource
{


   // <editor-fold desc="// – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * All options of the Source implementation
    *
    * @type array
    */
   protected $options      = [];

   /**
    * The current locale of the source
    *
    * @type Locale
    */
   protected $locale;

   /**
    * Declares if the current source requires numeric (integer) identifiers.
    *
    * @type bool
    */
   protected $_useNumericId;

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Gets the locale of current source.
    *
    * @return \Messier\Translation\Locale
    */
   public function getLocale() : Locale
   {

      return $this->locale;

   }

   /**
    * Returns if the current source requires numeric (integer) identifiers.
    *
    * @return bool
    */
   public function hasNumericIdentifier() : bool
   {

      return $this->_useNumericId;

   }

   /**
    * Gets all options of the translation source.
    *
    * @return array
    */
   public function getOptions() : array
   {

      return $this->options;

   }

   /**
    * Gets the option value of option with defined name or FALSE if the option is unknown.
    *
    * @param string $name The name of the option.
    * @param mixed  $defaultValue This value is remembered and returned if the option not exists. If the value is NULL
    *                             the value is not set, it is only returned in this case.
    * @return mixed
    */
   public function getOption( string $name, $defaultValue = false )
   {

      if ( ! $this->hasOption( $name ) )
      {
         if ( null === $defaultValue )
         {
            return $defaultValue;
         }
         $this->options[ $name ] = $defaultValue;
      }

      return $this->options[ $name ];

   }

   /**
    * Gets if an option with defined name exists.
    *
    * @param string $name The option name.
    * @return bool
    */
   public function hasOption( string $name ) : bool
   {

      return \array_key_exists( $name, $this->options );

   }

   /**
    * Sets a options value.
    *
    * @param string $name
    * @param $value
    * @return \Messier\Translation\Source\ISource
    */
   public function setOption( string $name, $value ) : ISource
   {

      $this->options[ $name ] = $value;

      return $this;

   }

   /**
    * Gets all translation categories, known by current source.
    *
    * @return array
    */
   public abstract function getCategories() : array;

   /**
    * Reload the source by current defined options.
    *
    * @return \Messier\Translation\Source\ISource
    * @throws \Exception
    */
   public abstract function reload() : ISource;

   /**
    * Gets the translation with the defined identifier
    *
    * @param string|int  $identifier
    * @param string|null $defaultTranslation Is returned if the translation was not found
    * @return string|null
    */
   public abstract function getTranslation( $identifier, ?string $defaultTranslation = null ) : ?string;

   /**
    * Gets all translations of an specific category. If not category is defined all translations of all categories
    * are returned.
    *
    * @param string|null $category
    * @return array
    */
   public abstract function getTranslations( ?string $category = null ) : array;

   // </editor-fold>


}

