<?php

get_header();
?>

<style>

body:not(.home) .site-content {
    background-color:#C4D2C7;
}

#filtrering {
    text-align: center;
    padding-top: 5rem;
}

.filter_valgt {
    display: none;
}

.filter {
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

.filter_valgt:hover {
    background-image: none;
    background-color: #FAD8E8;
    color: black;
    
}

#ekstra_p {
    grid-row: 1/1;
}

h3 {
    grid-column: 2/2;
}

.filter:hover {
    background-image: none;
    background-color: #FAD8E8;
    color: black;
    
}
.filter_valgt:focus {
    background-image: none;
    background-color: #FAD8E8;
    
}

.filter:focus, .her1:focus, .her2:focus {
    background-image: none;
    background-color: #FAD8E8;
    
}

.brobygning {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    padding-top: 6rem;
}


.kasse_1 {
    gap: 10px;
}

#kursus_oversigt {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-top: 5rem;
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

#ekstra_tekst {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    padding-bottom: 3rem;
}



#toppen {
    text-align: center;
    
}



#toppen .vi_tilbyder {
    font-size: 20px;
    margin-left: 15rem;
    margin-right: 15rem;
}


#ekstra_tekst p {
    font-size: 20px;
    padding-left: 7.8rem;
    padding-right: 10px;
    text-align: left;
}

#ekstra_tekst h3 {
    padding-left: 7.8rem;
    padding-right: 10px;
    text-align: left;
}

#ekstra_tekst a {
    padding-left: -2rem;
    
}

p {
    font-family: Galvji;
    font-size: 14px; 
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

@media(max-width: 500px) {
    #toppen .vi_tilbyder {
        margin: 0;
        padding-left: 5vw;
        padding-right: 5vw;
    }

    #kursus_oversigt {
    display: block;
    margin-left: 1rem;
    margin-right: 1rem;
}

    #kursus_oversight {
        
        background-color: #F6F2E4;
        padding: 34px;
        margin-top: 20px;
    }

    h3:first-child{
        margin-top: 10vw;
    }
}



</style>


<section id="primary" class="content-area">
    <main id="main" class="site-main">
    <section id="toppen">
    <h1 class="vi_tilbyder">VI TILBYDER</h1>
    <p class="vi_tilbyder">Vi tilbyder kurser, som henvender sig til elever såvel som
        undervisere, skoler og kommuner. Vores Kurser omhandler
        alt fra konflikhåndtering, FN’s verdensmål og økonomi.
        Nedenfor ser du en oversigt over de kurser vi tilbyder.</p>
    <div class="brobygning">
        <div id="ekstra_tekst">
            <h3>BROBYGNING OG ERHVERVSUDDANNELSER</h3>
                <p>Udover diverse kurser, tilbyder vi også brobygning i forskellige former. Læs 
                    mere om dette via nedenstående links.
                </p>
            <a href="https://ungdomsbyen.dk/wp-content/uploads/2020/03/ungby-erhvervsfolder-20-21.pdf">Katalog vedrørende brobygningsforløb</a>
    
        </div>
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
        <p class="henvendelse">Henvendelse: </p>
        <button class="her1">LÆS MERE</button>
        <button class="her2">BOOK HER</button>
        
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
            const catUrl = "https://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/categories";
             //hent custom category: hovedkategori
            const contUrl = "https://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/wp-json/wp/v2/hovedkategori";
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
            
            klon.querySelector(".beskrivelse").innerHTML = kursus.kort_beskrivelse;
            klon.querySelector(".pris").innerHTML = kursus.pris;
            klon.querySelector(".henvendelse").innerHTML += kursus.henvendelse;
            klon.querySelector(".her1").addEventListener("click", () => {
                location.href = kursus.link;
            })
            klon.querySelector(".her2").addEventListener("click", () => {
                location.href = "https://annemunksgaard.dk/kea/02sem/tema09/ungdomsbyen_wp/booking/";
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

    </script>

	</section><!-- #primary -->

<?php
get_footer(); ?>
<?php get_sidebar();?>





