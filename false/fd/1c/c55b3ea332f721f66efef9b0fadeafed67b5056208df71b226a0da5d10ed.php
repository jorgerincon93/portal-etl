<?php

/* agregarNomina.html */
class __TwigTemplate_fd1cc55b3ea332f721f66efef9b0fadeafed67b5056208df71b226a0da5d10ed extends Twig_Template
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
    \t\t\t  <label for=\"codigo\">Codigo</label>    \t\t\t
    \t\t\t  <input type=\"text\" class=\"form-control\" name=\"codigo\" id=\"codigo\" aria-describedby=\"codigo\" placeholder=\"Codigo\"   value=\"\" required/>
  \t\t\t  </div>
          <div class=\"col-md-6 mb-3\">
            <label for=\"selectTipo\">Tipo</label>
             <select class=\"form-control\" id=\"selectTipo\" name=\"selectTipo\" required>
               ";
        // line 24
        echo (isset($context["select_tipo"]) ? $context["select_tipo"] : null);
        echo "
             </select>   
          </div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"descript\">Descripcion</label>
          <input type=\"text\" class=\"form-control\" name=\"descript\" id=\"descript\" aria-describedby=\"descript\" placeholder=\"Descripcion\" value=\"\" required />
          <span class=\"help-block\" id=\"error\"></span>
        </div>  
  \t\t</div>
  \t
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 34
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 35
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
            url:'index_blank.php?component=Nomina&method=guardarNomina',
            type: \"POST\",
            data:\$('#envioDatos').serialize(),
            success: function (msm){

                \$('#miModalAdd').modal('hide');
               // location.reload('index_blank.php?component=Nomina&method=mostrarNomina'+";
        // line 63
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
        return "agregarNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 63,  65 => 35,  61 => 34,  48 => 24,  29 => 8,  19 => 1,);
    }
}
