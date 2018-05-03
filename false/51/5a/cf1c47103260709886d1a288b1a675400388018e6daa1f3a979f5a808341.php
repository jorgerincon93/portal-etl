<?php

/* editarDespreNomina.html */
class __TwigTemplate_515acf1c47103260709886d1a288b1a675400388018e6daa1f3a979f5a808341 extends Twig_Template
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

<!-- Modal -->
<div class=\"modal fade\" id=\"miModalEdit\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"miModalEdit\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-lg\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"miModalEdit\">";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["titulo_tabla"]) ? $context["titulo_tabla"] : null), "html", null, true);
        echo "</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <form class=\"container\" name=\"envioDatos\" id=\"envioDatos\" action=\"javascript:EnviarFormulario()\" method=\"POST\">
          
      <div class=\"row\">
          <div class=\"col-md-6 mb-3\">
            <label for=\"empleado\">Empleado</label>
             <select class=\"form-control\" id=\"empleado\" name=\"empleado\" required>
               ";
        // line 20
        echo (isset($context["select_empleado"]) ? $context["select_empleado"] : null);
        echo "
             </select>   
          </div>          
        <div class=\"col-md-6 mb-3\">
            <label for=\"item\">Item</label>
             <select class=\"form-control\" id=\"item\" name=\"item\" required>
               ";
        // line 26
        echo (isset($context["select_item"]) ? $context["select_item"] : null);
        echo "
             </select>   
        </div> 
      </div>
      <div class=\"row\">
        <div class=\"col-md-6 mb-3\">
            <label for=\"valor\">Valor</label>          
            <input type=\"text\" class=\"form-control\" name=\"valor\" id=\"valor\" aria-describedby=\"valor\" placeholder=\"Valor\" value=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosDespreNomina"]) ? $context["datosDespreNomina"] : null), "valor", array()), "html", null, true);
        echo "\" required/>
        </div>
        <div class=\"col-md-6 mb-3\">
            <label for=\"estado\">Estado</label>
             <select class=\"form-control\" id=\"estado\" name=\"estado\" required>
               ";
        // line 38
        echo (isset($context["select_estado"]) ? $context["select_estado"] : null);
        echo "
             </select>   
        </div> 
      </div>
      <div class=\"row\">
        <div class=\"col-md-6 mb-3\">
            <label for=\"feIni\">Fecha Inicio</label>          
            <input type=\"date\" class=\"form-control\" name=\"feIni\" id=\"feIni\" aria-describedby=\"feIni\" placeholder=\"Fecha Inicio\" value=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosDespreNomina"]) ? $context["datosDespreNomina"] : null), "fechaInicio", array()), "html", null, true);
        echo "\" required/>
        </div>
        <div class=\"col-md-6 mb-3\">
            <label for=\"feFin\">Fecha Fin</label>
            <input type=\"date\" class=\"form-control\" name=\"feFin\" id=\"feFin\" aria-describedby=\"feFin\" placeholder=\"Fecha Inicio\" value=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosDespreNomina"]) ? $context["datosDespreNomina"] : null), "fechaFin", array()), "html", null, true);
        echo "\" required/>
        </div>
      </div>
    
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 53
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 54
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idItemEmple\" id=\"idItemEmple\" value=\"";
        // line 55
        echo twig_escape_filter($this->env, (isset($context["idItemEmple"]) ? $context["idItemEmple"] : null), "html", null, true);
        echo "\" />
    
      
        </form>
    </div>  
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
        <button type=\"submit\" form=\"envioDatos\" class=\"btn btn-primary\">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script>
\t \$().ready(function(){
    \$(\"#envioDatos\").validate();
  });

function EnviarFormulario(){
    
      \$.ajax({
            url:'index_blank.php?component=DespreNomina&method=guardarDespreNomina',
            type: \"POST\",
            data:\$('#envioDatos').serialize(),
            success: function (msm){

                \$('#miModalEdit').modal('hide');
              //  location.reload('index_blank.php?component=DespreNomina&method=mostrarAdmLab'+";
        // line 83
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ");
            }
          });                  
      
    
}

</script>";
    }

    public function getTemplateName()
    {
        return "editarDespreNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 83,  103 => 55,  99 => 54,  95 => 53,  88 => 49,  81 => 45,  71 => 38,  63 => 33,  53 => 26,  44 => 20,  29 => 8,  19 => 1,);
    }
}
