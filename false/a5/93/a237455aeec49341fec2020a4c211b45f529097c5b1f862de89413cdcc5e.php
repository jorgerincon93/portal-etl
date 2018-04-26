<?php

/* generarCetiLabPdf.html */
class __TwigTemplate_a593a237455aeec49341fec2020a4c211b45f529097c5b1f862de89413cdcc5e extends Twig_Template
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

<div id=\"certiLabr\">
        <form method=\"POST\" name=\"ceLaboral\" id=\"ceLaboral\" action=\"crearPDF.php\" target=\"_blank\">
        \t<div id=\"certiLab\">
        \t\t<td>
        \t\t\t<img class=\"membre\" src=\"../portalEtl/imagenes/membrete.png\">
        \t\t</td>
        \t\t<table align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
        \t\t\t<tr>
        \t\t\t  <td>\t
        \t\t\t\t<center>CERTIFICA:</center>
        \t\t\t  </td> \t
        \t\t\t</tr>\t
            \t\t<tr>
\t\t\t\t\t\t<td>\t\t\t\t\t\t\t
            \t\t   \t    <br><br><br><br><br><br><br><br><br><br><br>
\t\t\t\t\t\t\t<p>Que  el  señor(a) ";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "nombre", array()), "html", null, true);
        echo ", Identificado con ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "tipoDocumento", array()), "html", null, true);
        echo "
\t\t\t\t\t\t\t";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "numeroDocumento", array()), "html", null, true);
        echo ", labora  en esta empresa desde el ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "diaIngre", array()), "html", null, true);
        echo " de 
\t\t\t\t\t\t\t";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "mesIngre", array()), "html", null, true);
        echo " de ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "anoIngre", array()), "html", null, true);
        echo ",
\t\t\t\t\t\t\tdesempeñando el cargo de ";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "cargo", array()), "html", null, true);
        echo " con un contrato a ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "tipoContrato", array()), "html", null, true);
        echo ".</p>
\t\t\t\t\t\t\t<br><br>\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t</td>
\t\t\t\t\t</tr>
\t\t\t\t\t<tr>
\t\t\t\t\t    <td>
\t\t\t\t\t    \t<br><br><br>
\t\t\t\t\t    \t<br><br><br>
\t\t\t\t\t    \t<br><br><br>
\t\t\t\t\t    \t<br><br><br>
\t\t\t\t\t        <p>Se expide a solicitud del interesado en Bogotá, a los ";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "diaSoli", array()), "html", null, true);
        echo " días del mes de ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "mesSoli", array()), "html", null, true);
        echo " de ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "anoSoli", array()), "html", null, true);
        echo ".</p><br><br>
\t\t\t\t\t\t</td>\t\t\t\t
        \t\t\t</tr>        \t\t\t
\t\t\t\t</table>
            </div>
\t\t\t<input type=\"hidden\" name=\"datosCertificado\" id=\"datosCertificado\" value=\"\">\t\t\t
        </form>           
</div>

<script>

\$().ready(function(){
    
\t\$(\"#ceLaboral\").validate();
   
     var shelf_clone = \$(\"#certiLab\").clone(); 
     var shelf = shelf_clone.prop(\"outerHTML\");
     var datos = \$(\"#datosCertificado\").val(shelf);
     \$(\"#ceLaboral\").submit();
     \$(\"#certiLabr\").hide();
});
    
        
\t/*function EnviarFormulario(){
\t\t
\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl:'index_blank.php?component=Geo&method=guardarCiudad',
\t\t\t\t\t\ttype: \"POST\",
\t\t\t\t\t\tdata:\$('#envioDatos').serialize(),
\t\t\t\t\t\tsuccess: function (msm){
\t\t\t\t\t\t\tjQuery.fancybox.open(msm);
\t\t\t\t\t\t\t//\$('#componenteCentral').html(msm);
\t\t\t\t\t\t}
\t\t\t\t\t});
\t}\t*/


</script>";
    }

    public function getTemplateName()
    {
        return "generarCetiLabPdf.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 33,  57 => 21,  51 => 20,  45 => 19,  39 => 18,  19 => 1,);
    }
}
