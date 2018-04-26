<?php

/* verDespreNomina.html */
class __TwigTemplate_3bfa845e5f3264a6964da04174b46143eb39aca8959d024a75555d0f0a033fd4 extends Twig_Template
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
          <label for=\"empleado\">Empleado</label>          
          <input type=\"text\" class=\"form-control\" aria-describedby=\"empleado\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "nombre", array()), "html", null, true);
        echo "\" readonly/>
        </div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"item\">Item</label>
           <input type=\"text\" class=\"form-control\" aria-describedby=\"item\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "descripcion", array()), "html", null, true);
        echo "\" readonly/>
        </div>
      </div>
      <div class=\"row\">
        <div class=\"col-md-6 mb-3\">
          <label for=\"valor\">Valor</label>
          <input type=\"text\" class=\"form-control\" aria-describedby=\"valor\" value=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "valor", array()), "html", null, true);
        echo "\" readonly />
        </div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"periodo\">Periodo</label>
          <input type=\"text\" class=\"form-control\" aria-describedby=\"periodo\" value=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "mesAnio", array()), "html", null, true);
        echo "\" readonly />
        </div>
      </div>
      <div class=\"row\">
        <div class=\"col-md-6 mb-3\">
          <label for=\"estado\">Estado</label>
          <input type=\"text\" class=\"form-control\" aria-describedby=\"periodo\" value=\"";
        // line 36
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "estado", array()), "html", null, true);
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
        return "verDespreNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 36,  60 => 30,  53 => 26,  44 => 20,  37 => 16,  19 => 1,);
    }
}
