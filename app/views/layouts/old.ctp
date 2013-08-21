<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0026)http://www.codeweb.com.br/ -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

         <title>AcadLabs :: Gest&atilde;o de laborat&oacute;rios de informática</title>
         <link rel="ICON" type="image/ico" href="http://www.codeweb.com.br/favicon.ico" />
         <link rel="SHORTCUT ICON" href="http://www.codeweb.com.br/favicon.ico" />
         <link rev="made" href="mailto:fabio.fabiozoroastro@gmail.com" />

         <meta name="title" content="AcadLabs :: Gestão de laboratórios de informática" />
         <meta name="url" content="http://www.codeweb.com.br" />
         <meta name="description" content="Melhor custo benefício para criar seu site na internet. Hospedagem profissional, pagamento facilitado e suporte permanente. Solicite uma visite sem compromisso." />
         <meta name="keywords" content="criar site, fazer site, hospedagem, empresa site, marketing digital" />
         <meta name="autor" content="Fabio Zoroastro" />
         <meta name="revisit-after" content="7" />
         <meta http-equiv="Content-language" content="br" />
         <meta http-equiv="Content-Style-Type" content="text/css" />


         <?php echo $html->css('acadlabs'); ?>
         <?php echo $html->css('black-tie/jquery-ui-1.8.8.custom'); ?>
         <?php echo $html->script('jquery-1.4.4.min'); ?>
         <?php echo $html->script('jquery-ui-1.8.8.custom.min'); ?>
   </head>

   <body>


      <div class="centraliza">
         <div id="topo">
            <div id="logo" style="float:left; width:200px; height:70px;">
               <a href="#"><?php echo $html->image('code_logo.png', array('border' => '0', 'style' => 'margin-left: 49px; margin-top: 12px;')); ?></a>
            </div>
            <div id="slogan" style="margin-left:31px; margin-top:25px; float:left; height:25px; width:200px;">
               <span class="verdana_10_cinza">Gest&atilde;o de Laborat&oacute;rios</span>
            </div>
            <div id="box_acesso" style="width:220px; margin-left:150px; margin-top:20px; float:right">
               <div id="webmail" style="float:left; margin-left:15px;">
                  <a href="http://www.codeweb.com.br/?p=webmail"><?php echo $html->image('email.png', array('border' => '0')); ?></a> <a href="http://www.codeweb.com.br/?p=webmail" class="link_branco" title="Acesso ao webmail">Webmail</a>
               </div>
               <div id="sistema" style="float:right; margin-right:47px;">
                  <a href="http://www.codeweb.com.br/?p=sistema"><?php echo $html->image('cog.png', array('border' => '0')); ?></a> <a href="http://www.codeweb.com.br/?p=sistema" class="link_branco" title="Acesso ao sistema">Sistema</a>
               </div>
            </div>
            <div style="float:right; width:304px; height:20px; font-size:11px; color:#FFFFFF; margin-top:40px;" id="menu_1">
               <a href="http://www.codeweb.com.br/?p=inicio">Home</a> | <a href="http://www.codeweb.com.br/?p=empresa">A empresa</a> | <a href="http://www.codeweb.com.br/?p=solucoes">Solu��es</a> | <a href="http://www.codeweb.com.br/?p=atendimento"><strong>Atendimento</strong></a>
            </div>
            <div id="menu_2" style="width:650px; height:25px; float:left; margin-top:35px;">
               <a href="http://www.codeweb.com.br/?p=tira_duvida" style="margin-left:30px;">Tire todas as d�vidas</a> <a href="http://www.codeweb.com.br/?p=planos" style="margin-left:30px;">Conhe�a os planos</a> <a href="http://www.codeweb.com.br/?p=portifolio" style="margin-left:30px;">Veja o nosso portif�lio</a> <a href="http://www.codeweb.com.br/?p=visita" style="margin-left:25px;">Solicite uma visita</a>
            </div>
         </div>

         <div id="conteudo"><?php echo $content_for_layout; ?></div>

      </div>

      <div style="width:980px; clear:both;"></div>
      <div style="background-image:url(img/fundo_rodape.png);">
         <div id="rodape" style="background-image:url(img/rodape.png); width:980px; margin-left:auto; margin-right:auto; height:130px; margin-top:25px; margin-bottom:0px; clear:both">
            <div style="text-align:right; padding-top:88px; padding-right:24px; ">
               <?php echo $html->image('logo_codeweb_peq.png', array('border' => '0')); ?>
            </div>
         </div>
      </div>






   </body></html>