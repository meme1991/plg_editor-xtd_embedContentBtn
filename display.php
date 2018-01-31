<?php
# @Author: SPEDI srl
# @Date:   30-01-2018
# @Email:  sviluppo@spedi.it
# @Last modified by:   SPEDI srl
# @Last modified time: 31-01-2018
# @License: GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
# @Copyright: Copyright (c) SPEDI srl

  define( '_JEXEC', 1 );
  define( 'DS', DIRECTORY_SEPARATOR );
  define( 'JPATH_BASE', realpath( '..'.DS.'..'.DS.'..'.DS ) );
  require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
  require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );

  $mainframe = JFactory::getApplication('administrator');
  jimport( 'joomla.plugin.plugin' );
  $ih_name = addslashes( $_GET['ih_name'] );

  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select($db->quoteName(array('id', 'title')));
  $query->from($db->quoteName('#__content'));
  $query->where($db->quoteName('state') . ' = '. $db->quote(1));
  $query->order('ordering ASC');
  $db->setQuery($query);
  $results = $db->loadObjectList();
 ?>

 <html>
  <head>
    <title><?php echo JText::_('Embed Content - (by SPEDI srl)') ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="dist/style.min.css" />
    <script type="text/javascript">
      function InsertHtmlDialogokClick() {
        // url
        var url = document.getElementById("url").value;
        url = "url="+url;
        // overlay
        var overlay = document.getElementById("overlay").value;
        overlay = "|overlay="+overlay;

        if(document.getElementById("overlay").value == 1){
          // label
          var label = document.getElementById("label").value;
          label  = "|label="+label;
          width  = "";
          height = "";
          align  = "";
        }else{
          // label
          label = "";
          // width
          var width = document.getElementById("width").value;
          width = "|width="+width;
          // height
          var height = document.getElementById("height").value;
          height = "|height="+height;
          // align
          var align = document.getElementById("align").value;
          align = "|align="+align;
        }

        var tag = "{embedContent "+url+overlay+label+width+height+align+"}";

        window.parent.jInsertEditorText(tag, '<?php echo $ih_name ?>');
        window.parent.jModalClose();
       }

       // funzione che testa i cambiamenti di template della galleria
       function onChange(){
        //var overlay = document.getElementById("overlay").value;
        if(document.getElementById("overlay").value == 1){
          document.getElementById("label-show").style.display = 'table-row';
          document.getElementById("iframe-option-w").style.display = 'none';
          document.getElementById("iframe-option-h").style.display = 'none';
        }
        else{
          document.getElementById("label-show").style.display = 'none';
          document.getElementById("iframe-option-w").style.display = 'table-row';
          document.getElementById("iframe-option-h").style.display = 'table-row';
        }
       }

       //
       function onChangeWidth(){
        var w = document.getElementById("width").value;
        if(w != '100%'){
          document.getElementById("align-option").style.display = 'table-row';
        }
        else{
          document.getElementById("align-option").style.display = 'none';
        }
       }

       function InsertHtmlDialogcancelClick() {
         window.parent.jModalClose();
       }
    </script>

   <style media="screen">
     @import url('https://fonts.googleapis.com/css?family=Titillium+Web:,400,400i,600');
     table{
       font-family: 'Titillium Web', sans-serif;
     }
     td{
       vertical-align: middle !important;
     }
     fieldset{
       border: 0 !important;
     }
    .btn{
      cursor: pointer;
    }

   </style>
   </head>
   <body>
     <form name="embedContentForm" onSubmit="return false;">
       <fieldset>
         <table class="table">
           <tr>
             <td><label for="url" class="col-form-label">Link del contenuto</label></td>
             <td><input type="url" class="form-control form-control-sm" id="url" name="url"></td>
           </tr>
           <tr>
             <td><label for="overlay" class="col-form-label">Contenuto in overlay</label></td>
             <td>
               <select class="form-control form-control-sm" name="overlay" id="overlay" onchange="onChange()">
                 <option value="0" selected>NO</option>
                 <option value="1">SI</option>
               </select>
             </td>
           </tr>
           <tr id="label-show" style="display:none;">
             <td><label for="label" class="col-form-label">Etichetta link</label></td>
             <td><input type="text" class="form-control form-control-sm" id="label" name="label"></td>
           </tr>
           <tr id="iframe-option-w">
             <td><label for="width" class="col-form-label">Larghezza iframe</label></td>
             <td><input type="text" class="form-control form-control-sm" id="width" name="width" value="100%" onchange="onChangeWidth()"></td>
           </tr>
           <tr id="iframe-option-h">
             <td><label for="height" class="col-form-label">Altezza iframe</label></td>
             <td><input type="text" class="form-control form-control-sm" id="height" name="height" value="450px"></td>
           </tr>
           <tr id="align-option" style="display:none;">
             <td><label for="align" class="col-form-label">Allineamento</label></td>
             <td>
               <select class="form-control form-control-sm" name="align" id="align" >
                 <option value="0" selected>NO</option>
                 <option value="1">Sinistra</option>
                 <option value="2">Destra</option>
               </select>
               <small id="alignHelp" class="form-text text-muted">Funziona solo con una larghezza diversa da 100%</small>
             </td>
           </tr>
         </table>
       </fieldset>
       <fieldset>
         <table class="table">
           <tr>
             <td>
               <input type="submit" class="btn btn-primary" value="<?= JText::_('Inserisci il codice') ?>" onClick="InsertHtmlDialogokClick()">
               <input type="button" class="btn btn-secondary" value="<?= JText::_('Annulla') ?>" onClick="InsertHtmlDialogcancelClick()">
             </td>
           </tr>
         </table>
       </fieldset>
     </form>
   </body>
 </html>
