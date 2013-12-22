<?php

// Grab Config
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

// Composer Autoload Helper
include_once DOCUMENT_ROOT . '/vendor/autoload.php';




/**
 * View
 */
$view = new stdClass;
$view->template = "index";
$view->title = "Socialcast";
$view->staticCSS = array(
    'gen-base.min'
);
$view->staticJS = array(
    'gen-base.min'
);





/**
 * Assetic
 */

// Group Assets
use Assetic\Asset\AssetCollection;

// Group Groups of Assets
use Assetic\AssetManager;

// Individual File Operations
use Assetic\Asset\FileAsset;

// Write to File Ability
use Assetic\AssetWriter;

// No Clue, lol
use Assetic\Asset\GlobAsset;

// CSS Min Library
use Assetic\Filter\CssMinFilter;

// JS Min Library
use Assetic\Filter\JSMinFilter;

// LESS Library
use Assetic\Filter\LessphpFilter;

// Generate Assets
if(ASSETGEN){

    /** Base CSS **/
    $baseCSS = new AssetCollection(
        array(
            new FileAsset('css/bootstrap-3.0.3.min.css'),
            new FileAsset('css/bootstrap-theme-3.0.3.min.css'),
            new FileAsset('css/font-awesome-4.0.3.min.css'),
            new FileAsset('css/main.less', array(new LessphpFilter()))
        )
    ); $baseCSS->setTargetPath('css/gen-base.min.css'); $baseCSS->load();

    /** Base JS **/
    $baseJS = new AssetCollection(
        array(
            new FileAsset('js/underscore.min.js'),
            new FileAsset('js/skrollr.min.js'),
            new FileAsset('js/jquery-2.0.3.min.js'),
            new FileAsset('js/bootstrap-3.0.3.min.js'),
            new FileAsset('js/jquery.scrollTo.min.js'),
            new FileAsset('js/jquery.localScroll.min.js'),
            new FileAsset('js/jquery.serialScroll.min.js'),
            new FileAsset('js/jquery.waypoints.min.js'),
            new FileAsset('js/jquery.jcarousel.min.js'),
            new FileAsset('js/plugins.js', array(new JSMinFilter())),
            new FileAsset('js/main.js', array(new JSMinFilter()))
        )
    ); $baseJS->setTargetPath('js/gen-base.min.js'); $baseJS->load();


    // Write the generated files
    if(ASSETWRITE){

        // Build Asset Managers
        $amBaseCSS = new AssetManager(); $amBaseCSS->set('baseCSS', $baseCSS);
        $amBaseJS = new AssetManager(); $amBaseJS->set('baseJS', $baseJS);

        // Write Assets
        $writer = new AssetWriter(DOCUMENT_ROOT);
        $writer->writeManagerAssets($amBaseCSS);
        $writer->writeManagerAssets($amBaseJS);

    }

}











/**
 * Handlebars
 */
use Handlebars\Handlebars;
$engine = new Handlebars(array(
    'loader' => new \Handlebars\Loader\FilesystemLoader(__DIR__.'/templates/'),
    'partials_loader' => new \Handlebars\Loader\FilesystemLoader(
            __DIR__ . '/templates/',
            array(
                'prefix' => '_'
            )
        )
));
echo $engine->render($view->template, $view);

?>