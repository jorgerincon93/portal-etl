<?php

/* listadoUsuarios.html */
class __TwigTemplate_3208494f8ff8e09e3f4e7c2472b5275672fb3d589e1d63ca151b923c291513e9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo twig_escape_filter($this->env, (isset($context["COMODIN"]) ? $context["COMODIN"] : null), "html", null, true);
        echo "
<div id=\"agregarUsuario\"></div>

";
        // line 4
        echo (isset($context["crear"]) ? $context["crear"] : null);
        echo "
   <div class=\"table-responsive\">
     <table id=\"usuario\" class=\"table table-bordered table-striped\">
         <thead>
             <tr>
                 <th data-column-id=\"id\" data-type=\"numeric\" data-visible=\"false\">Id Usuario</th>
                 <th data-column-id=\"login\">Login</th>
                 <th data-column-id=\"nombreUsuario\">Usuario</th>
                  <!--<th data-column-id=\"tipoDocumento\" data-visible=\"false\">Tipo Documento</th>
                 <th data-column-id=\"numeroDocumento\">Numero Documento</th>
                 <th data-column-id=\"area\">Area</th>
                 <th data-column-id=\"email\">Email</th>
                 <th data-column-id=\"rol\">Rol</th>-->
                 <th data-column-id=\"ultimoIngreso\">Ultimo Ingreso</th>
                 <th data-column-id=\"estado\">Estado</th>
                 <th data-column-id=\"intento\" data-type=\"numeric\">Intento</th>
                 <th data-column-accion=\"accion\" data-formatter=\"accion\" data-sortable=\"false\">Acciones</th>
             </tr>
         </thead>
     </table>
     <input type=\"hidden\" name=\"nombUsr\" id=\"nombUsr\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, (isset($context["nombreUsr"]) ? $context["nombreUsr"] : null), "html", null, true);
        echo "\" />
  </div>

<script>

\$(document).ready(function() {
   
   \$(\"#add_button\").click(function() {
      \$(\"#product_form\")[0].reset();
      \$(\".modal-tittle\").text(\"Add Product\");
      \$(\"#action\").val(\"Add\");
      \$(\"#operation\").val(\"Add\");
   });

   
  var datosUsuarios = \$(\"#usuario\").bootgrid({

      ajax: true,
      rowSelect: true,
      post: function() {
                return{
                    id:\"b0df282a-0d67-40e5-8558-c9e93b7befed\"
                };
            },
    url:'index_blank.php?component=Usuario&method=datosGrilla&idMenu='+";
        // line 48
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
    formatters: {
           \"accion\": function(column,row) {
               return  \"<div class=\\\"btn-group btn-group-sm\\\" role=\\\"group\\\">\"
                     + \"<button type=\\\"button\\\"  class=\\\"btn btn-sm command-edit\\\" data-toggle=\\\"modal\\\" data-target=\\\"#miModalEdit\\\" data-row-id=\\\"\"+ row.id +\"\\\" >\" 
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">mode_edit</i></<button> \"
                     + \"<button type=\\\"button\\\" class=\\\"btn btn-sm command-delete\\\" data-row-id=\\\"\" + row.id + \"\\\"> \"
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">delete</i></button> \"
                     + \"<br>\"
                     + \"<button type=\\\"button\\\" class=\\\"btn btn-sm command-view\\\" data-toggle=\\\"modal\\\" data-target=\\\"#miModalVer\\\"  data-row-id=\\\"\" + row.id + \"\\\"> \"
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">visibility</i></button> \"
                     + \"</div>\"
           }

        }

  }).on(\"loaded.rs.jquery.bootgrid\", function(){

    /* Executes after data is loaded and rendered */
    datosUsuarios.find(\".command-edit\").on(\"click\", function(e){
        
        editarUsuario(\$(this).data(\"row-id\"));

    }).end().find(\".command-delete\").on(\"click\", function(column, row){

        eliminarUsuario(\$(this).data(\"row-id\"));

    }).end().find(\".command-view\").on(\"click\",function(e){

        verUsuario(\$(this).data(\"row-id\"));
    });
});


});



function verUsuario(idUsuario){
    \$.ajax({
        url:'index_blank.php?component=Usuario&method=verUsuarios',
        data:'id='+idUsuario,
        success: function(msm){
           \$(\"#agregarUsuario\").html(msm);
           \$('#miModalVer').modal(\"show\");
        }
    });
}

function agregarUsuario(id_usuario){
    \$.ajax({
        url:'index_blank.php?component=Usuario&method=agregarUsuario&idMenu='+";
        // line 99
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        type: \"POST\",
        success: function(msm){

             \$(\"#agregarUsuario\").html(msm);
             \$('#miModalAdd').modal(\"show\");
             
        }
    });
}

function editarUsuario(id){
    
     \$.ajax({
        url:'index_blank.php?component=Usuario&method=editarUsuario',
        type: \"POST\",
        data:'id='+id+'&idMenu='+";
        // line 115
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        success: function(msm){

            \$(\"#agregarUsuario\").html(msm);
            \$('#miModalEdit').modal(\"show\");

        }
    });
}

function eliminarUsuario(id){
    //if(confirm('Realmente desea eliminar el usuario '+nombre+' ?')){
      
        \$.ajax({
          type: \"POST\",
          url: 'index_blank.php?component=Usuario&method=eliminarUsuario&id='+id+'&idMenu='+";
        // line 130
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
          success: function(msm){

                    alert('Usuario ' +\$(\"#nombUsr\").val()+ ' Inactivado');
                    //   \$('#componenteCentral').html(msm);
          }
        });
    //}
}
</script>";
    }

    public function getTemplateName()
    {
        return "listadoUsuarios.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  166 => 130,  148 => 115,  129 => 99,  75 => 48,  48 => 24,  25 => 4,  19 => 1,);
    }
}
