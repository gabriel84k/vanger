<template>
    <div id="Modal-Puesto-detalle" class="modal fade" role="dialog"  >
        <div class="modal-dialog modal-xl">
          
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header card-header shadow-sm">
               
                <h4 class="modal-title">{{detalles.tipopuesto.config.general.titulo}}</h4>
                <button type="button" class="close" data-dismiss="modal" @click="closeModal()">&times;</button>
            </div>
            <div class="modal-body detalle-puesto" :key="detalles.tipopuesto.id">
               
                <div class="m-widget1 col">
                    <div class="m-widget1__item">
                        <ul class="list-group">
                            <li :class="detalles.tipopuesto.config.general.classsubtitulo" 
                                :style="detalles.tipopuesto.config.general.stylesubtitulo" >
                                {{detalles.tipopuesto.config.general.subtitulo}}
                            </li>
                            
                            <li class="list-group-item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div v-for="(col,key,i) in detalles.tipopuesto.columnas" :key="i" >
                                            <div v-if="(col.verdetalle)" class="col m--align-left">
                                                <br>
                                                <h4 v-if="col.tipo=='date'" 
                                                    :class="detalles.tipopuesto.config.general.classdato"
                                                    :style="detalles.tipopuesto.config.general.styledato">
                                                    {{formatDate(value,false,4)}}
                                                </h4>
                                                <h4 v-else 
                                                    :class="detalles.tipopuesto.config.general.classdato"
                                                    :style="detalles.tipopuesto.config.general.styledato">
                                                    {{Split(detalles,key,'.')}}
                                                </h4>
                                                <h4 v-if="funct(col)=='nameadapt'" 
                                                    :class="detalles.tipopuesto.config.general.classdato"
                                                    :style="detalles.tipopuesto.config.general.styledato"> 
                                                    {{Splitnameadapt(detalles,key,'.',col)}}
                                                </h4>
                                                <hr class="hrp">
                                                <span :class="detalles.tipopuesto.config.general.classsubdato"
                                                      :style="detalles.tipopuesto.config.general.stylesubdato">
                                                      {{col.muestra}}
                                                </span>
                                            </div>
                                    </div>  
                                </div>
                            </li>
                        </ul>
                       
                    </div>
                    
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
                    
                    <comp-Inspecciones :visualize="detalles.id" :Inspdatos="datos" :RP="detalles.tipopuesto"></comp-Inspecciones>
                </div>
                
                <div v-show="param.Planilla" v-if="detalles.tipopuesto.element">
                    <div class="card-header">
                        <h5><i class="fa-sigex-title fa-book" aria-hidden="true"></i><span class="badge badge-secondary">Planillas</span></h5>
                    </div>
                
                    <!--<Planillas :idequipo="detalles.id" :key="detalles.id" :param="param"></Planillas>-->
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
        }
    },
    mounted(){
        console.log(this.detalles)
    },
    methods: {
         closeModal:function(){
                $('#Modal-Puesto-detalle').hide()
                $('#Modal-Puesto-detalle').toggleClass('show')
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
        Splitnameadapt(detalles,colname,separator,item){
            let resp=''
            let arr=''
            
            $.each(detalles.tipopuesto.columnas[colname]['name'], function (index, value) { 
                try {
                    arr=value.split(separator)
                    
                    switch (arr.length) {
                        case 0:
                            resp= detalles.tipopuesto.columnas[colname]['name']
                            break;
                        case 1:
                            
                            resp+= detalles[arr[0]]+' '+ item.func[1]+' '
                            break;
                        case 2:
                            resp+= detalles[arr[0]][arr[1]]+' '+ item.func[1]+' '
                            break;
                        case 3:
                            resp+= detalles[arr[0]][arr[1]][arr[2]]+' '+ item.func[1]+' '
                            break;
                        case 4:
                            resp+= detalles[arr[0]][arr[1]][arr[2]][arr[3]]+' '+ item.func[1]+' '
                            break;
                        case 5:
                            resp+= detalles[arr[0]][arr[1]][arr[2]][arr[3]][arr[4]]+' '+ item.func[1]+' '
                            break;
                    
                    }   
                
                   
                } catch (error) {
                    resp='Ausente'
                }
            });
            console.log(resp)
            return resp
            
        },
        funct(f){
           
            if (f!=='undefined'){
                if (f.hasOwnProperty('func')!=false){
                
                    switch (f.func[0]) {
                        case 'estado':
                            return 'estado'
                        case 'nameadapt':
                            return 'nameadapt'
                        default:
                            return false
                    }
                }else{return false}
            }else{ return false}
        },
        nullable(val){
            if (val=='' || val==null){
                return '-'
            }else{
                return val
            }

        },
        Split(detalles,colname,separator){
            let resp=''
            let arr=''
            try {
                arr=detalles.tipopuesto.columnas[colname]['name'].split(separator)
                
                switch (arr.length) {
                    case 0:
                        resp= detalles.tipopuesto.columnas[colname]['name']
                        break;
                    case 1:
                        resp= detalles[arr[0]]
                        break;
                    case 2:
                        resp= detalles[arr[0]][arr[1]]
                        break;
                    case 3:
                        resp= detalles[arr[0]][arr[1]][arr[2]]
                        break;
                    case 4:
                        resp= detalles[arr[0]][arr[1]][arr[2]][arr[3]]
                        break;
                    case 5:
                        resp= detalles[arr[0]][arr[1]][arr[2]][arr[3]][arr[4]]
                        break;
                
                }
            
                return resp
            } catch (error) {
                
            }
        },
        check(dato){   
            /* •Setea en el control del puesto los estados en [SI o NO] */
            switch (parseInt(dato)) {
                case 0:
                    return 'N0'
                    break
                case 1:
                    return 'Si'
                    break
                default:
                    return '-'
                    break
            }
          
        },      
        estadoCampo:function(estado){
            switch (parseInt(estado)) {
                case 0:
                    return "Cumple"
                    break;
                case 1:
                    return "No Cumple"
                    break;
                case null:
                    return "-"
                    break;
                default:
                    return '-'
                    break;
            }
        },
    },
}
</script>