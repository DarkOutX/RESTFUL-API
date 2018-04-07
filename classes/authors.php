<?php

class Author {
	
	public $id;
    public $name;
	
	private $tableName = 'authors';
	private $mysqlconnect;
	
	public function __construct()
    {   
        $this->mysqlconnect=new mysqli('localhost', 'root', 'password','book_db');
        $this->mysqlconnect->set_charset("utf8");
        if ($this->mysqlconnect->connect_errno)
            die("Connection to database failed");
    }
	
	private function formOutput($data) //формирование вывода
	{
		//return "<tr><td>".$data['ID']."</td><td>".$data['NAME']."</td></tr>";
		return "ID(".$data['ID'].") ".$data['NAME']."</br>";
	}
	
	public function getByID($id) //вывод автора по ID
    {
		$this->id=$id;
        $query=mysqli_fetch_array($this->mysqlconnect->query("SELECT * FROM $this->tableName WHERE ID=$this->id"));
		
		if (isset($query['NAME'])) {
			return $this->formOutput($query);
		}
		else
		{
			return "ОШИБКА 404. Автор с ID=".$this->id." не найден";
		}
    }		
	
	public function getAll() //вывод всех авторов
    {
        $query=$this->mysqlconnect->query("SELECT * FROM $this->tableName");
		while($data = mysqli_fetch_array($query)){ 
			$massOutput=$massOutput.$this->formOutput($data);
		}
		
		if (!is_null($massOutput)) {
			return $massOutput;
		}
		else
		{
			return "Авторы в базе не обнаружены.";
		}
    }	
	
	public function post($name) //добавление автора
    {
        $this->name = $name;
		$query=mysqli_num_rows($this->mysqlconnect->query("SELECT NAME FROM $this->tableName WHERE NAME='$this->name'"));
		
		if ($query) {
			//echo "Этот автор уже есть в базе.";
			return false;
		}
		else {
			$query=$this->mysqlconnect->query("INSERT INTO $this->tableName (ID,NAME) VALUES (NULL,'$this->name')");
			//echo "Автор успешно добавлен.";
			return true;
		}
	}	
	public function delete($id) //удаление автора
    {
		$this->id = $id;
		$query=mysqli_num_rows($this->mysqlconnect->query("SELECT ID FROM $this->tableName WHERE ID='$this->id'"));
		
		if ($query) {
			$query=$this->mysqlconnect->query("DELETE FROM $this->tableName WHERE id=$this->id");
			//echo "Автор успешно удален.";
			return true;
		}
		else {
			//echo "Автор не найден в базе.";
			return false;
		}
	}	
	
	public function put($id, $name) //редактирование автора
    {
		$this->id = $id;
		$this->name = $name;
		$query=mysqli_num_rows($this->mysqlconnect->query("SELECT ID FROM $this->tableName WHERE ID='$this->id'"));
		
		if ($query) {
			$query=$this->mysqlconnect->query("UPDATE $this->tableName SET NAME='$this->name' WHERE ID=$this->id");
			//echo "Автор успешно отредактирован.";
			return true;
		}
		else {
			//echo "Автор не найден в базе.";
			return false;
		}        
	}	
}
?>