<?php

/* seleccionarPeriodo.html */
class __TwigTemplate_76af5b2d19d1d5eac545e00c4367b8de6a78812a3553523d33bb22a9f45709cb extends Twig_Template
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
<div class=\"modal fade\" id=\"miModalDespre\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"miModalDespre\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-lg\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"miModalDespre\">";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["titulo"]) ? $context["titulo"] : null), "html", null, true);
        echo "</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <form class=\"container\" name=\"envioDatos\" id=\"envioDatos\" action=\"javascript:EnviarFormulario()\" method=\"POST\">


          <div class=\"col-lg-6 lg-3\">
            <!--<label for=\"intento\">Número Desprendible</label>-->
            <input type=\"text\" class=\"form-control lg\" name=\"numDespren\" id=\"numDespren\" aria-describedby=\"Número De Desprendibles\" placeholder=\"Número De Desprendibles\"/>
          </div>


          <div class=\"row\">       
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 23
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
          </div>

        </form>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
        <button type=\"submit\" form=\"envioDatos\" class=\"btn btn-primary\">Generar Desprendible</button>
      </div>
    </div>
  </div>
</div>


<script>
  \$().ready(function(){
    \$(\"#envioDatos\").validate();
    
  });
  
  function EnviarFormulario(){

    \$.ajax({
     url:'index_blank.php?component=CertiLabo&method=generarDesprNominaOK',
     type: \"POST\",
     data:\$('#envioDatos').serialize(),
     success: function (msm){
     
      \$('#componenteCentral').html(msm);
      \$(\"#miModalDespre\").hide();
      \$('.modal-backdrop').remove();
      
      
    }
  });
  }

</script>";
    }

    public function getTemplateName()
    {
        return "seleccionarPeriodo.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 24,  47 => 23,  28 => 7,  19 => 1,);
    }
}
