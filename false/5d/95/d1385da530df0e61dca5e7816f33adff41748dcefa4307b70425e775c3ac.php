<?php

/* listadoDespreNomina.html */
class __TwigTemplate_5d95d1385da530df0e61dca5e7816f33adff41748dcefa4307b70425e775c3ac extends Twig_Template
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


<div id=\"agregarEmpleadoItemNom\"></div>
";
        // line 5
        echo (isset($context["crear"]) ? $context["crear"] : null);
        echo "
   <div class=\"table-responsive\">
     <table id=\"empleadoItemNom\" class=\"table table-bordered table-striped\">
         <thead>
             <tr>
                 <th data-column-id=\"id\" data-type=\"numeric\" data-visible=\"false\">Id Empelado</th>
                 <th data-column-id=\"nombre\">Empleado</th>
                 <th data-column-id=\"descripcion\">Item</th>
                 <th data-column-id=\"valor\">Descripcion</th>
                 <th data-column-id=\"mesAnio\">Descripcion</th>
                 <th data-column-id=\"estado\">Estado</th>
                 <th data-column-id=\"idEmpItem\" data-visible=\"false\">Id Item Empleado</th>
                 <th data-column-accion=\"accion\" data-formatter=\"accion\" data-sortable=\"false\">Acciones</th>
             </tr>
         </thead>
     </table>
     <input type=\"hidden\" name=\"nombUsr\" id=\"nombUsr\" value=\"";
        // line 21
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

   
  var datosEmpleadoItemNom = \$(\"#empleadoItemNom\").bootgrid({

      ajax: true,
      rowSelect: true,
      post: function() {
                return{
                    id:\"b0df282a-0d67-40e5-8558-c9e93b7befed\"
                };
            },
    url:'index_blank.php?component=DespreNomina&method=datosGrilla&idMenu='+";
        // line 45
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
    formatters: {
           \"accion\": function(column,row) {
               return  \"<div class=\\\"btn-group btn-group-sm\\\" role=\\\"group\\\">\"
                     + \"<button type=\\\"button\\\"  class=\\\"btn btn-sm command-edit\\\" data-toggle=\\\"modal\\\" data-target=\\\"#miModalEdit\\\" data-row-id=\\\"\"+ row.idEmpItem +\"\\\" >\" 
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">mode_edit</i></<button> \"
                     /*+ \"<button type=\\\"button\\\" class=\\\"btn btn-sm command-delete\\\" data-row-id=\\\"\" + row.id + \"\\\"> \"
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">delete</i></button> \"*/
                     + \"<br>\"
                     + \"<button type=\\\"button\\\" class=\\\"btn btn-sm command-view\\\" data-toggle=\\\"modal\\\" data-target=\\\"#miModalVer\\\"  data-row-id=\\\"\" + row.idEmpItem + \"\\\"> \"
                     + \" <i class=\\\"material-icons\\\" style=\\\"color:#0275D8\\\">visibility</i></button> \"
                     + \"</div>\"
           }

        }

  }).on(\"loaded.rs.jquery.bootgrid\", function(){

    /* Executes after data is loaded and rendered */
    datosEmpleadoItemNom.find(\".command-edit\").on(\"click\", function(e){
       editarEmpleadoItemNom(\$(this).data(\"row-id\"));

    }).end().find(\".command-view\").on(\"click\",function(e){

        verDespreNomina(\$(this).data(\"row-id\"));
    });
});


});



function verDespreNomina(idNomina){
    \$.ajax({
        url:'index_blank.php?component=DespreNomina&method=verDespreNomina',
        data:'id='+idNomina,
        success: function(msm){
           \$(\"#agregarEmpleadoItemNom\").html(msm);
           \$('#miModalVer').modal(\"show\");
        }
    });
}

function agregarDespreNomina(id_Nomina){
    \$.ajax({
        url:'index_blank.php?component=DespreNomina&method=agregarDespreNomina&idMenu='+";
        // line 91
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        type: \"POST\",
        success: function(msm){

             \$(\"#agregarEmpleadoItemNom\").html(msm);
             \$('#miModalAdd').modal(\"show\");
             
        }
    });
}

function editarEmpleadoItemNom(id){
    
     \$.ajax({
        url:'index_blank.php?component=DespreNomina&method=editarDespreNomina',
        type: \"POST\",
        data:'id='+id+'&idMenu='+";
        // line 107
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ",
        success: function(msm){

            \$(\"#agregarEmpleadoItemNom\").html(msm);
            \$('#miModalEdit').modal(\"show\");

        }
    });
}

function eliminarDespreNomina(id){
    //if(confirm('Realmente desea eliminar el Nomina '+nombre+' ?')){
      
        \$.ajax({
          type: \"POST\",
          url: 'index_blank.php?component=Nomina&method=eliminarNomina&id='+id+'&idMenu='+";
        // line 122
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
        return "listadoDespreNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  158 => 122,  140 => 107,  121 => 91,  72 => 45,  45 => 21,  26 => 5,  19 => 1,);
    }
}
