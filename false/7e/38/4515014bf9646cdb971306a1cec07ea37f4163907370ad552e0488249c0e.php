<?php

/* verEmpleado.html */
class __TwigTemplate_7e384515014bf9646cdb971306a1cec07ea37f4163907370ad552e0488249c0e extends Twig_Template
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
       
  \t\t<div class=\"row\">       
        \t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"empleado\">Empleado</label>    \t\t\t
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Nombre Empleado\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "nombre", array()), "html", null, true);
        echo "\" readonly/>
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectTipoDoc\">Tipo Documento</label>
           <input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Tipo Documento\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "tipoDocumento", array()), "html", null, true);
        echo "\" readonly/>
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"docu\">Documento</label>
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"docu\" id=\"docu\" aria-describedby=\"docu\" placeholder=\"Numero Documento\" value=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "numeroDocumento", array()), "html", null, true);
        echo "\" readonly />
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectArea\">Area</label>
           <input type=\"text\" class=\"form-control\" name=\"area\" id=\"area\" aria-describedby=\"area\" placeholder=\"Tipo Documento\" value=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "area", array()), "html", null, true);
        echo "\" readonly/>
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"email\">Correo Electronico</label>
    \t\t\t<input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" aria-describedby=\"email\" placeholder=\"Correo\" value=\"";
        // line 36
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "email", array()), "html", null, true);
        echo "\" readonly />
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selcetRol\">Rol</label>
          <input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Tipo Documento\" value=\"";
        // line 40
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "rol", array()), "html", null, true);
        echo "\" readonly/>
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"selectEstado\">Estado</label>
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Tipo Documento\" value=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "estado", array()), "html", null, true);
        echo "\" readonly/>
  \t\t\t</div>
         <div class=\"col-md-6 mb-3\">
            <label for=\"selectTipoContra\">Tipo Contrato</label>
            <input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Tipo Documento\" value=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "tipoContrato", array()), "html", null, true);
        echo "\" readonly/>   
         </div>
  \t\t</div>
  \t\t<div class=\"row\">        
            <div class=\"col-md-6 mb-3\">
              <label for=\"fechIngreCom\">Fecha Ingreso Compañia</label>
                <div class=\"input-append date form_datetime\" >
                     <input type=\"text\" class=\"form-control\" name=\"fechIngreCom\" id=\"fechIngreCom\" value=\"";
        // line 57
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "fechaIngreEmple", array()), "html", null, true);
        echo "\" readonly>
                     <span class=\"add-on\"><i class=\"icon-remove\"></i></span>
                     <span class=\"add-on\"><i class=\"icon-calendar\"></i></span>
                </div>             
            </div>
            <div class=\"col-md-6 mb-3\">
               <label for=\"cargo\">Cargo</label>          
               <input type=\"text\" class=\"form-control\" name=\"cargo\" id=\"cargo\" aria-describedby=\"cargo\" placeholder=\"Cargo\" value=\"";
        // line 64
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "cargo", array()), "html", null, true);
        echo "\" readonly/>
            </div>       
      </div>
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
        // line 81
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "jerarquia", array()), "html", null, true);
        echo "</td>
\t\t</tr>
                
\t\t<tr>
\t\t\t<td class=\"tituloAlineado\">Ultimo Ingreso </td>
\t\t\t<td>";
        // line 86
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "ultimoIngreso", array()), "html", null, true);
        echo "</td>
\t\t</tr>
\t\t
\t</table>-->
<script>
function regresar(){
\t\$.ajax({
\t\turl:'index_blank.php?component=Empleado&method=listadoEmpleado',
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
        return "verEmpleado.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  140 => 86,  132 => 81,  112 => 64,  102 => 57,  92 => 50,  85 => 46,  76 => 40,  69 => 36,  60 => 30,  53 => 26,  44 => 20,  37 => 16,  19 => 1,);
    }
}
