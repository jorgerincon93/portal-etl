<?php

/* editarNomina.html */
class __TwigTemplate_5d89b02eb2607fa84b2dac13d7190589ee604aa9cad700897caa84ca77e6051a extends Twig_Template
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
          
  \t\t<div class=\"row\">
        <div class=\"col-md-6 mb-3\">
            <label for=\"codigo\">Codigo</label>          
            <input type=\"text\" class=\"form-control\" name=\"codigo\" id=\"codigo\" aria-describedby=\"codigo\" placeholder=\"Codigo\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosNomina"]) ? $context["datosNomina"] : null), "codigo", array()), "html", null, true);
        echo "\" required/>
        </div>
         <div class=\"col-md-6 mb-3\">
            <label for=\"selectTipo\">Tipo</label>
             <select class=\"form-control\" id=\"selectTipo\" name=\"selectTipo\" required>
               ";
        // line 24
        echo (isset($context["select_tipo"]) ? $context["select_tipo"] : null);
        echo "
             </select>   
          </div>
        \t<div class=\"col-md-6 mb-3\">
            <label for=\"descript\">Descripcion</label>
             <input type=\"text\" class=\"form-control\" name=\"descript\" id=\"descript\" aria-describedby=\"descript\" placeholder=\"Descripcion\" value=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosNomina"]) ? $context["datosNomina"] : null), "descripcion", array()), "html", null, true);
        echo "\" required />
             <span class=\"help-block\" id=\"error\"></span>
          </div>
  \t\t</div>
      
            <input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosNomina"]) ? $context["datosNomina"] : null), "id", array()), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 36
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
      
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
\t \$().ready(function(){
    \$(\"#envioDatos\").validate();
  });

function EnviarFormulario(){
    
      \$.ajax({
            url:'index_blank.php?component=Nomina&method=guardarNomina',
            type: \"POST\",
            data:\$('#envioDatos').serialize(),
            success: function (msm){

                \$('#miModalEdit').modal('hide');
                location.reload('index_blank.php?component=Nomina&method=mostrarNomina'+";
        // line 64
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ");
            }
          });                  
      
    
}

</script>";
    }

    public function getTemplateName()
    {
        return "editarNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 64,  75 => 36,  71 => 35,  67 => 34,  59 => 29,  51 => 24,  43 => 19,  29 => 8,  19 => 1,);
    }
}
