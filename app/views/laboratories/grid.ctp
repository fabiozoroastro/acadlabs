<?php
if (count($results) > 0) {
   /* Display paging info */
?>
   <div id="pagination">
   <?php
   echo $paginator->prev('Anterior');
   echo $paginator->numbers(array('separator' => ' - '));
   echo $paginator->next('Póximo');
   ?>
</div>

<table class="listing" cellspacing="0">
   <thead>
      <tr class="header">
         <th>Nome</th>
         <th>N&#176; de Computadores</th>
         <th>Ativo</th>
      </tr>
   </thead>
   <tbody>
      <?php
      $index = 0;
      foreach ($results as $lab) {
      ?>
      <tr class='<?php echo $index % 2 == 0 ?'list-line-odd':'list-line-even';?>'
          onclick="location.href='<?php echo ($this->base).'/laboratories/edit/'.$lab['Laboratory']['id'] ?>'">
            <td><?php echo $lab['Laboratory']['name']; ?></td>
            <td><?php echo $lab['Laboratory']['number_computers']; ?></td>
            <td><?php echo ( $lab['Laboratory']['active']  ? $html->image('bullet_blue.png'):$html->image('bullet_red.png') ) ; ?></td>
         </tr>
      <?php
      $index++;
      }
      ?>
   </tbody>
</table>
<?php
   }else{ echo("Nenhum registro encontrado."); }
?>
