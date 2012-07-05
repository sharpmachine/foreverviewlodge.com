<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'foreverviewlodge.com');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':8|H[1Ew7$;mp)>/`FxK]#1mv?7ny2A0SR*iVDQq>o#8O|V#-?2^-/hDG+^r?JH}');
define('SECURE_AUTH_KEY',  'sZ[KQWeYeVJ8b;5!(0,?wps~{.X.;`8-g^]@uRR_@DX]BAz]c%Bj=)jPc|sJ--qx');
define('LOGGED_IN_KEY',    'R!P.-G935o,cw]=s/j^H|xE$+g+M.UJu|vfpA.H3rG<0e25[2dHhX7I!iu4D0E-E');
define('NONCE_KEY',        'R)huCsK+<[eFu5aexYRPD.idV6t=G|?A<2VCj^T#]#+T-0D%l(5}!H+#,+bsv3EX');
define('AUTH_SALT',        'n-+Bu&-2SN@oFldlFIU*{6`x@^YW<t3_GL(1{;ujAKCR#t$^N)BF8aS/N<O_[g_s');
define('SECURE_AUTH_SALT', '@VU|_|<#,9XCyU]sdi&)SCi#n`S+d^%+Hi8+%Du.;GnYDvq<`F|4I<@YX1J}a>YS');
define('LOGGED_IN_SALT',   'F0z;q_)lp;M}6}Y{Y8=+ETVARY`af,,U<Vwx+yXkqyF;p%#+_zRQj3xFuqwJ`u 0');
define('NONCE_SALT',       '}YU8UupY!nvm_xj]@NG6 LU}!@1{^5q8YjJLM&h+Q5J:WvYl;;%Co?AtC2W3|*f,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mc_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
