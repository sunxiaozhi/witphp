<?php
/**
 * WitPHP
 * Session类
 * Author: sunxiaozhi
 * Date: 2018/6/21 16:08
 */

namespace wit\base;

class Session
{
    //存放session前缀
    protected static $prefix;

    //存放session过期时间
    protected static $time;

    //当前session状态
    protected static $is_start = null;

    /**
     * 初始化session
     * @param array $config
     * @throws Exception
     */
    public static function init($config = [])
    {
        $is_start = false;
        if (empty($config)) {
            $config = Config::get('session');
        }
        $path = empty($config['PATH']) ? ini_get('session.save_path') : $config['PATH'];
        ini_set('session.save_path', $path);
        ini_set('session.use_trans_sid', 1);
        self::$prefix = empty($config['prefix']) ? 'Z-PHP' : $config['prefix'];
        //SESSION开启检测
        if (!empty($config['AUTO_START']) && PHP_SESSION_ACTIVE != session_status()) {
            ini_set('session.auto_start', 0);
            $is_start = true;
        }
        //解决FLASH上传SESSION丢失
        if (!empty($config['VAR_SESSION_ID']) && isset($_REQUEST[$config['VAR_SESSION_ID']])) {
            session_id($_REQUEST[$config['VAR_SESSION_ID']]);
        }
        ini_set('session.cookie_lifetime', 999999999);
        self::$time = empty($config['expire']) ? '0' : $config['expire'];
        ini_set('session.use_cookies', 1);
        //SESSION名称设置
        session_name(empty($config['NAME']) ? 'Z-PHP' : $config['NAME']);
        $driver = empty($config['DRIVER']) ? 'File' : $config['DRIVER'];
        if ($driver != 'File') {
            $class = '\system\session\driver\\' . $driver;
            session_set_save_handler(new $class(['prefix' => self::$prefix]));
        }
        //开启SESSION
        if ($is_start) {
            session_start();
            self::$is_start = $is_start;
        } else {
            self::$is_start = $is_start;
        }
    }

    /**
     * 开启session
     * @param bool $reset 是否强制开启session
     */
    public static function Start($reset = false)
    {
        $reset === true ? session_start() : !isset($_SESSION) && session_start();
    }

    /**
     * 设置session
     *
     * @param $name
     * @param $value
     * @param string $prefix session作用域
     * @param string $expire 过期时间
     * @return bool
     * @throws Exception
     */
    public static function set($name, $value, $prefix = '', $expire = '')
    {
        empty(self::$is_start) && self::Boot();
        $prefix = $prefix == '' ? self::$prefix : $prefix;
        $expire === '' ? Config::set('session', ['expire' => self::$time]) : Config::set('session', ['expire' => $expire]);
        if (ini_get('session.save_handler') == 'files') {
            $expire = $expire === '' ? self::$time : $expire;
            $expire = $expire == '0' ? 99999999 : $expire;
            $value = is_array($value) ? json_encode($value) : $value;
            $_SESSION[$prefix][$name] = $value . md5(sha1('Z-PHP')) . (time() + $expire);
        } else {
            $_SESSION[$prefix][$name] = $value;
        }
        return true;
    }

    /**
     * 判断session是否存在
     *
     * @param $name
     * @param string $prefix session作用域
     * @return bool
     * @throws Exception
     */
    public static function has($name, $prefix = '')
    {
        empty(self::$is_start) && self::Boot();
        $prefix = $prefix === '' ? self::$prefix : $prefix;
        if (self::Get($name, $prefix)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取session
     *
     * @param $name
     * @param string $prefix session作用域
     * @return bool|mixed
     * @throws Exception
     */
    public static function get($name, $prefix = '')
    {
        empty(self::$is_start) && self::Boot();
        $prefix = $prefix === '' ? self::$prefix : $prefix;
        if (empty($_SESSION[$prefix])) return false;
        if (ini_get('session.save_handler') == 'files') {
            if ($name == '*') {
                foreach ($_SESSION[$prefix] as $k => $v) {
                    list($value, $timeout) = explode(md5(sha1('Z-PHP')), $v);
                    if ($timeout > time()) {
                        $data[$k] = !is_array(json_decode($value, true)) ? $value : json_decode($value, true);
                    } else {
                        unset($_SESSION[$prefix][$k]);
                    }
                }
            } else {
                if (empty($_SESSION[$prefix][$name])) return false;
                list($value, $timeout) = explode(md5(sha1('Z-PHP')), $_SESSION[$prefix][$name]);
                if ($timeout > time()) {
                    $data = !is_array(json_decode($value, true)) ? $value : json_decode($value, true);
                } else {
                    unset($_SESSION[$prefix][$name]);
                }
            }
            return isset($data) ? $data : false;
        } else {
            return $name == '*' ? ($_SESSION[$prefix]) : (isset($_SESSION[$prefix][$name]) ? $_SESSION[$prefix][$name] : false);
        }
    }

    /**
     * 删除session
     *
     * @param $name
     * @param string $prefix session作用域
     * @return bool
     * @throws Exception
     */
    public static function del($name, $prefix = '')
    {
        empty(self::$is_start) && self::Boot();
        $prefix = $prefix === '' ? self::$prefix : $prefix;
        if (!empty($_SESSION[$prefix][$name])) {
            unset($_SESSION[$prefix][$name]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 清除所有session数据
     *
     * @param string $prefix session作用域
     * @return bool
     */
    public static function clean($prefix = '')
    {
        $prefix = $prefix === '' ? self::$prefix : $prefix;
        if (isset($_SESSION[$prefix])) {
            unset($_SESSION[$prefix]);
        }
        $_SESSION[$prefix] = [];
        return true;
    }

    /**
     * 重启session会话
     *
     * @throws Exception
     */
    public static function boot()
    {
        if (is_null(self::$is_start)) {
            self::init();
        } elseif (false === self::$is_start) {
            session_start();
            self::$is_start = true;
        }
    }

    /**
     * 销毁session
     *
     * @return void
     */
    public static function destroy()
    {
        if (!empty($_SESSION)) {
            $_SESSION = [];
        }
        session_unset();
        session_destroy();
        self::$is_start = null;
    }
}