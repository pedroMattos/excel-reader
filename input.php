<?php
$servidor = '';
$banco = '';
$usuario = '';
$senha = '';
$link = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$link) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
} else {
  echo 'Conectado!';
}

$sql = mysqli_query($link, "Select * From unity");
while($exibe = mysqli_fetch_assoc($sql)){
  echo $exibe['unity_name'] .'<br>';
}
?>

<div class="row container">
  <div class="col-6">
  <!-- Envia para a página atual -->
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
      <!-- A planilha deve estar no formato XML -->
      <input type="file" name="planilha" id="plan">
      <label for="planilha">Arquivo</label>
      <input type="submit" value="Enviar">
    </form>
  </div>
  <div class="col-6">
<?php
// Gera o código nonce
  $dados = $_FILES['planilha'];
  // Recupera código de segurança para acesso a api do wordpress
  // echo '<button id="media">Media</button>';

  // verifica se existe arquivo
  if($_FILES['planilha']['tmp_name']){
    // Função nativa do PHP para percorrer html/xml
    $arquivo = new DOMDocument();
    $arquivo->load($_FILES['planilha']['tmp_name']);
    // var_dump($arquivo);
    // acessa as linhas da tabela
    $linhas = $arquivo->getElementsByTagName("table-row");
    // percorre as linhas
    foreach($linhas as $linha){
      // recupera os valores de cada celula em cada linha
      if($linha->getElementsByTagName("table-cell")->item(0)->nodeValue) {
        $codigo = $linha->getElementsByTagName("table-cell")->item(0)->nodeValue;
      }
      // $codigo = $linha->nodeValue;
      echo "<p class='titulo-item-planilha'>invoice_id: $codigo <br></p>";
      if($linha->getElementsByTagName("table-cell")->item(1)->nodeValue) {
        $descricao = $linha->getElementsByTagName("table-cell")->item(1)->nodeValue;
      }
      // $codigo = $linha->nodeValue;
      echo "<p>invoice_valor: $descricao <br></p>";
      if($linha->getElementsByTagName("table-cell")->item(2)->nodeValue) {
        $quant = $linha->getElementsByTagName("table-cell")->item(2)->nodeValue;
      }
      // $codigo = $linha->nodeValue;
      echo "<p>invoice_date: $quant <br></p>";

      // recupera os valores de cada celula em cada linha
      if($linha->getElementsByTagName("table-cell")->item(3)->nodeValue) {
        $codigo2 = $linha->getElementsByTagName("table-cell")->item(3)->nodeValue;
      }
      // $codigo = $linha->nodeValue;
      echo "<p class='titulo-item-planilha'>invoice_id: $codigo2 <br></p>";
      if($linha->getElementsByTagName("table-cell")->item(4)->nodeValue) {
        $descricao2 = $linha->getElementsByTagName("table-cell")->item(4)->nodeValue;
      }
      // $codigo = $linha->nodeValue;
      echo "<p>invoice_valor: $descricao2 <br></p>";
      if($linha->getElementsByTagName("table-cell")->item(5)->nodeValue) {
        $quant2 = $linha->getElementsByTagName("table-cell")->item(5)->nodeValue;
      }
      // $codigo = $linha->nodeValue;
      echo "<p>invoice_date: $quant2 <br></p>";
      $sql = "INSERT INTO measurement_a (description, valor, invoice_id) VALUES ('$quant', $descricao, $codigo)";
      echo "<br>";

      if ($link->query($sql) === TRUE) {
        echo "Inserido com sucesso!";
      } else {
        echo "Erro: " . $sql . "<br>" . $link->error;
      }
      $sql2 = "INSERT INTO measurement_a (description, valor, invoice_id) VALUES ('$quant2', $descricao2, $codigo2)";
      echo "SQL INPUT: $sql";
      echo "<br>";
      if ($link->query($sql2) === TRUE) {
        echo "Inserido com sucesso!";
      } else {
        echo "Erro: " . $sql2 . "<br>" . $link->error;
      }
      // $valor = $linha->getElementsByTagName("table-cell")->item(3)->nodeValue;
      // // $codigo = $linha->nodeValue;
      // echo "<p>Valor: $valor <br></p>";
      // $promo = $linha->getElementsByTagName("table-cell")->item(4)->nodeValue;
      // // $codigo = $linha->nodeValue;
      // echo "<p>Promoção: $promo <br></p>";
      // $group = $linha->getElementsByTagName("table-cell")->item(5)->nodeValue;
      // $codigo = $linha->nodeValue;
      // echo "<p class='link-item-planilha'>Grupo: $group <br></p>";
      echo '<hr>';
    }
  }


?>
 <p id="fields"></p>
  </div>
</div>