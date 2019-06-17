<?php
// Factory class
interface IUser
{
    function getName();
}

class User implements IUser
{
    public function __construct($id) { }

    public function getName()
    {
        return "Jack";
    }

    public static function create()
    {
        return new User (null);
    }

    public static function load($id)
    {
        return new User ($id);
    }
}

$s = User::load(5);
var_dump($s->getName());

// Factory class - end

// Singleton
class DBConnection
{
    public static function get()
    {
        static $db = null;
        if ($db == null) {
            $db = new DBConnection();
        }
            return $db;
    }
    private $_handle = null;

    private function __construct()
    {
        $dsn = 'blabla';
        $this->_handle = 'bla';
    }

    public function handle()
    {
        return $this->_handle;
    }
}

print_r("Handle = " . DBConnection::get()->handle() . "\n");
print_r("Handle = " . DBConnection::get()->handle() . "\n");

// Singleton end
