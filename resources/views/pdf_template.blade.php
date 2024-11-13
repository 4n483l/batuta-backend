<!DOCTYPE html>
<html>

<head>
    <title>{{ $note->title }}</title>
    <style>
        /* Agrega estilo aquí para el PDF */
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        h1 {
            color: #6d85a8;
        }

        p {
            font-size: 14px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <h1>{{ $note->title }}</h1>
    <h3>Tema: {{ $note->topic }}</h3>
    <p><strong>Contenido:</strong></p>
    <p>{{ $note->content }}</p>
    <p><strong>Asignatura:</strong> {{ $note->subject->name }} - {{ $note->subject->level }}</p>
</body>

</html>
