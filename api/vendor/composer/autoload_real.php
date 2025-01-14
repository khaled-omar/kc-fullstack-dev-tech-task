<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita8c1726aee684c341d7e46eeeae0fb4e
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInita8c1726aee684c341d7e46eeeae0fb4e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita8c1726aee684c341d7e46eeeae0fb4e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita8c1726aee684c341d7e46eeeae0fb4e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
