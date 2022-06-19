<?php include 'router.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
    <table id="booksTable" class="table">
        <thead>
            <tr>
                <th>Titulolo</th>
                <th>Id_autor</th>
                <th>Id_genero</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <input type="button" value="Cargar Libros" id="loadBooks">
        <div style="display:none;" id="messages">
            <p></p>
        </div>
        <div style="display: none;" id="bookForm">
            <hr/>
            <table>
                <tr>
                    <td>Titulo</td>
                    <td><input type="text" name="bookTitle" id="bookTitle"></td>
                </tr>
                <tr>
                    <td>Id_autor</td>
                    <td><input type="text" name="bookAuthorId" id="bookAuthorId"></td>
                </tr>
                <tr>
                    <td>Id_genero</td>
                    <td><input type="text" name="bookGenreId" id="bookGenreId"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="button" value="Guardar" id="bookSave"></td>
                </tr>
            </table>
        </div>
    </table>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/eee10799b3.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>
    <script type="text/javascript">
        $('#loadBooks').click( function(){
            $('#messages').first('p').text('Cargando libros...');
            $('#messages').show();
            $.ajax(//Obteniendo los libros
                {
                    'url': 'https://api-rest-plat.herokuapp.com/router.php/books',//Accedemos a la url para obtner los libros
                    'success': function(data){//Si la respuesta es correcta, recibimos esos datos que estan en formato json
                        $('#messages').hide();
                        $('#booksTable > tbody').empty();
                        for(b in data){
                            addBook(data[b]);
                        } 
                        $('#bookForm').show();
                    }
                }
            )
        } )

        function addBook(book){
            $('#booksTable tr:last').after('<tr><td>' + book.titulo + '</td><td>' + book.id_autor + '</td><td>' + book.id_genero + '</td><tr>');
        }


        $('#bookSave').click(function(){
            var newBook = {
                'titulo': $('#bookTitle').val(),
                'id_autor': $('#bookAuthorId').val(),
                'id_genero': $('#bookGenreId').val() 
            }

            $('#message').first('p').text('Guardando libro...');
            $('#message').show();

            $.ajax({
                'url': 'https://api-rest-plat.herokuapp.com/router.php/books',
                'method': 'POST',
                'data': JSON.stringify(newBook),
                'success': function(data){
                    $('#message').hide(); 
                    addBook(newBook);
                }
            });
        });
    </script>
</html>