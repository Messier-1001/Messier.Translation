<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\Translation
 * @since          2017-03-21
 * @version        0.1.3
 */


declare( strict_types = 1 );


namespace Messier\Translation;


/**
 * If a class should be able to translate some specific, class depending texts, it must implement this interface.
 *
 * @since v0.1.3
 */
interface ILocalizable
{


   /**
    * Gets the translator that handles the translation behind the class scenes.
    *
    * @return \Messier\Translation\ITranslator
    */
   public function getTranslator() : ITranslator;


}

