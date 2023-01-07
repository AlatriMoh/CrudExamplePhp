class User{
    public $Id = -1;
    public $Name = "";
    public $Email = "";
    public $Password = "";
    public $IsActive = 1;
    public $IsDeleted = 0;
    public $CreatedBy = -1;
    public $CreatedAt;
    public $UpdatedBy = -1;
    public $UpdatedAt;

    function __construct(){ }

    public function Add()
    {
        try {
            $this->CreatedAt=$this->UpdatedAt== date('Y-m-d H:i:s');
            $stmt = DB::Connection()->prepare("INSERT INTO tblusers (Id, Name, Email, Password, IsActive, IsDeleted, CreatedBy, CreatedAt, UpdatedBy, UpdatedAt) VALUES (NULL, :Name, :Email, :Password, :IsActive, :IsDeleted, :CreatedBy, :CreatedAt, :UpdatedBy, :UpdatedAt)");
            $this->CreatedAt = date('Y-m-d H:i:s');
            $this->UpdatedAt = date('Y-m-d H:i:s');
            $stmt->execute(array(
                ':Name'=>$this->Name,
                ':Email'=>$this->Email,
                ':Password'=>md5($this->Password),
                ':IsActive'=>$this->IsActive,
                ':IsDeleted'=>$this->IsDeleted,
                ':CreatedBy'=>$this->CreatedBy,
                ':CreatedAt'=>$this->CreatedAt,
                ':UpdatedBy'=>$this->UpdatedBy,
                ':UpdatedAt'=>$this->UpdatedAt,
            ));
            return true;
    
        }catch(PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function Modify()
    {
        try {
            $this->UpdatedAt== date('Y-m-d H:i:s');
            $stmt = DB::Connection()->prepare("UPDATE tblusers SET Name = :Name, Email=:Email, Password=:Password, UpdatedBy=:UpdatedBy, UpdatedAt=:UpdatedAt WHERE Id = :Id");
            $stmt->execute(array(
                ':Id'=>$this->Id,
                ':Name'=>$this->Name,
                ':Email'=>$this->Email,
                ':Password'=>md5($this->Password),
                ':UpdatedBy'=>$this->UpdatedBy,
                ':UpdatedAt'=>$this->UpdatedAt,
            ));
            return true;    
        }catch(PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function ModifyPassword()
    {
        try {
            $this->UpdatedAt== date('Y-m-d H:i:s');
            $stmt = DB::Connection()->prepare("UPDATE tblusers SET Password=:Password, UpdatedBy=:UpdatedBy, UpdatedAt=:UpdatedAt WHERE Id = :Id");
            $stmt->execute(array(
                ':Id'=>$this->Id,
                ':Password'=>md5($this->Password),
                ':UpdatedBy'=>$this->UpdatedBy,
                ':UpdatedAt'=>$this->UpdatedAt,
            ));
            return true;    
        }catch(PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function Remove()
    {
        try {
            $this->UpdatedAt=date('Y-m-d H:i:s');
            $stmt = DB::Connection()->prepare("UPDATE tblusers SET IsDeleted=1, UpdatedBy=:UpdatedBy, UpdatedAt=:UpdatedAt WHERE Id = :Id");
            $stmt->execute(array(
                ':Id'=>$this->Id,
                ':UpdatedBy'=>$this->UpdatedBy,
                ':UpdatedAt'=>$this->UpdatedAt,
            ));
            return true;    
        }catch(PDOException $ex) {
            die($ex->getMessage());
        }
    } 

    public function Destroy()
    {
        try {
            $stmt = DB::Connection()->prepare("DELETE FROM tblusers WHERE Id = :Id");
            $stmt->execute(array(
                ':Id'=>$this->Id
            ));
            return true;    
        }catch(PDOException $ex)
        {
            die($ex->getMessage());
        }
    }    
    
    public function CheckUserAndPassword()
    {
        try {
            $stmt = DB::Connection()->prepare("SELECT COUNT(*) FROM tblusers WHERE Email=:Email AND Password=:Password");
            $stmt->execute(array(
                ':Email'=>$this->Email,
                ':Password'=>md5($this->Password)
            ));
            if ($stmt->fetchColumn() == 1){
                $stmt = DB::Connection()->prepare("SELECT * FROM tblusers WHERE Email=:Email AND Password=:Password");
                $stmt->execute(array(
                    ':Email'=>$this->Email,
                    ':Password'=>md5($this->Password)
                ));
                $user = $stmt->fetch();
                $this->Id = $user['Id'];
                $this->Name = $user['Name'];
                $this->Email = $user['Email'];
                $this->Password = $user['Password'];
                $this->IsActive = $user['IsActive'];
                $this->IsDeleted = $user['IsDeleted'];
                $this->CreatedBy = $user['CreatedBy'];
                $this->CreatedAt = $user['CreatedAt'];
                $this->UpdatedBy = $user['UpdatedBy'];
                $this->UpdatedAt = $user['UpdatedAt'];
                return true;
            } 
            else return false;    
        }catch(PDOException $ex){
            die($ex->getMessage());
        }
    }

    public function CheckBeforeUpdatePassword()
    {
        try {
            $stmt = DB::Connection()->prepare("SELECT COUNT(*) FROM tblusers WHERE Email=:Email AND Password=:Password");
            $stmt->execute(array(
                ':Email'=>$this->Email,
                ':Password'=>md5($this->Password)
            ));
            if ($stmt->fetchColumn() == 1){                
                return true;
            } 
            else return false;    
        }catch(PDOException $ex){
            die($ex->getMessage());
        }
    }    
}
