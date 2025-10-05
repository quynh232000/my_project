<?php

define('PHPWORD_BASE_DIR', realpath(__DIR__));
if (!defined('URL_APP'))    define('URL_APP', @$_SERVER['REQUEST_SCHEME'] . '://' . @$_SERVER['HTTP_HOST']);
if (!defined('URL_PUBLIC')) define('URL_PUBLIC', URL_APP . '/public');
if (!defined('URL_ASSET'))  define('URL_ASSET', URL_PUBLIC . '/assets');
if (!defined('URL_UPLOAD')) define('URL_UPLOAD', URL_APP . '/uploads');
if (!defined('URL_FILES')) define('URL_FILES', URL_APP . '/files');
if (!defined('URL_CKFINDER')) define('URL_CKFINDER', '/uploads');

//define('DS', DIRECTORY_SEPARATOR);
if (!defined('DS'))          define('DS', DIRECTORY_SEPARATOR);
if (!defined('PATH_APP'))    define('PATH_APP', dirname(dirname(__FILE__)));
if (!defined('PATH_PUBLIC')) define('PATH_PUBLIC', PATH_APP . DS . 'public');
if (!defined('PATH_ASSET'))  define('PATH_ASSET', PATH_PUBLIC . DS . 'assets');
if (!defined('PATH_UPLOAD')) define('PATH_UPLOAD', PATH_PUBLIC . DS . 'uploads');
if (!defined('PATH_FONTS'))  define('PATH_FONTS', PATH_ASSET . DS . 'fonts');
if (!defined('PATH_ROUTE'))  define('PATH_ROUTE', PATH_APP . DS . 'routes');
if (!defined('PATH_FILES'))  define('PATH_FILES', PATH_PUBLIC  . DS  . 'files');
if (!defined('PATH_AVT'))    define('PATH_AVT', PATH_UPLOAD . DS . 'avatar');
// ==================== SYSTEM ============================
if (!defined('TABLE_USER'))     define('TABLE_USER', 'users');
if (!defined('PATH_CKFINDER'))  define('PATH_CKFINDER', PATH_PUBLIC . DS . 'uploads');
if (!defined('PART_UPLOAD_CKFINDER')) define('PART_UPLOAD_CKFINDER', '/uploads/files/');
//Config size name when resize image
if (!defined('FILE_SIZE_NAME'))      define('FILE_SIZE_NAME', '300X200');
//config name give component
if (!defined('COMPONENT_FLIGHT'))      define('COMPONENT_FLIGHT', 'flight');
if (!defined('COMPONENT_TOUR'))      define('COMPONENT_TOUR', 'tour');

@require_once(__DIR__ . '/define-hotel.php');
@require_once(__DIR__ . '/define-cms.php');
