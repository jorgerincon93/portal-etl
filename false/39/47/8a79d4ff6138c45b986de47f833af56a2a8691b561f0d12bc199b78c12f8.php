<?php

/* certiLaboral.html */
class __TwigTemplate_39478a79d4ff6138c45b986de47f833af56a2a8691b561f0d12bc199b78c12f8 extends Twig_Template
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
\t";
        // line 2
        echo (isset($context["generar"]) ? $context["generar"] : null);
        echo "
\t<input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 3
        echo (isset($context["idMenu"]) ? $context["idMenu"] : null);
        echo "\">
<script>
    
    \$().ready(function(){
\t\t\$(\"#envioDatos\").validate();
\t\t\$(\"#miModalDespre\").modal(\"show\");
    });
        
\tfunction generarCetiLaSulbPdf(){
\t\t
\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl:'index_blank.php?component=CertiLabo&method=generarCetiLaSulbPdf',
\t\t\t\t\t\ttype: \"POST\",
\t\t\t\t\t\tdata:\$('#envioDatos').serialize() + '&idMenu='+ \$(\"#idMenu\").val(),
\t\t\t\t\t\tsuccess: function (msm){\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\$('#componenteCentral').html(msm);
\t\t\t\t\t\t}
\t\t\t\t\t});
\t}\t

\tfunction generarCetiLabPdf(){
\t\t
\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl:'index_blank.php?component=CertiLabo&method=generarCetiLabPdf',
\t\t\t\t\t\ttype: \"POST\",
\t\t\t\t\t\tdata:\$('#envioDatos').serialize() + '&idMenu='+ \$(\"#idMenu\").val(),
\t\t\t\t\t\tsuccess: function (msm){\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\$('#componenteCentral').html(msm);
\t\t\t\t\t\t\t\$(\"#datosCertificado\").hide();
\t\t\t\t\t\t}
\t\t\t\t\t});
\t}

\tfunction generarDesprNomina(){
\t\t
\t\t
\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl:'index_blank.php?component=CertiLabo&method=generarDesprNomina',
\t\t\t\t\t\ttype: \"POST\",
\t\t\t\t\t\tdata:\$('#envioDatos').serialize() + '&idMenu='+ \$(\"#idMenu\").val(),
\t\t\t\t\t\tsuccess: function (msm){\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\$('#componenteCentral').html(msm);\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\$(\"#datosCertificado\").hide();
\t\t\t\t\t\t}
\t\t\t\t\t});
\t}
\t

</script>";
    }

    public function getTemplateName()
    {
        return "certiLaboral.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 3,  23 => 2,  19 => 1,);
    }
}
