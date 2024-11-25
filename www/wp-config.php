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
$onGae = (getenv('GAE_ENV') === 'standard');

if ($onGae) {
	define('DB_NAME', getenv('DB_NAME'));
	/** MySQL database username */
	define('DB_USER', getenv('DB_USER'));
	/** MySQL database password */
	define('DB_PASSWORD', getenv('DB_PASSWORD'));
	/** MySQL hostname (使用 Cloud SQL 連接名稱) */
	define('DB_HOST', getenv('DB_HOST'));

	// 更改網址
	define('WP_HOME','https://wpjs-442309.de.r.appspot.com');
	define('WP_SITEURL','https://wpjs-442309.de.r.appspot.com');
	$_SERVER['HTTPS'] = 'on';
} else {
    /** Local environment */
    define('DB_HOST', 'serverless-us-central1.sysp0000.db2.skysql.com:4009');
    /** The name of the database for WordPress */
    define('DB_NAME', 'wordpress');
    /** MySQL database username */
    define('DB_USER', 'dbpgf09274233');
    /** MySQL database password */
    define('DB_PASSWORD', 'Aa3345678!');
}


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
define('AUTH_KEY', '8%s*5379))4t6:CvtONy@712ZEkDL+45MWpl0]|23oW3TlC(tku)1322]+73I]67');
define('SECURE_AUTH_KEY', 'g0!FY#sX@9(-2)AKS0h8y3YC5a-y2e9;7Ol[3Q6e944D@*Jh10WR99!hzl6xSMR[');
define('LOGGED_IN_KEY', 'cy:8782[G*1!E)83OIp+%afD+&)G-(|Gh2mQKENXB!FV_TeSq&ofQ)cae4fgX37B');
define('NONCE_KEY', '35F)FH(&7VoaK6i20!0G8*30ohP3L]K7F/Zh*MkQLG4_%56W//5U93&6w;|Y(W4f');
define('AUTH_SALT', '|R+2i9:2&[D6;Dk_3W99|kY4E)T|g70uk0(d4q5ya*BEu13M!A9SH_Y~0-_@47/1');
define('SECURE_AUTH_SALT', 'RWK36Rt1|H0q-_Gpf89U|w@;25WYE#(3UW[fOZW~[T#2%2_irSp|&Fp-oL9s~c16');
define('LOGGED_IN_SALT', ')h+1Z+2H9]7-7eQ25*2)Vi4faj|[zM|8))R:J#Ye|rIXVLL&3)3d241m:w0d1|fb');
define('NONCE_SALT', '_QJ3lDlwL#/I~;FE_#)MF106IvU6F5&57gh%C@D9[|48F[)Uf#bIbi14C4q8-!PN');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'qrYy9H_';


/* Add any custom values between this line and the "stop editing" line. */

define('WP_ALLOW_MULTISITE', true);
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
