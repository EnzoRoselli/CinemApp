<?php 
    namespace Config\Constants;

    if (!defined('SIGNUP_SUCCESS')) define('SIGNUP_SUCCESS', '"Usuario creado exitosamente, por favor inicie sesion con sus credenciales"');
    if (!defined('EMAIL_EXISTS')) define('EMAIL_EXISTS', 'Ya existe ese email');
    if (!defined('ID_NUMBER_EXISTS')) define('ID_NUMBER_EXISTS', 'Tu DNI fue registrado con anterioridad');
    if (!defined('LOGIN_FAILURE')) define('LOGIN_FAILURE', 'Usuario o contraseña incorrectos');
    if (!defined('SIGNUP_FAILURE')) define('SIGNUP_FAILURE', '"Los datos que intenta ingresar corresponden a un usuario existente en nuestra base de datos"');
    if (!defined('INCOMPLETE_INPUTS')) define('INCOMPLETE_INPUTS', '"Quedaron campos incompletos"');
    if (!defined('LOGOUT_SUCCESS')) define('LOGOUT_SUCCESS', '"La sesion se ha cerrado con éxito"');


?>
