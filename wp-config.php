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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'demo_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'fDa-_iwpU;>lA[l?IRvCpso>YtrEsk_57Uz`0e/_97ox&^9rqAn8_VO6UtQpA%|=' );
define( 'SECURE_AUTH_KEY',  'D~fH*%z[s|c|,`F;`e|ucQ4rT)PFL>-]L%~JILbkgZs;>vC3-0;kt/W&y0t#R<Ov' );
define( 'LOGGED_IN_KEY',    '53A|,YsRLJjN 9qt]Zu})FllGU5$1MAUbFYLGAC!$bPGOW shEZI,NCz7,ViF4*_' );
define( 'NONCE_KEY',        'TQ#wN`d|b[S<,$EmOQNZvYVGr0M*]^[#itOtdQ L%*pn|7W8?<7U?h>H%0uDFDU?' );
define( 'AUTH_SALT',        'D(fCLuKvTycRv`se4R-Yx?hf82r,J[h+_;H5y7{?7UEKgpGz/tnSviU*iJH1)=;,' );
define( 'SECURE_AUTH_SALT', 'UDczle<8LO>lBY*7aQ 3%O-67!E:Nbm4h=D[o1^Vud10`JL~, 7S8v?8:)KwZS}y' );
define( 'LOGGED_IN_SALT',   'q$?Dp;tLS#G,`k9 (*aF.;S?FQaV}{P`#g==NjeS]UO*ii`wKXM1Pol-HcqfXZn~' );
define( 'NONCE_SALT',       'k#@PYboDiL2c ;M,s!SUnDam+dqu#Qfc5pDR/Y/8GX`Zjr=(_4}DQ0vxrDuc$gle' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
