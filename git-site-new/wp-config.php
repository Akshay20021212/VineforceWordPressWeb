<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'git-site-new' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'rL4O5M7UvDceVIly3Qx0s68kR2GPgaMPwKHGHB0U4kDNEHJA32Owm8ELUO10Pkpj' );
define( 'SECURE_AUTH_KEY',  'n8xlcMrpkH1T06XsDKORPccvJbcNrYh6M3IJ6cOBBiK3KIn5fJ9vSfP50nVMw7O0' );
define( 'LOGGED_IN_KEY',    '8uYtVTHEOOrZL9aCwcKmk5LxCx3iVyLZzpwG7ajz88JRlaKPPmzDTdSfUk8F7xSe' );
define( 'NONCE_KEY',        'XmqOQWvxsT5RGR6EKSmYgy70ZidwKKg5AeVciWoTE1hobTLXewXcFgZupAbVK98c' );
define( 'AUTH_SALT',        'VyfqmAFfkAg9HrWaNab4NxMb3Cw4oLr4g10L6tfHckUdHGgyo6VF5KR0TAIm9DUG' );
define( 'SECURE_AUTH_SALT', '3SLoSs42sAqny9YO6vMZ3TpuVBIujMWF1coUQH48Kr0ThiaLeU9v45azAJlJXKCi' );
define( 'LOGGED_IN_SALT',   'o2GQbRlgXalMNlCPwGfvkn0MXyoZoe8lEN4Fmvdnk43zNgbNDFTFoUiu2UjDAU3k' );
define( 'NONCE_SALT',       '3s22tK4CZjb0KKC6tWeJ5AMEGRRg1HXhpgLAQHjQVe8XtTY3pV9zSokWTpur5jjC' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
