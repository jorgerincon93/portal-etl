<?php

/* generarCetiLaSulbPdf.html */
class __TwigTemplate_0c2a95d18cd4b32e8eecda0053b646a63be1e54cbae4281832db48e2013213a4 extends Twig_Template
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
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["COMODIN"]) ? $context["COMODIN"] : null), "html", null, true);
        echo "

<div id=\"certiLabr\">
        <form method=\"POST\" name=\"ceLaboral\" id=\"ceLaboral\" action=\"crearPDF.php\">
        \t<div id=\"certiLab\">
        \t\t<td>
        \t\t\t<img class=\"membre\" src=\"imagenes/membrete.png\">
        \t\t</td>
        \t\t<table align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
        \t\t\t<tr>
        \t\t\t  <td>\t
        \t\t\t\t<center>CERTIFICA:</center>
        \t\t\t  </td> \t
        \t\t\t</tr>\t
            \t\t<tr>
\t\t\t\t\t\t<td>\t\t\t\t\t\t\t
            \t\t   \t    <br><br><br>
\t\t\t\t\t\t\t<p>Que  el  señor(a) ";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "nombreUsuario", array()), "html", null, true);
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
\t\t\t\t\t\t</td>
\t\t\t\t\t</tr>
\t\t\t\t\t<tr>\t
\t\t\t\t\t\t<td>
\t\t\t\t\t\t\t<u>Salariales: De acuerdo  con lo establecido en el Art.  128 del código sustantivo del trabajo.</u>\t
\t\t\t\t\t\t\t<br><br>
\t\t\t\t\t        <br><br>
\t\t\t\t\t    </td>
\t\t\t\t\t</tr>
\t\t\t\t\t<tr>
\t\t\t\t\t    <td>        
\t\t\t\t\t        <p>Salario Ordinario: ";
        // line 35
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "salarioBasico", array()), "html", null, true);
        echo "</p>
\t\t\t\t\t        <br><br>
\t\t\t\t\t        <u>No salariales: De  acuerdo con lo  establecido en el Arti.128 del código sustantivo de trabajo.</u>
\t\t\t\t\t        <br><br>
\t\t\t\t\t        <p>Bono de servicio:\t\t\t\t\t";
        // line 39
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "bonoAdicional", array()), "html", null, true);
        echo "</p>
\t\t\t\t\t        <p>Medio de transporte:\t\t\t\t";
        // line 40
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "bonoTransporte", array()), "html", null, true);
        echo "</p><br><br>
\t\t\t\t\t        <p>Para un total mensual de ";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "totalLetra", array()), "html", null, true);
        echo " Pesos M/cte. ( \$";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "totalSal", array()), "html", null, true);
        echo ").</p><br><br><br>
\t\t\t\t\t        <p>Se expide a solicitud del interesado en Bogotá, a los ";
        // line 42
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
\t\t\t<input type=\"hidden\" name=\"datosCertificado\" id=\"datosCertificado\" value=\"\">
        </form>           
</div>

<script>

\$().ready(function(){
    
\t\$(\"#ceLaboral\").validate();
   
     var shelf_clone = \$(\"#certiLab\").clone(); 
     var shelf = shelf_clone.prop(\"outerHTML\");
     var datos = \$(\"#datosCertificado\").val(shelf);
     \$(\"#ceLaboral\").submit();
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
        return "generarCetiLaSulbPdf.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 42,  92 => 41,  88 => 40,  84 => 39,  77 => 35,  58 => 21,  52 => 20,  46 => 19,  40 => 18,  19 => 1,);
    }
}
