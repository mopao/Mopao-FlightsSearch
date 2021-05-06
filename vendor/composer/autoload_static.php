<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2a8c96fe6ded95d9b72f924b241e9f43
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mopao\\ObjectManagers\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mopao\\ObjectManagers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/objectManagers',
        ),
    );

    public static $prefixesPsr0 = array (
        'R' => 
        array (
            'Requests' => 
            array (
                0 => __DIR__ . '/..' . '/rmccue/requests/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2a8c96fe6ded95d9b72f924b241e9f43::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2a8c96fe6ded95d9b72f924b241e9f43::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit2a8c96fe6ded95d9b72f924b241e9f43::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}