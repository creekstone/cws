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
define( 'DB_NAME', 'dbmnkcmxvtgoib' );

/** Database username */
define( 'DB_USER', 'u0haiwqllfqmf' );

/** Database password */
define( 'DB_PASSWORD', 't3y8gifaho6w' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          'hIZZ%w~$m?ojvXdF%vap1Xc*ec~QI:+pTFRG.NI}9n-/71TSygc@8<pBZ4Y< [WB' );
define( 'SECURE_AUTH_KEY',   'L&>RW<}wF`o8j1dUoOipr|Vu&p*BNuCdUL&3#}>(i8h-3D6_;W&j5dV ~75![x,K' );
define( 'LOGGED_IN_KEY',     't]@|#GIE:D+?-qCo`eOX,sQwA#M*6Om9eB:lopangXVRayqTYUsUrEC5EWrsSjxM' );
define( 'NONCE_KEY',         'GReeZ.}Jg!U>!IF2bJF2]VZc1[s*%CE:O$Aw^1]y_xDh9F8M[iD=6xvTT*;[i%{#' );
define( 'AUTH_SALT',         '~qomHS>u^m7FLY$nU*e%.if,EGP&7?GXhIhwQ{#8myaHHM1>)HwFQil[RcSs>l&z' );
define( 'SECURE_AUTH_SALT',  'M)X+C2^h(PTlXry3iG4uc4vn([[3 $::{{Hs/`dL}7g5,_nfHiX)YJ|7V=zc2X,Q' );
define( 'LOGGED_IN_SALT',    'S_E[lbNdm0giHKR |=&c&(`ffa1*[<=B=+fl|6V+(v2dT!p3I^)I&!0al3hbTFF0' );
define( 'NONCE_SALT',        '4!6mm{LRj%(T0/kN)? Br;0SZFCdU}wHB3mDQ=!blYqE@843%DI&$5 HZhToI{>;' );
define( 'WP_CACHE_KEY_SALT', 'jB6hX:}rT:%mF4}q.lT4ok2.;08PEA1/%~mPYyo#0jqI2SX]4c*vj)Li(3b~[/#n' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'tgh_';


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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
@include_once('/var/lib/sec/wp-settings-pre.php'); // Added by SiteGround WordPress management system
require_once ABSPATH . 'wp-settings.php';
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
