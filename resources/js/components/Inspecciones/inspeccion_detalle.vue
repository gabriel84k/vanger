<template>
    <div id="Modal-insp-detalle" class="modal fade" role="dialog"  >
        <div class="modal-dialog modal-xl">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header card-header shadow-sm">
                    <h4 class="modal-title">Detalle Inspección - Puesto {{formatstring(detalles.DetalleInspeccion.columnas.name,true,false)}}</h4>
                    <button type="button" class="close" data-dismiss="" @click="closeModal()">&times;</button>
                </div>
                <div class="modal-body detalle-equipo" :key="detalles.id">
                    
                    <div class=" col">
                        <div class="m-widget1__item">
                            <ul class="list-group">
                                <li class="list-group-item">Información Básica del Puesto</li>
                             
                                <li class="list-group-item">
                                    <div class="row col m-row--no-padding align-items-center">
                                         <!--• Col. Particulares •-->
                                        <div v-for="(col,k,i) in detalles.ColParticulares" :key="k+i">
                                            
                                            <div v-if="k==detalles.row_type" :class="'row m--align-left ' + coincidenelementos">
                                              
                                                <div v-for="(item,key,i) in col" :key="i" >
                                                    <!--• Solo para los modelos de Kit •-->
                                                        {{modelo(key,SplitParticular(detalles,k,key,'.'))}}

                                                    <!--• Solo para código de elemento •-->
                                                        {{codigoelemento(SplitParticular(detalles,k,key,'.'),item,detalles)}}

                                                    <!--• Columnas particulares de la inspeccion •-->
                                                    <div v-if="item.verdetalle"  class="col">
                                                        <h4 v-if="item.tipo=='date'" class="m-widget1__title title">{{formatDate(SplitParticular(detalles,k,key,'.'),false,4)}}</h4>
                                                        <h4 v-else class="m-widget1__title title">{{SplitParticular(detalles,k,key,'.')}}</h4>
                                                        <h4 v-if="funct(item)=='estado'" class="m-widget1__title title">{{estadoInspeccion(SplitParticular(detalles,k,key,'.'))}}</h4>
                                                        <h4 v-if="funct(item)=='nameadapt'" class="m-widget1__title title"> {{Splitnameadapt(detalles,k,key,'.',item)}}</h4>
                                                       
                                                        <hr class="hrp">
                                                        <span class="m-widget1__desc subtitle ">{{item.muestra}}</span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!--• col. Puesto Base •-->
                                        <div v-for="(col,k,i) in detalles.columnas" :key="i">
                                            <div v-if="col.verdetalle" class=" col m--align-left" >
                                                <h4 v-if="col.tipo=='date'" class="m-widget1__title title">{{formatDate(Split(detalles,k,'.'),false,4)}}</h4>
                                                <h4 v-else-if="funct(col)=='estado'" class="m-widget1__title title">{{estadoInspeccion(Split(detalles,k,'.'))}}</h4>
                                                <h4 v-else class="m-widget1__title title">{{Split(detalles,k,'.')}}</h4>
                                                <hr class="hrp">
                                                <span class="m-widget1__desc subtitle ">{{col.muestra}}</span>
                                            </div>
                                        </div>
                                        <p>
                                            <a  class="btn btn-outline-success" 
                                                data-toggle="collapse" 
                                                href="#collapsedetallepuesto" 
                                                role="button" 
                                                aria-expanded="false" 
                                                aria-controls="collapsedetallepuesto"
                                                style="font-size: 12px;">
                                                    Detalle Puesto
                                            </a>
                                        </p>
                                    </div>
                                    <hr>
                                     <!--• Col. Puesto Especifico •-->
                                    <div class="collapse multi-collapse row" id="collapsedetallepuesto">
                                           
                                        <div v-for="(item,key,i) in detalles.puesto.tipopuesto" :key="i" class="col m--align-left" >
                                            <div v-if="detalles.puesto.tipopuesto.columnas && key in detalles.puesto.tipopuesto.columnas">
                                                <h4 class="m-widget1__title title">{{item}}</h4>
                                                <hr class="hrp">
                                                <span class="m-widget1__desc subtitle ">{{detalles.puesto.tipopuesto.columnas[key].muestra}}</span>
                                            </div>
                                        </div>
                                           
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <br>
                        <div class="m-widget1__item">  
                            <ul class="list-group">
                                <li class="list-group-item">Control</li>
                                <!-- •Detalle de la Inspeccion• -->
                                <li  class="list-group-item">
                                    <ul  class="list-group list-group-horizontal row">
                                            <div v-for="(col,key, index) in detalles.DetalleInspeccion.columnas" :key="index" class="formatsubcard">
                                                <!--• Solo para Duchas •-->
                                                    {{muestraducha(col.name,detalles)}}
                                                <!--FIN-->
                                                <li  v-if="col.visible && kitmodel(col.modelo) && mostrar==true" :class="'list-group-item text-center ' + colorclass(Split(detalles.DetalleInspeccion,key,'.'),col,detalles)">
                                                    
                                                    <div :class="'row m-row--no-padding align-items-center'">
                                                        <div class="col m--align-left">
                                                        
                                                            <div v-if="col.tipo=='bool'">{{check(Split(detalles.DetalleInspeccion,key,'.'))}}</div>
                                                            <div v-else-if="col.tipo=='cumple'">{{estadoCampo(Split(detalles.DetalleInspeccion,key,'.'))}}</div>
                                                            <div v-else-if="col.tipo=='bool2'">{{check2(Split(detalles.DetalleInspeccion,key,'.'))}}</div>
                                                            <div v-else-if="col.tipo=='boolMal'">{{Split(detalles.DetalleInspeccion,key,'.')}}</div>
                                                            <div v-else>{{nullable(Split(detalles.DetalleInspeccion,key,'.'))}}</div>
                                                            <hr class="hrp">
                                                            <span class="m-widget1__desc subtitle">{{col.muestra}}</span>
                                                        </div>
                                                    </div>                                                    
                                                </li>
                                            </div>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <br>
                        <li  class="list-group-item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col m--align-left">
                                    <h4 class="m-widget1__title title">{{detalles.observaciones}}</h4>
                                    <hr class="hrp">
                                    <span class="m-widget1__desc subtitle">Observaciones</span>
                                </div>
                            </div>
                        </li>
                    </div>
                    <hr class="shadow">
                </div>
                <div class="modal-footer shadow-lg">
                    <button type="button" class="btn btn-secondary" data-dismiss="" @click="closeModal()">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    const $ = require('jquery') 
    window.$ = $ 
