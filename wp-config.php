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
define('DB_NAME', 'wp_stylistnetwork');

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
define('AUTH_KEY',         'uKm0RvBX&VBJ;:.%L}{E1z;o6L+!:cPvk=2)Ln1fDx7|>#^0NT^l^ojBHdEaM&|M');
define('SECURE_AUTH_KEY',  '[>?pN/O_[GFf)g;-_48B&`)xXm5Xf+8q5]KHS1*^kb(G PO{h.9_]7? Z@Xy:G!B');
define('LOGGED_IN_KEY',    '|75CBd=4xX3pu&iZypl, S9F8|Nwj|FTlTK%#tXkj}c_ZNsP>myRdidLUGq/H~5*');
define('NONCE_KEY',        'l%-p?:3Q|^^#LD4=pV+}RcY~<8:a!DF,q:Su,wxYc7wq`xZpJG(+zEsa&uuY#x(]');
define('AUTH_SALT',        ':m8(k0qK22:/Q7WhLKm;?/AN04!:!->8.VAoQBY?@DEDm(vIw?=`*!2HK8[5YK2e');
define('SECURE_AUTH_SALT', 'SD4cB_2LCan{O~Ik*[fw&j|u;<xI#^Uv,A72F/W$b r?tf$nazmWM>HSi:?>E$TM');
define('LOGGED_IN_SALT',   'fefsLx/cB?ZN_fgHrv)|6Wi$ *PDnF,HN10&4>DN4>hK/ fnC:(!S1UE~9r4w|-r');
define('NONCE_SALT',       '@-3K[dWt+o`4e7Y sf]|aLYJc|R9u{qeGS,gL+[))oe$:J~a+@_})AxM6d61{Rjp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
