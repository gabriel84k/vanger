<template>
    <div id="Modal-Equipo-detalle" class="modal fade" role="dialog"  >
        <div class="modal-dialog modal-xl">
          
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header card-header shadow-sm">
                <h4 class="modal-title">Detalle {{detalles}}</h4>
                <button type="button" class="close" data-dismiss="" @click="closeModal()">&times;</button>
            </div>
            <div class="modal-body detalle-equipo" :key="detalles.id">
                 
                <div class="m-widget1 col">
                    <div class="m-widget1__item">
                         
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{detalles.nro_equipo_evolution}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle ">Numero de Equipo</span>
                            </div>
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{detalles.tipo}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle">Tipo de equipo</span>
                            </div>
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{ capacidad(detalles.capacidad , detalles.unidad)}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle">Capacidad del Equipo</span>
                            </div>
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{detalles.marca}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle">Marca del Equipo</span>
                            </div>
                            
                        </div>
                    </div>
                    <br>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{formatDate(detalles.vencimiento_ph,false,4)}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle">Vencimiento de [PH]</span>
                            </div>
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{formatDate(detalles.fecha_fabricacion, false, 2)}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle">Fecha de Fabricación</span>
                            </div>
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{formatDate(detalles.fecha_ultimo_ph, false, 2)}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle">Fecha de Ultimo [PH]</span>
                            </div>
                            <div class="col m--align-left">
                                <h4 class="m-widget1__title title">{{formatDate(detalles.vencimiento_carga,false,4)}}</h4>
                                <hr class="hrp">
                                <span class="m-widget1__desc subtitle">Vencimiento de Carga</span>
                            </div>
                            
                        </div>
                    </div>
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
                    <!--<comp-Inspecciones :idequipo="detalles.id" :Inspdatos="datos" :RP="detalles.id"></comp-Inspecciones>-->
                </div>
                <div v-show="param.Planilla">
                    <div class="card-header">
                        <h5><i class="fa-sigex-title fa-book" aria-hidden="true"></i><span class="badge badge-secondary">Planillas</span></h5>
                    </div>
                    <Planillas :idequipo="detalles.id" :key="detalles.id"></Planillas>
                </div>
            </div>
            <div class="modal-footer shadow-lg">
                <button type="button" class="btn btn-secondary" data-dismiss="" @click="closeModal()">Cerrar</button>
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
            loading:false
           
        }
    },
    mounted(){
       console.log(this.detalles)

    },
    components:{
        Planillas
    },
    methods: {
      
        closeModal:function(){
            $('#Modal-Equipo-detalle').hide()
            $('#Modal-Equipo-detalle').toggleClass('show')
            
         },
        formatDate:function(value,h,f){
            let date=new Date(value)
            
            var dia=String(date.getDate());
            var mes=String(date.getMonth()+1);
            

            (dia.length==1)?dia='0'+dia:dia;
            (mes.length==1)?mes='0'+mes:mes;

            if (h==true){
                var hora=String(date.getHours());
                var minuto=String(date.getMinutes());
                var segundo=String(date.getSeconds());
                (hora.length==1)?hora='0'+String(hora):hora;
                (minuto.length==1)?minuto='0'+String(minuto):minuto;
                (segundo.length==1)?segundo='0'+String(segundo):segundo;
                return dia + '/' + mes + '/' + date.getFullYear() +'  '+ hora +':'+ minuto +':'+ segundo;
            }else{
                if (f==2)
                    return mes + '/' + String(date.getFullYear()).substr(-2,2)
                else if(f==0)
                    return dia + '/' + mes + '/' + date.getFullYear();
                else if(f==4)
                    return  + mes + '/' + date.getFullYear();            }
                
        },
        capacidad(cap,unidad){
            if (cap==null){
                cap=''
            }
            if(unidad==null){
                unidad=''
            }

            return cap+' '+unidad
        }
    },
}
</script>