<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\Translation
 * @since          2017-03-21
 * @version        0.2.0
 */


declare( strict_types = 1 );


namespace Messier\Translation;


use Messier\Translation\Sources\ISource;


/**
 * Each translator must implement this interface
 */
interface ITranslator
{


   /**
    * Gets the used translation source
    *
    * @return \Messier\Translation\Sources\ISource
    */
   public function getSource() : ISource;

   /**
    * Gets all translation categories, known by current source.
    *
    * The array key <=> array value association must be consistent!
    *
    * In most cases the key is the unique identifier from a database table record or something else
    *
    * @return array
    * @music Snap / Exterminator <https://www.youtube.com/watch?v=myFu0jtXcd8>
    */
   public function getCategories() : array;

   /**
    * Gets the translation with the defined identifier. If the identifier not points to a known translation
    * and no $defaultTranslation is defined the identifier itself is returned as a string.
    *
    * @param string|int  $identifier
    * @param string|null $defaultTranslation Is returned if the translation was not found
    * @return string
    */
   public function getTranslation( $identifier, ?string $defaultTranslation = null ) : string;

   /**
    * Gets all translations of an specific category. If no category is defined all translations of all categories
    * are returned.
    *
    * @param string|null $category
    * @return array
    */
   public function getTranslations( ?string $category = null ) : array;


}

