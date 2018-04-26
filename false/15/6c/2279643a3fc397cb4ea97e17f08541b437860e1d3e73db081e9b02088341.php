<?php

/* plantillaMenu.html */
class __TwigTemplate_156c2279643a3fc397cb4ea97e17f08541b437860e1d3e73db081e9b02088341 extends Twig_Template
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
<ul id=\"main-menu\" class=\"sm sm-mint\">
    ";
        // line 3
        echo (isset($context["lista_menu"]) ? $context["lista_menu"] : null);
        echo "
    
    
</ul>

<script>
\$(function() {
\t\t\$('#main-menu').smartmenus({
\t\t\tsubMenusSubOffsetX: 6,
\t\t\tsubMenusSubOffsetY: -8
\t\t});
\t});


function contenido(url, component, method,opciones ){
  
    \$.ajax({
        type: \"POST\",
\t\t url: url,
\t    data:'component=' + component + '&method=' + method + '&' + opciones ,
\t    success: function(msm){
            \$('#componenteCentral').html(msm);
\t     }
    });
}



</script>";
    }

    public function getTemplateName()
    {
        return "plantillaMenu.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 3,  19 => 1,);
    }
}
