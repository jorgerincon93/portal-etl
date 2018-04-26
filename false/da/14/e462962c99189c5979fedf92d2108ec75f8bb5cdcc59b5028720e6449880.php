<?php

/* editarUsuario.html */
class __TwigTemplate_da14e462962c99189c5979fedf92d2108ec75f8bb5cdcc59b5028720e6449880 extends Twig_Template
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
    \t\t\t<label for=\"usuario\">Usuario</label>
            ";
        // line 19
        if (((isset($context["opcion"]) ? $context["opcion"] : null) == "editar")) {
            echo " 
    \t\t\t   <input type=\"text\" class=\"form-control\" name=\"usuario\" id=\"usuario\" aria-describedby=\"usuario\" placeholder=\"Login\" readonly value=\"";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosUsuario"]) ? $context["datosUsuario"] : null), "login", array()), "html", null, true);
            echo "\"/>             
             ";
        } else {
            // line 22
            echo "             <input type=\"text\" class=\"form-control\" name=\"usuario\" id=\"usuario\" aria-describedby=\"usuario\" placeholder=\"Login\"     value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosUsuario"]) ? $context["datosUsuario"] : null), "login", array()), "html", null, true);
            echo "\"/>
            ";
        }
        // line 23
        echo " 
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectEstado\">Estado</label>
          <select class=\"form-control\" name=\"selectEstado\" id=\"selectEstado\" required>
            ";
        // line 28
        echo (isset($context["select_estado"]) ? $context["select_estado"] : null);
        echo "
          </select>   
        </div>
  \t\t</div>
      <div class=\"row\"> 
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectEmpleado\">Empleado</label>
          <select class=\"form-control\" name=\"selectEmpleado\" id=\"selectEmpleado\" required>
            ";
        // line 36
        echo (isset($context["selectEmple"]) ? $context["selectEmple"] : null);
        echo "
          </select>   
        </div>  
        <div class=\"col-md-6 mb-3\">
          <label for=\"intento\">Intento Ingreso</label>
          <input type=\"text\" class=\"form-control\" name=\"intento\" id=\"intento\" aria-describedby=\"intento\" placeholder=\"Intento Ingreso\" value=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosUsuario"]) ? $context["datosUsuario"] : null), "intento", array()), "html", null, true);
        echo "\" />
        </div>
      </div>
  \t\t<div class=\"row\">\t        
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"clave\">Contraseña</label>
    \t\t\t<input type=\"password\" class=\"form-control\" name=\"clave\" id=\"clave\" placeholder=\"Contraseña\" value=\"\" />
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"reclave\">Repetir Contraseña</label>
          <input type=\"password\" class=\"form-control\" name=\"reclave\" id=\"reclave\" placeholder=\"Repetir Contraseña\" equalTo=\"#clave\" value=\"\" />
        </div>
      </div>
      <div class=\"row\">       

            <input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosUsuario"]) ? $context["datosUsuario"] : null), "id", array()), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 57
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 58
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
      </div>
  \t\t
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
\t\$().ready(function(){
\t\t\$(\"#envioDatos\").validate();
\t});

\$(\".form_datetime\").datetimepicker({
        format: \"yyyy/mm/dd\",
        autoclose: true,
        todayBtn: true,
        //startDate: \"2013-02-14 10:00\",
        minuteStep: 10
});

function usuarioValido(){
           
\t\tvar usuario=\$('#usuario').val();                
\t\tfor(var i=0; i<usuario.length; i++){
\t\t\tif(usuario[i]==' '){
\t\t\t\treturn false;
\t\t\t}
\t\t}
\t\treturn true;
}

\tfunction EnviarFormulario(){
\t\t
\t\tif(usuarioValido()){                    
\t\t\t//if(nombreValido()=='valido'){
\t\t\t//\tif(documentoValido()=='valido'){
\t\t\t\t\tvar request = \$.ajax({
\t\t\t\t\t\turl:'index_blank.php?component=Usuario&method=guardarUsuario',
\t\t\t\t\t\ttype: \"POST\",
\t\t\t\t\t\tdata:\$('#envioDatos').serialize(),
            dataType: \"html\"         
\t\t\t\t\t});
          request.done(function(msm) {

                \$('#miModalEdit').modal('hide');
                //location.reload('index_blank.php?component=Usuario&method=mostrarUsuarios'+";
        // line 110
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ");
          });

\t\t\t\t/*}
\t\t\t\telse{
\t\t\t\t\talert('El No. Documento que desea asignar ya se encuentra atado a otro usuario.\\nPor favor verifique.')
\t\t\t\t};
\t\t\t}
\t\t\telse{
\t\t\t\talert('El usuario que desea asignar ya se encuentra en uso.');
\t\t\t}*/
\t\t}
\t\telse{
\t\t\talert('El usuario que desea asignar contiene espacios en blanco.\\nPor Favor verifique.');
\t\t}
\t}

\tfunction nombreValido(){
\t\tvar usuario = \$('#usuario').val();
\t\tvar ident = \$('#id').val();
\t\tvar responder='';
                
\t\t\$.ajax({
\t\t\turl:'index_blank.php?component=Usuario&method=validarRepetido',
\t\t\ttype: \"POST\",
\t\t\tasync:false,
\t\t\tdata:'login='+usuario+'&id='+ident,
\t\t\tsuccess: function (msm){
\t\t\t\tresponder=msm;
\t\t\t}
\t\t});     
               //alert(\$.trim(responder));
\t\treturn \$.trim(responder);
\t}

\tfunction documentoValido(){
\t\tvar documento = \$('#docu').val();
\t\tvar ident = \$('#id').val();
\t\tvar responder='';
                
\t\t\$.ajax({
\t\t\turl:'index_blank.php?component=Usuario&method=validarDocumento',
\t\t\ttype: \"POST\",
\t\t\tasync:false,
\t\t\tdata:'numeroDocumento='+documento+'&id='+ident,
\t\t\tsuccess: function (msm){
\t\t\t\tresponder=msm;
\t\t\t}
\t\t});                 
\t\treturn \$.trim(responder);
\t}

</script>";
    }

    public function getTemplateName()
    {
        return "editarUsuario.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  165 => 110,  110 => 58,  106 => 57,  102 => 56,  84 => 41,  76 => 36,  65 => 28,  58 => 23,  52 => 22,  47 => 20,  43 => 19,  29 => 8,  19 => 1,);
    }
}
