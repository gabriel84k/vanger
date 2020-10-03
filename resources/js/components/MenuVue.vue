<template>
    
    <div class="col-md-2">
        <div id="accordion">
            <div id="menu" class="card">
            
                <div class="card-header" id="headingOne">
                    <h3 class="mb-0">
                        <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                           <i class="fa fa-bars" aria-hidden="true"></i>&nbsp
                           Menú
                        </a>
                    </h3>
                </div>

                <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                    <ul class="nav flex-column">
                        <!--Ellos quieren que se desactive por completo-->
                        <li v-if="false" class="nav-item">
                            <a class="nav-link" href="/home/Sucursales">
                                <i class="fa-sigex fa-building-o"></i>
                                <span class="m-menu__link-text">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Sucursales</font>
                                    </font>
                                </span>
                            </a>
                        </li>
                        
                        <!--<li v-if="mostrarmenu.Controles"  class="nav-item"> Ellos quieren que se desactive por completo-->
                            <li v-if="false"  class="nav-item">
                            <a class="nav-link" href="/home/Control-Periodicos">
                                <i class="fa-sigex fa-free-code-camp"></i>
                                <span class="m-menu__link-text">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Inspecciones</font>
                                    </font>
                                </span>
                            </a>
                        
                        </li>
                        <li v-if="mostrarmenu.Planilla" class="nav-item">
                            <a class="nav-link" href="/home/Planilla">
                                <i class="fa-sigex fa-book"></i>
                            
                                <span class="m-menu__link-text">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Planillas</font>
                                    </font>
                                </span>
                            </a>
                        
                        </li>
                        <li v-if="mostrarmenu.Equipos" class="nav-item">
                            <a class="nav-link" href="/home/Elementos/Equipos">
                                <i class="fa-sigex fa-fire-extinguisher"></i>
                                <span class="m-menu__link-text">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Equipos</font>
                                    </font>
                                </span>
                            </a>
                        
                        </li>
                        <!--<li v-if="mostrarmenu.Bombas" class="nav-item" > Ellos quieren que se desactive por completo-->
                        <li v-if="false"  class="nav-item">
                            <a class="nav-link" href="/home/Elementos/Bombas">
                                <i class="fa-sigex fa-fire-extinguisher"></i>
                                <span class="m-menu__link-text">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Bombas</font>
                                    </font>
                                </span>
                            </a>
                        
                        </li>
                        <li v-if="mostrarmenu.Mangueras" class="nav-item" >
                            <a class="nav-link" href="/home/Elementos/Mangueras">
                                <i class="fa-sigex fa-tint"></i>
                                <span class="m-menu__link-text">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Mangueras</font>
                                    </font>
                                </span>
                            </a>
                        
                        </li>
                        <li class="nav-item salir-menu" @click="salir()">
                            <a class="nav-link" href="#" >
                                <i class="fa-sigex fa-sign-out text-right"></i>
                            
                                <span class="m-menu__link-text">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Salir</font>
                                    </font>
                                </span>
                            </a>
                        
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
       
</template>

<script>
    export default {
        props:['mostrarmenu'],
       
        data(){
            return {
               
            }
        },
        mounted() {
          
          
        },
        methods: {
           salir:function(){
                try {
                    axios.post('/logout')
                        .then(response => {
                            location.reload('/');
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
           }
        },
    }
</script>
