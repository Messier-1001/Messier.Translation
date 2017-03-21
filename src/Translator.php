<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\GITweb\Translation
 * @since          2017-03-17
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\Translation;


use Messier\Translation\Sources\ISource;


/**
 * Defines a class that …
 */
class Translator implements ITranslator
{


   // <editor-fold desc="// – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * All options of the Source implementation
    *
    * @type \Messier\Translation\Sources\ISource
    */
   protected $_source;

   /**
    * Categories cache if it must be stored inside the translator
    *
    * @type array
    */
   protected $_categories;

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   /**
    * Translator constructor.
    *
    * @param \Messier\Translation\Sources\ISource $source
    */
   public function __construct( ISource $source )
   {

      $this->_source     = $source;

      $this->_categories = $source->getAllCategories();

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Gets the used translation source
    *
    * @return \Messier\Translation\Sources\ISource
    */
   public final function getSource() : ISource
   {

      return $this->_source;

   }

   /**
    * Gets all options of the translation source.
    *
    * @return array
    */
   public function getCategories() : array
   {

      return $this->_categories;

   }

   /**
    * Gets the translation with the defined identifier. If the identifier not points to a known translation
    * and no $defaultTranslation is defined the identifier itself is returned as a string.
    *
    * @param string|int  $identifier
    * @param string|null $defaultTranslation Is returned if the translation was not found
    * @return string
    */
   public function getTranslation( $identifier, ?string $defaultTranslation = null ) : string
   {

      if ( false === ( $translationText = $this->_source->read( $identifier ) ) )
      {
         if ( null === $defaultTranslation )
         {
            return (string) $identifier;
         }
         return $defaultTranslation;
      }

      return \is_array( $translationText ) ? $translationText[ 'text' ] : (string) $translationText;

   }

   /**
    * Gets all translations of an specific category. If no category is defined all translations of all categories
    * are returned.
    *
    * @param string|null $category
    * @return array
    */
   public function getTranslations( ?string $category = null ) : array
   {

      $translations = $this->_source->read( null, $category );

      $result = [];

      foreach ( $translations as $key => $value )
      {
         $result[ $key ] = $value[ 'text' ];
      }

      return $result;

   }

   // </editor-fold>


}

