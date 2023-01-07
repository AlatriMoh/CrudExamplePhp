class DB{
    private static $server = "mysql:host=localhost;dbname=tazaordersdb";
    private static $user = "root";
    private static $password = "";
    private static $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    public static function Connection(){
        try{
            return new PDO(self::$server, self::$user, self::$password, self::$options);
        }catch(PDOException $ex){
            die($ex->getMessage());
        }
    }
    public static function Connection_($options){
        try{
            return new PDO(self::$server, self::$user, self::$password, $options);
        }catch(PDOException $ex){
            die($ex->getMessage());
        }
    }
}
