<?php

/* agregarDespreNomina.html */
class __TwigTemplate_69c86359585ce3264bf4f1d903c63e6f3f66b0913ceffcf7326b6af6cf7d5780 extends Twig_Template
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
<div class=\"modal fade\" id=\"miModalAdd\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"miModalAdd\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-lg\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"miModalAdd\">";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["titulo_tabla"]) ? $context["titulo_tabla"] : null), "html", null, true);
        echo "</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <form class=\"container\" name=\"envioDatos\" id=\"envioDatos\" action=\"javascript:EnviarFormulario()\" method=\"POST\">
          
  \t\t<div class=\"row\">
        \t<div class=\"col-md-6 mb-3\">
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
  \t\t</div>
      <div class=\"row\">
        <div class=\"col-md-6 mb-3\">
            <label for=\"valor\">Valor</label>          
            <input type=\"text\" class=\"form-control\" name=\"valor\" id=\"valor\" aria-describedby=\"valor\" placeholder=\"Valor\" value=\"\" required/>
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
            <input type=\"date\" class=\"form-control\" name=\"feIni\" id=\"feIni\" aria-describedby=\"feIni\" placeholder=\"fecha Inicio\" value=\"\" required/>
        </div>
        <div class=\"col-md-6 mb-3\">
            <label for=\"feFin\">Fecha Fin</label>          
            <input type=\"date\" class=\"form-control\" name=\"feFin\" id=\"feFin\" aria-describedby=\"feFin\" placeholder=\"fecha Fin\" value=\"\" required/>
        </div>
      </div>
  \t
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 53
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 54
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
  \t
  \t\t
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
\t\$().ready(function(){
\t\t\$(\"#envioDatos\").validate();
\t});

function EnviarFormulario(){
\t\t
\t\t  \$.ajax({
            url:'index_blank.php?component=DespreNomina&method=guardarDespreNomina',
            type: \"POST\",
            data:\$('#envioDatos').serialize(),
            success: function (msm){

                \$('#miModalAdd').modal('hide');
               // location.reload('index_blank.php?component=Nomina&method=mostrarNomina'+";
        // line 82
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ");
            }
          });                  
\t\t\t
\t\t
}

</script>";
    }

    public function getTemplateName()
    {
        return "agregarDespreNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  121 => 82,  90 => 54,  86 => 53,  68 => 38,  53 => 26,  44 => 20,  29 => 8,  19 => 1,);
    }
}
