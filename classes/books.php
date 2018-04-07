<?php

class Book {
	
	public $id;
    public $author_ID;
    public $title;
    public $ISBN;	
	
	private $tableName = 'books';
	private $mysqlconnect;
	
	public function __construct()
    {    	
        $this->mysqlconnect=new mysqli('localhost', 'root', 'password','book_db');
        $this->mysqlconnect->set_charset("utf8");
        if ($this->mysqlconnect->connect_errno)
            die("Connection to database failed");
    }
	
	private function formOutput($data, $authorName = NULL) //формирование вывода
	{
		if (isset($authorName)) {	// Если вывод книг по автору, то выводится его имя
			//return "<tr><td>".$data['ID']."</td><td>".$authorName."</td><td>".$data['TITLE']."</td><td>".$data['ISBN']."</td></tr>";
			return "ID(".$data['ID'].") ".$authorName." - ".$data['TITLE'].", ISBN:".$data['ISBN']."</br>";
		}
		else {
			//return "<tr><td>".$data['ID']."</td><td>".$data['AUTHOR_ID']."</td><td>".$data['TITLE']."</td><td>".$data['ISBN']."</td></tr>";
			return "ID(".$data['ID'].") ".$data['AUTHOR_ID']." - ".$data['TITLE'].", ISBN:".$data['ISBN']."</br>";
		}
	}
	
	public function getAll() //вывод всех книг
    {
        $query=$this->mysqlconnect->query("SELECT * FROM $this->tableName");
		while($data = mysqli_fetch_array($query)){ 
			$authorNameFromID=mysqli_fetch_array($this->mysqlconnect->query("SELECT NAME FROM authors WHERE ID=".$data['AUTHOR_ID']))['NAME']; //Ищем имя автора по ID
			$massOutput=$massOutput.$this->formOutput($data, $authorNameFromID);
		}
		
		if (!is_null($massOutput)) {
			return $massOutput;
		}
		else
		{
			return "Книги в базе не обнаружены.";
		}
    }	
	
	public function getByAuthorID($author_ID) //вывод всех книг автора указанного по ID
    {
        $query=$this->mysqlconnect->query("SELECT * FROM $this->tableName WHERE AUTHOR_ID=".$author_ID);
		while($data = mysqli_fetch_array($query)){ 
			$authorNameFromID=mysqli_fetch_array($this->mysqlconnect->query("SELECT NAME FROM authors WHERE ID=".$data['AUTHOR_ID']))['NAME']; //Ищем имя автора по ID
			$massOutput=$massOutput.$this->formOutput($data,$authorNameFromID);
		}
		
		if (!is_null($massOutput)) {
			return $massOutput;
		}
		else
		{
			return "Книги автора с ID(".$author_ID.") в базе не обнаружены.";
		}
    }	
	
	public function getByID($id) //вывод книги по ID
    {
		$this->id=$id;
        $query=mysqli_fetch_array($this->mysqlconnect->query("SELECT * FROM $this->tableName WHERE ID=$this->id"));
			
		if (isset($query['TITLE'])) {
			$authorNameFromID=mysqli_fetch_array($this->mysqlconnect->query("SELECT NAME FROM authors WHERE ID=".$query['AUTHOR_ID']))['NAME']; //Ищем имя автора по ID
			return $this->formOutput($query,$authorNameFromID);
		}
		else
		{
			return "ОШИБКА 404. Книга с ID=".$this->id." не найдена.";
		}
    }		
	
	public function getByISBN($ISBN) //вывод книги по ISBN
    {
		$this->ISBN=$ISBN;
        $query=mysqli_fetch_array($this->mysqlconnect->query("SELECT * FROM $this->tableName WHERE ISBN=$this->ISBN"));
		
		if (isset($query['TITLE'])) {
			$authorNameFromID=mysqli_fetch_array($this->mysqlconnect->query("SELECT NAME FROM authors WHERE ID=".$query['AUTHOR_ID']))['NAME']; //Ищем имя автора по ID
			return $this->formOutput($query,$authorNameFromID);
		}
		else
		{
			return "ОШИБКА 404. Книга с ISBN=".$this->ISBN." не найдена.";
		}
    }	
		
