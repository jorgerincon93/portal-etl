<?php

/* listadoEmpleado.html */
class __TwigTemplate_35497a0ed309549ce2d563c7cadcd4f6063603ebf7465a9f6c3b7aae777946c5 extends Twig_Template
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


<div id=\"agregarEmpleado\"></div>
";
        // line 5
        echo (isset($context["crear"]) ? $context["crear"] : null);
        echo "
   <div class=\"table-responsive\">
     <table id=\"Empleado\" class=\"table table-bordered table-striped\">
         <thead>
             <tr>
                 <th data-column-id=\"id\" data-type=\"numeric\" data-visible=\"false\">Id Empelado</th>
                 <th data-column-id=\"nombre\">Nombre empleado</th>
                 <th data-column-id=\"tipoDocumento\">Tipo Documento</th>
                 <th data-column-id=\"numeroDocumento\">Numero Documento</th>
                 <th data-column-id=\"area\" data-visible=\"false\">Area</th>
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

   
  var datosEmpleado = \$(\"#Empleado\").bootgrid({

      ajax: true,
      rowSelect: true,
      post: function() {
                return{
                    id:\"b0df282a-0d67-40e5-8558-c9e93b7befed\"
                };
            },
    url:'index_blank.php?component=Empleado&method=datosGrilla&idMenu='+";
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
    datosEmpleado.find(\".command-edit\").on(\"click\", function(e){
        
        editarEmpleado(\$(this).data(\"row-id\"));

    }).end().find(\".command-delete\").on(\"click\", function(column, row){

        eliminarEmpleado(\$(this).data(\"row-id\"));

    }).end().find(\".command-view\").on(\"click\",function(e){

        verEmpleado(\$(this).data(\"row-id\"));
    });
});


});



function verEmpleado(idEmpleado){
    \$.ajax({
        url:'index_blank.php?component=Empleado&method=verEmpleado',
        data:'id='+idEmpleado,
        success: function(msm){
           \$(\"#agregarEmpleado\").html(msm);
           \$('#miModalVer').modal(\"show\");
        }
    });
}

function agregarEmpleado(id_Empleado){
    \$.ajax({
        url:'index_blank.php?component=Empleado&method=agregarEmpleado&idMenu='+";
        // line 98
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        type: \"POST\",
        success: function(msm){

             \$(\"#agregarEmpleado\").html(msm);
             \$('#miModalAdd').modal(\"show\");
             
        }
    });
}

function editarEmpleado(id){
    
     \$.ajax({
        url:'index_blank.php?component=Empleado&method=editarEmpleado',
        type: \"POST\",
        data:'id='+id+'&idMenu='+";
        // line 114
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        success: function(msm){

            \$(\"#agregarEmpleado\").html(msm);
            \$('#miModalEdit').modal(\"show\");

        }
    });
}

function eliminarEmpleado(id){
    //if(confirm('Realmente desea eliminar el Empleado '+nombre+' ?')){
      
        \$.ajax({
          type: \"POST\",
          url: 'index_blank.php?component=Empleado&method=eliminarEmpleado&id='+id+'&idMenu='+";
        // line 129
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
          success: function(msm){

                    alert('Empleado ' +\$(\"#nombUsr\").val()+ ' Inactivado');
                    //   \$('#componenteCentral').html(msm);
          }
        });
    //}
}
</script>";
    }

    public function getTemplateName()
    {
        return "listadoEmpleado.html";
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
