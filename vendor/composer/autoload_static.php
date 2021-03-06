<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb0e43648515cdb71c75b5d4f4bc4f2a1
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SimpleSoftwareIO\\QrCode\\' => 24,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SimpleSoftwareIO\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/simplesoftwareio/simple-qrcode/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb0e43648515cdb71c75b5d4f4bc4f2a1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb0e43648515cdb71c75b5d4f4bc4f2a1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb0e43648515cdb71c75b5d4f4bc4f2a1::$classMap;

        }, null, ClassLoader::class);
    }
}
