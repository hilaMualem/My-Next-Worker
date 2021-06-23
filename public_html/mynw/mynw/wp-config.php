<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'mynextworker' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'myneynextworkeradmin' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'shUAMw9s6WoRGCAu' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'bSc7;1ojs8rDN{7;2OYoEHcwlWH+#HB5]-kCL85o[Xcw(ucGRb!F62KxE7KI`|6K' );
define( 'SECURE_AUTH_KEY',  '{V<YRnc>31@J*M`TO{6/quH*WRWCW482%,23yZ2A5IACY88TT^<c3%N}yoR|1X(8' );
define( 'LOGGED_IN_KEY',    '(GM0&.=;pOK=0*~W|pUEyd nc]t0Y3]Hi/rssH6ZQm8kNb8=md]J#G=43+/%nE)R' );
define( 'NONCE_KEY',        '6l9?<}kv5jC/khyXo9UrI?#--lbUrBT1@}X1(;7j6r#8b.$6XI>6vLm*`A7O-k@+' );
define( 'AUTH_SALT',        'oQ^t{grtH; LzfRgy4EC^X;+_9]n&E9mGgN5<JIiI1]urw%hH&;(u:[xAeZ-@<+K' );
define( 'SECURE_AUTH_SALT', '9zb5k?4F0YU>$|s|S}H!o(Ep9k>A+J>fl}2Z*90%]fb0`<Cnr9^;x%33#f}/jL+1' );
define( 'LOGGED_IN_SALT',   ':WO`D1mK#P{6gegIps%M<RcgMBiY+c&{x]RkY!+p`a+XBH1/dv{_-qY7,Sye>+:B' );
define( 'NONCE_SALT',       '$J.@g[{qRhr2#~:Y9> BwY$Hg&?ogOVBibZz#A!7Y!MNs>KnV7xu[^!2p1>m>y0 ' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