	public function post($author_ID, $title, $ISBN) //добавление книги
    {
        $this->author_ID = $author_ID;
        $this->title = $title;
        $this->ISBN = $ISBN;
		
		$query=mysqli_num_rows($this->mysqlconnect->query("SELECT TITLE FROM $this->tableName WHERE TITLE='$this->title' AND AUTHOR_ID=$this->author_ID"));
				
		if ($query) {
			//echo "Эта книга уже есть в базе.";
			return false;
		}
		else {
			$query=$this->mysqlconnect->query("INSERT INTO $this->tableName (ID,AUTHOR_ID,TITLE,ISBN) VALUES (NULL,$this->author_ID,'$this->title',$this->ISBN)");
			//echo "Книга успешно добавлена.";
			return true;
		}
	}	
	
	public function delete($id) //удаление книги
    {
		$this->id = $id;
		$query=mysqli_num_rows($this->mysqlconnect->query("SELECT ID FROM $this->tableName WHERE ID='$this->id'"));
		
		if ($query) {
			$query=$this->mysqlconnect->query("DELETE FROM $this->tableName WHERE id=$this->id");
			//echo "Книга успешно удалена.";
			return true;
		}
		else {
			//echo "Книга не найдена в базе.";
			return false;
		}
	}	
	
	public function put($id, $param1 = NULL, $param2 = NULL, $param3 = NULL) //редактирование книги при условии, что новый ID не длинее 13 символов, а название книги задается в кавычках.
    {
		$this->id=$id;
		$query=mysqli_num_rows($this->mysqlconnect->query("SELECT ID FROM $this->tableName WHERE ID='$this->id'"));
		
		if ($query) {
			$args = count(func_get_args()) - 1;
			$query=mysqli_fetch_array($this->mysqlconnect->query("SELECT * FROM $this->tableName WHERE ID=$this->id"));
			
			$this->author_ID = $query[AUTHOR_ID];
			$this->title = $query[TITLE];
			$this->ISBN = $query[ISBN];
		
			switch ($args) {
				case 3:
					$this->author_ID = $param1;
					$this->title = $param2;
					$this->ISBN = $param3;
				break;
				case 2:
					if (is_string($param1)) { $this->title = $param1;  $this->ISBN = $param2;}
					if (is_int($param1) && ($param1 < 1000000000000)) {
							$this->author_ID = $param1;
							if (is_string($param2)) { $this->title = $param2; } else { $this->ISBN = $param2;}
						}
					//if (is_int($param1) && ($param1 >= 1000000000000)) { break; } //из двух параметров первый - это ISBN (последний) => второй задан неверно. Однако, такой запрос все-равно не поступит, так что закомментил. 
				break;
				case 1:
					if (is_string($param1)) { $this->title = $param1;}
					if (is_int($param1) && ($param1 < 1000000000000)) { $this->author_ID = $param1; }
					if (is_int($param1) && ($param1 >= 1000000000000)) { $this->ISBN = $param1; }
				break;
				}
			/*
			echo "</br>БЫЛО:_".$query[AUTHOR_ID]." ".$query[TITLE]." ".$query[ISBN]."</br>";
			echo "СТАЛО:".$this->author_ID." ".$this->title." ".$this->ISBN."</br>";
			*/				
			$query=$this->mysqlconnect->query("UPDATE $this->tableName SET AUTHOR_ID=$this->author_ID, TITLE='$this->title', ISBN=$this->ISBN WHERE ID=$this->id");
			//echo "Книга успешно отредактирована.";
			return true;
		}
		else {
			//echo "Книга не найдена в базе.";
			return false;
		}        
	}	
}

?>