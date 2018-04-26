<?php

/* listadoUsuarios.html */
class __TwigTemplate_7d1288fba8b5db510373d823180549a11bc0e78bf8f6d908dfb4ab66e4e764fc extends Twig_Template
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
     <table id=\"nomina\" class=\"table table-bordered table-striped\">
         <thead>
             <tr>
                 <th data-column-id=\"id\" data-type=\"numeric\" data-visible=\"false\">Id Usuario</th>
                 <th data-column-id=\"nombre\" data-visible=\"false\">Nombre empleado</th>
                 <th data-column-id=\"tipoDocumento\" data-visible=\"false\">Tipo Documento</th>
                 <th data-column-id=\"numeroDocumento\">Numero Documento</th>
                 <th data-column-id=\"area\">Area</th>
                 <th data-column-id=\"email\">Email</th>
                 <th data-column-id=\"rol\">Rol</th>
                 <th data-column-id=\"estado\">Estado</th>
                 <th data-column-id=\"cargo\">Cargo</th>
                 <th data-column-accion=\"accion\" data-formatter=\"accion\" data-sortable=\"false\">Acciones</th>
             </tr>
         </thead>
     </table>
     <input type=\"hidden\" name=\"nombUsr\" id=\"nombUsr\" value=\"";
        // line 23
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

   
  var datosNomina = \$(\"#nomina\").bootgrid({

      ajax: true,
      rowSelect: true,
      post: function() {
                return{
                    id:\"b0df282a-0d67-40e5-8558-c9e93b7befed\"
                };
            },
    url:'index_blank.php?component=NominaEtl&method=datosGrilla&idMenu='+";
        // line 47
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
    datosNomina.find(\".command-edit\").on(\"click\", function(e){
        
        editarNominaEtl(\$(this).data(\"row-id\"));

    }).end().find(\".command-delete\").on(\"click\", function(column, row){

        eliminarNominaEtl(\$(this).data(\"row-id\"));

    }).end().find(\".command-view\").on(\"click\",function(e){

        verNominaEtl(\$(this).data(\"row-id\"));
    });
});


});



function verUsuario(idUsuario){
    \$.ajax({
        url:'index_blank.php?component=NominaEtl&method=verNominaEtl',
        data:'id='+idNominaEtl,
        success: function(msm){
           \$(\"#agregarNominaEtl\").html(msm);
           \$('#miModalVer').modal(\"show\");
        }
    });
}

function agregarNomina(id_NominaEtl){
    \$.ajax({
        url:'index_blank.php?component=NominaEtl&method=agregarNomina&idMenu='+";
        // line 98
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        type: \"POST\",
        success: function(msm){

             \$(\"#agregarNominaEtl\").html(msm);
             \$('#miModalAdd').modal(\"show\");
             
        }
    });
}

function editarNominaEtl(id){
    
     \$.ajax({
        url:'index_blank.php?component=NominaEtl&method=editarNominaEtl',
        type: \"POST\",
        data:'id='+id+'&idMenu='+";
        // line 114
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        success: function(msm){

            \$(\"#agregarNominaEtl\").html(msm);
            \$('#miModalEdit').modal(\"show\");

        }
    });
}

function eliminarNominaEtl(id){
    //if(confirm('Realmente desea eliminar el NominaEtl '+nombre+' ?')){
      
        \$.ajax({
          type: \"POST\",
          url: 'index_blank.php?component=NominaEtl&method=eliminarNominaEtl&id='+id+'&idMenu='+";
        // line 129
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
          success: function(msm){

                    alert('NominaEtl ' +\$(\"#nombUsr\").val()+ ' Inactivado');
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
        return array (  165 => 129,  147 => 114,  128 => 98,  74 => 47,  47 => 23,  26 => 5,  19 => 1,);
    }
}
