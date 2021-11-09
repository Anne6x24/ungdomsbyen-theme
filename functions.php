<?php
add_action( 'wp_enqueue_scripts', 'enqueue_important_files' );
function enqueue_important_files() {
/*hent parent stylesheet i parenttemaets mappe*/
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
?>

<main>
<button class="luk">Tilbage</button>
<section id="kursus_indhold">
    <article class="enkeltKursus">
<article class="kasse_1">
        <p class="beskrivelse_1"></p>
    </article>
    <article class="kasse_2">
        <p class="klassetrin"></p>
        <p class="varighed"></p>
        <p class="deltagere"></p>
        <p class="indhold"></p>
        <p class="indhold_b"></p>
    </article>
    <article class="kasse_3">
        <h3 class="overskrift_2"></h3>
        <p class="tekst_1"></p>
    </article>
    <article class="kasse_4">
        <h3 class="overskrift_3"></h3>
        <p class="tekst_2"></p>
    </article>
    <article class="kasse_5">
        <h3 class="overskrift_4"></h3>
        <p class="tekst_3"></p>
    </article>
    <article class="kasse_6">
        <h3 class="overskrift_5"></h3>
        <p class="tekst_4"></p>
    </article>
    </article>
</section>

</main>

<script>
        let kursus;
        document.addEventListener("DOMContentLoaded", start);
   
    async function getJson () {
        console.log("id er", <?php echo get_the_ID() ?>);
        //hent en enkelt ret udfra id et//
        let JsonData = await fetch('http://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/kursus/<?php echo get_the_ID() ?>');
        ret = await JsonData.json();
        visKursus(); 

    }

    function visKursus () {
            
            document.querySelector(".beskrivelse_1").textContent = kursus.beskrivelse;

        }

        document.querySelector(".luk")add.EventListener("click", () => {
            history.back();
        })
    


    </script>
