<!DOCTYPE html>
<html>

<head>
  <!-- Aqui estamos dizendo que é um arquivo HTML, e também configuramos o título da página -->
  <title>Encurtador de URL</title>

  <!-- A gente coloca um link pra uma biblioteca de ícones bonitos do Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Aqui vai um script (JavaScript) que vai verificar o que o usuário digitou -->
  <script>
    function sendLink() {
      const valueInput = document.getElementById('input_link').value; // Pega o que foi digitado no campo de texto
      if (valueInput == '') { // Se não tiver nada digitado...
        alert('o campo esta vazio'); // Exibe um alerta dizendo que o campo está vazio
      }
    }
  </script>

  <style>
    /* Abaixo vem o CSS pra dar aquele grau visual no site */
    
    body, html {
      height: 100%; /* Deixa o corpo e html com altura 100% da tela */
      margin: 0; /* Sem margem, pra preencher tudo */
      display: flex; /*  Flexbox pra centralizar as coisas */
      justify-content: center; /* Alinha tudo no centro na horizontal */
      align-items: center; /* Alinha tudo no centro na vertical */
      background-image: url('./public/background.jpg'); /* Aqui é a imagem de fundo. PS: Cuidado que só funciona no seu PC assim. */
      background-size: cover; /* A imagem vai cobrir toda a tela */
      background-position: center; /* A imagem vai ficar bem no centro */
      background-repeat: no-repeat; /* A imagem não vai se repetir */
      background-attachment: fixed; /* Vai fixar a imagem no fundo, mesmo quando rolar a página */
      font-family: Arial, Helvetica, sans-serif; /* Uma fonte bem comum e simples */
      color: white; /* Texto na cor branca pra ficar bem visível */
    }

    h1 {
      color: #f9f9f9; /* Título branco */
      font-size: 2em; /* Tamanho do título */
      margin-bottom: 20px; /* Espaço embaixo do título */
    }

    input[type="text"] {
      padding: 10px; /* Espacinho interno do input */
      font-size: 1em; /* Tamanho da fonte */
      width: 300px; /* Largura do campo de texto */
      border: 1px solid #cccccc; /* Bordinha clara no input */
      border-radius: 5px; /* Bordas arredondadas */
      margin-bottom: 10px; /* Espaço abaixo do campo de texto */
    }

    button {
      padding: 10px 20px; /* Dando um bom espaço no botão */
      font-size: 1em; /* Tamanho da fonte do botão */
      background-color: #0080AF; /* Cor verde bonita pro botão */
      color: white; /* Texto branco */
      border: none; /* Sem borda no botão */
      border-radius: 5px; /* Borda arredondada no botão */
      cursor: pointer; /* Faz o cursor virar uma mãozinha quando passa sobre o botão */
    }

    button:hover {
      background-color: #45a049; /* Quando passar o mouse em cima, o botão fica um verde mais escuro */
    }
  </style>
  <?php
      $host = 'localhost';
      $db = 'link_shorter';
      $user = 'root';
      $pass = '';
      $conn = new PDO ("mysql:host=$host;dbname=$db", $user, $pass);

      $link = '';
      $original_link = '';
      function shortLink($size = 6) {
        return substr(str_shuffle("abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789"), 0, $size);
      }
      
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $original_link = $_POST['input_link'];
        $link = shortLink (6);
        $stmp = $conn->prepare ("INSERT INTO links (original_link, short_code) VALUES (:original_link, :short_code) ");
        $stmp ->execute (['original_link'=>$original_link, 'short_code'=>$link]);
      }
      ?>
</head>

<body>
  <div>
    <!-- Título grandão pra chamar atenção -->
    <h1>Encurtador de URL</h1>
    
    <!-- O botão que chama a função sendLink() quando clicado -->
    <form action="/" method="post">
      
      <!-- Aqui o input onde o usuário vai digitar o link que quer encurtar -->
      <input id="input_link" name="input_link" type="text" placeholder="Insira seu link aqui" required>
      <button type="submit">Encurtar <i class="fas fa-arrow-right"></i></button>
      
    </form>
    <h4>
      <?php
        if($link !== ''){
          $dominio = $_SERVER['HTTP_HOST'];
          echo ("http://" . $dominio . "/" . $link);

          ## http://localhost/ADJASHDSJ
        }
      ?>
    </h4>
  </div>
</body>

</html>