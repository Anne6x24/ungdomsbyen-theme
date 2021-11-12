<?php

get_header();
?>

<style>

body:not(.home) .site-content {
    background-color:#C4D2C7;
}

nav {
    text-align: center;
}

button {
    background-image: none;
    /* background-color: #019C51; */
    background-color: #FFFFFF;
    border-style: solid;
    border-width: 2px 2px 2px 2px;
    border-color: #000000;
    color: black;
    margin: 5px;
    padding: 5px 10px;
}

button:hover {
    background-image: none;
    background-color: #FAD8E8;
    
}

.brobygning {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}



#kursus_oversigt {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-top: 4rem;
    margin-left: 5rem;
    margin-right: 5rem;
}

#kursus_oversigt{
    grid-column: 1/2;
    grid-row: 1;
    background-color: #F6F2E4;
    padding: 34px;
    margin: 130px;
    margin-top: 20px;
}

#toppen {
    text-align: center;
    
}



#toppen p {
    font-size: 20px;
    margin-left: 15rem;
    margin-right: 15rem;
}



p {
    font-family: Galvji;
    font-size: 10px; 
}

h2, h4 {
    color: black;
}

h3 {
    font-size: 22px;
}

h4 {
    font-size: 15px;
}
</style>


<section id="primary" class="content-area">
    <main id="main" class="site-main">
    <section id="toppen">
    <h1>VI TILBYDER</h1>
    <p>Vi tilbyder kurser, som henvender sig til elever såvel som
undervisere, skoler og kommuner. Vores Kurser omhandler
alt fra konflikhåndtering, FN’s verdensmål og økonomi.
Nedenfor ser du en oversigt over de kurser vi tilbyder.</p>
    <div class="brobygning">
    <h3>BROBYGNING OG ERHVERVSUDDANNELSER</h3>
    <p>Udover diverse kurser, tilbyder vi også brobygning i forskellige former. Læs 
        mere om dette via nedenstående links.
    </p>
    <a href="https://ungdomsbyen.dk/wp-content/uploads/2020/03/ungby-erhvervsfolder-20-21.pdf">Katalog vedrørende brobygningsforløb</a>
    </div>
    </section> 
    <nav id="filtrering"><button class="filter_valgt" data-kursus="alle">Alle</button></nav>
  
   
    <!-- <nav id="indhold_filtrering"><button class="filter_valgt" data-cont="alle">Alle</button></nav> -->
    
    <section id="kursus_oversigt"></section>
    </main>
    </section>






<template>
    <article class="kasse_1">
        
    <h3 class="navn"></h3>
    <h4 class="kategori"></h2>
        <p class="beskrivelse"></p>
        <p class="pris"></p>
        <p class="henvendelse"></p>
        <button class="her1">LÆS MERE</button>
        <button clas="her2">BOOK HER</button>
        
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
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-kursus="${cat.id}">${cat.name}</button>`
                
                }
            })

            // indhold.forEach(cont=>{
            //    console.log(cont.id);
            //     document.querySelector("#indhold_filtrering").innerHTML += `<button class="filter" data-cont="${cont.id}">${cont.name}</button>`
            
            // })

            addEventListenersToButtons();
        }

        function visKurser() {
            console.log(kurser);
            liste.innerHTML = "";
            console.log({filterKursus});
            console.log({filterIndhold});
            kurser.forEach(kursus => {
                //tjek filterRet og filterIndhold til filtrering
                if ((filterKursus == "alle"  || kursus.categories.includes(parseInt(filterKursus))) && (filterIndhold == "alle"  || kursus.hovedkategori.includes(parseInt(filterIndhold)))) {
                    const klon = skabelon.cloneNode(true).content;
                    klon.querySelector(".navn").innerHTML = kursus.navn;
                    klon.querySelector(".kategori").innerHTML = kursus.kategori;
            
            klon.querySelector(".beskrivelse").innerHTML = kursus.beskrivelse;
            klon.querySelector(".pris").innerHTML = kursus.pris;
            klon.querySelector(".henvendelse").innerHTML = kursus.henvendelse;
            klon.querySelector(".her1").addEventListener("click", () => {
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
            //  document.querySelectorAll("#indhold_filtrering button").forEach(elm => {
            //     elm.addEventListener("click", filtreringIndhold);
            // })
        }
        
        function filtrering() {
            filterKursus = this.dataset.kursus;
            
            //fjern .valgt fra alle
            document.querySelectorAll("#filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
          
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visKurser();
        }
        //  function filtreringIndhold() {
        //     filterIndhold = this.dataset.cont;
           
        //      //fjern .valgt fra alle
        //     document.querySelectorAll("#indhold_filtrering .filter").forEach(elm => {
        //         elm.classList.remove("valgt");
        //     });
        //     //tilføj .valgt til den valgte
        //     this.classList.add("valgt");
        //     visKurser();
        // }
    </script>

	</section><!-- #primary -->

<?php
get_footer(); ?>
<?php get_sidebar();?>





