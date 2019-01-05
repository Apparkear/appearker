<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita5cba6e96fd1277fd98f1ef60f313b16
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CorsSlim\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CorsSlim\\' => 
        array (
            0 => __DIR__ . '/..' . '/palanik/corsslim',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita5cba6e96fd1277fd98f1ef60f313b16::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita5cba6e96fd1277fd98f1ef60f313b16::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInita5cba6e96fd1277fd98f1ef60f313b16::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}