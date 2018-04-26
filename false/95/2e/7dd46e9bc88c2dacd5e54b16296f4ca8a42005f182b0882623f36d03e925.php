<?php

/* verNomina.html */
class __TwigTemplate_952e7dd46e9bc88c2dacd5e54b16296f4ca8a42005f182b0882623f36d03e925 extends Twig_Template
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
<div class=\"modal fade\" id=\"miModalVer\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"miModalVer\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-lg\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"miModalVer\">DETALLE EMPLEADO</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
       
       <div class=\"row\">       
        <div class=\"col-md-6 mb-3\">
          <label for=\"codigo\">Codigo</label>          
          <input type=\"text\" class=\"form-control\" aria-describedby=\"codigo\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "codigo", array()), "html", null, true);
        echo "\" readonly/>
        </div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"tioi\">Tipo</label>
           <input type=\"text\" class=\"form-control\" aria-describedby=\"tipo\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "tipo", array()), "html", null, true);
        echo "\" readonly/>
        </div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"descri\">Descripcion</label>
          <input type=\"text\" class=\"form-control\" aria-describedby=\"descri\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "descripcion", array()), "html", null, true);
        echo "\" readonly />
        </div>
       </div>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "verNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 24,  44 => 20,  37 => 16,  19 => 1,);
    }
}
