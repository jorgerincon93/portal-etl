<?php

/* plantillaContenido.html */
class __TwigTemplate_c1b7ba271b89fdbce4090a46ece0661f1997df3bc021d0c6754749df235f5c57 extends Twig_Template
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
<table class=\"tablaContenido\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    <tr>
\t<td style=\" vertical-align: top;\">";
        // line 4
        echo (isset($context["menu_general"]) ? $context["menu_general"] : null);
        echo "</td>\t\t\t\t\t
    </tr>
    <tr>\t\t
        <td style=\" vertical-align: top;\">
            <div id=\"componenteCentral\">
             ";
        // line 9
        echo (isset($context["contenido_home"]) ? $context["contenido_home"] : null);
        echo "
            </div>
        </td>
    </tr>
    
</table>
<script>
   
    function alerta(numContra,nomClie,fechaFin,dias){
        
        \$.jAlert({'title': 'Contratos Por Vencer',
                  'content': 'EL Contrato ' + numContra + ' del Cliente ' + nomClie + ' vence en ' + dias + ' dias( ' +fechaFin + ' )',
                  'theme': 'blue',
                  'btns': { 'text': 'close' }
        });  
        
    }
     
    function alertaProd(nombre,conteo){
        
        \$.jAlert({'title': 'Productos por Agotar',
                  'content': 'EL Producto ' + nombre + ' Esta proximo a agotarce. ' + 'Numero de Productos Disponibles: ' +conteo,
                  'theme': 'blue',
                  'btns': { 'text': 'close' }
        });  
        
    }                                            
    
     \$(document).ready(verifProd );
     
    function verifProd(){ 
        
       
        \$.ajax({
            url:'index_blank.php?component=Home&method=prodCant',
                    type: \"POST\",
                    data: \"nada\",
                    success: function (msm){
                        
                      var productos = JSON.parse(msm);
                     for(var i=0;i<=10;i++){
                                                  
                         alertaProd(productos[i].nombre,productos[i].conteo);
                     }  
                       
                     // \$('#componenteCentral').html(msm);
                     
                    }
        });
     // }  
    }
    
    function actEstadoProductoDisp(){ 
        
       
        \$.ajax({
            url:'index_blank.php?component=Home&method=actEstadoProductoDisp',
                    type: \"POST\",
                    data: \"nada\",
                    success: function (msm){
                        
                      var productos = JSON.parse(msm);
                     for(var i=0;i<=10;i++){
                                                  
                         alerta(productos[i].numeroContrato,productos[i].nombre,
                                productos[i].totalDia,productos[i].fFin);
                     }  
                       
                     // \$('#componenteCentral').html(msm);
                     
                    }
        });
     // }  
    }      

    
</script>

";
    }

    public function getTemplateName()
    {
        return "plantillaContenido.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 9,  25 => 4,  19 => 1,);
    }
}
