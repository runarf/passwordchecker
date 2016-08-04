<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f10f0d5753be3bb11ac2a4d34f41c10
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Yaml\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1f10f0d5753be3bb11ac2a4d34f41c10::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1f10f0d5753be3bb11ac2a4d34f41c10::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
