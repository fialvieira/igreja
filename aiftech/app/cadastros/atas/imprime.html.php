<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" type="image/png" sizes="64x64" href="<?= SITE ?>core/templates/igreja/img/favico.ico">
    <title><?= \Sistema::$nome ?></title>
    <link rel="stylesheet" href="imprime.css">
  </head>
  <body>
    <section>
      <div>
        <p>
          <b>Ata <?= $ata->getNum() ?><?= (is_numeric($ata->getNum()))? ' ('.convertNumToWords($ata->getNum()).')' : '' ?></b> 
          <?= nl2br(str_replace(['(b)','(/b)','(B)','(/B)','(u)','(/u)','(U)','(/U)'], ['<b>','</b>','<b>','</b>','<u>','</u>','<u>','</u>'], $texto)) ?>
          <?php
            
//          do {
//            $int = strpos($texto, '(');
//            $find = substr($texto, $int, 3);
//            switch ($find) {
//              case '(b)':
//                $int_fim = strpos($texto, '(/b)');
//                $tam = $int_fim - ($int + 3);
//                ?>
                <!--//<?/= substr($texto, 0, $int) ?> <b> <?/= substr($texto, $int + 3, $tam) ?></b>-->
                <?php
//                $start = $int_fim + 4;
//                break;
//              case '(u)':
//                $int_fim = strpos($texto, '(/u)');
//                $tam = $int_fim - ($int + 3);
//                ?>
                <!--//<?/= substr($texto, 0, $int) ?> <u> <?/= substr($texto, $int + 3, $tam) ?> </u>-->
                <?php
//                $start = $int_fim + 4;
//                break;
//              default:
//                if ($int) {
//                  ?>
                  <?=''// substr($texto, 0, $int + 1) ?>
                  <?php
//                  $start = $int + 1;
//                } else {
//                  ?>
                  <?=''// substr($texto, 0) ?>
                  <?php
//                  $start = 0;
//                }
//                break;
//            }
//            if ($start > 0) {
//              $texto = substr($texto, $start);
//            } else {
//              $texto = '';
//            }
//          } while (strlen($texto) > 0);
          ?>
        </p>
      </div>
      <br>
      <br>
      <table>  
        <tr>
          <td width="50%">_________________________________</td>
          <td width="50%">_________________________________</td>
        </tr>
        <tr>
          <td width="50%"><?= $presidente_nome ?></td>            
          <td width="50%"><?= $secretario_nome ?></td>            
        </tr>
        <tr>
          <td width="50%"><?= $presidente_cargo ?></td>
          <td width="50%"><?= $secretario_cargo ?></td>                          
        </tr>  
      </table>
    </section>
  </body>
</html>