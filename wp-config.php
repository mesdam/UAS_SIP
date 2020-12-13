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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bugbug' );

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
define( 'AUTH_KEY',         '`9q@a|u:ln$rib>Y,a1x)y>e5)rzx2p5draJ(hMk}APnt/?)Z4g_RE ~iQfh*L7S' );
define( 'SECURE_AUTH_KEY',  'KXgOT!YSQAx~2%>oY6YpAXf.W^?bn ZPG{_Dg,e.@oaAN~WA [uW7-:*Jft0#c&L' );
define( 'LOGGED_IN_KEY',    ',Q=vc>(wm.<2T9Okqn:I]-~is v-|h@%0a-K}IlpO5hzB,>K-VXjDKBN,:6BZ:#2' );
define( 'NONCE_KEY',        'QrppQL&/G2{G<MJEd(H?>c^{5(p`8$L4Ma9~/u&KmCm.STpX}4SEf.dlj2xh:E<n' );
define( 'AUTH_SALT',        '-5i`V!5~iIZ?P..;+])^fbw^JDE]]:uhE+#mPW,EobfqH<X_p}$u+C>eCNp#P=.F' );
define( 'SECURE_AUTH_SALT', 'w:d9yZbnl&a}*m: vYi3fSR^I(+2ND me#gYU+Tp5g;cTXZ <9``obP)06wyM7N0' );
define( 'LOGGED_IN_SALT',   '@ 7o<9{}?dt~q,zx&M~st?[)!2F,}7&Y94>Ilx;i=_wC-y#W>q3IpH,]*i`4;j$<' );
define( 'NONCE_SALT',       'Zq-h[(;re>/doCBY>cP,dFA)*9]4WG:K,I#sbNAvmG6EVv%Hh@E$}cs8VU{t;W9|' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
