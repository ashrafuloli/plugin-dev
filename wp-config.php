<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'plugin-dev' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'N+O2h%llM8/2r1ZktxN+NUuOR:?f8)sOapZeYd<1kV#y(vsoM&GXmmD}I*`ym2}8' );
define( 'SECURE_AUTH_KEY',  'v0jve!ug0ToM+BX)(~=RSWN^1X#$z-?e-0BmFa;M;/=VC%?u40gs-j:QA}el{DgW' );
define( 'LOGGED_IN_KEY',    'G@I,s5|]xMNr*=W<tIDU{v8>QCJ#sX@@p#*!]9u2(Ds@,>1J^#i6yaB/C=]_iy 8' );
define( 'NONCE_KEY',        'e|vhkvcfTf) Mcc2j@rp_n%jny&veHzN@.KLTYu;8)|}p/`X,.Bj(KbfLwd U3]F' );
define( 'AUTH_SALT',        '>V s/XuB@N3l#KH gC4%RXSB>;qmbk0x*yTSZpOT4l)nGuR1O)WQ7[<rM/Wm!B/z' );
define( 'SECURE_AUTH_SALT', '!2OA!)lwQ=Jdp5xuvSgnTv?o%Z*=J+;l*F:V%D5%dZFIb**pY24|uI!U24V8/L-]' );
define( 'LOGGED_IN_SALT',   '0002)%/>S.K$zcoAl>h;)iBJti6$tIo)k(T;&P:XLfFM=zrv>m_URgv+}](BbRMj' );
define( 'NONCE_SALT',       'O 7#`8k>g,c|P{%Y <kZX7t$KWwvJFUi<HH`#ILWzIh1H&jg9]cX;40X|Z20+<8P' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
define('WP_SITEURL', 'http://localhost/wp-project/plugin-dev/');
define('WP_HOME', 'http://localhost/wp-project/plugin-dev/');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
