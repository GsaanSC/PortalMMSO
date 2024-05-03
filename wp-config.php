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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'PortF3' );

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
define( 'AUTH_KEY',         '_CgVk>Gr@KH~Ai}rI 6/1,C3cuRxS)?I5M{(gt<0OV^Cy{n@G&U?Z%^O6VG,`lxt' );
define( 'SECURE_AUTH_KEY',  '4y6|)GM#*WdObmEX++zE5Xy!F5 %UW6f=P+iv<q;ns|ZOeY d0:E_6WcD3M<OYue' );
define( 'LOGGED_IN_KEY',    '~#OL}[3[UxyAu-2O~2OF2AlA%cw-m/~49Or{2z`9,2-;;5Wfb;t=;y1-:KCn%jro' );
define( 'NONCE_KEY',        'mT5sk-6GQR~~|&4  E6clXQjW(G>Xny.&vi6 f592jS(ThO8Jk?79sS[&>vjsJ3_' );
define( 'AUTH_SALT',        'Lv3X#boTND;}dqW.0&|RjPv~@:%+HgN#sAb$j:qO|:HeBEboKsis%7wszO)~8?o<' );
define( 'SECURE_AUTH_SALT', 'wyl[fhK9Su?5q 0AW<_0LgXwPQZaTnXH8|{:~Y1hF.y+HC33>^&}f_xN1oKs=%dl' );
define( 'LOGGED_IN_SALT',   'CDAn.ni3jB0S$cM5%yU4pd:CiAM$;$QD{D(O`%aoAO_k:-f}&ms!P=p0~;``+E*5' );
define( 'NONCE_SALT',       'I,|lC6?$kr-5vT&6/T<01; e#Y-B]TAA!fZ)kad^ !na~JOoy9 kxk$=XU^:-;!o' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
