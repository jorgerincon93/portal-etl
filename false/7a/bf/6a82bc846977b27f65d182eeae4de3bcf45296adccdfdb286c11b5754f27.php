<?php

/* verUsuario.html */
class __TwigTemplate_7abf6a82bc846977b27f65d182eeae4de3bcf45296adccdfdb286c11b5754f27 extends Twig_Template
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
        <h5 class=\"modal-title\" id=\"miModalVer\">DETALLE USUARIO</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
       
  \t\t<div class=\"row\">
        \t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"usuario\">Usuario</label>
    \t\t\t   <input type=\"text\" class=\"form-control\" name=\"usuario\" id=\"usuario\" aria-describedby=\"usuario\" placeholder=\"Login\" readonly value=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "login", array()), "html", null, true);
        echo "\"/>             
            </div>        \t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"selectEstado\">Estado</label>
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Tipo Documento\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "estado", array()), "html", null, true);
        echo "\" readonly/>
  \t\t\t</div>
  \t\t</div>
  \t\t<div class=\"row\">\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"intento\">Intento Ingreso</label>
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"intento\" id=\"intento\" aria-describedby=\"intento\" placeholder=\"Intento Ingreso\" value=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "intento", array()), "html", null, true);
        echo "\" readonly/>
  \t\t\t</div>
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"intento\">Ultimo Ingreso</label>
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"intento\" id=\"intento\" aria-describedby=\"intento\" placeholder=\"Ultimo Ingreso\" value=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "ultimoIngreso", array()), "html", null, true);
        echo "\" readonly/>
  \t\t\t</div>
  \t\t</div>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
      </div>
    </div>
  </div>
</div>

              <!--  <tr>
\t\t\t<td class=\"tituloAlineado\">Intento </td>
\t\t\t<td></td>
\t\t</tr>
                <tr>
\t\t\t<td class=\"tituloAlineado\">Jerarquia </td>
\t\t\t<td>";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "jerarquia", array()), "html", null, true);
        echo "</td>
\t\t</tr>
                
\t\t<tr>
\t\t\t<td class=\"tituloAlineado\">Ultimo Ingreso </td>
\t\t\t<td>";
        // line 52
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "ultimoIngreso", array()), "html", null, true);
        echo "</td>
\t\t</tr>
\t\t
\t</table>-->
<script>
function regresar(){
\t\$.ajax({
\t\turl:'index_blank.php?component=usuarios&method=listadoUsuarios',
\t\ttype: \"POST\",
\t\tsuccess: function (msm){
\t\t\t\$('#componente_central').html(msm);
\t\t\t\$('.formError').remove();
\t\t}
\t});
}
</script>";
    }

    public function getTemplateName()
    {
        return "verUsuario.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 52,  80 => 47,  60 => 30,  53 => 26,  44 => 20,  37 => 16,  19 => 1,);
    }
}
