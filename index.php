
<html>
<head>
	<style type="text/css">
		p {
			text-align: center;
			font-size: 25pt;
			
		}
		.main{
			width: 36%;
			margin-left:32%;
			font-size: 15pt;
			font-style: bold;
		}
		.sub{
			display:inline-block;
			width: 49%;
			
		}
		#left {
			text-align:left;
		}
		#right {
			text-align:right;
		}
		 .abutton {
			border: 1px solid #333; /* Рамка */
			display: inline-block;
			padding: 5px 15px; /* Поля */
			text-decoration: none; 
			color: #000;
			width: 85%;
		}
		.abutton:hover {
			box-shadow: 0 0 5px rgba(0,0,0,0.3); /* Тень */
			background: linear-gradient(to bottom, #fcfff4, #e9e9ce); /* Градиент */
			color: #a00;
		}
	
	</style>
	<script>
		function setBookIDlink() {
			document.getElementById('bookIDlink').href = 'books/' + document.getElementById('varbox').value;
		}	
		function setAuthorIDlink() {
			document.getElementById('authorIDlink').href = 'authors/' + document.getElementById('varbox').value;
		}	
		function setISBNlink() {
			document.getElementById('ISBNlink').href = 'books/ISBN/' + document.getElementById('varbox').value;
		}	
		function setBookByAuthorIDlink() {
			document.getElementById('bookByAuthorIDlink').href = 'books/author/' + document.getElementById('varbox').value;
		}	
	</script>
</head>

<body>
<p>Добро пожаловать в BOOK API!</p>

<div class='main'>
<div class='sub' id='left'>
<a href='#' class='abutton' id='bookIDlink' onClick="setBookIDlink();">Посмотреть книгу по ID</a></br>
<a href='books' class='abutton'>Посмотреть все книги</a></br>
<a href=# class='abutton' id='ISBNlink' onClick="setISBNlink();">Найти книгу по ISBN</a></br>
</div>
<div class='sub' id='right'>
<a href='#' class='abutton' id='authorIDlink' onClick="setAuthorIDlink();">Посмотреть автора по ID</a></br>
<a href='authors' class='abutton'>Посмотреть авторов</a></br>
<a href=# class='abutton' id='bookByAuthorIDlink' onClick="setBookByAuthorIDlink();">Все книги автора</a></br>
</div>
</br></br>
ID/ISBN/Author_id:<input type="text" value="" id="varbox" required> 

</br></br>
</br></br>
<div id="bookformdiv">
<form action="books/" method="post"
	<label for="bookvarbox1">ID автора</label>
	<input type="text" name="author_id" id="bookvarbox1" required></br>
	<label for="bookvarbox2">Название книги</label>
	<input type="text" name="title" id="bookvarbox2" required></br>
	<label for="bookvarbox3">ISBN</label>
	<input type="text" name="ISBN" id="bookvarbox3" required></br> 
	<input type="submit" value="Добавить книгу"  required>
</form>
</div>
</br></br>
</br></br>
<div id="authorformdiv">
<form action="authors/" method="post"
	<label for="authvarbox3">Имя нового автора</label>
	<input type="text" name="name" id="authvarbox3" required></br> 
	<input type="submit" value="Добавить автора"  required>
</form>
</div>
</div>
</body>
</html\>