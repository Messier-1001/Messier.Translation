<?php

include dirname( __DIR__ ) . '/vendor/autoload.php';

\Messier\Translation\Locale::Create( new \Messier\Translation\Locale( 'de', 'DE' ) )->registerAsGlobalInstance();

$source = \Messier\Translation\Sources\ArraySource::LoadFromFolder( __DIR__ . '/i18n' );

$translator = new \Messier\Translation\Translator( $source );

printf( $translator->getTranslation( 'Hello, my name is %s.' ), 'Max' );
echo "\n", $translator->getTranslation( 'This is a short example text.' ), "\n";
$translations = \array_values( $translator->getTranslations( 'Category 1' ) );
print_r( $translations );
