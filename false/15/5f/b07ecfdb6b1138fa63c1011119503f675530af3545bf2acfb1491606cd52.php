<?php

/* agregarUsuario.html */
class __TwigTemplate_155fb07ecfdb6b1138fa63c1011119503f675530af3545bf2acfb1491606cd52 extends Twig_Template
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
<div class=\"modal fade\" id=\"miModalAdd\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"miModalAdd\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-lg\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"miModalAdd\">";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["titulo_tabla"]) ? $context["titulo_tabla"] : null), "html", null, true);
        echo "</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <form class=\"container\" name=\"envioDatos\" id=\"envioDatos\" action=\"javascript:EnviarFormulario()\" method=\"POST\">
          
      <div class=\"row\">
          <div class=\"col-md-6 mb-3\">
          <label for=\"usuario\">Usuario</label>
            <input type=\"text\" class=\"form-control\" name=\"usuario\" id=\"usuario\" aria-describedby=\"usuario\" placeholder=\"Login\" value=\"\">
        </div>
          <div class=\"col-md-6 mb-3\">
          <label for=\"selectEmpleado\">Empleado</label>
          <select class=\"form-control\" name=\"selectEmpleado\" id=\"selectEmpleado\" required>
            ";
        // line 24
        echo (isset($context["selectEmple"]) ? $context["selectEmple"] : null);
        echo "
          </select>   
        </div>  
      </div>
     <div class=\"row\">
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectEstado\">Estado</label>
          <select class=\"form-control\" name=\"selectEstado\" id=\"selectEstado\" required>
            ";
        // line 32
        echo (isset($context["select_estado"]) ? $context["select_estado"] : null);
        echo "
          </select>   
        </div>  
        <div class=\"col-md-6 mb-3\">
          <label for=\"usuario\">Nombre Usuario</label>
            <input type=\"text\" class=\"form-control\" name=\"usuarioNombre\" id=\"usuarioNombre\" aria-describedby=\"usuarioNombre\" placeholder=\"Nombre Usuario\" value=\"\">
        </div>
      </div>
      <div class=\"row\">       
        <div class=\"col-md-6 mb-3\">
          <label for=\"clave\">Contraseña</label>
          <input type=\"password\" class=\"form-control\" name=\"clave\" id=\"clave\" placeholder=\"Contraseña\" value=\"\" />
        </div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"reclave\">Repetir Contraseña</label>
          <input type=\"password\" class=\"form-control\" name=\"reclave\" id=\"reclave\" placeholder=\"Repetir Contraseña\" equalTo=\"#clave\" value=\"\" />
        </div>

            <input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosUsuario"]) ? $context["datosUsuario"] : null), "id", array()), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 51
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 52
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
      </div>
      
        </form>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
        <button type=\"submit\" form=\"envioDatos\" class=\"btn btn-primary\">Guardar Usuario</button>
      </div>
    </div>
  </div>
</div>


<script>
  \$().ready(function(){
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
           
    var usuario=\$('#usuario').val();                
    for(var i=0; i<usuario.length; i++){
      if(usuario[i]==' '){
        return false;
      }
    }
    return true;
}

  function EnviarFormulario(){
    
    if(usuarioValido()){                    
      if(nombreValido()=='valido'){
        
          var request = \$.ajax({
            url:'index_blank.php?component=Usuario&method=guardarUsuario',
            type: \"POST\",
            data:\$('#envioDatos').serialize(),
            dataType: \"html\"         
          });
          request.done(function(msm) {

                \$('#miModal').modal('hide');
                location.reload('index_blank.php?component=Usuario&method=mostrarUsuarios'+";
        // line 106
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ");
          });

        
      }
      else{
        alert('El usuario que desea asignar ya se encuentra en uso.');
      }
    }
    else{
      alert('El usuario que desea asignar contiene espacios en blanco.\\nPor Favor verifique.');
    }
  }

  function nombreValido(){
    var usuario = \$('#usuario').val();
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
      url:'index_blank.php?component=Usuario&method=validarDocumento',
      type: \"POST\",
      async:false,
      data:'numeroDocumento='+documento+'&id='+ident,
      success: function (msm){
        responder=msm;
      }
    });                 
    return \$.trim(responder);
  }

</script>";
    }

    public function getTemplateName()
    {
        return "agregarUsuario.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  145 => 106,  88 => 52,  84 => 51,  80 => 50,  59 => 32,  48 => 24,  29 => 8,  19 => 1,);
    }
}
