

<?php
/**
 * Block Name: Donaciones
 * This is the template that displays the image and text block.
 */

 $id = 'donaciones-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'wp-block-donaciones';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> on">    
  <div class="donacion">
    <form action="" id="resultado">
      <button id="quiero-donar">
        <a onclick="displayForm()" class="quiero-donar"><?php _e('Quiero donar', 'PDP'); ?><i class="ico ico-cuore"></i></a>
      </button>
    </form>

    <div id="display" class="hide postal-code">
      <input id="numb" maxlength="5" min="0" max="99999" placeholder="<?php _e('Entre su código postal', 'PDP'); ?>" />
      <button type="button" onclick="postalCode()"><?php _e('Validar', 'PDP'); ?></button>
      <p id="text"></p>
    </div>
  </div>
  <div id="postal" class="hide postalcode">
    <br />
    <button id="show-more" onclick="showFunction()"><?php _e('¿Por que te pedimos el código postal?', 'PDP'); ?></button>
    <p id="porque" class="hide text-left"><?php _e('Tu ayuda se presta desde los 80 centros de San Juan de Dios repartidos por la geografía española, y por ello, te pedimos que nos facilites tu código postal, para poder remitirte a la Obra Social más próxima a tu zona.', 'PDP');?></p>
  </div>
</div>
<script>

document.getElementById("quiero-donar").disabled = true;

function displayForm() {
  var show = document.getElementById("display");
  var why = document.getElementById("postal");
  show.classList.toggle("hide");
  why.classList.toggle("hide");
}

function showFunction() {
  var buttonOn = document.getElementById("show-more");
  var element = document.getElementById("porque");
  element.classList.toggle("hide");
  buttonOn.classList.toggle("on");
}

function postalCode() {
  let y = document.getElementById("numb").value;
  x =  y.substring(0, 2);
 
 const zoneA = ["03","07","08","12","17","22","25","30","43","44","46","50"];
 const zoneB = ["02","04","06","10","11","13","14","16","18","21","23","29","35","38","41","45","51","52"];
 const zoneC = ["01","05","09","15","19","20","24","26","27","28","31","32","33","34","36","37","39","40","42","47","48","49"];
  
 let text;
  
  if (isNaN(x) || x < 1 ) {
    text = "valla... prueba con un número entero de cinco cifras";
    document.getElementById("text").innerHTML = text;
    
  } else if( zoneA.includes(x)){
    url = "https://solidaritat.santjoandedeu.org/colabora/socios/?lang=es";
    text = "";
    window.open(url, '_blank');
  
  } else if( zoneB.includes(x)){
    // url = "https://www.sjd.es/estumomento/?q=/#donar";
    url = "https://solidaridad.sjd.es/?q=/#donar";
    text = "";
    window.open(url, '_blank');
      
  } else if( zoneC.includes(x)){
    url = "https://obrasocialsanjuandedios.es/quiero-donar/";
    text = "";
    window.open(url, '_blank');
    
  } else {
  	text = "<?php _e('No reconocemos el código postal, inténtelo de nuevo', 'PDP'); ?>";
  }
  
  document.getElementById("resultado").action = url;
  document.getElementById("resultado").classList.remove("hide");
  document.getElementById("quiero-donar").disabled = false;
  document.getElementById("text").innerHTML = text;
  document.getElementById("display").classList.toggle("hide");
  document.getElementById("<?php echo esc_attr($id); ?>").classList.toggle("ON");
  
}

</script>

</div>