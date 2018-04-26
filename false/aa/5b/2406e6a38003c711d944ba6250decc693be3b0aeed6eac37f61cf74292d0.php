<?php

/* listadoNomina.html */
class __TwigTemplate_aa5b2406e6a38003c711d944ba6250decc693be3b0aeed6eac37f61cf74292d0 extends Twig_Template
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


<div id=\"agregarNomina\"></div>
";
        // line 5
        echo (isset($context["crear"]) ? $context["crear"] : null);
        echo "
   <div class=\"table-responsive\">
     <table id=\"Nomina\" class=\"table table-bordered table-striped\">
         <thead>
             <tr>
                 <th data-column-id=\"id\" data-type=\"numeric\" data-visible=\"false\">Id Empelado</th>
                 <th data-column-id=\"codigo\">Nombre</th>
                 <th data-column-id=\"tipo\">Tipo Ingreso</th>
                 <th data-column-id=\"descripcion\">Descripcion</th>
                 <th data-column-accion=\"accion\" data-formatter=\"accion\" data-sortable=\"false\">Acciones</th>
             </tr>
         </thead>
     </table>
     <input type=\"hidden\" name=\"nombUsr\" id=\"nombUsr\" value=\"";
        // line 18
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

   
  var datosNomina = \$(\"#Nomina\").bootgrid({

      ajax: true,
      rowSelect: true,
      post: function() {
                return{
                    id:\"b0df282a-0d67-40e5-8558-c9e93b7befed\"
                };
            },
    url:'index_blank.php?component=Nomina&method=datosGrilla&idMenu='+";
        // line 42
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
    formatters: {
           \"accion\": function(column,row) {
               return  \"<div class=\\\"btn-group btn-group-sm\\\" role=\\\"group\\\">\"
                     + \"<button type=\\\"button\\\"  class=\\\"btn btn-sm command-edit\\\" data-toggle=\\\"modal\\\" data-target=\\\"#miModalEdit\\\" data-row-id=\\\"\"+ row.id +\"\\\" >\" 
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">mode_edit</i></<button> \"
                     /*+ \"<button type=\\\"button\\\" class=\\\"btn btn-sm command-delete\\\" data-row-id=\\\"\" + row.id + \"\\\"> \"
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">delete</i></button> \"*/
                     + \"<br>\"
                     + \"<button type=\\\"button\\\" class=\\\"btn btn-sm command-view\\\" data-toggle=\\\"modal\\\" data-target=\\\"#miModalVer\\\"  data-row-id=\\\"\" + row.id + \"\\\"> \"
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">visibility</i></button> \"
                     + \"</div>\"
           }

        }

  }).on(\"loaded.rs.jquery.bootgrid\", function(){

    /* Executes after data is loaded and rendered */
    datosNomina.find(\".command-edit\").on(\"click\", function(e){
        
        editarNomina(\$(this).data(\"row-id\"));

    }).end().find(\".command-view\").on(\"click\",function(e){

        verNomina(\$(this).data(\"row-id\"));
    });
});


});



function verNomina(idNomina){
    \$.ajax({
        url:'index_blank.php?component=Nomina&method=verNomina',
        data:'id='+idNomina,
        success: function(msm){
           \$(\"#agregarNomina\").html(msm);
           \$('#miModalVer').modal(\"show\");
        }
    });
}

function agregarNomina(id_Nomina){
    \$.ajax({
        url:'index_blank.php?component=Nomina&method=agregarNomina&idMenu='+";
        // line 89
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        type: \"POST\",
        success: function(msm){

             \$(\"#agregarNomina\").html(msm);
             \$('#miModalAdd').modal(\"show\");
             
        }
    });
}

function editarNomina(id){
    
     \$.ajax({
        url:'index_blank.php?component=Nomina&method=editarNomina',
        type: \"POST\",
        data:'id='+id+'&idMenu='+";
        // line 105
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        success: function(msm){

            \$(\"#agregarNomina\").html(msm);
            \$('#miModalEdit').modal(\"show\");

        }
    });
}

function eliminarNomina(id){
    //if(confirm('Realmente desea eliminar el Nomina '+nombre+' ?')){
      
        \$.ajax({
          type: \"POST\",
          url: 'index_blank.php?component=Nomina&method=eliminarNomina&id='+id+'&idMenu='+";
        // line 120
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
          success: function(msm){

                    alert('Nomina ' +\$(\"#nombUsr\").val()+ ' Inactivado');
                    //   \$('#componenteCentral').html(msm);
          }
        });
    //}
}
</script>";
    }

    public function getTemplateName()
    {
        return "listadoNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  156 => 120,  138 => 105,  119 => 89,  69 => 42,  42 => 18,  26 => 5,  19 => 1,);
    }
}
