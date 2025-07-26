<?php
namespace Ljn\Practice25;
interface dbContruct 
{
 public function insert ($data);
 public function select ($columns='*');
public function update ($data);
public function delete ();
public function exec();
public function all();

}
class db implements dbContruct
{
    public $table;
    private $sql;
    private $connection;
   public  function __construct($host,$user,$password,$db,$table)
    {
       $this->connection= mysqli_connect("$host","$user","$password","$db");
        $this->table=$table;
    }
        
public function insert ($data){
    $val="";
    $keys="";
foreach($data as $key=> $value)
{
    $keys.="`$key`,";
    if(is_string($value))
    {
        $val.="'$value',";
    }
    else 
    {
       $val.="$value,"; 
    }
}
$val=rtrim($val,',');
$keys=rtrim($keys,',');
$this->sql="INSERT INTO `$this->table` ($keys) VALUES ($val);";
return $this;
}
 public function select ($columns='*')
 {
  $this->sql="SELECT $columns FROM `$this->table` ;";
  return $this;
 }
public function update ($data)
{
     $val="";
foreach($data as $key=>$value)
{
    if(is_string($value))
    {
       $val.="$key='$value'," ;
    }
    else 
    {
       $val.="$key=$value," ;
    }
}
$val=rtrim($val,',');
  $this->sql="UPDATE `$this->table` SET ";
  return $this;
}
public function delete (){
$this->sql="DELETE FROM `$this->table`";
return $this;
}
public function exec()
{
 $query= mysqli_query($this->connection,$this->sql);
 return mysqli_affected_rows($this->connection);
}
public function all()
{
  $query=mysqli_query($this->connection,$this->sql);
  return mysqli_fetch_all($query,MYSQLI_ASSOC);
}
public function get()
{
  $query=mysqli_query($this->connection,$this->sql);
  return mysqli_fetch_assoc($query);
}
public function where ($column,$operator,$value)
{
   $this->sql.=" WHERE `$column` $operator '$value'";
    return $this;
}
public function andwhere ($column,$operator,$value)
{
   $this->sql.=" AND `$column` $operator '$value'";
    return $this;
}
public function orwhere ($column,$operator,$value)
{
   $this->sql.=" OR `$column` $operator '$value'";
    return $this;
}
// select * from users inner join categories on =
public function innerjoin ($table,$pk,$fk)
{
 $this->sql.=" INNER JOIN  `$table` ON $pk = $fk";
  return $this;
}
public function leftjoin ($table,$pk,$fk)
{
 $this->sql.=" LEFT JOIN  `$table` ON $pk = $fk";
  return $this;
}
public function rightrjoin ($table,$pk,$fk)
{
 $this->sql.=" RIGHT JOIN  `$table` ON $pk = $fk";
  return $this;
}

}

?>