<?php

/* editarEmpleado.html */
class __TwigTemplate_dac31243694cc0532fa6870a8157146185d58e9c5429dae0703e76973aed8090 extends Twig_Template
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
<div class=\"modal fade\" id=\"miModalEdit\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"miModalEdit\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-lg\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"miModalEdit\">";
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
    \t\t\t<label for=\"empleado\">Empleado</label>    \t\t\t
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Nombre Empleado\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "nombre", array()), "html", null, true);
        echo "\" required/>
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectTipoDoc\">Tipo Documento</label>
          <select class=\"form-control\" id=\"selectTipoDoc\" name=\"selectTipoDoc\" required>
            ";
        // line 24
        echo (isset($context["select_tipoDoc"]) ? $context["select_tipoDoc"] : null);
        echo "
          </select>   
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"docu\">Documento</label>
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"docu\" id=\"docu\" aria-describedby=\"docu\" placeholder=\"Numero Documento\" value=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "numeroDocumento", array()), "html", null, true);
        echo "\" required />
    \t\t\t<span class=\"help-block\" id=\"error\"></span>
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectArea\">Area</label>
          <select class=\"form-control\" id=\"selectArea\" name=\"selectArea\" required>
            ";
        // line 37
        echo (isset($context["select_area"]) ? $context["select_area"] : null);
        echo "
          </select>   
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"email\">Correo Electronico</label>
    \t\t\t<input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" aria-describedby=\"email\" placeholder=\"Correo\" value=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "email", array()), "html", null, true);
        echo "\" required />
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selcetRol\">Rol</label>
          <select class=\"form-control\" name=\"selcetRol\" id=\"selcetRol\" required>
            ";
        // line 49
        echo (isset($context["select_rol"]) ? $context["select_rol"] : null);
        echo "
          </select>   
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"selectEstado\">Estado</label>
    \t\t\t<select class=\"form-control\" name=\"selectEstado\" id=\"selectEstado\" required>
    \t\t\t\t";
        // line 57
        echo (isset($context["select_estado"]) ? $context["select_estado"] : null);
        echo "
    \t\t\t</select> \t
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
            <label for=\"selectTipoContra\">Tipo Contrato</label>
            <select class=\"form-control\" name=\"selectTipoContra\" id=\"selectTipoContra\" required>
                ";
        // line 63
        echo (isset($context["selectTipoContra"]) ? $context["selectTipoContra"] : null);
        echo "
            </select>   
         </div>
  \t\t</div>
      <div class=\"row\">         
            <div class=\"col-md-6 mb-3\">
              <label for=\"fechIngreCom\">Fecha Ingreso Compañia</label>
               <div class=\"input-append date form_datetime\" >
                 <input type=\"text\" class=\"form-control\" name=\"fechIngreCom\" id=\"fechIngreCom\" data-date-format=\"dd/mm/yyyy\" value=\"";
        // line 71
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "fechaIngreEmple", array()), "html", null, true);
        echo "\" readonly>
                     <span class=\"add-on\"><i class=\"icon-remove\"></i></span>
                     <span class=\"add-on\"><i class=\"icon-calendar\"></i></span>
                </div>
              </div>
               <div class=\"col-md-6 mb-3\">
                    <label for=\"cargo\">Cargo</label>          
                     <select class=\"form-control\" name=\"selectCargo\" id=\"selectCargo\" required>
                        ";
        // line 79
        echo (isset($context["selectCargo"]) ? $context["selectCargo"] : null);
        echo "
                     </select>
                </div>
        </div>
      
            <input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
        // line 84
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEmpleado"]) ? $context["datosEmpleado"] : null), "id", array()), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 85
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 86
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
      
  \t\t
        </form>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
        <button type=\"submit\" form=\"envioDatos\" class=\"btn btn-primary\">Guardar Empleado</button>
      </div>
    </div>
  </div>
</div>


<script>
\t \$().ready(function(){
    \$(\"#envioDatos\").validate();
  });

  //\$('#fechIngreCom').datetimepicker();
  \$(\".form_datetime\").datetimepicker({
        format: \"yyyy/mm/dd\",
        autoclose: true,
        todayBtn: true
        //startDate: \"2013-02-14 10:00\",
        //minuteStep: 10
    });


function usuarioValido(){
           
    var empleado=\$('#empleado').val();                
    for(var i=0; i<empleado.length; i++){
      if(empleado[i]==' '){
        return false;
      }
    }
    return true;
}

  function EnviarFormulario(){
    
      var request = \$.ajax({
           url:'index_blank.php?component=Empleado&method=guardarEmpleado',
          type: \"POST\",
          data:\$('#envioDatos').serialize(),
      dataType: \"html\"         
    });
    request.done(function(msm) {

        \$('#miModal').modal('hide');
        location.reload('index_blank.php?component=Empleado&method=mostrarEmpleado'+";
        // line 137
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ");
    });

}

  function nombreValido(){
    var usuario = \$('#empleado').val();
    var ident = \$('#id').val();
    var responder='';
                
    \$.ajax({
      url:'index_blank.php?component=Usuario&method=validarRepetido',
      type: \"POST\",
      async:false,
      data:'login='+usuario+'&id='+ident,
      success: function (msm){
        responder=msm;
      }
    });     
               //alert(\$.trim(responder));
    return \$.trim(responder);
  }

  function documentoValido(){
    var documento = \$('#docu').val();
    var ident = \$('#id').val();
    var responder='';
                
    \$.ajax({
      url:'index_blank.php?component=Empleado&method=validarDocumento',
      type: \"POST\",
      async:false,
      data:'numeroDocumento='+documento+'&id='+ident,
      success: function (msm){
        responder=msm;
      }
    });                 
    return \$.trim(responder);
  }

</script>
</script>";
    }

    public function getTemplateName()
    {
        return "editarEmpleado.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  200 => 137,  146 => 86,  142 => 85,  138 => 84,  130 => 79,  119 => 71,  108 => 63,  99 => 57,  88 => 49,  80 => 44,  70 => 37,  61 => 31,  51 => 24,  43 => 19,  29 => 8,  19 => 1,);
    }
}
