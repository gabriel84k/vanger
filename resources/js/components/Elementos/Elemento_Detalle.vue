<template>
    <div id="Modal-Equipo-detalle" class="modal fade" role="dialog"  >
        <div class="modal-dialog modal-xl">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header card-header shadow-sm">
                <h4 class="modal-title">Detalle Elemento -{{detalles.config.general.titulo}}</h4>
                <button type="button" class="close" data-dismiss="modal" @click="closeModal()">&times;</button>
            </div>
            <div class="modal-body detalle-equipo" :key="detalles.id">
                       
                <div class="col">
                    <div class="m-widget1__item">
                            <ul class="list-group">
                                <li :class="detalles.config.general.classheard" :style="detalles.config.general.styleheard">{{detalles.config.general.subtitulo}}</li>
                                <li class="list-group-item">
                                    <div class="row m-row--no-padding align-items-center">
                                        
                                        <div v-for="(col,i) in detalles.columnas" :key="i" >
                                            <br>
                                            <div v-if="col.verdetalle">
                                                <div v-for="(value , k, index) in detalles" :key="index">        
                                                
                                                    <div v-if="col.name == k" class="col m--align-left">
                                                        <h4 v-if="col.tipo=='date'" :class="detalles.config.general.classdato" :style="detalles.config.general.styledato">{{formatDate(value,false,5)}}</h4>
                                                        <h4 v-else-if="col.tipo=='bool'" :class="detalles.config.general.classdato" :style="detalles.config.general.styledato">{{check(value)}}</h4>
                                                        <h4 v-else :class="detalles.config.general.classdato" :style="detalles.config.general.styledato">{{nullable(value)}}</h4>
                                                        <hr class="hrp">
                                                        <span :class="detalles.config.general.classsubdato" :style="detalles.config.general.stylesubdato" >{{col.muestra}}</span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </li>
                            </ul>
                    </div>
                    <br>
                    <br>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                        </div>
                    </div>
                </div>
                
                <hr class="shadow">
              
                <div v-show="param.Controles">
                    <div class="card-header">
                        <h5><i class="fa-sigex-title fa-book" aria-hidden="true"></i><span class="badge badge-secondary">Inspecciones</span></h5>
                    </div>
                    
                    <comp-Inspecciones :idequipo="detalles.id" :Inspdatos="datos" :RP="detalles"></comp-Inspecciones>
                </div>
                <div v-if="mostrar(detalles.row_type)"  v-show="param.Planilla">
                    <div class="card-header">
                        <h5><i class="fa-sigex-title fa-book" aria-hidden="true"></i><span class="badge badge-secondary">Planillas</span></h5>
                    </div>
                   
                    <Planillas :idequipo="detalles.id" :key="detalles.id" :param="param"></Planillas>
                </div>
            </div>
            <div class="modal-footer shadow-lg">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Cerrar</button>
            </div>
            </div>

        </div>
    </div>
</template>
<script>
    const $ = require('jquery') //usamos jquery
    window.$ = $ //lo colocamos de forma global
    import inspecciones from '../Inspecciones/Inspecciones'
    import Planillas from '../Planillas/Planilla'

export default {
     
    props:['detalles','datos','param'],
    data() {
        return {
            errored:false,
            loading:false,
        }
    },
    mounted(){
       console.log(this.detalles)

    },
    components:{
        Planillas,
        inspecciones
    },
    methods: {
      
        closeModal:function(){
            $('#Modal-Equipo-detalle').hide()
           
            
         },
        formatDate:function(value,h,f){

            if (value){
               
                var arr=value.split(' ')
                let date=arr[0].split('-')
                
                if (h==true){
                    var hora=String(date[0]);
                    var minuto=String(date[1]);
                    var segundo=String(date[2]);
                    
                    return date[2] + '/' + date[1] + '/' + date[0] +'  '+ hora +':'+ minuto +':'+ segundo;
                }else{
                    if (f==2){
                        return date[1] + '/' + String(date[0]).substr(-2,2)
                    
                    }else if(f==4){
                        return date[2] + '/' + date[1] + '/' + date[0];

                    }else if(f==5){
                        return  date[1] + '/' + date[0];
                    }
                }
            }else{
                return ''
            }
                
        },
        capacidad(cap,unidad){
            if (cap==null){
                cap=''
            }
            if(unidad==null){
                unidad=''
            }

            return cap+' '+unidad
        },
        mostrar(rowtype){
            switch (rowtype) {
                case 'extintor':
                    return true
                    break;
                case 'mangueras':
                    return true
                    break;
                default:
                    return false
                    break;
            }
        },
        check(dato){   
            this.colorcard=''                      /* •Setea en el control del puesto los estados en [SI o NO] */
            switch (dato) {
                case 0:
                    return 'N0'
                    break;
                case 1:
                     return 'Si'
                    break;
                default:
                    return '-'
                    break;
            }
           
        },  
        nullable(val){
            if (val=='' || val==null){
                return '-'
            }else{
                return val
            }

        },
        formatstring:function(value, toCase, toUpCase){
            if (value){
                if (toCase==true){
                    console.log(value)
                    return value[0].toUpperCase() + value.slice(1);
                }else if (toUpCase==true){
                    return value.toUpperCase();
                }
            }
        },

    },
}
</script>