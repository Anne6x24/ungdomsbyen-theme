<?php

get_header();
?>

<section id="primary" class="content-area">
    <main id="main" class="site-main">
    
    <nav id="filtrering"><button class="filter_valgt" data_cont="alle">Alle</button></nav>
    <nav id="indhold_filtrering"><button class="filter_valgt" data_cont="alle">Alle</button></nav>
    
    <section id="kursus_oversigt"></section>
    </main>
    </section>

<template>
    <article class="kasse_1">
    <h2 class="kategori"></h2>
        <h3 class="navn"></h3>
        <h4 class="kategori_2"></h4>
        <h5 class="kursus"></h5>
        <p class="beskrivelse"></p>
        <p class="pris"></p>
        <p class="henvendelse"></p>
    </article>

</template> 


<script>

        const siteUrl = "<?php echo esc_url( home_url( '/' ) ); ?>";
        let kurser = [];
        let categories = [];
        let indhold = [];
        const liste = document.querySelector("#kursus_oversigt");
        const skabelon = document.querySelector("template");
        let filterKursus = "alle";
        let filterIndhold = "alle";
        document.addEventListener("DOMContentLoaded", start);

        function start() {
            console.log("id er", <?php echo get_the_ID() ?>);
            console.log(siteUrl);
            getJson();
        }


        async function getJson() {
            //hent alle custom posttypes retter
            const url = siteUrl +"wp-json/wp/v2/kursus?per_page=100";
            //hent basis categories
            const catUrl = "http://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/categories";
             //hent custom category: hovedkategori
            const contUrl = "http://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/hovedkategori";
            let response = await fetch(url);
            let catResponse = await fetch(catUrl);
            let contResponse = await fetch(contUrl);
            kurser = await response.json();
            categories = await catResponse.json();
            indhold = await contResponse.json();
            
            visKurser();
            opretKnapper();
        }
            function opretKnapper(){
            
            categories.forEach(cat=>{
               //console.log(cat.id);
                if(cat.name != "Uncategorized"){
                document.querySelector("#filtrering").innerHTML += `<button class="filter_valgt" data-kursus="${cat.id}">${cat.name}</button>`
                
                }
            })

            indhold.forEach(cont=>{
               console.log(cont.id);
                document.querySelector("#indhold_filtrering").innerHTML += `<button class="filter_valgt" data-cont="${cont.id}">${cont.name}</button>`
            
            })

            addEventListenersToButtons();
        }

        function visKurser() {
            console.log(kurser);
            liste.innerHTML = "";
            console.log({filterKursus});
            console.log({filterIndhold});
            kurser.forEach(kursus => {
                //tjek filterRet og filterIndhold til filtrering
                if ((filterKursus == "alle"  || kursus.categories.includes(parseInt(filterKursus))) && (filterIndhold == "alle"  || kursus.indhold.includes(parseInt(filterIndhold)))) {
                    const klon = skabelon.cloneNode(true).content;
                    klon.querySelector(".kategori").innerHTML = kursus.kategori;
            klon.querySelector(".navn").innerHTML = kursus.navn;
            klon.querySelector(".beskrivelse").innerHTML = kursus.beskrivelse;
            klon.querySelector(".pris").innerHTML = kursus.pris;
            klon.querySelector(".henvendelse").innerHTML = kursus.henvendelse;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = kursus.link;
                    })
                    liste.appendChild(klon);
                }
            })

        }
         function addEventListenersToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.addEventListener("click", filtrering);
            })
             document.querySelectorAll("#indhold_filtrering button").forEach(elm => {
                elm.addEventListener("click", filtreringIndhold);
            })
        }
        
        function filtrering() {
            filterKursus = this.dataset.kursus;
            document.querySelector("h2").textContent = this.textContent;
            //fjern .valgt fra alle
            document.querySelectorAll("#filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
          
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visKurser();
        }
         function filtreringIndhold() {
            filterIndhold = this.dataset.kursus;
            document.querySelector("h2").textContent = this.textContent;
             //fjern .valgt fra alle
            document.querySelectorAll("#indhold_filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visKurser();
        }
    </script>

	</section><!-- #primary -->

<?php
get_footer();





