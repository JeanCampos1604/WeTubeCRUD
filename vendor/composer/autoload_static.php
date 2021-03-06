<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita796692c9153607591da59487b48253a
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita796692c9153607591da59487b48253a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita796692c9153607591da59487b48253a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita796692c9153607591da59487b48253a::$classMap;

        }, null, ClassLoader::class);
    }
}
