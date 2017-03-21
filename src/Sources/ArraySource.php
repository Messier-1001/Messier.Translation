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
 * A array source declares all translations of a specific locale inside an array
 *
 * @since v0.2.0
 */
class ArraySource extends AbstractSource
{


   private $_categories;


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   /**
    * Init a new ArrayTranslator instance.
    *
    * Known options are:
    *
    * <b>data</b>
    *
    * An optional associative or numeric indicated array (depending to $useNumericId) with translation data.
    *
    * The keys are the identifiers, the values can be strings or an array with the translation text key='text'
    * and optional the name of an category key='category'
    *
    * <b>file</b>
    *
    * If 'data' is not defined a valid PHP file must be specified that return the translations array.
    *
    * example content with numeric indicators:
    *
    * <code>
    * return [
    *    1 => 'Einfacher Übersetzungstext',
    *    3 => [
    *       'text'     => 'Ein anderer Übersetzungstext mit einer Kategorie'
    *       'category' => 'Foo'
    *    ]
    * ];
    * </code>
    *
    * example content with string indicators:
    *
    * <code>
    * return [
    *    'Simple translation text' => 'Einfacher Übersetzungstext',
    *    'An other translation text with a category' => [
    *       'text'     => 'Ein anderer Übersetzungstext mit einer Kategorie'
    *       'category' => 'Foo'
    *    ]
    * ];
    * </code>
    *
    *
    * @param \Messier\Translation\Locale|null $locale The source Locale
    * @param array                            $data
    * @param array|null                       $options
    */
   public function __construct( ?Locale $locale, array $data = [], ?array $options = null )
   {

      parent::__construct( $locale );

      if ( \is_array( $options ) && 0 < \count( $options ) )
      {
         $this->_options = $options;
      }

      $this->setData( $data );

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Sets a new array with translation data that should be used.
    *
    * The array keys are the identifiers (string|int) the values must be arrays with items 'text' and optionally
    * with 'category' or the values is a string that will be converted to [ 'text' => $value ]
    *
    * @param array $data
    * @param bool  $doReload
    * @return ArraySource
    */
   public function setData( array $data, bool $doReload = true )
   {

      $this->_options[ 'data' ] = [];
      $this->_categories = [];

      foreach ( $data as $key => $value )
      {
         if ( \is_array( $value ) )
         {
            if ( isset( $value[ 'text' ] ) )
            {
               $this->_options[ 'data' ][ $key ] = $value;
            }
            if ( isset( $value[ 'category' ] ) )
            {
               $this->_categories[] = $value[ 'category' ];
            }
         }
         else
         {
            $this->_options[ 'data' ][ $key ] = [ 'text' => $value ];
         }
      }

      $this->_categories = \array_unique( $this->_categories );

      if ( $doReload )
      {
         $this->reload();
      }

      return $this;

   }

   /**
    * Reads one or more translation values.
    *
    * @param  null|string|int $identifier
    * @param  null|string     $category
    * @return array|false
    */
   public function read( $identifier, ?string $category = null )
   {

      if ( ! \is_int( $identifier ) && ! \is_string( $identifier ) && null === $category )
      {
         // No identifier and no category => RETURN ALL REGISTERED TRANSLATIONS
         return $this->_options[ 'data' ];
      }

      if ( \is_int( $identifier ) || \is_string( $identifier ) )
      {

         // A known identifier format
         if ( ! isset( $this->_options[ 'data' ][ $identifier ] ) )
         {
            // The translation not exists
            return false;
         }

         if ( null !== $category )
         {
            if ( ! isset( $this->_options[ 'data' ][ $identifier ][ 'category' ] ) ||
                 $category !== $this->_options[ 'data' ][ $identifier ][ 'category' ] )
            {
               return false;
            }
            return $this->_options[ 'data' ][ $identifier ];
         }

         return $this->_options[ 'data' ][ $identifier ];

      }

      if ( null === $category )
      {
         return false;
      }

      $result = [];

      foreach ( (array) $this->_options[ 'data' ] as $key => $value )
      {
         if ( isset( $value[ 'category' ] ) && $category === $value[ 'category' ] )
         {
            $result[ $key ] = $value;
         }
      }

      return $result;

   }

   /**
    * Reload the source by current defined options.
    *
    * @return \Messier\Translation\Sources\ArraySource
    */
   public function reload()
   {

      if ( isset( $this->_options[ 'folder' ] ) )
      {
         return $this->reloadFromFolder();
      }

      if ( ! isset( $this->_options[ 'file' ] ) || ! \file_exists( $this->_options[ 'file' ] ) )
      {
         return $this;
      }

      return $this->reloadFromFile();

   }

   /**
    * Sets a options value.
    *
    * @param string $name
    * @param mixed  $value
    * @return \Messier\Translation\Sources\ArraySource
    */
   public function setOption( string $name, $value )
   {

      parent::setOption( $name, $value );

      return $this;

   }

   /**
    * Returns all usable category names
    *
    * @return array
    */
   public function getAllCategories() : array
   {

      return $this->_categories;

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P R I V A T E   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * @return \Messier\Translation\Sources\ArraySource
    */
   private function reloadFromFolder()
   {

      $languageFolderBase = rtrim( $this->_options[ 'folder' ], '\\/' );

      if ( ! empty( $languageFolderBase ) ) { $languageFolderBase .= '/'; }

      $languageFile = $languageFolderBase . $this->_locale->getLID() . '_' . $this->_locale->getCID();

      if ( \strlen( $this->_locale->getCharset() ) > 0 )
      {
         $languageFile .= '/' . $this->_locale->getCharset() . '.php';
      }
      else
      {
         $languageFile .= '.php';
      }

      if ( ! \file_exists( $languageFile ) )
      {
         $languageFile = $languageFolderBase . $this->_locale->getLID() . '_' . $this->_locale->getCID() . '.php';
      }

      if ( ! \file_exists( $languageFile ) )
      {
         $languageFile = $languageFolderBase . $this->_locale->getLID() . '.php';
      }

      if ( ! \file_exists( $languageFile ) )
      {
         unset(
            $this->_options[ 'file' ],
            $this->_options[ 'folder' ]
         );
         return $this;
      }

      $this->_options[ 'file' ]   = $languageFile;
      $this->_options[ 'folder' ] = $languageFolderBase;

      return $this->reloadFromFile();

   }

   /**
    * @return \Messier\Translation\Sources\ArraySource
    */
   private function reloadFromFile()
   {

      try
      {
         /** @noinspection PhpIncludeInspection */
         $translations = include $this->_options[ 'file' ];
      }
      catch ( \Throwable $ex ) { $translations = []; }

      if ( ! \is_array( $translations ) )
      {
         $translations = [];
      }

      return $this->setData( \array_merge( $this->_options[ 'data' ], $translations ), false );

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –">

   /**
    * Loads a translation array source from a specific folder that contains one or more locale depending PHP files.
    *
    * E.G: if the defined $folder is '/var/www/example.com/translations' and the declared Locale is de_DE.UTF-8
    *
    * it tries to use:
    *
    * - /var/www/example.com/translations/de_DE.UTF-8.php
    * - /var/www/example.com/translations/de_DE.php
    * - /var/www/example.com/translations/de.php
    *
    * The used file should be declared like for translations with numeric indicators
    *
    * <code>
    * return [
    *
    *    // Simple translation as string (translation is not a part of a category)
    *    1 => 'Übersetzter Text',
    *
    *    // Translation is an array (translation is not a part of a category)
    *    2 => [ 'text' => 'Anderer übersetzter Text' ],
    *
    *    // Translation is an array (translation is a part of the 'category name' category)
    *    4 => [ 'category' => 'category name', 'text' => 'Anderer übersetzter Text' ],
    *
    *    // Translation is an array (translation is not a part of a category because no category is defined)
    *    5 => [ 'text' => 'Anderer übersetzter Text' ],
    *
    *    // Translation will be ignored because the 'text' element not exists inside the array
    *    6 => [ 'category' => 'category name', 'value' => 'Anderer übersetzter Text' ]
    *
    * ];
    * </code>
    *
    * or for translations with string indicators:
    *
    * <code>
    * return [
    *
    *    // Simple translation as string (translation is not a part of a category)
    *    'Translated text' => 'Übersetzter Text',
    *
    *    // Translation is an array (translation is not a part of a category)
    *    'Other translated text 1' => [ 'text' => 'Anderer übersetzter Text 1' ],
    *
    *    // Translation is an array (translation is a part of the 'category name' category)
    *    'Other translated text 2' => [ 'category' => 'category name', 'text' => 'Anderer übersetzter Text 2' ],
    *
    *    // Translation is an array (translation is not a part of a category because no category is defined)
    *    'Other translated text 3' => [ 'text' => 'Anderer übersetzter Text 3' ],
    *
    *    // Translation will be ignored because the 'text' element not exists inside the array
    *    'Other translated text 3' => [ 'category' => 'category name', 'value' => 'Anderer übersetzter Text 4' ]
    *
    * ];
    * </code>
    *
    * @param  string                             $folder
    * @param  \Messier\Translation\Locale|null   $locale
    * @return \Messier\Translation\Sources\ArraySource
    */
   public static function LoadFromFolder( string $folder, ?Locale $locale = null ) : ArraySource
   {

      try
      {
         return new ArraySource( $locale, [], [ 'folder' => $folder ] );
      }
      catch ( \Throwable $ex )
      {
         return new ArraySource( $locale, [] );
      }

   }

   // </editor-fold>


}

