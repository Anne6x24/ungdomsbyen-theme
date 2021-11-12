

<?php
get_header();
?>

    <section id="primary" class="content-area">
        <main id="single" class="site-main">
        <button class="luk">Tilbage</button>
        <section class="indhold">
            <article class="enkeltKursus">
                <p class="kortbeskrivelse"></p>
                <h4 class="klassetrin">Klassetrin:</h4>
                <h4 class="varighed">Varighed:</h4>
                <h4 class="fag">Fag:</h4>
                <h4 class="deltagere">Antal deltagere:</h4>
                <h4 class="indhold">Indhold:</h4>
                <p class="pris"></p>
                <button class="book"></button>
                
                <p class="navn"></p>
            </article>
        </section>
    </main>

    <script>
        //find parametre (variabler) i url'en
       // let urlParams = new URLSearchParams(window.location.search);
        //returner værdien for variablen "id" 
       // let id = urlParams.get("id");
        let kursus;
        document.addEventListener("DOMContentLoaded", getJson);

        async function getJson() {
            console.log("id er", <?php echo get_the_ID() ?>);
            //hent en enkelt ret udfra id'et
            let jsonData = await fetch("http://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/kursus/" + <?php echo get_the_ID() ?>);
            kursus = await jsonData.json();
            visKursus();
            console.log(kursus);
        }
        //vis data om retten
        function visKursus() {
            
            document.querySelector(".kortbeskrivelse").innerHTML = kursus.beskrivelse;
            document.querySelector(".klassetrin").innerHTML = kursus.antal_deltagere;
            document.querySelector(".varighed").innerHTML = kursus.varighed;
            document.querySelector(".indhold").innerHTML = kursus.indhold;
            document.querySelector(".pris").innerHTML = kursus.pris;
            
        }

        document.querySelector(".luk").addEventListener("click", () => {
            //link tilbage til den foregående side på "luk" knappen
            history.back();
        })
    </script>

        
    </section><!-- #primary -->

<?php

get_footer(); ?>
<?php get_sidebar();?>


