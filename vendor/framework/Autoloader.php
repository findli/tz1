<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 5:13 PM
 */
/*
 * <?php
namespace Example\Tests;

class MockPsr4AutoloaderClass extends Psr4AutoloaderClass
{
    protected $files = array();

    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    protected function requireFile($file)
    {
        return in_array($file, $this->files);
    }
}

class Psr4AutoloaderClassTest extends \PHPUnit_Framework_TestCase
{
    protected $loader;

    protected function setUp()
    {
        $this->loader = new MockPsr4AutoloaderClass;

        $this->loader->setFiles(array(
            '/vendor/foo.bar/src/ClassName.php',
            '/vendor/foo.bar/src/DoomClassName.php',
            '/vendor/foo.bar/tests/ClassNameTest.php',
            '/vendor/foo.bardoom/src/ClassName.php',
            '/vendor/foo.bar.baz.dib/src/ClassName.php',
            '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php',
        ));

        $this->loader->addNamespace(
            'Foo\Bar',
            '/vendor/foo.bar/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar',
            '/vendor/foo.bar/tests'
        );

        $this->loader->addNamespace(
            'Foo\BarDoom',
            '/vendor/foo.bardoom/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar\Baz\Dib',
            '/vendor/foo.bar.baz.dib/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar\Baz\Dib\Zim\Gir',
            '/vendor/foo.bar.baz.dib.zim.gir/src'
        );
    }

    public function testExistingFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\ClassName');
        $expect = '/vendor/foo.bar/src/ClassName.php';
        $this->assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\Bar\ClassNameTest');
        $expect = '/vendor/foo.bar/tests/ClassNameTest.php';
        $this->assertSame($expect, $actual);
    }

    public function testMissingFile()
    {
        $actual = $this->loader->loadClass('No_Vendor\No_Package\NoClass');
        $this->assertFalse($actual);
    }

    public function testDeepFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\Baz\Dib\Zim\Gir\ClassName');
        $expect = '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php';
        $this->assertSame($expect, $actual);
    }

    public function testConfusion()
    {
        $actual = $this->loader->loadClass('Foo\Bar\DoomClassName');
        $expect = '/vendor/foo.bar/src/DoomClassName.php';
        $this->assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\BarDoom\ClassName');
        $expect = '/vendor/foo.bardoom/src/ClassName.php';
        $this->assertSame($expect, $actual);
    }
}
 */

namespace framework;

/**
 * An example of a general-purpose implementation that includes the optional
 * functionality of allowing multiple base directories for a single namespace
 * prefix.
 *
 * Given a foo-bar package of classes in the file system at the following
 * paths ...
 *
 *     /path/to/packages/foo-bar/
 *         src/
 *             Baz.php             # Foo\Bar\Baz
 *             Qux/
 *                 Quux.php        # Foo\Bar\Qux\Quux
 *         tests/
 *             BazTest.php         # Foo\Bar\BazTest
 *             Qux/
 *                 QuuxTest.php    # Foo\Bar\Qux\QuuxTest
 *
 * ... add the path to the class files for the \Foo\Bar\ namespace prefix
 * as follows:
 *
 *      <?php
 *      // instantiate the loader
 *      $loader = new \Example\Psr4AutoloaderClass;
 *
 *      // register the autoloader
 *      $loader->register();
 *
 *      // register the base directories for the namespace prefix
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\Quux class from /path/to/packages/foo-bar/src/Qux/Quux.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\Quux;
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\QuuxTest class from /path/to/packages/foo-bar/tests/Qux/QuuxTest.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\QuuxTest;
 */
class Psr4AutoloaderClass
{
	/**
	 * An associative array where the key is a namespace prefix and the value
	 * is an array of base directories for classes in that namespace.
	 *
	 * @var array
	 */
	protected static $prefixes = array();

	/**
	 * Register loader with SPL autoloader stack.
	 *
	 * @return void
	 */
	public function register()
	{
		spl_autoload_register( array( $this, 'loadClass' ) );
	}

	/**
	 * Adds a base directory for a namespace prefix.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $base_dir A base directory for class files in the
	 * namespace.
	 * @param bool $prepend If true, prepend the base directory to the stack
	 * instead of appending it; this causes it to be searched first rather
	 * than last.
	 * @return void
	 */
	public function addNamespace( $prefix, $base_dir, $prepend = FALSE )
	{
		// normalize namespace prefix
		$prefix = trim( $prefix, '\\' ) . '\\';

		// normalize the base directory with a trailing separator
		$base_dir = rtrim( $base_dir, '/' ) . DIRECTORY_SEPARATOR;
		$base_dir = rtrim( $base_dir, DIRECTORY_SEPARATOR ) . '/';

		// initialize the namespace prefix array
		if ( isset( self::$prefixes[ $prefix ] ) === FALSE ) {
			self::$prefixes[ $prefix ] = array();
		}

		// retain the base directory for the namespace prefix
		if ( $prepend ) {
			array_unshift( self::$prefixes[ $prefix ], $base_dir );
		} else {
			array_push( self::$prefixes[ $prefix ], $base_dir );
		}
	}

