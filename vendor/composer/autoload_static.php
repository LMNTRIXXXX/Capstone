<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb69df67ec7713ee5685fb89effea50b6
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitb69df67ec7713ee5685fb89effea50b6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb69df67ec7713ee5685fb89effea50b6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb69df67ec7713ee5685fb89effea50b6::$classMap;

        }, null, ClassLoader::class);
    }
}
