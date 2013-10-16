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
define('DB_NAME', 'abeautif_data');

/** MySQL database username */
define('DB_USER', 'abeautif_admin');

/** MySQL database password */
define('DB_PASSWORD', 'enteraja');

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
define('AUTH_KEY',         'UkK7PO+T8Zan)DU6%p)$,PWrRn2AP;8~g/>mZ>!%KqgILM)mWe{T#^3Pf;4w9)8E');
define('SECURE_AUTH_KEY',  'NIXv4<Z)IRWkY6c#ISb3}=;,TJOYo]s#q%}>_Bz64ZKL[h+kJ!B1Y.M@aW`kdlFA');
define('LOGGED_IN_KEY',    'TB<jQ*AwpdN;~cNjxS+fKeCv&lnrCR5}9vu8X(ai)z:VL|!%C#L&uUS,c^R#jTb:');
define('NONCE_KEY',        '&uzVj3S-_=|1eA9N+~xP[$.t2>3?794VVav;rdpd{RE^ZT:y^pd2;8:`1+HQ>EYh');
define('AUTH_SALT',        '*e$^qlM8eMade*GAZgc!Hn+WwI,E%WSIPIB_6tC!j,aD1QR4g4CzkL)|2wy(DgYy');
define('SECURE_AUTH_SALT', '|wHrZubr-Wmjv}ws!DMJ8OZW^X?V$o-]/dgeHO)=H}r425K@$c^%QKgAGJ6/V&Fr');
define('LOGGED_IN_SALT',   '5*%vb-}3$&6CKf4)t|FoO7JWV2tFMOc@|ym}(c>!C|NY4]s;Vn%x#];K-QxFM&Cu');
define('NONCE_SALT',       'i)VZqP2YW]qqJvom-`)@$2J(<bEtP_S#!vs|EPwiPkzVN.g]Sj~wP^|D=I9kbSv~');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ps_';

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