	/**
	 * Loads the class file for a given class name.
	 *
	 * @param string $class The fully-qualified class name.
	 * @return mixed The mapped file name on success, or boolean false on
	 * failure.
	 */
	public function loadClass( $class )
	{
		// the current namespace prefix
		$prefix = $class;

		// work backwards through the namespace names of the fully-qualified
		// class name to find a mapped file name
		while ( FALSE !== $pos = strrpos( $prefix, '\\' ) ) {

			// retain the trailing namespace separator in the prefix
			$prefix = substr( $class, 0, $pos + 1 );

			// the rest is the relative class name
			$relative_class = substr( $class, $pos + 1 );

			// try to load a mapped file for the prefix and relative class
			$mapped_file = $this->loadMappedFile( $prefix, $relative_class );
			if ( $mapped_file ) {
				return $mapped_file;
			}

			// remove the trailing namespace separator for the next iteration
			// of strrpos()
			$prefix = rtrim( $prefix, '\\' );
		}

		// never found a mapped file
		return FALSE;
	}

	/**
	 * Load the mapped file for a namespace prefix and relative class.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $relative_class The relative class name.
	 * @return mixed Boolean false if no mapped file can be loaded, or the
	 * name of the mapped file that was loaded.
	 */
	protected function loadMappedFile( $prefix, $relative_class )
	{
		// are there any base directories for this namespace prefix?
		if ( isset( self::$prefixes[ $prefix ] ) === FALSE ) {
			return FALSE;
		}

		// look through base directories for this namespace prefix
		foreach ( self::$prefixes[ $prefix ] as $base_dir ) {

			// replace the namespace prefix with the base directory,
			// replace namespace separators with directory separators
			// in the relative class name, append with .php
			$file = $base_dir
				. str_replace( '\\', DIRECTORY_SEPARATOR, $relative_class )
				. '.php';
			$file = $base_dir
				. str_replace( '\\', '/', $relative_class )
				. '.php';

			// if the mapped file exists, require it
			if ( $this->requireFile( $file ) ) {
				// yes, we're done
				return $file;
			}
		}

		// never found it
		return FALSE;
	}

	/**
	 * If a file exists, require it from the file system.
	 *
	 * @param string $file The file to require.
	 * @return bool True if the file exists, false if not.
	 */
	protected function requireFile( $file )
	{
		if ( file_exists( $file ) ) {
			require $file;

			return TRUE;
		}

		return FALSE;
	}

}

class Autoloader extends \framework\Psr4AutoloaderClass
{
	private static $instance;

	final function __construct()
	{
	}

	final public static function instance()
	{
		if ( !self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	static function registerAutoloader()
	{
		// instantiate the loader
		// register the autoloader
		self::$instance->register();
		// register the base directories for the namespace prefix
		self::$instance->addNamespace( 'vendor', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
		self::$instance->addNamespace( 'framework', __DIR__ . DIRECTORY_SEPARATOR );
		self::$instance->addNamespace( 'frontend', dirname( dirname( __DIR__ ) ) . '/frontend/' );
		self::$instance->addNamespace( 'model', dirname( dirname( __DIR__ ) ) . '/frontend/model/' );
		self::$instance->addNamespace( 'theme', dirname( dirname( __DIR__ ) ) . '/frontend/theme/' );
		self::$instance->addNamespace( 'controller', dirname( dirname( __DIR__ ) ) . '/frontend/controller/' );
		self::$instance->addNamespace( 'exceptions', __DIR__ . '/exceptions/' );
	}

	/*
	 *
	 */
	public static function resolvePath( $path )
	{
		$path = ( new Autoloader() )->resolvePrefix( $path );

		return $path . '.php';
	}

	/*
	 * resolve autoload registered prefixes
	 */
	private function resolvePrefix( $path )
	{
		foreach ( self::$prefixes as $k1 => $v1 ) {
			$k1  = '\\' . $k1;
			$len = strlen( $k1 );
//			echo '<br>';
//			echo 'substr(' . $path . ', ' . $len . ') === ' . $k1;
//			echo '<br>';
			if ( substr( $path, 0, $len ) === $k1 ) {
				$path = str_replace('\\', '/', str_replace( $k1, $v1[ 0 ], $path ));
			}
		}

		return $path;
	}
}