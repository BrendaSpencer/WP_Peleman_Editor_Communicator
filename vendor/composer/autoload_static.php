<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5d1dde0dc56bac4167f2cd55ff083c02
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WSPEC\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WSPEC\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5d1dde0dc56bac4167f2cd55ff083c02::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5d1dde0dc56bac4167f2cd55ff083c02::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5d1dde0dc56bac4167f2cd55ff083c02::$classMap;

        }, null, ClassLoader::class);
    }
}
