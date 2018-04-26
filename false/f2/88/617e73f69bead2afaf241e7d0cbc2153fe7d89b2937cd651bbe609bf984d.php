<?php

/* plantillaFooter.html */
class __TwigTemplate_f288617e73f69bead2afaf241e7d0cbc2153fe7d89b2937cd651bbe609bf984d extends Twig_Template
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
<div>
    (c)Derechos Reservados Mundo Limpieza 2016 (v 0.2)
</div>";
    }

    public function getTemplateName()
    {
        return "plantillaFooter.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
