<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\Translation
 * @since          2016-12-23
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\Translation;


use \Messier\Translation\Source\ISource;


/**
 * Defines a class that …
 */
class Translator implements ITranslator
{


   // <editor-fold desc="// – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * The translation source
    *
    * @type \Messier\Translation\Source\ISource
    */
   protected $_source;

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   /**
    * Init a new Translator instance.
    *
    * @param \Messier\Translation\Source\ISource $source
    */
   public function __construct( ISource $source )
   {

      $this->_source = $source;

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Gets the Source declaration of the translator.
    *
    * @return \Messier\Translation\Source\ISource
    */
   public function getSource() : ISource
   {

      return $this->_source;

   }

   /**
    * Gets the translation by an numeric identifier.
    *
    * @param int $number The numeric identifier
    * @param string $defaultTranslation This text is returned as translation if the source not holds the
    *                                   translation with the requested identifier.
    * @param array ...$args If the translation contains sprintf compatible replacements
    *                                   you can declare the replacing values here.
    * @return string
    */
   public function translateByNumber( int $number, string $defaultTranslation, ...$args ) : string
   {

      $transStr = $this->_source->getTranslation( $number, $defaultTranslation );

      if ( \count( $args ) < 1 )
      {
         return $transStr;
      }

      return \sprintf( $transStr, $args );

   }

   /**
    * Gets the translation by an text identifier. If no translation was found inside the current used
    * source $text is returned as translation.
    *
    * @param string $text The text identifier. Often the english text if english is the main language
    * @param array ...$args If the translation contains sprintf compatible replacements you can declare the
    *                        replacing values here.
    * @return string
    */
   public function translateByText( string $text, ...$args ) : string
   {

      $transStr = $this->_source->getTranslation( $text );

      if ( \count( $args ) < 1 )
      {
         return $transStr;
      }

      return \sprintf( $transStr, $args );

   }

   /**
    * Sets the Source declaration of the translator.
    *
    * @param  \Messier\Translation\Source\ISource $source
    * @return \Messier\Translation\ITranslator
    */
   public function setSource( ISource $source ) : ITranslator
   {

      $this->_source = $source;

      return $this;

   }

   // </editor-fold>


}

