=== Pds Block Visibility ===
Contributors:      The WordPress Contributors
Tags:              block
Tested up to:      6.0
Stable tag:        0.1.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

# PDS Block Visibility

PDS Block Visibility és un plugin per a WordPress que et permet controlar la visualització dels blocs de Gutenberg en funció del tipus de dispositiu del visitant. Amb aquest plugin, pots decidir fàcilment si un bloc ha de ser visible en dispositius mòbils (telèfons) o en ordinadors d'escriptori.

## Funcions

- **Visibilitat per Dispositiu:**  
  Activa o desactiva la visualització dels blocs per a telèfons i escriptoris mitjançant atributs específics del bloc.

- **Integració amb Gutenberg:**  
  S'integra perfectament amb l'editor de Gutenberg, permetent-te gestionar les opcions de visibilitat directament des de l'editor de pàgines o publicacions.

- **Optimització del Rendiment:**  
  Utilitza la funció `wp_is_mobile()` de WordPress per a una detecció ràpida i eficient dels dispositius.

## Instal·lació

1. **Descarrega o Clona el Repositori:**  
   Col·loca la carpeta `pds-block-visibility` dins del directori `wp-content/plugins/` de la teva instal·lació de WordPress.

2. **Activa el Plugin:**  
   Accedeix al tauler d'administració de WordPress, ves a **Plugins > Plugins Instal·lats** i activa **PDS Block Visibility**.

## Ús

1. **Afegeix el Bloc a Gutenberg:**  
   A l'editor de Gutenberg, busca el bloc **PDS Block Visibility** i afegeix-lo a la teva publicació o pàgina.

2. **Configura les Opcions de Visibilitat:**  
   A la barra lateral del bloc, ajusta els següents atributs:
   - **Visibilitat (Telèfon):** Activa o desactiva la visualització del bloc en dispositius mòbils.
   - **Visibilitat (Escriptori):** Activa o desactiva la visualització del bloc en ordinadors.

   *Nota: Assegura't que els noms dels atributs en la configuració del bloc coincideixin amb els definits al codi del plugin (per exemple, utilitza "visibilityPhone" de manera coherent).*



## Notes per a Desenvolupadors

- **Detecció de Dispositius:**  
  El plugin utilitza `wp_is_mobile()` per a una detecció bàsica de dispositius mòbils. Si necessites una detecció més precisa (per exemple, distingir entre telèfons i tauletes), pots considerar integrar una llibreria més avançada com [Mobile Detect](https://github.com/serbanghita/Mobile-Detect).

- **Ampliació de Funcionalitats:**  
  Encara que actualment el plugin suporta la visibilitat per a telèfons i escriptoris, pots ampliar-lo per incloure altres tipus de dispositius (com ara tauletes) afegint nous atributs en el fitxer `block.json` (per exemple, `"visibilityTablet"`) i modificant el render callback al fitxer `block-visibility.php`.

- **Gestió d'Actius:**  
  El plugin enfileja scripts i estils tant per a l'editor com per al frontend. L'ús de `filemtime()` assegura que els usuaris sempre carreguin la versió més recent dels actius durant el desenvolupament.

## Canvis

### 1.0.0
- Llançament inicial de PDS Block Visibility.
- Afegit el control de visibilitat per dispositiu per als blocs de Gutenberg.
- Implementada la detecció de dispositius amb `wp_is_mobile()`.

## Llicència

Aquest plugin està llicenciat sota la GPL-2.0-or-later. Consulta la [GNU General Public License](https://www.gnu.org/licenses/gpl-2.0.html) per a més detalls.

## Suport

Si tens algun problema o suggeriment per a millorar el plugin, obre una incidència al repositori de GitHub o contacta amb l'autor del plugin.

## Autor

Ricard PDS