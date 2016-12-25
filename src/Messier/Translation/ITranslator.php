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


namespace Messier\Translation;


use \Messier\Translation\Source\ISource;


/**
 * Each translator should implement this translator interface.
 *
 * @since v0.1.0
 */
interface ITranslator
{


   /**
    * Gets the Source declaration of the translator.
    *
    * @return \Messier\Translation\Source\ISource
    */
   public function getSource() : ISource;

   /**
    * Gets the Source declaration of the translator.
    *
    * @param \Messier\Translation\Source\ISource $source
    * @return \Messier\Translation\ITranslator
    */
   public function setSource( ISource $source ) : ITranslator;

   /**
    * Gets the translation by an numeric identifier.
    *
    * @param int    $number             The numeric identifier
    * @param string $defaultTranslation This text is returned as translation if the source not holds the
    *                                   translation with the requested identifier.
    * @param array  ...$args            If the translation contains sprintf compatible replacements
    *                                   you can declare the replacing values here.
    * @return string
    */
   public function translateByNumber( int $number, string $defaultTranslation, ...$args ) : string;

   /**
    * Gets the translation by an text identifier. If no translation was found inside the current used
    * source $text is returned as translation.
    *
    * @param string $text    The text identifier. Often the english text if english is the main language
    * @param array  ...$args If the translation contains sprintf compatible replacements you can declare the
    *                        replacing values here.
    * @return string
    */
   public function translateByText( string $text, ...$args ) : string;


}

