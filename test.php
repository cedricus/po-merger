<?php
include 'vendor/autoload.php';
require_once('core/pos_info.php');

use Gettext\Translations;
use satellitewp\po;

$baseLocale = 'fr-ca';
$copyLocale = 'fr';
$tests = array('100', '101', '102', '103');
$error = 0;

$pi = new \satellitewp\po\Pos_Info($baseLocale, $copyLocale);
$pi->set_url( 'https://wordpress.org/plugins/wordpress-seo/' );

$vars = $pi->get_internal();

echo 'name: ' . $pi->get_project_name()."\n";
echo 'type: ' . $pi->get_project_type()."\n";

foreach ($tests as $test) {
    $base = Translations::fromPoFile('tests/locale/'.$baseLocale.'/'. $test .'-'.$baseLocale.'.po');
    $copy = Translations::fromPoFile('tests/locale/'.$copyLocale.'/'. $test .'-'.$copyLocale.'.po');

    foreach( $base as $tr) {
        
        if ( ! $tr->hasTranslation() ) {
            $copy_tr = $copy->find( $tr->getContext(), $tr->getOriginal() );

            if ($copy_tr !== false) {
                $tr->setTranslation( $copy_tr->getTranslation() );

                if ($tr->hasPluralTranslations()) {
                    $tr->setPluralTranslations( $copy_tr->getPluralTranslations() );
                }
            }
        }
    }

    $base->toPoFile('result.po');

    $res = Translations::fromPoFile('result.po');
    $exp = Translations::fromPoFile('tests/locale/expected/'. $test .'-expected-'.$baseLocale.'.po');

    if ($res->toPoString() != $exp->toPoString()) {
        echo $test.' FAILED'."\n";
        $error = 1;
    } else {
        echo $test.' SUCCEED'."\n";
    }
}

exit($error);