export default {
     
    props:['detalles'],
    data() {
        return {
            items:5,
            display:'none',
            colorcard:'',
            modelokit:0,
            mostrar:true,
            coincidenelementos:'',
            bordercolor:''
        }
    },
  
    methods: {
        mostrar(obj){
           
            if (obj==false || obj=='undefined'){
                return 'none;'
            }else if (obj==true){
                return 'block;'
            }
        },
        formatDate:function(value,h,f){          /* •Formatea las Fechas */
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
        formatstring:function(value, toCase, toUpCase){
            
            if (toCase==true){
                return value[0].toUpperCase() + value.slice(1);
            }else if (toUpCase==true){
                return value.toUpperCase();
            }
        },
        capacidad(cap,unidad){                   /* •Da Formato a la capacidad */
            if (cap==null){
                cap=''
            }
            if(unidad==null){
                unidad=''
            }
            return cap+' '+unidad
        },
        check(dato){   
                          /* •Setea en el control del puesto los estados en [SI o NO] */
            switch (parseInt(dato)) {
                case 0:
                    return 'NO'
                    
                case 1:
                    return 'SI'
                    
                default:
                    return '-'
            }
          
        },
        check2(dato){   
                          /* •Setea en el control del puesto los estados en [SI o NO] */
            switch (parseInt(dato)) {
                case 1:
                    return 'NO'
                    
                case 0:
                    return 'SI'
                    
                default:
                    return '-'
            }
          
        },      
        colorclass(dato,col,detalles){
            
            if (col.visible){
                if (col.tipo=='bool'){
                    switch (parseInt(dato)) {
                        case 1:
                            return 'border border-danger'   
                            
                        case 0:
                            return 'border border-success'   
                            
                        default:
                            return ''
                            
                    }
                }else if (col.tipo=='bool2'){
                    switch (parseInt(dato)) {
                        case 1:
                            return 'border border-success'   
                            
                        case 0:
                            return 'border border-danger'   
                            
                        default:
                            return ''
                            
                    }
                }else if(col.tipo=='cumple'){
                    switch (parseInt(dato)) {
                        case 1:
                            return 'border border-success'   
                            
                        case 0:
                            return 'border border-danger'   
                            
                        default:
                            return ''
                            
                    }
                }else if(col.tipo=='boolMal'){
                    switch (dato.toUpperCase()) {
                        case 'BIEN':
                           return 'border border-success'   
                            
                        case 'MAL':
                            return 'border border-danger'   
                        case 'NO ENCONTRADA':
                            
                            return 'border border-danger'
                        case 'NO APLICA':
                            return ''
                            
                    }
                }
                /* Control de Elemento encontrado */
                if(col.name=='codigoElementoEncontrado'){
                    if (dato == detalles.DetalleInspeccion.codigoelemento){
                        return 'border border-success'   
                    }else{
                        return 'border border-danger'   
                    }
                }else{
                    return''
                }
            }else{
                
                return ''
            }

        },
        estadoCampo:function(estado){
            switch (parseInt(estado)) {
                case 1:
                    
                    return "Cumple"
                    break;
                case 0:
                   
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
        estadoInspeccion:function(e){
            switch(e){
                case 0:
                    return 'No Realizada';
                    break;
                case 1:
                    return 'Realizada';
                    break;
                case 2:
                    return 'Sustituto';
                    break;
                case 3:
                    return 'Inaccesible';
                    break;
                    
            }           
        },        
        
        closeModal:function(){                  /* •Cierra el modal por codigo */
            $('#Modal-insp-detalle, .modal-backdrop').hide()
            $('#Modal-insp-detalle').toggleClass('show')
        },
        Split(detalles,colname,separator){
            let resp=''
            let arr=''
            try {
                arr=detalles.columnas[colname]['name'].split(separator)
                
                switch (arr.length) {
                    case 0:
                        resp= detalles.columnas[colname]['name']
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
        SplitParticular(detalles,colname,key,separator){
            let resp=''
            let arr=''
            
            try {
                arr=detalles.ColParticulares[colname][key]['name'].split(separator)
                switch (arr.length) {
                    case 0:
                        resp= detalles.columnas[colname]['name']
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
        Splitnameadapt(detalles,colname,key,separator,item){
            let resp=''
            let arr=''
            console.log('detalles que pasa')
            console.log(detalles)
            console.log(colname)
            console.log(key)
            $.each(detalles.ColParticulares[colname][key]['name'], function (index, value) { 
                try {
                    arr=value.split(separator)
                    
                    switch (arr.length) {
                        case 0:
                            resp= detalles.columnas[colname]['name']
                            break;
                        case 1:
                            
                            resp+= detalles[arr[0]]+' '+ item.func[1]+' '
                            break;
                        case 2:
                            
                            if(arr[1]=='longitudmili' || arr[1]=='diametromili'){
                                var medida=''
                                if (arr[1]=='longitudmili'){medida='mts'}else if(arr[1]=='diametromili'){medida="mm"}
                                
                                resp+= Number(detalles[arr[0]][arr[1]]).toFixed(1)+' '+ medida +' '+ item.func[1]+' '
                                break;
                            }else{
                                resp+= detalles[arr[0]][arr[1]]+' '+ item.func[1]+' '
                                break;
                            }
                            
                            
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
        codigoelemento(dato,col,detalles){
            /* Control de Elemento encontrado */
            if(col.name=='puesto.tipopuesto.codigoElemento'){
                if (dato == detalles.DetalleInspeccion.codigoElementoEncontrado){
                    this.coincidenelementos= 'border border-success'   
                }else{
                    this.coincidenelementos= 'border border-danger'   
                }
            }else{
                this.coincidenelementos=''
            }
        },
        /* Exclusivo para KIT DE DERRAME */
        modelo(key,item){
           
            if (key=='modelo'){
                
                switch (item.toUpperCase()) {
                    case 'MODELO 1':
                        this.modelokit=1;
                        break;
                    case 'MODELO 2':
                        this.modelokit=2;
                        break;

                    case 'MODELO 3':
                         this.modelokit=3;
                        break;
                   
                }
            }
        },
        kitmodel(modelo){
            let señal=false
            let kit=this.modelokit
            if(modelo){
                $.each(modelo, function (i, val) { 
                  
                    if (val==kit){
                        señal=true
                    }
                
                });
            }else{
                señal=true
            }
            return  señal
            
        },
        /* Exclusivo para DUCHA */
        muestraducha(val,detalles){
                
            if (val=='ducha' || val=='lavaojos'){
                if (detalles.puesto.tipopuesto.tipo_ducha.toUpperCase()==val.toUpperCase()){
                    this.mostrar=true
                }else{
                    this.mostrar=false
                }
            }else{
                this.mostrar=true
            }
        },
        /* FIN Exclusivo */
        
        
    },
}
</script>