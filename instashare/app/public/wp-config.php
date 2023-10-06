<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}


define('AUTH_KEY',         '8VzlwtMt4ZhQTInrq+Ubzjx8fircTrm1HQSR6wpQoiC9+JQ13rbPNef7Am2QwYdHfGnpDY6TJ0Uyn0TCh0RLLQ==');
define('SECURE_AUTH_KEY',  'y5Xel+zqp7VyAClrokCssCYWP/a3w3RJ2/VKWZ1lb+m/3Y19viEwZ8XE3FhuWDClhu/RDKWzb6CFDiQ69xpXuQ==');
define('LOGGED_IN_KEY',    '+OtmPOI8sQ0HC/BIEdp7kP6JlDPuFoZXsaINTOt1xz5WZY2rBANKmZEDHRrG1Z77ForB/vJp/OzBNRqAX+UzLQ==');
define('NONCE_KEY',        '3uhFGR0aLe7PI6L04nJHmM4yy0wro9YC1HM370PCeD2Un9GC41Hg6Q2OAtAIFeXweCTYFFNzVuSIWMu2SpNeyA==');
define('AUTH_SALT',        '9zJ3kb2Gs9HNwGZvA0klDlKA4QKpvvEEH9a5iL4/Q9wUtWBom3hzPqfO95hDauENhnvXxY7y9nFT/+q2VZKYVA==');
define('SECURE_AUTH_SALT', 'DEMRVW21e9wnlNgsn49/CeXUqohCXN3GDiEbIbIv8xObouYHzfRUORW6WjKLJ5E08vjJ5jN7VSoDv17+vLWnGw==');
define('LOGGED_IN_SALT',   '7oSot4Z++ZsGd8aU2rQlD3wEhdXGulTg18N0ZIuzbqyEv9si3f+XTOxtn8XQESp8paqOh/yxU0MT1kaSJDhlnQ==');
define('NONCE_SALT',       'F4ltkjSjyU5yvso1PDJW7oVcA2yvQR5mZ5+nA2JpP5uhCAJP+ofcU5FV1jtlhtFD6jnRVJi8A2nxDk4RJM/R6g==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
